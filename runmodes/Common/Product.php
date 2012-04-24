<?php
require_once('Common_Header.php');
require_once('classes/ProductHolder.php');
require_once('classes/CategoryHolder.php');
require_once('classes/DropdownManager.php');
require_once('classes/CMS/SettingsHolder.php');

class Product extends Runmode 
{
	function Product()
	{
		$this->base_map[0] = 'id';
		$this->base_map[1] = 'action';		
		$this->base_map[2] = 'second_action_id';
		parent::Runmode();
		
		if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		{
			if (!is_numeric($_REQUEST['id']))
			{
				$ph = new ProductHolder();				
				if ($ph->loadBySeo($_REQUEST['id']))
				{
					$_REQUEST['id'] = $ph->get_key_value();
				}
			}
		}
	}
	
	function process()
	{
                if (isset($_REQUEST['id']))
                {
                        $ph = new ProductHolder($_REQUEST['id']);
                        $active = $ph->hasActiveCategory();
                        if ($active)
                        {
                            $id = $_REQUEST['id'];


                            $ph = new ProductHolder($id);
                            $pdata = $ph->get_data();
                            if (!empty($pdata))
                            {
                                $GLOBALS['core.smarty']->assign('pdata',$pdata);
                                $GLOBALS['core.smarty']->assign('seo_data',$pdata);
                                $GLOBALS['core.smarty']->assign('cur_cat',$pdata['category_id']);
                                $this->load_lists();
                            }

                            $ph->loadAllProducts();

                        }
                        else $GLOBALS['core.smarty']->assign('inactive_product',1);

                }
		return Common_Header::out('Common/product');
	}
	
	function ajax_calculate_price()
	{
		$response = array('html' => '','success' => 1,'message' => '','price' => '');
		
		if (isset($_REQUEST['q']['id']) && !empty($_REQUEST['q']['id']))
		{
			$id = $_REQUEST['q']['id'];
			if (	isset($_REQUEST['q']['width']) && !empty($_REQUEST['q']['width'])
				&&	isset($_REQUEST['q']['height']) && !empty($_REQUEST['q']['height']))
				{
					if ($_REQUEST['q']['width'][0] == '.') $_REQUEST['q']['width'] = "0".$_REQUEST['q']['width'];
					if ($_REQUEST['q']['height'][0] == '.') $_REQUEST['q']['height'] = "0".$_REQUEST['q']['height'];
				
					$ph = new ProductHolder($_REQUEST['q']['id']);
					$price = $ph->calculate_price($_REQUEST['q']['width'],$_REQUEST['q']['height']);
					if ($price == -1) $response['message'] = 'Invalid input data';
					else $response['price'] = $price;
				}
				else
				{
					$response['message'] = 'Invalid input data';
				}
		}
		$GLOBALS['core.ajax']->put_to_output($response);
	}
	
	function process_save($id)
	{		
		$ph = new ProductHolder($id);
		
		$access = $ph->hasActiveCategory();
		if ($access)
		{		
			$pdata = $ph->get_data();
	        $options = $ph->getOptions();
			
			$data = array();
			$add_to_cart = true;
			
			$data['category_id'] = $pdata['category_id'];
			if (isset($pdata['not_wholesale']))	$data['not_wholesale'] = $pdata['not_wholesale'];
			$data['price'] = 0;
	        $data['weight'] = 0;
	        $error_message = "";
			if (isset($_REQUEST['quantity']) && !empty($_REQUEST['quantity']))
			{
				if ($_REQUEST['quantity'] <= $pdata['quantity'])
				{
					$data['quantity'] = $_REQUEST['quantity'];
	            	$data['price'] = $pdata['price'];
					$data['quantity'] = (int)$_REQUEST['quantity'];				
					$data['weight'] = $data['weight'] * $data['quantity'];
				}
				else
				{
					$add_to_cart = false;
					$error_message = 'We currently only have ' . $pdata['quantity'] . ' item(s) of this product in stock. Please adjust your quantity to within this quantity';
				}
			}
	       	else
	        {
	        	if (isset($_REQUEST['quantity_option']))
	        	{
		            foreach($_REQUEST['quantity_option'] as $k => $value)
		            {
		                if(is_numeric($k))
		                {                    
		                    if(isset($_REQUEST['quantity_option'][$k]) && is_numeric($_REQUEST['quantity_option'][$k]) && !empty($_REQUEST['quantity_option'][$k]))
		                    {
		                        $quantity = $_REQUEST['quantity_option'][$k];
								$option = new OptionHolder($k);
								$odata = $option->get_data();
								$oquantity = $odata['quantity'];
								if ($quantity <= $oquantity)
								{
		                        	$data['options'][$k] = $quantity;
		    	                	$data['price'] = $options[$k]['price'] * $quantity + $data['price'];
		        	            	$data['quantity'] = 1;
								}
								else 
								{                        
		                        	$add_to_cart = false;                        	
		                        	$error_message .= "<br />We currently only have " . $odata['quantity'] . " item(s) of this product option" . $odata['name']  . " in stock. Please adjust your quantity to within this quantity";
								}
		                    }
		                }
		            }
	        	}
	            if (empty($data['options'])) $add_to_cart = false;
	        }
			$data['product_id'] = $id;
	                    
			if ($add_to_cart && $data['price'] > 0)
			{
				if (!isset($_SESSION['cart']))
				{
	                $_SESSION['cart'] = array();
				}
				if (isset($_REQUEST['cart_id']))
				{
	                $_SESSION['cart'][$_REQUEST['cart_id']] = $data;
				}
				else
				{
					if(count($_SESSION['cart']) > 0)
					{
						$flag = 0;
						foreach ($_SESSION['cart'] as $key => $value)
						{						
							if(($pdata['has_options'] && isset($value['option_id']) && $data['option_id'] == $value['option_id']) 
								|| ($pdata['has_options'] == 0 && $value['product_id'] == $data['product_id']))
							{
								$_SESSION['cart'][$key]['quantity'] += $data['quantity'];
								$flag = 1;
								break;
							}
						}
						if($flag < 1)
						{
							$_SESSION['cart'][] = $data;
						}	
					}
					else 
					{
						$_SESSION['cart'][] = $data;
					}
				}
			}
			
			if (isset($_REQUEST['cart_id'])) $GLOBALS['core.smarty']->assign('cart_id', $_REQUEST['cart_id']);
			$GLOBALS['core.smarty']->assign('error_message', $error_message);
			$GLOBALS['core.smarty']->assign('request', $_REQUEST);
		}
		
		return $add_to_cart;
	}

	
	function load_lists()
	{
		$ph = new ProductHolder();
		$ph->load_lists();
		
		$ch = new CategoryHolder();
		$list = $ch->getAll();
		$GLOBALS['core.smarty']->assign('tag_categories',$list);
		
	}
}
?>