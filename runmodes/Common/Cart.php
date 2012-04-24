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
require_once('classes/CrossSellHolder.php');
require_once('classes/CertificateHolder.php');

class Cart extends Runmode 
{
	function Cart()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		$this->base_map[2] = 'option_id';
		parent::Runmode();		
	}
	
	function process()
	{
		//pp($_REQUEST);
		//pp($_SESSION);
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
			elseif ('delete_certificate' == $_REQUEST['action'])
			{
            	if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
                {
                    if(isset($_SESSION['certificates'][$_REQUEST['id']]))
					{
                        unset($_SESSION['certificates'][$_REQUEST['id']]);
					}
                }
			}
			elseif ('DeleteOption' == $_REQUEST['action'])
			{
				if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
                {
                	if(isset($_REQUEST['option_id']) && is_numeric($_REQUEST['option_id']))
                	{
                		if (isset($_SESSION['cart'][$_REQUEST['id']]['options'][$_REQUEST['option_id']]))
                		{
                			unset($_SESSION['cart'][$_REQUEST['id']]['options'][$_REQUEST['option_id']]);
                		}
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
			}
        }        

        if (isset($_SESSION['cart']))
        {
			$cm = new CartManager();			
			$cm->calculate_total($_SESSION['cart']);
			$GLOBALS['core.smarty']->assign('cart',$_SESSION['cart']);
			$GLOBALS['core.smarty']->assign('cart_total',$_SESSION['cart_total']);
			$GLOBALS['core.smarty']->assign('wholesale_discount',$_SESSION['wholesale_discount']);
			$ph = new ProductHolder();
			$products = $ph->getAll();
			$GLOBALS['core.smarty']->assign('products',$products);
			
			$ch = new CertificateHolder();
			$ch->load_lists();
			
			$options = $ph->getAllOptions();
			$GLOBALS['core.smarty']->assign('options',$options);
		
			$dm = new DropdownManager();
			$dm->load_lists();
			
			$product_ids = $cm->get_product_ids($_SESSION['cart']);
        	$csm = new CrossSellHolder();
        	$cross_sells = $csm->getProductsCrossSells($product_ids);
        	$GLOBALS['core.smarty']->assign('cross_sells', $cross_sells);
        	
        	if (isset($settings['shipping_type']))
        	{
        		if ($settings['shipping_type'] == 0)
				{					
					
				}
				elseif ($settings['shipping_type'] == 1)
				{
					//fixed
					$fixed_shippings = $GLOBALS['core.sql']->getAll("select * from #p#fixed_shipping");
					$GLOBALS['core.smarty']->assign('fixed_shippings', $fixed_shippings);
				}
				else 
				{
					
				}
        	}
        	
        	if (isset($_SESSION['shipping'])) $GLOBALS['core.smarty']->assign('shipping', $_SESSION['shipping']);
        }
        $this->process_coupon();
        if (isset($_SESSION['coupons']))
        {
            $GLOBALS['core.smarty']->assign('coupons', $_SESSION['coupons']);
        }
        
        $this->process_certificate();
        if (isset($_SESSION['certificates']))
        {        	
            $GLOBALS['core.smarty']->assign('cart_certificates', $_SESSION['certificates']);
        }
	
        if (!isset($_SESSION['continue_shopping_url']))
        {
        	$continue_shopping_url = 'Categories.html';
        }
        else
        {
        	$continue_shopping_url = $_SESSION['continue_shopping_url'];
        }
        $GLOBALS['core.smarty']->assign('continue_shopping_url',$continue_shopping_url);
        
        
        if (isset($_REQUEST['checkout']) && !empty($_REQUEST['checkout']))
        {
			$GLOBALS['core.runmode']->init('RegistrationInCheckout');
			$GLOBALS['core.runmode']->run();
			return  '';
        }
        
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
	
	function process_certificate()
	{		
		if ($GLOBALS['core.auth.user']->is_member_of('user'))
		{			
			$error_messages = array();
			if (isset($_REQUEST['certificate_code']) && !empty($_REQUEST['certificate_code']))
			{
				//pp($_REQUEST);
				$pch = new PurchasedCertificateHolder();
				if ($pch->loadByCode($_REQUEST['certificate_code']))
				{
				    $certificate_info = $pch->processCart($_SESSION['cart']);
				    if ($certificate_info['error_message'] == '')
				    {
						if (!isset($_SESSION['certificates']))
						{
						    $_SESSION['certificates'] = array();
						}
					    $_SESSION['certificates'][$pch->get_key_value()] = $pch->get_data();
					    $_SESSION['certificates'][$pch->get_key_value()]['discount'] = $certificate_info['discount'];
				    }
				    else 
				    {
				    	$error_messages[] = $certificate_info['error_message'];
				    }
				}
				else $error_messages[] = 'Certificate with this code does not exist.';
			}
			if(isset($_SESSION['certificates']))
			{
				foreach ($_SESSION['certificates'] as $key => $value)
				{
					$pch = new PurchasedCertificateHolder($key);
					$certificate_info = $pch->processCart($_SESSION['cart'], $key);
					if ($certificate_info['error_message'] == '')
				    {
						if (!isset($_SESSION['certificates']))
						{
						    $_SESSION['certificates'] = array();
						}
					    $_SESSION['certificates'][$pch->get_key_value()] = $pch->get_data();
					    $_SESSION['certificates'][$pch->get_key_value()]['discount'] = $certificate_info['discount'];
				    }
				    else $error_messages[] = $coupon_info['error_message'];
				}
			}
			if (!empty($error_messages)) $GLOBALS['core.smarty']->assign('error_messages',$error_messages);
		}
	}
	
	function checkout()
	{
		/*
		$shippings = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ",array(),'id');
		$GLOBALS['core.smarty']->assign('shippings',$shippings);
		*/
		
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
            $total = 0;
            
            $this->validate_form_data($data, $error, $billing_info, $shipping_info, $total);
            
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
                                $data['total'] = 0;
                                if (isset($_SESSION['shipping'])) $data['shipping_info'] = serialize($_SESSION['shipping']);

                                if(is_numeric($GLOBALS['core.auth.user']->uid))
                                {
                                    if(isset($_SESSION['coupons']) && count($_SESSION['coupons']) > 0) $data['coupons'] = serialize($_SESSION['coupons']);
                                    if(isset($_SESSION['certificates']) && count($_SESSION['certificates']) > 0) $data['certificates'] = serialize($_SESSION['certificates']);
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
                                                                
                                
                                $from_name = $settings['credit_card_name'];
                                $from_email = $settings['credit_card_from_email'];
                                $admin_email = $settings['credit_card_email'];
                                
                                $this->send_payment_email($trid,$from_name, $from_email, $admin_email, $data['email']);
        						$cm = new CartManager();
        						$cm->descrease_quantity($_SESSION['cart']);
								$cm->finish_payment($_SESSION['cart'], $trid);
                                unset($_SESSION['cart']);

                                $conf = $GLOBALS['core.config']->get_config('templates');
                                header("Location:" . $conf['common']['domain_name'] . $conf['common']['script_url'] . "Thank_You/" . $trid . ".html");
                                return;

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
                        $data['method'] = 'direct deposit';
                        if (empty($error) && empty($reg_errors))
                        {
                            //save info
                            $data['total'] = $total;
							if (isset($_SESSION['shipping'])) $data['shipping_info'] = serialize($_SESSION['shipping']);
                            $_SESSION['deposit_info'] = array();
                            $_SESSION['deposit_info']['data'] = $data;
                            $_SESSION['deposit_info']['billing_info'] = $billing_info;
                            $_SESSION['deposit_info']['shipping_info'] = $shipping_info;

                            $user_id = 0;
                            if (isset($rh))	$_SESSION['deposit_info']['reg_data'] = $reg_data;

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

                                    /*
                                    if (isset($_REQUEST['card_type']) && !empty($_REQUEST['card_type']))	$card['card_type'] = $_REQUEST['card_type'];
                                    else $error['card_type'] = 1;
                                    */

                                    if (isset($_REQUEST['card_name']) && !empty($_REQUEST['card_name']))	$card['card_name'] = $_REQUEST['card_name'];
                                    else $error['card_name'] = 1;

                                    
                                    if (isset($_REQUEST['card_number']) && !empty($_REQUEST['card_name']))
                                    {
	                                    $card['card_number'] = $_REQUEST['card_number'];
                                    }
                                    else $error['card_number'] = 1;

                                    if (isset($_REQUEST['expire_month']) && !empty($_REQUEST['expire_month'])
                                            && isset($_REQUEST['expire_year']) && !empty($_REQUEST['expire_year']))
                                            {
                                                $card['expire_month'] = $_REQUEST['expire_month'];
                                                $card['expire_year'] = $_REQUEST['expire_year'];
                                            }
                                    else $error['expire'] = 1;

                                    if (isset($_REQUEST['cvv_number']) && !empty($_REQUEST['cvv_number']))	$card['cvv_number'] = $_REQUEST['cvv_number'];
                                    else $error['cvv_number'] = 1;

                                    if (empty($error))
                                    {
                                    	//pp($_REQUEST);
                                    	$vpcURL = "https://api.securepay.com.au/xmlapi/payment"; 
                                    	//"http://test.securepay.com.au/xmlapi/payment";
                                    	$merchantID = "SEJ00" . "01";
                                    	$merchantPassword = "hFs5rUeax8"; //"9mYwZABp";
                                    	
                                    	$card_number = $_REQUEST['card_number'];
                                    	$card_expiry = $_REQUEST['expire_month'] . "/" . $_REQUEST['expire_year'];
                                    	$card_cvv = $_REQUEST['cvv_number'];
                                    	
                                    	$total = sprintf("%01.2f", $total);
                                    	$new_total = str_replace(".","", $total); 
                                    	$messageID = md5(time().microtime());
                                    	$messageTimestamp = date("YdmHis")."000000+600";
                                    	
                                    	$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                                    				<SecurePayMessage>
                                    					<MessageInfo>
															<messageID>$messageID</messageID>
															<messageTimestamp>$messageTimestamp</messageTimestamp>
															<timeoutValue>60</timeoutValue>
															<apiVersion>xml-4.2</apiVersion>
														</MessageInfo>
														<MerchantInfo>
															<merchantID>$merchantID</merchantID>
															<password>$merchantPassword</password>
														</MerchantInfo>
														<RequestType>Payment</RequestType>
														<Payment>
															<TxnList count=\"1\">\"
																<Txn ID=\"1\">
																	<txnType>0</txnType>
																	<txnSource>23</txnSource>
																	<amount>$new_total</amount>
																	<currency>AUD</currency>
																	<purchaseOrderNo>test</purchaseOrderNo>
																	<CreditCardInfo>
																		<cardNumber>$card_number</cardNumber>
																		<expiryDate>$card_expiry</expiryDate>
																		<cvv>$card_cvv</cvv>
																	</CreditCardInfo>
																</Txn>
															</TxnList>
														</Payment>
													</SecurePayMessage>";
                                    	ob_start();
										
										// initialise Client URL object
										//print $xml;
										$ch = curl_init();
										
										// set the URL of the VPC
										curl_setopt ($ch, CURLOPT_URL, $vpcURL);
										curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));	  										
										curl_setopt ($ch, CURLOPT_POST, 1);
										curl_setopt ($ch, CURLOPT_POSTFIELDS, $xml);
                                    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
										curl_exec ($ch);
										
										// get response
										$response = ob_get_contents();										
										
										// turn output buffering off.
										ob_end_clean();										
										// close client URL
										curl_close ($ch);
										//print '<pre>';
										//print_r($response);
										$GLOBALS['core.xml']->setInputString($response);
										$result = $GLOBALS['core.xml']->parser_xml_to_array();
										//pp($result);
										//exit();																				
										
										if (isset($result['SecurePayMessage']['Payment'][0]['TxnList'][0]['Txn'][0]['approved'][0]['value']) && $result['SecurePayMessage']['Payment'][0]['TxnList'][0]['Txn'][0]['approved'][0]['value'] == 'Yes')
										{
											$approved = true;
											$status = 1;
										}
										else 
										{
											$approved = false;
											$status = $result['SecurePayMessage']['Payment'][0]['TxnList'][0]['Txn'][0]['responseText'][0]['value'];
										}
										
										//pp($result);
										//pp($status);
										//exit();

										if ($approved)
										{															
	                                        //save info
	                                        $data['total'] = $total;
	                                        if (isset($_SESSION['shipping'])) $data['shipping_info'] = serialize($_SESSION['shipping']);
	                                        //$data['card_number'] = $card['inner_numbers'];
	                                        if(is_numeric($GLOBALS['core.auth.user']->uid))
	                                        {
	                                        	$data['user_id'] = $GLOBALS['core.auth.user']->uid;
	                                            if(isset($_SESSION['coupons']) && count($_SESSION['coupons']) > 0) $data['coupons'] = serialize($_SESSION['coupons']);
	                                            if(isset($_SESSION['certificates']) && count($_SESSION['certificates']) > 0) $data['certificates'] = serialize($_SESSION['certificates']);
	                                        }
	                                        $GLOBALS['core.store']->save('payment',$data,array('key_name' => 'id'));
	                                        $trid = $GLOBALS['core.store']->last_id();	                                        
	                                        $GLOBALS['core.store']->save('payment',array('transaction_id' => $trid),array('key_name' => 'id','key_value' => $trid));
	                                        if(is_numeric($GLOBALS['core.auth.user']->uid))
	                                        {
	                                                if(isset($_SESSION['coupons']) && count($_SESSION['coupons']) > 0)
	                                                {
	                                                        foreach ($_SESSION['coupons'] as $key => $value)
	                                                        {
	                                                                $cp = new CouponHolder($key);                                                                
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
	                                                                                
	                                       	$from_name = $settings['credit_card_name'];
	                                		$from_email = $settings['credit_card_from_email'];
	                                		$admin_email = $settings['credit_card_email'];
	                                        
	                                        $this->send_payment_email($trid,$from_name, $from_email, $admin_email, $data['email']);

	                                        $cm = new CartManager();
	        								$cm->descrease_quantity($_SESSION['cart']);
	                                        $cm->finish_payment($_SESSION['cart'], $trid);
	                                        unset($_SESSION['cart']);
	
	                                        //save discount points
	                                        if (!isset($data['discount_point']) && $GLOBALS['core.auth.user']->is_member_of('user'))
	                                        {
	                                            if (isset($settings['discount_point']) && !empty($settings['discount_point']))
	                                            {                                                                            
	                                                $total = 0;
	                                                if (isset($_SESSION['total_cost'])) $total = $_SESSION['total_cost'];
	                                                $points = $total * $settings['discount_point'];
													$GLOBALS['core.store']->save('payment',array('not_approved_points' => $points),array('key_name' => 'id' , 'key_value' => $trid));
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
	                                        
	                                        $conf = $GLOBALS['core.config']->get_config('templates');
	                                        header("Location:" . $conf['common']['domain_name'] . $conf['common']['script_url'] . "Thank_You/" . $trid . ".html");
	                                        exit();
										}
										else 
										{
											//pp($message);
											//pp($response);
											$GLOBALS['core.smarty']->assign('payment_error', $status);
                                            $GLOBALS['core.smarty']->assign('card',$card);                                            
                                            $GLOBALS['core.smarty']->assign('data', $data);
										}
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
                    	if (empty($error) && empty($reg_errors))
                        {
                            $data['method'] = 'paypal';
                            if (isset($_SESSION['shipping'])) $data['shipping_info'] = serialize($_SESSION['shipping']);
                            $_SESSION['paypal_payment'] = $data;
                            $GLOBALS['core.store']->save('payment_temp', array('data' => serialize($data)),array('key_name' => 'id'));
                            $request_id = $GLOBALS['core.store']->last_id();
                            $GLOBALS['core.log']->do_log($data);
                            $payment = new Payment();
                            return $payment->process_paypal($request_id);
                        }
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
			if (!isset($data) || empty($data))	$GLOBALS['core.smarty']->assign('data',$resdata);			
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
			$dm = new DropdownManager();
			$dm->load_lists();
		} 
		
		$countries = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#country',array(),'country_id');
        $GLOBALS['core.smarty']->assign('countries',$countries);
		
        if (isset($_SESSION['shipping'])) $GLOBALS['core.smarty']->assign('shipping', $_SESSION['shipping']);
		if(isset($_SESSION['cart_total']))	$GLOBALS['core.smarty']->assign('cart_total', $_SESSION['cart_total']);
		if(isset($_SESSION['total_with_coupons']))	$GLOBALS['core.smarty']->assign('total_with_coupons', $_SESSION['total_with_coupons']);
		if (isset($_SESSION['total_with_coupons']))	$GLOBALS['core.smarty']->assign('real_total', $_SESSION['total_with_coupons']);
		elseif (isset($_SESSION['cart_total'])) $GLOBALS['core.smarty']->assign('real_total', $_SESSION['cart_total']);
		return Common_Header::out('Common/checkout'); 
	}
	
	function process_card($data)
	{
		
	}
	
	function validate_form_data(&$data, &$error, &$billing_info, &$shipping_info, &$total)
	{
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
            if (isset($_SESSION['wholesale_discount'])) $data['wholesale_discount'] = $_SESSION['wholesale_discount'];
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
        
        if (isset($_REQUEST['shipping_country']) && !empty($_REQUEST['shipping_country']))
        {
	        $data['shipping_country_id'] = $_REQUEST['shipping_country'];
            $shipping_info['country_id'] = $_REQUEST['shipping_country'];
        }
        else $error['shipping_country'] = 1;
        if (isset($_REQUEST['country']) && !empty($_REQUEST['country']))
        {
        	$data['country_id'] = $_REQUEST['country'];
            $billing_info['country_id'] = $_REQUEST['country'];
        }
        else $error['country'] = 1;

        if ($GLOBALS['core.auth.user']->is_member_of('user'))
        {
                $usr = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
                $data['email'] = $usr->get_data('email');
        }
        elseif (isset($_REQUEST['billing_email']) && !empty($_REQUEST['billing_email']))
        {
                $data['email'] = $_REQUEST['billing_email'];
                $billing_info['email'] = $_REQUEST['billing_email'];
        }
        elseif (isset($_REQUEST['email']) && !empty($_REQUEST['email']))
        {
                $data['email'] = $_REQUEST['email'];
                $billing_info['email'] = $_REQUEST['email'];
        }
        else $error['email'] = 1;

        if (isset($_REQUEST['comments']) && !empty($_REQUEST['comments'])) $data['comments'] = $_REQUEST['comments'];

        $data['shipping'] = $_SESSION['shipping_price'];
	}
	
	function send_payment_email($trid, $from_name, $from_email, $admin_email, $user_email)
	{
		$d = $GLOBALS['core.sql']->getRow("select * from #p#payment where id = ?",array($trid));
        $d['products'] = unserialize($d['cart_info']);
        if (isset($d['coupons']))	$d['coupons'] = unserialize($d['coupons']);
		if (isset($d['certificates'])) $d['certificates'] = unserialize($d['certificates']);
		if (isset($d['shipping_info'])) $d['shipping_info'] = unserialize($d['shipping_info']);
		
        $ph = new ProductHolder();
        $products = $ph->getAll();
        $options = $ph->getAllOptions();
        $GLOBALS['core.smarty']->assign('options',$options);
        $GLOBALS['core.smarty']->assign('products',$products);
        
        $ch = new CertificateHolder();
        $ch->load_lists();
                
        $GLOBALS['core.smarty']->assign('data',$d);
        $GLOBALS['core.smarty']->assign('coupons_m', $data['coupons']);
		$GLOBALS['core.smarty']->assign('certificates_m', $data['certificates']);
        
		/*
        $shippings = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ",array(),'id');
        $GLOBALS['core.smarty']->assign('shippings',$shippings);
        
        $item_shippings = $GLOBALS['core.sql']->getAll("select * from #p#item_shipping order by created ",array(),'id');
		$GLOBALS['core.smarty']->assign('item_shippings',$item_shippings);
		*/
		
		$countries = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#country',array(),'country_id');
        $GLOBALS['core.smarty']->assign('countries',$countries);

        $email = $GLOBALS['core.smarty']->fetch('Admin/payment_details.tpl');        

        $GLOBALS['core.mail']->init();
        $GLOBALS['core.mail']->addAddress($admin_email);
        $GLOBALS['core.mail']->setSubject('Payment info');
        $GLOBALS['core.mail']->setFromName($from_name);
        $GLOBALS['core.mail']->setFrom($from_email);                                                            
        $GLOBALS['core.mail']->isHTML(true);
        $GLOBALS['core.mail']->setBody($email);
        $GLOBALS['core.mail']->send();

        $GLOBALS['core.mail']->init();
        $GLOBALS['core.mail']->addAddress($user_email);
        $GLOBALS['core.mail']->setSubject('Payment info');
        $GLOBALS['core.mail']->setFromName($from_name);
        $GLOBALS['core.mail']->setFrom($from_email);
        $GLOBALS['core.mail']->isHTML(true);
        $GLOBALS['core.mail']->setBody($email);
        $GLOBALS['core.mail']->send();        
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
			if(isset($_SESSION['coupons']) && count($_SESSION['coupons']) > 0) $data['coupons'] = serialize($_SESSION['coupons']);
			if(isset($_SESSION['certificates']) && count($_SESSION['certificates']) > 0) $data['certificates'] = serialize($_SESSION['certificates']);
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
		
		$from_name = $settings['direct_deposit_from_name'];
		$from_email = $settings['direct_deposit_from_email'];
		$admin_email = $settings['direct_deposit_email'];
		
		$this->send_payment_email($trid,$from_name, $from_email, $admin_email, $data['email']);
		
		$cm = new CartManager();
		$cm->descrease_quantity($_SESSION['cart']);
		$cm->finish_payment($_SESSION['cart'], $trid);
		unset($_SESSION['cart']);		
		/*
		//direct deposit info need to show
		//with "0300 + id from database"		
		*/
		
		if (!isset($data['discount_point']) && $GLOBALS['core.auth.user']->is_member_of('user'))
		{
			if (isset($settings['discount_point']) && !empty($settings['discount_point']))
			{
				$total = 0;
				if (isset($_SESSION['total_cost'])) $total = $_SESSION['total_cost'];
				$points = $total * $settings['discount_point'];				
				$GLOBALS['core.store']->save('payment',array('not_approved_points' => $points),array('key_name' => 'id' , 'key_value' => $trid));
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
		$trid = "0300" . $trid;
		header("Location:" . $conf['common']['domain_name'] . $conf['common']['script_url'] . "Thank_You/" . $trid . "/1.html");
		return;
	}
	
	function check_limit_discount($addedd_amount)
	{
		$user = new UserHolder($GLOBALS['core.auth.user']->data['user_id']);
		$user->addPoints($addedd_amount);		
	}
	
	function null2unknown($map, $key)
	{
    	if (array_key_exists($key, $map))
    	{
        	if (!is_null($map[$key]))
        	{
            	return $map[$key];
        	}
    	}
    	return "No Value Returned";
	} 
	
	function getResponseDescription($responseCode) 
	{
    	switch ($responseCode) 
    	{
	        case "0" : $result = "Transaction Successful"; break;
	        case "?" : $result = "Transaction status is unknown"; break;
	        case "1" : $result = "Unknown Error"; break;
	        case "2" : $result = "Bank Declined Transaction"; break;
	        case "3" : $result = "No Reply from Bank"; break;
	        case "4" : $result = "Expired Card"; break;
	        case "5" : $result = "Insufficient funds"; break;
	        case "6" : $result = "Error Communicating with Bank"; break;
	        case "7" : $result = "Payment Server System Error"; break;
	        case "8" : $result = "Transaction Type Not Supported"; break;
	        case "9" : $result = "Bank declined transaction (Do not contact Bank)"; break;
	        case "A" : $result = "Transaction Aborted"; break;
	        case "C" : $result = "Transaction Cancelled"; break;
	        case "D" : $result = "Deferred transaction has been received and is awaiting processing"; break;
	        case "F" : $result = "3D Secure Authentication failed"; break;
	        case "I" : $result = "Card Security Code verification failed"; break;
	        case "L" : $result = "Shopping Transaction Locked (Please try the transaction again later)"; break;
	        case "N" : $result = "Cardholder is not enrolled in Authentication scheme"; break;
	        case "P" : $result = "Transaction has been received by the Payment Adaptor and is being processed"; break;
	        case "R" : $result = "Transaction was not processed - Reached limit of retry attempts allowed"; break;
	        case "S" : $result = "Duplicate SessionID (OrderInfo)"; break;
	        case "T" : $result = "Address Verification Failed"; break;
	        case "U" : $result = "Card Security Code Failed"; break;
	        case "V" : $result = "Address Verification and Card Security Code Failed"; break;
	        default  : $result = "Unable to be determined"; 
    	}
    	return $result;
	}
}
?>