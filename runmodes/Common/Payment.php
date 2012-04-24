<?php
	require_once('modules/Paypal.php');
	//require_once('PaymentHeader.php');
	require_once('classes/Billing_Country_Holder.php');
	require_once('classes/PaymentHolder.php');
	require_once('classes/BillingHolder.php');
	require_once('classes/Coupon/CouponHolder.php');
	require_once('Common_Header.php');
	require_once('classes/SettingsHolder.php');
	require_once('classes/CartManager.php');

	class Payment extends Runmode 
	{
		var $shippings = array(1 => 17,2 => 25,3 => 65,4 => 45);
		
		function Payment()
		{
			$this->base_map[0] = 'id';
			parent::Runmode();
		}
		
		function process()
		{
			$templates = $GLOBALS['core.config']->get_config('templates');
			if (isset($_REQUEST['continue']) and $_REQUEST['continue'])
			{				
				if ($_REQUEST['method'] == 'paypal')
				{
			        $url = $templates['common']['full_url'];
	                //$paymentAmount = 1;
	                $paymentAmount = $_SESSION['payment'][$_REQUEST['id']]['price'];
	                $currencyCodeType = 'AUD';
	                $paymentType = 'Sale';

	                $returnURL = urlencode($templates['common']['full_url'].'index.php?rm=confirm_payment&currencyCodeType='.$currencyCodeType.'&paymentType='.$paymentType.'&paymentAmount='.$paymentAmount.'&request_id='.$_REQUEST['id']);
	                $cancelURL = urlencode($templates['common']['full_url'].'cancel_payment/'.$_REQUEST['id'].'.html');
	                $nvpstr="&Amt=".$paymentAmount."&PAYMENTACTION=".$paymentType."&ReturnUrl=".$returnURL."&CANCELURL=".$cancelURL ."&CURRENCYCODE=".$currencyCodeType;

	                $pp = new Paypal();
	                $resArray = $pp->hash_call("SetExpressCheckout",$nvpstr);
			    	$_SESSION['reshash'] = $resArray;
	
			    	$ack = strtoupper($resArray["ACK"]);
			    	$paypal_config = $GLOBALS['core.config']->get_config('paypal');
					
	                if($ack == "SUCCESS")
	                {
						// Redirect to paypal.com here
						$token = urldecode($resArray["TOKEN"]);
						$payPalURL = $paypal_config['common']['PAYPAL_URL'].$token;
						header("Location: ".$payPalURL);
				    }
	                else
	                {
	                 	$GLOBALS['core.smarty']->assign('message',$resArray['L_SHORTMESSAGE0'].":".$resArray['L_LONGMESSAGE0']);
			    	}
				}
				elseif ($_REQUEST['method'] == 'onsite')
				{
					header("Location: ".$templates['common']['secure_url']."CardPayment/".$_REQUEST['id'].".html");
					exit();
				}
			}
			$total = $_SESSION['payment'][$_REQUEST['id']]['price'];
			$GLOBALS['core.smarty']->assign('total',$total);
			$GLOBALS['core.smarty']->assign('id',$_REQUEST['id']);
			//return Common_Header::out('Paypal/select_payment_type');
		}
		
		function process_paypal($request_id)
		{
			$templates = $GLOBALS['core.config']->get_config('templates');
			$url = $templates['common']['full_url'];
            //$paymentAmount = 1;
            //$paymentAmount = $_SESSION['payment'][$_REQUEST['id']]['price'];
            $paymentAmount = $_SESSION['cart_total'];// + $this->shippings[$_SESSION['paypal_payment']['shipping']];
            $currencyCodeType = 'AUD';
            $paymentType = 'Sale';
			$_REQUEST['id'] = $request_id;
			
            $returnURL = urlencode($templates['common']['full_url'].'index.php?rm=confirm_payment&currencyCodeType='.$currencyCodeType.'&paymentType='.$paymentType.'&paymentAmount='.$paymentAmount.'&request_id='.$_REQUEST['id']);
            $cancelURL = urlencode($templates['common']['full_url'].'cancel_payment/'.$_REQUEST['id'].'.html');
            $nvpstr="&Amt=".$paymentAmount."&PAYMENTACTION=".$paymentType."&ReturnUrl=".$returnURL."&CANCELURL=".$cancelURL ."&CURRENCYCODE=".$currencyCodeType;

            $pp = new Paypal();
            $resArray = $pp->hash_call("SetExpressCheckout",$nvpstr);
	    	$_SESSION['reshash'] = $resArray;

	    	$ack = strtoupper($resArray["ACK"]);
	    	$paypal_config = $GLOBALS['core.config']->get_config('paypal');
			
	    	//pp($resArray);
	    	$GLOBALS['core.log']->do_log($returnURL);
	    	
            if($ack == "SUCCESS")
            {
				// Redirect to paypal.com here
				$token = urldecode($resArray["TOKEN"]);
				$payPalURL = $paypal_config['common']['PAYPAL_URL'].$token;
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
					}
				}
				
				header("Location: ".$payPalURL);
		    }
            else
            {
             	$GLOBALS['core.smarty']->assign('message',$resArray['L_SHORTMESSAGE0'].":".$resArray['L_LONGMESSAGE0']);
	    	}
	    	return '';
		}
		
		function process_card()
		{
			//pp($_SESSION);
			//$total = $_SESSION['cart_total'] + $this->shippings[$_SESSION['card_payment']['shipping']];
			$shippings = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ",array(),'id');
			$total = $_SESSION['cart_total'];// + $shippings[$_SESSION['card_payment']['shipping']]['price'];
			if (isset($_REQUEST['checkout']) and $_REQUEST['checkout'])
			{
				$ipaddress = $_SERVER['REMOTE_ADDR'];
				$errors = array();
				$GLOBALS['core.validator']->add('cc_type',$_REQUEST['cc_type'],'','va_string');
	
				$GLOBALS['core.validator']->add('cc_expiration_month',$_REQUEST['cc_expiration_month'],'','va_mm');
				$GLOBALS['core.validator']->add('cc_expiration_year',$_REQUEST['cc_expiration_year'],'','va_yyyy');
				$GLOBALS['core.validator']->add('cc_cvv',$_REQUEST['cc_cvv'],'','va_cvv');
				$GLOBALS['core.validator']->add('cc_first_name',$_REQUEST['cc_first_name'],'','va_string');
				$GLOBALS['core.validator']->add('cc_last_name',$_REQUEST['cc_last_name'],'','va_string');
				$GLOBALS['core.validator']->add('cc_billing_country',$_REQUEST['cc_billing_country'],'','va_string');			
				if (isset($_REQUEST['cc_billing_state']))
				$GLOBALS['core.validator']->add('cc_billing_state',$_REQUEST['cc_billing_state'],'','va_string_empty');				
				$GLOBALS['core.validator']->add('cc_billing_city',$_REQUEST['cc_billing_city'],'','va_string');
				$GLOBALS['core.validator']->add('cc_billing_zip',$_REQUEST['cc_billing_zip'],'','va_string');
				$GLOBALS['core.validator']->add('cc_billing_address',$_REQUEST['cc_billing_address'],'','va_string');
				$errors = $GLOBALS['core.validator']->check();
	
				if (!isset($_REQUEST['cc_number']) or !$_REQUEST['cc_number']) $errors['cc_number'] = 1;

				if (!count($errors))
				{
					$cc_type = $_REQUEST['cc_type'];
					$cc_number = $_REQUEST['cc_number'];
					$cc_exp_month = $_REQUEST['cc_expiration_month'];
					$cc_exp_year = $_REQUEST['cc_expiration_year'];
					$cc_cvv = $_REQUEST['cc_cvv'];
	
					$cc_first_name = $_REQUEST['cc_first_name'];
					$cc_last_name = $_REQUEST['cc_last_name'];
					$cc_billing_address = $_REQUEST['cc_billing_address'];
					$cc_billing_city = $_REQUEST['cc_billing_city'];
					if (isset($_REQUEST['cc_billing_state']))
					$cc_billing_state = $_REQUEST['cc_billing_state'];
					else $cc_billing_state = '';
					$ch = new Billing_Country_Holder($_REQUEST['cc_billing_country']);
					$cc_billing_country = $ch->get_data('code');
					$cc_billing_zip = $_REQUEST['cc_billing_zip'];
					//$total = 1;
	
					$nvpstr = "&PAYMENTACTION=Sale&IPADDRESS={$ipaddress}&CREDITCARDTYPE={$cc_type}&ACCT={$cc_number}&EXPDATE={$cc_exp_month}{$cc_exp_year}&CVV2={$cc_cvv}&AMT={$total}&FIRSTNAME={$cc_first_name}&LASTNAME={$cc_last_name}&STREET={$cc_billing_address}&CITY={$cc_billing_city}&STATE={$cc_billing_state}&COUNTRYCODE={$cc_billing_country}&ZIP={$cc_billing_zip}";
					$pp = new Paypal();
					$resArray = $pp->hash_call("DoDirectPayment",$nvpstr);
	
			    	/* Display the API response back to the browser.
			   			If the response from PayPal was a success, display the response parameters'
			   			If the response was an error, display the errors received using APIError.php.
			   		*/
					$ack = strtoupper($resArray["ACK"]);
					//pp($resArray);
					
					if(strtoupper($ack == "SUCCESS"))
					{
						$_SESSION['reshash'] = $resArray;
						$data = array();
						//$data['code'] = $_REQUEST['id'];
						$data['total'] = $resArray['AMT'];
						$data['transaction_id'] = $resArray['TRANSACTIONID'];
						$data['order_time'] = $resArray['TIMESTAMP'];
						//$data['type'] = $_SESSION['payment'][$_REQUEST['id']]['type'];
						$ph = new PaymentHolder();
						$ph->set_data($data);
						$ph->save();
						
						$billing_info = array();
						$billing_info['cc_type'] = $cc_type;
						$billing_info['cc_billing_address'] = $cc_billing_address;
						$billing_info['cc_billing_city'] 	= $cc_billing_city;
						$billing_info['cc_billing_country'] = $cc_billing_country;
						$billing_info['cc_billing_state'] 	= $cc_billing_state;
						$billing_info['cc_billing_zip'] 	= $cc_billing_zip;
						$billing_info['payment_id'] = $ph->get_key_value();
						$bh = new BillingHolder();
						$bh->set_data($billing_info);
						$bh->save();
						
						$cdata = $_SESSION['card_payment'];
						$cdata['total'] = $resArray['AMT'];
						$cdata['transaction_id'] = $resArray['TRANSACTIONID'];
						$GLOBALS['core.store']->save('payment',$cdata,array('key_name' => 'id'));
						$trid = $GLOBALS['core.store']->last_id();
						
						$this->send_email($cdata,$trid);
						
						unset($_SESSION['cart_total']);
						unset($_SESSION['cart']);
						unset($_SESSION['card_payment']);
						
						$deposit = $GLOBALS['core.sql']->getRow("select * from #p#deposit");
						header("Location:".$deposit['url'].".html");
						return '';
					}
					else
					{
						$_REQUEST['message'] = $resArray['L_SHORTMESSAGE0'];
					}
				}
				else
				{
					$GLOBALS['core.smarty']->assign('errors',$errors);
				}
			}				
			$GLOBALS['core.smarty']->assign('total',$total);
			
	
			$countries = Billing_Country_Holder::getAll();
			$GLOBALS['core.smarty']->assign('countries',$countries);
	
			if (isset($_REQUEST['cc_billing_country']) and $_REQUEST['cc_billing_country'])
			{
				$ch = new Billing_Country_Holder($_REQUEST['cc_billing_country']);
				$states = $ch->getStates();
				$GLOBALS['core.smarty']->assign('states',$states);
			}
	
			foreach ($_REQUEST as $key => $value) $GLOBALS['core.smarty']->assign($key,$value);
	
			$GLOBALS['core.smarty']->assign('billing_info',$_SESSION['card_payment']);
			return Common_Header::out('Paypal/card_payment');
		}		
		
		function confirm_payment()
		{
			//pp($_REQUEST);
			$_SESSION['token']=$_REQUEST['token'];
			$_SESSION['payer_id'] = $_REQUEST['PayerID'];
			$_SESSION['paymentAmount']=$_REQUEST['paymentAmount'];
			$_SESSION['currCodeType']=$_REQUEST['currencyCodeType'];
			$_SESSION['paymentType']=$_REQUEST['paymentType'];
			$GLOBALS['core.smarty']->assign('paymentAmount',$_REQUEST['paymentAmount']);
			$GLOBALS['core.smarty']->assign('currencyCodeType',$_REQUEST['currencyCodeType']);
			$GLOBALS['core.smarty']->assign('request_id',$_REQUEST['request_id']);
			$resArray = $_SESSION['reshash'];	
			$_REQUEST['id'] = $_REQUEST['request_id'];
			
			$GLOBALS['core.log']->do_log($_SESSION);
			
			return Common_Header::out('Paypal/confirm_payment');
		}
		
		function do_payment()
		{
			$token = urlencode( $_SESSION['token']);
			$paymentAmount = urlencode ($_SESSION['paymentAmount']);
			$paymentType = urlencode($_SESSION['paymentType']);
			$currCodeType = urlencode($_SESSION['currCodeType']);
			$payerID = urlencode($_SESSION['payer_id']);
			$serverName = urlencode($_SERVER['SERVER_NAME']);
	
			$nvpstr='&TOKEN='.$token.'&PAYERID='.$payerID.'&PAYMENTACTION='.$paymentType.'&AMT='.$paymentAmount.'&CURRENCYCODE='.$currCodeType.'&IPADDRESS='.$serverName ;
	
			/* Make the call to PayPal to finalize payment
	   			If an error occured, show the resulting errors
	        */
			
			$pp = new Paypal();
			$resArray = $pp->hash_call("DoExpressCheckoutPayment",$nvpstr);
			/* Display the API response back to the browser.
	   			If the response from PayPal was a success, display the response parameters'
	   			If the response was an error, display the errors received using APIError.php.
	   		*/
			$ack = strtoupper($resArray["ACK"]);
			
			if($ack == "SUCCESS")
			{
				$_SESSION['reshash'] = $resArray;	
				$data = array();
				//$data['code'] = $_REQUEST['request_id'];
				$data['total'] = $resArray['AMT'];
				$data['transaction_id'] = $resArray['TRANSACTIONID'];
				$data['order_time'] = $resArray['TIMESTAMP'];
				//$data['type'] = $_SESSION['payment'][$_REQUEST['request_id']]['type'];

				$ph = new PaymentHolder();
				$ph->set_data($data);
				$ph->save();
				
				//$cdata = $_SESSION['paypal_payment'];
				$cdata = $GLOBALS['core.sql']->getOne("select data from #p#payment_temp where id = ?",array($_REQUEST['request_id']));
				$cdata = unserialize($cdata);				
				$cdata['total'] = $resArray['AMT'];
				$cdata['transaction_id'] = $resArray['TRANSACTIONID'];
				
				if(is_numeric($GLOBALS['core.auth.user']->uid))
				{
					if(isset($_SESSION['coupons']) && count($_SESSION['coupons']) > 0) $data['coupons'] = serialize($_SESSION['coupons']);
					if(isset($_SESSION['certificates']) && count($_SESSION['certificates']) > 0) $data['certificates'] = serialize($_SESSION['certificates']);
				}
				
				$GLOBALS['core.store']->save('payment',$cdata,array('key_name' => 'id'));
				$trid = $GLOBALS['core.store']->last_id();
				
				$GLOBALS['core.log']->do_log($cdata);				
				
				if ($GLOBALS['core.auth.user']->is_member_of('user'))
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
					}
				}
				
				$cm = new CartManager();
				$cm->descrease_quantity($_SESSION['cart']);
				$cm->finish_payment($_SESSION['cart'], $trid);
				unset($_SESSION['cart_total']);
				unset($_SESSION['cart']);
				unset($_SESSION['paypal_payment']);
				//$deposit = $GLOBALS['core.sql']->getRow("select * from #p#deposit");
				//header("Location:".$deposit['url'].".html");
				
				$this->send_email($cdata,$trid);
				
				
				$conf = $GLOBALS['core.config']->get_config('templates');				
				header("Location:" . $conf['common']['domain_name'] . $conf['common']['script_url'] . "Thank_You/" . $cdata['transaction_id'] . ".html");				
				return '';
			}
			else
			{
				$_REQUEST['message'] = $resArray['L_SHORTMESSAGE0'];
			}
			return Common_Header::out('Paypal/confirm_payment');
		}
		
		function send_email($data,$trid = '')
		{
			/*
			require_once('classes/ProductHolder.php');
			require_once('classes/DropdownManager.php');
			
			
			$data['products'] = unserialize($data['cart_info']);
			$ph = new ProductHolder();
			$products = $ph->getAll();
			$GLOBALS['core.smarty']->assign('products',$products);
			$dm = new DropdownManager();
			$dm->load_lists();
			$GLOBALS['core.smarty']->assign('data',$data);			
			$shippings = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ",array(),'id');
			$GLOBALS['core.smarty']->assign('shippings',$shippings);
			
			$item_shippings = $GLOBALS['core.sql']->getAll("select * from #p#item_shipping order by created ",array(),'id');
			$GLOBALS['core.smarty']->assign('item_shippings',$item_shippings);
			
			$email = $GLOBALS['core.smarty']->fetch('Admin/payment_details.tpl');
			*/		
			
			$sh = new SettingsHolder();
			$settings = $sh->getSettings();
			
			
			$from_name = $settings['direct_deposit_from_name'];
			$from_email = $settings['direct_deposit_from_email'];
			$admin_email = $settings['direct_deposit_email'];
			
			require_once('runmodes/Common/Cart.php');
			$data = $GLOBALS['core.sql']->getRow("select * from #p#payment where id = ?",array($trid));
			$cart = new Cart();
			$cart->send_payment_email($trid,$from_name, $from_email, $admin_email, $user_email,$data['email']);
			
			/*
			
			$GLOBALS['core.mail']->init();
			$GLOBALS['core.mail']->addAddress($admin_email);
			$GLOBALS['core.mail']->setSubject('Payment info');			
			$GLOBALS['core.mail']->setFromName($from_name);
			$GLOBALS['core.mail']->setFrom($from_email);						
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
			*/
		}
	}
?>