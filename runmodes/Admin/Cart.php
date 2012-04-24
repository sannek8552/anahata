<?php
require_once('Common_Header.php');
require_once('classes/ProductHolder.php');
require_once('classes/DropdownManager.php');
require_once('classes/CartManager.php');
require_once('runmodes/Common/Payment.php');
require_once('classes/UserHolder.php');
require_once('classes/RegistrationHelper.php');
require_once('classes/SettingsHolder.php');
require_once('classes/Coupon/CouponHolder.php');

class Cart extends Runmode 
{
	function Cart()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();		
	}
	
	function process()
	{
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		
	    if (isset($_REQUEST['action']))
	    {
	        if ('Delete' == $_REQUEST['action'])
	        {
	            if (isset($_REQUEST['id']))
	            {
	               if (isset($_SESSION['cart'][$_REQUEST['id']])) unset($_SESSION['cart'][$_REQUEST['id']]);
	            }
	        }
			elseif ('delete_coupon' == $_REQUEST['action'])
			{
            	if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
                {
                        if(isset($_SESSION['coupons'][$_REQUEST['id']]))
						{
                            unset($_SESSION['coupons'][$_REQUEST['id']]);
						}
                }
			}
        }
        if (isset($_REQUEST['update_quantity']) && !empty($_REQUEST['update_quantity']))
        {
			if (isset($_SESSION['cart']))
			{
                foreach ($_SESSION['cart'] as $key => $value)
                {
                    if (isset($value['positions']))
					{
                        foreach ($value['positions'] as $pkey => $pvalue)
                        {
							$rkey = 'quantity_'.$key.'_'.$pkey;
							if (isset($_REQUEST[$rkey]))
							{
                                if (empty($_REQUEST[$rkey]))
                                {
									unset($_SESSION['cart'][$key]['positions'][$pkey]);
									continue;
                                }
                                else
                                {
									$_SESSION['cart'][$key]['positions'][$pkey]['quantity'] = (int)$_REQUEST[$rkey];
                                }
							}
                        }
					}
					elseif (isset($_REQUEST['quantity_'.$key]))
					{
                        if (empty($_REQUEST['quantity_'.$key]))
                        {
							unset($_SESSION['cart'][$key]);
							continue;
                        }
                        else
                        {
							if(isset($_SESSION['cart'][$key]['weight']))
                            {
                                $w = $_SESSION['cart'][$key]['weight']/$_SESSION['cart'][$key]['quantity'];
                                $_SESSION['cart'][$key]['weight'] = $w * (int)$_REQUEST['quantity_'.$key];
							}
                            $_SESSION['cart'][$key]['quantity'] = (int)$_REQUEST['quantity_'.$key];
                        }
                   	}
                    $ph = new ProductHolder();
                    $options = $ph->getAllOptions();
                    foreach($_REQUEST as $key => $value)
                    {
                        $k = str_replace( 'opt_quantity_', '', $key);
                        if($k != $key)
                        {

                            $arr = split('_', $k);
                            if(count($arr) == 2)
                            {
                                if(isset( $_REQUEST['opt_quantity_'.$arr[0].'_'.$arr[1]] ) && is_numeric($_REQUEST['opt_quantity_'.$arr[0].'_'.$arr[1]]))
                                {
                                    $quantity = $_REQUEST['opt_quantity_'.$arr[0].'_'.$arr[1]];
                                }
                                else
                                {
                                    $quantity = 0;
                                }
                                $_SESSION['cart'][$arr[0]]['options'][$arr[1]] = $quantity;
                            }
                        }

                    }
                }
                
                /*
                if (isset($_REQUEST['use_discount_point']) && !empty($_REQUEST['use_discount_point']))
                {
                	if ($GLOBALS['core.auth.user']->is_member_of('user'))
                	{
                		$user = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
                		$udata = $user->get_data();
                		if ($udata['discount_point'] >= $settings['discount_limit'])
                		{
                			if (!isset($_SESSION['cart_discount_point'])) 
                			{
                				$_SESSION['cart_discount_point'] = $udata['discount_point'];
                				$cart = new CartManager();
                				$cart->calculate_total($_SESSION['cart']);
                			}
                		}
                	}
                }
                */
			}
        }
        if (isset($_REQUEST['checkout']) && !empty($_REQUEST['checkout']))
        {
			$GLOBALS['core.runmode']->init('RegistrationInCheckout');
			$GLOBALS['core.runmode']->run();
			return  '';
        }

        if (isset($_SESSION['cart']))
        {
			$cm = new CartManager();			
			$cm->calculate_total($_SESSION['cart']);
			$GLOBALS['core.smarty']->assign('cart',$_SESSION['cart']);
			$GLOBALS['core.smarty']->assign('cart_total',$_SESSION['cart_total']);
			$ph = new ProductHolder();
			$products = $ph->getAll();
			$GLOBALS['core.smarty']->assign('products',$products);
			
			$options = $ph->getAllOptions();
			$GLOBALS['core.smarty']->assign('options',$options);
		
			$dm = new DropdownManager();
			$dm->load_lists();
        }
        $this->process_coupon();
        if (isset($_SESSION['coupons']))
        {
            $GLOBALS['core.smarty']->assign('coupons', $_SESSION['coupons']);
        }
	
        if (!isset($_SESSION['continue_shopping_url']))
        {
        	$continue_shopping_url = 'Category.html';
        }
        else
        {
        	$continue_shopping_url = $_SESSION['continue_shopping_url'];
        }
        
        $GLOBALS['core.smarty']->assign('continue_shopping_url',$continue_shopping_url);
        return Common_Header::out('Common/cart');
	}
	
	function process_coupon()
	{
		if ($GLOBALS['core.auth.user']->is_member_of('user'))
		{
			$error_messages = array();
			if (isset($_REQUEST['code']) && !empty($_REQUEST['code']))
			{
				$ch = new CouponHolder();
				if ($ch->loadByCode($_REQUEST['code']))
				{
				    $coupon_info = $ch->processCart($_SESSION['cart']);
				    if ($coupon_info['error_message'] == '')
				    {
						if (!isset($_SESSION['coupons']))
						{
						    $_SESSION['coupons'] = array();
						}
					    $_SESSION['coupons'][$ch->get_key_value()] = $ch->get_data();
					    $_SESSION['coupons'][$ch->get_key_value()]['discount'] = $coupon_info['discount'];
				    }
				    else 
				    {
				    	$error_messages[] = $coupon_info['error_message'];
				    	//$GLOBALS['core.smarty']->assign('error_message', $coupon_info['error_message']);
				    }
				}
			}
			if(isset($_SESSION['coupons']))
			{
				foreach ($_SESSION['coupons'] as $key => $value)
				{
					$ch = new CouponHolder($key);
					$coupon_info = $ch->processCart($_SESSION['cart'], $key);
					if ($coupon_info['error_message'] == '')
				    {
						if (!isset($_SESSION['coupons']))
						{
						    $_SESSION['coupons'] = array();
						}
					    $_SESSION['coupons'][$ch->get_key_value()] = $ch->get_data();
					    $_SESSION['coupons'][$ch->get_key_value()]['discount'] = $coupon_info['discount'];
				    }
				    else $error_messages[] = $coupon_info['error_message'];
				}
			}
			if (!empty($error_messages)) $GLOBALS['core.smarty']->assign('error_messages',$error_messages);
		}
	}
	
	function checkout()
	{
		$shippings = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ",array(),'id');
		$GLOBALS['core.smarty']->assign('shippings',$shippings);
		
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		$GLOBALS['core.smarty']->assign('settings',$settings);
		
		//pp('here');
		if ((isset($_REQUEST['save']) && !empty($_REQUEST['save'])) || (isset($_REQUEST['js_save']) && !empty($_REQUEST['js_save'])) )
		{
			$billing_info = array();
			$shipping_info = array();
			
			$data = array();
			$error = array();
			$text_cart = "";
			$total = 0;
			if (isset($_SESSION['cart']))
			{
				$cart = $_SESSION['cart'];
				$cart_manager = new CartManager();
				$cart_manager->calculate_total($cart);
				if(isset($_SESSION['total_with_coupons']))
				{
					$total = $_SESSION['total_with_coupons'];
				}
				else 
				{
					$total = $_SESSION['cart_total'];
				}
				
				$text_cart = serialize($cart);
			}
			$data['cart_info'] = $text_cart;
			if (isset($_REQUEST['client_name']) && !empty($_REQUEST['client_name'])) 
			{
				$data['client_name'] = $_REQUEST['client_name'];
				$billing_info['name'] = $_REQUEST['client_name'];
			}
			else $error['client_name'] = 1;
			if (isset($_REQUEST['address']) && !empty($_REQUEST['address']))
			{
				$data['address'] = $_REQUEST['address'];
				$billing_info['address'] = $_REQUEST['address'];
			}
			else $error['address'] = 1;
			if (isset($_REQUEST['shipping_address']) && !empty($_REQUEST['shipping_address'])) 
			{
				$data['shipping_address'] = $_REQUEST['shipping_address'];
				$shipping_info['address'] = $_REQUEST['shipping_address'];
			}
			else $error['shipping_address'] = 1;

			if (isset($_REQUEST['address2']) && !empty($_REQUEST['address2'])) 
			{
				$data['address2'] = $_REQUEST['address2'];
				$billing_info['address2'] = $_REQUEST['address2'];
			}
			if (isset($_REQUEST['shipping_address2']) && !empty($_REQUEST['shipping_address2'])) 
			{
				$data['shipping_address2'] = $_REQUEST['shipping_address2'];
				$shipping_info['address2'] = $_REQUEST['shipping_address2'];
			}
			
			if (isset($_REQUEST['suburb']) && !empty($_REQUEST['suburb'])) 
			{
				$data['suburb'] = $_REQUEST['suburb'];
				$billing_info['suburb'] = $_REQUEST['suburb'];
			}
			else $error['suburb'] = 1;
			if (isset($_REQUEST['shipping_suburb']) && !empty($_REQUEST['shipping_suburb'])) 
			{
				$data['shipping_suburb'] = $_REQUEST['shipping_suburb'];
				$shipping_info['suburb'] = $_REQUEST['shipping_suburb'];
			}
			else $error['shipping_suburb'] = 1;
			
			if (isset($_REQUEST['state']) && !empty($_REQUEST['state'])) 
			{
				$data['state'] = $_REQUEST['state'];
				$billing_info['state'] = $_REQUEST['state'];
			}
			else $error['state'] = 1;
			if (isset($_REQUEST['shipping_state']) && !empty($_REQUEST['shipping_state'])) 
			{
				$data['shipping_state'] = $_REQUEST['shipping_state'];
				$shipping_info['state'] = $_REQUEST['shipping_state'];
			}
			else $error['shipping_state'] = 1;
			
			if (isset($_REQUEST['postcode']) && !empty($_REQUEST['postcode'])) 
			{
				$data['postcode'] = $_REQUEST['postcode'];
				$billing_info['postcode'] = $_REQUEST['postcode'];
			}
			else $error['postcode'] = 1;
			if (isset($_REQUEST['shipping_postcode']) && !empty($_REQUEST['shipping_postcode'])) 
			{
				$data['shipping_postcode'] = $_REQUEST['shipping_postcode'];
				$shipping_info['postcode'] = $_REQUEST['shipping_postcode'];
			}
			else $error['shipping_postcode'] = 1;
			
			if (isset($_REQUEST['phone']) && !empty($_REQUEST['phone'])) 
			{
				$data['phone'] = $_REQUEST['phone'];
				$billing_info['phone'] = $_REQUEST['phone'];
			}
			else $error['phone'] = 1;
			if (isset($_REQUEST['shipping_phone']) && !empty($_REQUEST['shipping_phone'])) 
			{
				$data['shipping_phone'] = $_REQUEST['shipping_phone'];
				$shipping_info['phone'] = $_REQUEST['shipping_phone'];
			}
			else $error['shipping_phone'] = 1;
			
			if (isset($_REQUEST['billing_email']) && !empty($_REQUEST['billing_email'])) 
			{
				$data['email'] = $_REQUEST['billing_email'];
				$billing_info['email'] = $_REQUEST['billing_email'];
			}
			else $error['email'] = 1;
			
			if (isset($_REQUEST['comments']) && !empty($_REQUEST['comments'])) $data['comments'] = $_REQUEST['comments'];
			/*
			if (isset($_REQUEST['shipping'])) 			
				$data['shipping'] = $_REQUEST['shipping'];			
			else $error['shipping'] = 1;
			*/
			$data['shipping'] = $_SESSION['shipping_price'];

			$reg_errors = array();
			$reg_data = array();
			
			if (isset($_REQUEST['login']) && isset($_REQUEST['password']))
			{
				$rh = new RegistrationHelper();
				$reg_data = $rh->gatherData($_REQUEST);
				$reg_errors = $rh->checkForErrors($reg_data);
			}
			
			if (isset($_REQUEST['use_discount_point']) && !empty($_REQUEST['use_discount_point']))
			{
				$GLOBALS['core.smarty']->assign('use_discount_point', 1);
				
				if ($GLOBALS['core.auth.user']->is_member_of('user'))
				{					
					$usr = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
					$discount_point = $usr->get_data('discount_point');
					if ($discount_point >= $settings['discount_limit'])
					{
						if (empty($error))
						{
							if ($discount_point >= $total)
							{
								//no payment at all
								$data['discount_point'] = $total;								
							}
							else 
							{
								$total = $total - $discount_point;
								$data['discount_point'] = $discount_point;
							}
						}
					}
				}
			}
			
			if (isset($_REQUEST['method']))
			{
				if ($_REQUEST['method'] == 'deposit')
				{
					$data['method'] = 'deposit';
					if (empty($error) && empty($reg_errors))
					{
						//save info						
						$data['total'] = $total;
						
						$_SESSION['deposit_info'] = array();
						$_SESSION['deposit_info']['data'] = $data;
						$_SESSION['deposit_info']['billing_info'] = $billing_info;
						$_SESSION['deposit_info']['shipping_info'] = $shipping_info;

						$user_id = 0;
						if (isset($rh))	
						{
							$_SESSION['deposit_info']['reg_data'] = $reg_data;							
						}
					
						$deposit = $GLOBALS['core.sql']->getRow("select * from #p#deposit");
						$GLOBALS['core.smarty']->assign('deposit',$deposit);
						
						return Common_Header::out('Common/deposit_info');
					}
				}
				elseif ($_REQUEST['method'] == 'card')
				{
					$data['method'] = 'card';
					if (empty($error))
					{
						//collect credit card info
						$card = array();
						
						if (isset($_REQUEST['card_type']) && !empty($_REQUEST['card_type']))
						{
							$card['card_type'] = $_REQUEST['card_type'];
						}
						else $error['card_type'] = 1;
						
						if (isset($_REQUEST['card_name']) && !empty($_REQUEST['card_name']))
						{
							$card['card_name'] = $_REQUEST['card_name'];
						}
						else $error['card_name'] = 1;
						
						if (isset($_REQUEST['card_number']) && !empty($_REQUEST['card_name'])
							&& strlen($_REQUEST['card_number']) == 16)
							{
								$card['inner_numbers'] = substr($_REQUEST['card_number'],4,8);
								$card['left_numbers'] = substr($_REQUEST['card_number'],0,4);
								$card['right_numbers'] = substr($_REQUEST['card_number'],12,4);
							}
						else $error['card_number'] = 1;
						
						if (isset($_REQUEST['expire_month']) && !empty($_REQUEST['expire_month'])
							&& isset($_REQUEST['expire_year']) && !empty($_REQUEST['expire_year']))
							{
								$card['expire_month'] = $_REQUEST['expire_month'];
								$card['expire_year'] = $_REQUEST['expire_year'];
							}
						else $error['expire'] = 1;
						
						if (isset($_REQUEST['cvv_number']) && !empty($_REQUEST['cvv_number']))
						{
							$card['cvv_number'] = $_REQUEST['cvv_number'];
						}
						else $error['cvv_number'] = 1;
						
						
						if (empty($error))
						{
							//save info
							$data['total'] = $total;
							$data['card_number'] = $card['inner_numbers'];
							if(is_numeric($GLOBALS['core.auth.user']->uid))
							{
								if(isset($_SESSION['coupons']) && count($_SESSION['coupons']) > 0)
								{
									$data['coupons'] = serialize($_SESSION['coupons']);
								}
							}
							$GLOBALS['core.store']->save('payment',$data,array('key_name' => 'id'));
							$trid = $GLOBALS['core.store']->last_id();
							$GLOBALS['core.store']->save('payment',array('transaction_id' => '0300'.$trid),array('key_name' => 'id','key_value' => $trid));
							if(is_numeric($GLOBALS['core.auth.user']->uid))
							{
								if(isset($_SESSION['coupons']) && count($_SESSION['coupons']) > 0)
								{
									foreach ($_SESSION['coupons'] as $key => $value)
									{
										$cp = new CouponHolder($key);
										//$GLOBALS['core.store']->save('coupon', array('count_of_uses' => $cp->get_data('count_of_uses') + 1), array('key_name' => 'id', 'key_value' => $cp->get_key_value()));
										$cp->set_data(array('count_of_uses' => $cp->get_data('count_of_uses') + 1));
										$cp->save();
										$cp->save_user_coupon($GLOBALS['core.auth.user']->uid, $key);
									}
									$GLOBALS['core.smarty']->assign('coupons_m', $_SESSION['coupons']);
									unset($_SESSION['coupons']);
								}
							}
							if(isset($_SESSION['cart_total']))	$GLOBALS['core.smarty']->assign('cart_total', $_SESSION['cart_total']);
							if(isset($_SESSION['total_with_coupons']))	$GLOBALS['core.smarty']->assign('total_with_coupons', $_SESSION['total_with_coupons']);
							require_once('classes/ProductHolder.php');
							require_once('classes/DropdownManager.php');
							
							$d = $GLOBALS['core.sql']->getRow("select * from #p#payment where id = ?",array($trid));
							$d['products'] = unserialize($d['cart_info']);
							$ph = new ProductHolder();
							$products = $ph->getAll();
							$options = $ph->getAllOptions();
							$GLOBALS['core.smarty']->assign('options',$options);
							$GLOBALS['core.smarty']->assign('products',$products);
							$dm = new DropdownManager();
							$dm->load_lists();
							$GLOBALS['core.smarty']->assign('data',$d);			
							$shippings = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ",array(),'id');
							$GLOBALS['core.smarty']->assign('shippings',$shippings);
														
							$email = $GLOBALS['core.smarty']->fetch('Admin/payment_details.tpl');
							
							//pp($email);
							$info = $GLOBALS['core.sql']->getRow("select * from #p#email where id = ?",array(1));
							$from_name = $settings['credit_card_name']; //$info['from_name'];
							$from_email = $settings['credit_card_from_email']; // $info['from_email'];
							$admin_email = $settings['credit_card_email']; // $info['admin_email'];
														
							$GLOBALS['core.mail']->init();
							$GLOBALS['core.mail']->addAddress($admin_email);
							$GLOBALS['core.mail']->setSubject('Payment info');
							$GLOBALS['core.mail']->setFromName($from_name);
							$GLOBALS['core.mail']->setFrom($from_email);
														
							//$GLOBALS['core.smarty']->assign('data',$data);
							//$GLOBALS['core.smarty']->assign('deposit',1);							
							$GLOBALS['core.mail']->isHTML(true);
                                                        
							$GLOBALS['core.mail']->setBody($email);
							$GLOBALS['core.mail']->send();
							
							$GLOBALS['core.mail']->init();
							$GLOBALS['core.mail']->addAddress($data['email']);
							$GLOBALS['core.mail']->setSubject('Payment info');
							$GLOBALS['core.mail']->setFromName($from_name);
							$GLOBALS['core.mail']->setFrom($from_email);
							$GLOBALS['core.mail']->isHTML(true);
							$GLOBALS['core.mail']->setBody($email);
							$GLOBALS['core.mail']->send();
							
							//pp($GLOBALS['core.mail']);
							//exit();
							
							//email with credit card info
							$GLOBALS['core.mail']->init();
							$GLOBALS['core.mail']->addAddress($admin_email);
							$GLOBALS['core.mail']->setSubject('Card info');
							$GLOBALS['core.mail']->setFromName($from_name);
							$GLOBALS['core.mail']->setFrom($from_email);
														
							$GLOBALS['core.smarty']->assign('data',$d);
							$GLOBALS['core.smarty']->assign('card',$card);
							$GLOBALS['core.smarty']->assign('deposit',1);							
							$email = $GLOBALS['core.smarty']->fetch('Admin/card_details.tpl');


							$GLOBALS['core.mail']->isHTML(true);
							$GLOBALS['core.mail']->setBody($email);
							$GLOBALS['core.mail']->send();
							
							//pp($email);
							//pp($GLOBALS['core.mail']);
							
							//$this->finish_payment();
							unset($_SESSION['cart']);
							
							//save discount points
							if (!isset($data['discount_point']) && $GLOBALS['core.auth.user']->is_member_of('user'))
							{
									if (isset($settings['discount_point']) && !empty($settings['discount_point']))
									{
										$total = 0;
										if (isset($_SESSION['total_with_coupons'])) $total = $_SESSION['total_with_coupons'];
										elseif (isset($_SESSION['cart_total'])) $total = $_SESSION['cart_total'];
										$points = $total * $settings['discount_point'];
										$user = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
										$points += $user->get_data('discount_point');				
										$user->set_data(array('discount_point' => $points));
										$user->save();
										$this->check_limit_discount($total * $settings['discount_point']);
									}
							}
							elseif (isset($data['discount_point']))
							{
								$user = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
								$old_point = $user->get_data('discount_point');
								$user->set_data(array('discount_point' => $old_point - $data['discount_point']));
								$user->save();
							}

							
							//direct deposit info need to show
							//with "0300 + id from database"
							
							//$GLOBALS['core.smarty']->assign('trid',$trid);
							//return Common_Header::out('Common/card_info');												
							$conf = $GLOBALS['core.config']->get_config('templates');
							header("Location:" . $conf['common']['domain_name'] . $conf['common']['script_url'] . "Thank_You/" . $trid . ".html");
							exit();
						}
						else 
						{
							$card['card_number'] = $_REQUEST['card_number'];
							$GLOBALS['core.smarty']->assign('card',$card);
						}
					}
				} 
				elseif ($_REQUEST['method'] == 'paypal' && $settings['paypal'] == 1)
				{
					$data['method'] = 'paypal';
					$_SESSION['paypal_payment'] = $data;
					$payment = new Payment();
					return $payment->process_paypal();
				}
				else $error['method'] = 1;
			}
			else $error['method'] = 1;
			if (!empty($error) || !empty($reg_errors)) 
			{
				$GLOBALS['core.smarty']->assign('error',$error);
				$GLOBALS['core.smarty']->assign('data',$data);
				
				$GLOBALS['core.smarty']->assign('reg_errors',$reg_errors);
				$GLOBALS['core.smarty']->assign('reg_data',$reg_data);
			}
		}

		if (isset($_SESSION['cart']))
		{
			$cm = new CartManager();			
			$cm->calculate_total($_SESSION['cart']);
			$total = $_SESSION['cart_total'];
			$GLOBALS['core.smarty']->assign('total',$total);
		}
		
		if ($GLOBALS['core.auth.user']->is_member_of('user'))
		{
			$uh = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);			
			$udata = $uh->getFullData();
			$resdata = $uh->transformData($udata);
			$GLOBALS['core.smarty']->assign('data',$resdata);
		}
		elseif (isset($_REQUEST['sign_in']) && !empty($_REQUEST['sign_in']))
		{
			$GLOBALS['core.smarty']->assign('error_login',1);
			$GLOBALS['core.runmode']->init('RegistrationInCheckout');
			$GLOBALS['core.runmode']->run();
			return '';
		}
		elseif (isset($_SESSION['reg_in_check']) && !empty($_SESSION['reg_in_check']))
		{
			$regincheck = $_SESSION['reg_in_check'];
			//unset($_SESSION['reg_in_check']);
			if ($regincheck == 1)	$GLOBALS['core.smarty']->assign('create_account',1);
			elseif ($regincheck == 2) $GLOBALS['core.smarty']->assign('anonymous_account',1);
		} 
		if(isset($_SESSION['cart_total']))	$GLOBALS['core.smarty']->assign('cart_total', $_SESSION['cart_total']);
		if(isset($_SESSION['total_with_coupons']))	$GLOBALS['core.smarty']->assign('total_with_coupons', $_SESSION['total_with_coupons']);
		if (isset($_SESSION['total_with_coupons']))	$GLOBALS['core.smarty']->assign('real_total', $_SESSION['total_with_coupons']);
		elseif (isset($_SESSION['cart_total'])) $GLOBALS['core.smarty']->assign('real_total', $_SESSION['cart_total']);
		
		
		return Common_Header::out('Common/checkout'); 
	}
	
	function process_card($data)
	{
		
	}
	
	function finish_payment()
	{
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		
		if (isset($_SESSION['paypal_payment']) && !empty($_SESSION['paypal_payment']))
		{
			$data = $_SESSION['paypal_payment'];
			if (!isset($data['discount_point']) && $GLOBALS['core.auth.user']->is_member_of('user'))
			{
				if (isset($settings['discount_point']) && !empty($settings['discount_point']))
				{
					$total = 0;
					if (isset($_SESSION['total_with_coupons'])) $total = $_SESSION['total_with_coupons'];
					elseif (isset($_SESSION['cart_total'])) $total = $_SESSION['cart_total'];
					$points = $total * $settings['discount_point'];
					$user = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
					$points += $user->get_data('discount_point');				
					$user->set_data(array('discount_point' => $points));
					$user->save();
					$this->check_limit_discount($total * $settings['discount_point']);
				}
			}
			elseif (isset($data['discount_point']))
			{
				$user = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
				$old_point = $user->get_data('discount_point');
				$user->set_data(array('discount_point' => $old_point - $data['discount_point']));
				$user->save();
			}
		}
		
		unset($_SESSION['cart']);
		$config = $GLOBALS['core.config']->get_config('templates');
		$url = $GLOBALS['core.sql']->getOne("select url from #p#deposit");
		header("Location: ".$config['common']['full_url'].$url.".html");
		return '';
	}
	
	function thankyou()
	{
		//return Common_Header::out('Common/CMS/finish_payment');
	} 
	
	function finish_deposit()
	{
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		
		$data = $_SESSION['deposit_info']['data'];
		$billing_info = $_SESSION['deposit_info']['billing_info'];
		$shipping_info = $_SESSION['deposit_info']['shipping_info'];
		
		$user_id = 0;
		if (isset($_SESSION['deposit_info']['reg_data']))	
		{
			$rh = new RegistrationHelper();
			$reg_data = $_SESSION['deposit_info']['reg_data'];			
			$user_id = $rh->registerUser($reg_data);
			$rh->authoriseUser($reg_data);
			
			$user = new UserHolder($user_id);
			$billing_info['user_id'] = $user_id;
			$shipping_info['user_id'] = $user_id;
			$user->saveBilling($billing_info);
			$user->saveShipping($shipping_info);			
			
		}
		elseif ($GLOBALS['core.auth.user']->uid) $user_id = $GLOBALS['core.auth.user']->uid;
		
		$data['user_id'] = $user_id;
		if(is_numeric($GLOBALS['core.auth.user']->uid))
		{
			if(isset($_SESSION['coupons']) && count($_SESSION['coupons']) > 0)
			{
				$data['coupons'] = serialize($_SESSION['coupons']);
			}
		}
		$GLOBALS['core.store']->save('payment',$data,array('key_name' => 'id'));
		$trid = $GLOBALS['core.store']->last_id();
		$GLOBALS['core.store']->save('payment',array('transaction_id' => '0300'.$trid),array('key_name' => 'id','key_value' => $trid));
		if(is_numeric($GLOBALS['core.auth.user']->uid))
		{
			if(isset($_SESSION['coupons']) && count($_SESSION['coupons']) > 0)
			{
				foreach ($_SESSION['coupons'] as $key => $value)
				{
					$cp = new CouponHolder($key);
					//$GLOBALS['core.store']->save('coupon', array('count_of_uses' => $cp->get_data('count_of_uses') + 1), array('key_name' => 'id', 'key_value' => $cp->get_key_value()));
					$cp->set_data(array('count_of_uses' => $cp->get_data('count_of_uses') + 1));
					$cp->save();
					$cp->save_user_coupon($GLOBALS['core.auth.user']->uid, $key);
				}
				$GLOBALS['core.smarty']->assign('coupons_m', $_SESSION['coupons']);
				unset($_SESSION['coupons']);
			}
		}
		if(isset($_SESSION['cart_total']))	$GLOBALS['core.smarty']->assign('cart_total', $_SESSION['cart_total']);
		if(isset($_SESSION['total_with_coupons']))	$GLOBALS['core.smarty']->assign('total_with_coupons', $_SESSION['total_with_coupons']);
		require_once('classes/ProductHolder.php');
		require_once('classes/DropdownManager.php');
		
		$d = $GLOBALS['core.sql']->getRow("select * from #p#payment where id = ?",array($trid));
		$d['products'] = unserialize($d['cart_info']);
		$ph = new ProductHolder();
		$products = $ph->getAll();
		$GLOBALS['core.smarty']->assign('products',$products);
		$options = $ph->getAllOptions();
		$GLOBALS['core.smarty']->assign('options',$options);
		
		$dm = new DropdownManager();
		$dm->load_lists();
		$GLOBALS['core.smarty']->assign('data',$d);			
		$shippings = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ",array(),'id');
		$GLOBALS['core.smarty']->assign('shippings',$shippings);
		//pp($d);
		if (isset($data['discount_point'])) $GLOBALS['core.smarty']->assign('discount_point', $data['discount_point']);
		
		$email = $GLOBALS['core.smarty']->fetch('Admin/payment_details.tpl');
		
		
		$info = $GLOBALS['core.sql']->getRow("select * from #p#email where id = ?",array(1));
		
		$from_name = $settings['direct_deposit_from_name']; //$info['from_name'];
		$from_email = $settings['direct_deposit_from_email']; // $info['from_email'];
		$admin_email = $settings['direct_deposit_email']; // $info['admin_email'];
								
		$GLOBALS['core.mail']->init();
		$GLOBALS['core.mail']->addAddress($admin_email);
		$GLOBALS['core.mail']->setSubject('Payment info');
		$GLOBALS['core.mail']->setFromName($from_name);
		$GLOBALS['core.mail']->setFrom($from_email);
								
		$GLOBALS['core.smarty']->assign('data',$data);
		$GLOBALS['core.smarty']->assign('deposit',1);
		
		$GLOBALS['core.mail']->isHTML(true);
		$GLOBALS['core.mail']->setBody($email);
		$GLOBALS['core.mail']->send();
		
		$GLOBALS['core.mail']->init();
		$GLOBALS['core.mail']->addAddress($data['email']);
		$GLOBALS['core.mail']->setSubject('Payment info');
		$GLOBALS['core.mail']->setFromName($from_name);
		$GLOBALS['core.mail']->setFrom($from_email);
		$GLOBALS['core.mail']->isHTML(true);
		$GLOBALS['core.mail']->setBody($email);
		$GLOBALS['core.mail']->send();
		unset($_SESSION['cart']);
				
		/*
		//direct deposit info need to show
		//with "0300 + id from database"
		$GLOBALS['core.smarty']->assign('trid',$trid);
		$deposit = $GLOBALS['core.sql']->getRow("select * from #p#deposit");
		$GLOBALS['core.smarty']->assign('deposit',$deposit);				
		return Common_Header::out('Common/finish_deposit');
		*/
		
		if (!isset($data['discount_point']) && $GLOBALS['core.auth.user']->is_member_of('user'))
		{
			if (isset($settings['discount_point']) && !empty($settings['discount_point']))
			{
				$total = 0;
				if (isset($_SESSION['total_with_coupons'])) $total = $_SESSION['total_with_coupons'];
				elseif (isset($_SESSION['cart_total'])) $total = $_SESSION['cart_total'];
				$points = $total * $settings['discount_point'];
				$user = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
				$points += $user->get_data('discount_point');				
				$user->set_data(array('discount_point' => $points));
				$user->save();
				$this->check_limit_discount($total * $settings['discount_point']);
			}
		}
		elseif (isset($data['discount_point']))
		{
			$user = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
			$old_point = $user->get_data('discount_point');
			$user->set_data(array('discount_point' => $old_point - $data['discount_point']));
			$user->save();
		}
		
		$conf = $GLOBALS['core.config']->get_config('templates');
		header("Location:" . $conf['common']['domain_name'] . $conf['common']['script_url'] . "Thank_You/" . $trid . "/1.html");
		return;
	}
	
	function check_limit_discount($addedd_amount)
	{
		$user = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
		$points = $user->get_data('discount_point');
		
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		
		if ($points >= $settings['discount_limit'] && ($points - $addedd_amount < $settings['discount_limit']))
		{
			$info = $GLOBALS['core.sql']->getRow("select * from #p#email where id = ?",array(1));
		
			$from_name = $settings['direct_deposit_from_name']; //$info['from_name'];
			$from_email = $settings['direct_deposit_from_email']; // $info['from_email'];
			$admin_email = $settings['direct_deposit_email']; // $info['admin_email'];
									
			$GLOBALS['core.mail']->init();
			$GLOBALS['core.mail']->addAddress($admin_email);
			$GLOBALS['core.mail']->setSubject('Reaching discount points limit');
			$GLOBALS['core.mail']->setFromName($from_name);
			$GLOBALS['core.mail']->setFrom($from_email);
									
			$GLOBALS['core.smarty']->assign('data',$data);
			$GLOBALS['core.smarty']->assign('deposit',1);
			
			$GLOBALS['core.smarty']->assign('data', $user->getFullData());
			$email = $GLOBALS['core.smarty']->fetch('Emails/admin_email_discount_point.tpl');

			$GLOBALS['core.mail']->isHTML(true);
			$GLOBALS['core.mail']->setBody($email);
			$GLOBALS['core.mail']->send();
			
			$GLOBALS['core.mail']->init();
			$GLOBALS['core.mail']->addAddress($user->get_data('email'));
			$GLOBALS['core.mail']->setSubject('Reaching discount points limit');
			$GLOBALS['core.mail']->setFromName($from_name);
			$GLOBALS['core.mail']->setFrom($from_email);
			$email = "Congratulations! You exceed minimum limit to use discount points. Now you can use them to pay at bambinosandrugrats.com.au ";
			$GLOBALS['core.mail']->setBody($email);
			$GLOBALS['core.mail']->send();
		}
	}
}
?>