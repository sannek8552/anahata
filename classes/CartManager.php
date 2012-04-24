<?php
require_once('classes/ProductHolder.php');
require_once('classes/SettingsHolder.php');
require_once('classes/WholesaleHolder.php');
require_once('classes/OptionHolder.php');
require_once('classes/PurchasedCertificateHolder.php');

class CartManager
{
	function CartManager()
	{
		
	}
	
	function calculate_total($cart)
	{
		$total = 0;
		$weight = 0;
		$total_quantity = 0;
		$cart_count = 0;
		
		$wholesale_categories = array();
		$wholesale_discount = 0;
		if ($GLOBALS['core.auth.user']->is_member_of('user'))
		{
			$wh = new WholesaleHolder();
			$wholesale_categories = $wh->getWholesalesCategoriesForUser($GLOBALS['core.auth.user']->data['user_id']);
		}

        foreach ($cart as $key => $value)
		{
			$quantity = 0;
			$ph = new ProductHolder();
            $options = $ph->getAllOptions();
            
			if (isset($value['options']))
			{
                $price = 0;
                foreach ($value['options'] as $k => $v)
                {
                    $price = $options[$k]['price'] * $v + $price;
                    $total_quantity += $v;
                    $cart_count ++;
                }
                
                if (isset($value['not_wholesale']) && empty($value['not_wholesale']) 
            		&& !empty($value['category_id']) 
            		&& (isset($wholesale_categories[$value['category_id']]) || isset($wholesale_categories[0])))
            		{
            			$discount = 0;
            			if (isset($wholesale_categories[$value['category_id']])) $discount = $wholesale_categories[$value['category_id']]['discount'];
            			else $discount = $wholesale_categories[0]['discount'];
            			$wholesale_discount += round($price * $discount / 100, 2);
            			$price = round($price * (100 - $discount) / 100,2);
            		}
                
                $total+=$price;
			}
			elseif (isset($value['price']))
			{
				$cart_count ++;
				$price = $value['price'];
				if (isset($value['positions']))
				{
					foreach ($value['positions'] as $pkey => $pvalue)
					{
						if (isset($pvalue['quantity']) && $pvalue['quantity'] > 0)
							$quantity += $pvalue['quantity'];
					}
				}
				elseif (isset($value['quantity']) && $value['quantity'] > 0) $quantity += $value['quantity'];
				
				
				if (isset($value['not_wholesale']) && empty($value['not_wholesale']) 
            		&& !empty($value['category_id']) 
            		&& (isset($wholesale_categories[$value['category_id']]) || isset($wholesale_categories[0])))
            		{
            			$discount = 0;
            			if (isset($wholesale_categories[$value['category_id']])) $discount = $wholesale_categories[$value['category_id']]['discount'];
            			else $discount = $wholesale_categories[0]['discount'];
            			$wholesale_discount += round($price * $discount / 100, 2);
            			$price = round($price * (100 - $discount) / 100,2);
            		}
				
				$total += $quantity * $price;
				if (!isset($value['certificate']))	$total_quantity += $quantity;
			}
			
			if (isset($value['options']))
			{
                $w = 0;
                foreach ($value['options'] as $k => $v)
                {
                    $w = $options[$k]['weight'] * $v + $w;
                }
				$weight += $w;
			}
			elseif(isset($value['weight']))
			{
				$weight = $weight + $value['weight'];
			}
		}
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
				
		//$ship_type = CartManager::get_ship_price($weight);
		$ship_type = array('price' => 0, 'id' => 0);
		if (isset($settings['shipping_type']))
		{
			if ($settings['shipping_type'] == 0)
			{
				//weight
				$ship_type = CartManager::get_ship_price($weight);
			}
			elseif ($settings['shipping_type'] == 1)
			{
				//fixed
				$ship_type = CartManager::get_fixed_ship();
			}
			else 
			{
				//items
				$ship_type = CartManager::get_items_ship_price($total_quantity);
			}
		}
		
		$_SESSION['cart_total'] = $total + $ship_type['price'];
		$_SESSION['shipping_price'] = $ship_type['id'];
		$_SESSION['shipping'] = $ship_type;
		$GLOBALS['core.smarty']->assign('ship_type', $ship_type);
		$GLOBALS['core.smarty']->assign('weight', $weight);
		$_SESSION['cart_items'] = $cart_count;
		$_SESSION['total_cost'] = $total;
		$_SESSION['wholesale_discount'] = $wholesale_discount;
		
		$total_discount = 0;
		
		if (isset($_SESSION['coupons']))
		{		    
		    foreach($_SESSION['coupons'] as $key => $value)
		    {
				$total_discount += $value['discount'];	
		    }
		}   

		if (isset($_SESSION['certificates']))
		{		    
		    foreach($_SESSION['certificates'] as $key => $value)
		    {
				$total_discount += $value['discount'];	
		    }
		}		    
		
		if ($total_discount > 0)
		{
			$_SESSION['total_with_coupons'] = $_SESSION['cart_total'] - $total_discount;
			if ($_SESSION['total_with_coupons'] < 0) $_SESSION['total_with_coupons'] = 0;
			$GLOBALS['core.smarty']->assign('total_with_coupons',$_SESSION['total_with_coupons']);		
		}
		elseif (isset($_SESSION['total_with_coupons'])) unset($_SESSION['total_with_coupons']);

		
		if (isset($settings['tax_gsm']) && !empty($settings['tax_gsm']))
		{
			if (isset($_SESSION['total_with_coupons']))
			{
				$_SESSION['tax_gsm'] = round($_SESSION['total_with_coupons'] * $settings['tax_gsm'] / 100,2);
				$_SESSION['total_with_coupons'] += $_SESSION['tax_gsm'];
			}
			else 
			{
				$_SESSION['tax_gsm'] = round($_SESSION['cart_total'] * $settings['tax_gsm'] / 100,2);
				$_SESSION['cart_total'] += $_SESSION['tax_gsm'];
			}
			
			$GLOBALS['core.smarty']->assign('tax_gsm',$_SESSION['tax_gsm']);
		}
		//pp($cart);
		//pp($_SESSION);
	}
	
	function get_product_ids($cart)
	{
		$product_ids = array();
		foreach ($cart as $key => $value)
		{
			if (isset($value['product_id']) && !empty($value['product_id']) && !in_array($value['product_id'],$product_ids) && !isset($value['certificate']))
				$product_ids[$value['product_id']] = $value['product_id'];
		}
		return $product_ids;
	}
	
	function get_fixed_ship()
	{
		$to_ret = array('price' => 0, 'id' => 0);
		if (isset($_REQUEST['fixed_shipping_id']))
		{
			$ship_id = $_REQUEST['fixed_shipping_id'];
			$_SESSION['fixed_shipping_id'] = $ship_id;
		}
		elseif (isset($_SESSION['fixed_shipping_id']))
		{
			$ship_id = $_SESSION['fixed_shipping_id'];
		}
		else 
		{
			$ship_id = $GLOBALS['core.sql']->getOne("select id from #p#fixed_shipping");
		}
		
		if (!empty($ship_id))
		{
			$to_ret = $GLOBALS['core.sql']->getRow("select * from #p#fixed_shipping where id = ? ",array($ship_id));
		}
		return $to_ret;
	}
	
	function get_ship_price($weight)
	{
		$row = $GLOBALS['core.sql']->getRow("SELECT id, price, from_w, to_w, method FROM #p#shipping WHERE from_w <= $weight AND to_w >= $weight");
		if(count($row) > 0)
		{
			return $row;
		}
		else 
		{
			$r = $GLOBALS['core.sql']->getAll("SELECT id, price, from_w, to_w, method FROM #p#shipping ORDER BY to_w DESC LIMIT 1");
			return $r[0];
		}
	} 
	
	function get_items_ship_price($quantity)
	{
		$row = $GLOBALS['core.sql']->getRow("SELECT id, price, from_w, to_w, method FROM #p#item_shipping WHERE from_w <= $quantity AND $quantity <= to_w ");
		if(count($row) > 0)
		{
			return $row;
		}
		else 
		{
			$r = $GLOBALS['core.sql']->getAll("SELECT id, price, from_w, to_w, method FROM #p#item_shipping ORDER BY from_w DESC LIMIT 1");
			//pp($r);
			return $r[0];
		}
	}
	
	function descrease_quantity($cart)
	{
		foreach ($cart as $key => $value)
		{			
			$ph = new ProductHolder($value['product_id']);
            $options = $ph->getAllOptions();
			if (isset($value['options']))
			{
                foreach ($value['options'] as $k => $v)
                {                                     
                    $option = new OptionHolder($k);
                    $option_q = $option->get_data('quantity');
                    if ($option_q > $v) $option_q = $option_q - $v;
                    else $option_q = 0;
                    $option->set_data(array('quantity' => $option_q));
                    $option->save();
                }
			}
			elseif (isset($value['price']))
			{
				if (isset($value['quantity']) && $value['quantity'] > 0) 
				{					
					$product = new ProductHolder($value['product_id']);
                    $product_q = $product->get_data('quantity');
                    if ($product_q > $value['quantity']) $product_q = $product_q - $value['quantity'];
                    else $product_q = 0;
                    $product->set_data(array('quantity' => $product_q));
                    $product->save();
				}
			}
			$ph->checkStockLimit();
		}
	}
	
	function finish_payment($cart, $trid)
	{
		foreach ($cart as $key => $value)
		{
			if (isset($value['certificate']) && !empty($value['certificate']))
			{
				$data = array();
				$data['certificate_id'] = $value['product_id'];
				$data['payment_id'] = $trid;
				$data['person_name'] = $value['person_name'];
				$data['person_email'] = $value['person_email'];
				$data['person_comment'] = $value['person_comment'];
				$data['status'] = 'Not approved';
				
				$pch = new PurchasedCertificateHolder();
				$data['code'] = $pch->generateCode();
				
				$pch->set_data($data);
				$pch->save();
			}
		}
		
		if (isset($_SESSION['certificates']))
		{
			foreach ($_SESSION['certificates'] as $key => $value)
			{
				$cp = new PurchasedCertificateHolder($key);
				$cp->set_data(array('used' => 1));
				$cp->save();
			}
			unset($_SESSION['certificates']);
		}
		
		if (isset($_SESSION['last_ordered'])) unset($_SESSION['last_ordered']);
	}
}
?>