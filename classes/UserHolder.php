<?php
require_once('Data_Holder.php');
require_once('classes/SettingsHolder.php');
require_once('classes/WholesaleHolder.php');

class UserHolder extends Data_Holder 
{
	function UserHolder($id = null)
	{
		$table = 'user';
		$key_info = array('key_name' => 'user_id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}
	
	function getFullData()
	{
		$data = $this->get_data();
		//process for collect full data (billing,shipping addresses)
		$data['billing'] = $this->getBilling();
		$data['shipping'] = $this->getShipping();
		
		$wh = new WholesaleHolder();
		$data['wholesales'] = $wh->getWholesalesForUser($this->get_key_value());
		return $data;
	}
	
	function getAll()
	{
		return $GLOBALS['core.sql']->getAll("select * from #p#user where groups = 'user' AND disabled != 1 order by login ",array(),'user_id');
	}
	
	function getAllWithFullData()
	{
		$users = $this->getAll();
		$billings = $this->getAllBilling();
		$shippings = $this->getAllShipping();
		
		$wh = new WholesaleHolder();
		$wholesales = $wh->getAllWholesaleUser();
		
		foreach ($users as $key => $value)
		{
			$users[$key]['billing'] = (isset($billings[$key])) ? $billings[$key] : array();
			$users[$key]['shipping'] = (isset($shippings[$key])) ? $shippings[$key] : array();
			$users[$key]['wholesales'] = (isset($wholesales[$key])) ? $wholesales[$key] : array();
		}
		return $users;
	}
	
	function getAllBilling()
	{
		return $GLOBALS['core.sql']->getAll("select * from #p#user_billing ",array(),'user_id');		
	}
	
	function getAllShipping()
	{
		return $GLOBALS['core.sql']->getAll("select * from #p#user_shipping ",array(),'user_id');		
	}
	
	function getBilling()
	{
		$id = 0;
		$id = $this->get_key_value();
		return $GLOBALS['core.sql']->getRow("select * from #p#user_billing where user_id = ?",array($id));
	}
	
	function getShipping()
	{
		$id = 0;
		$id = $this->get_key_value();
		return $GLOBALS['core.sql']->getRow("select * from #p#user_shipping where user_id = ?",array($id));
	}
	
	function saveBilling($data)
	{
		$id = $this->get_key_value();
		if (!empty($id))
		{
			$bid = $GLOBALS['core.sql']->getOne("select id from #p#user_billing where user_id = ? ",array($id));
			$key_info = array('key_name' => 'id');
			if (!empty($bid)) $key_info['key_value'] = $bid;
			$GLOBALS['core.store']->save('user_billing',$data,$key_info);
		}
	}
	
	function saveShipping($data)
	{
		$id = $this->get_key_value();
		if (!empty($id))
		{
			$sid = $GLOBALS['core.sql']->getOne("select id from #p#user_shipping where user_id = ? ",array($id));
			$key_info = array('key_name' => 'id');
			if (!empty($sid)) $key_info['key_value'] = $sid;
			$GLOBALS['core.store']->save('user_shipping',$data,$key_info);
		}
	}
	
	function transformData($data)
	{
		$to_ret =array();		
		
		if (isset($data['billing']) && !empty($data['billing']))
		{
			$to_ret['client_name'] = $data['billing']['name'];
			$to_ret['address'] = $data['billing']['address'];
			$to_ret['address2'] = $data['billing']['address2'];
			$to_ret['suburb'] = $data['billing']['suburb'];		
			$to_ret['state'] = $data['billing']['state'];
			$to_ret['postcode'] = $data['billing']['postcode'];
			$to_ret['phone'] = $data['billing']['phone'];
			$to_ret['email'] = $data['billing']['email'];
 			$to_ret['country_id'] = $data['billing']['country_id'];
		}
		if (isset($data['shipping']) && !empty($data['shipping']))
		{
			$to_ret['shipping_address'] = $data['shipping']['address'];
			$to_ret['shipping_address2'] = $data['shipping']['address2'];
			$to_ret['shipping_suburb'] = $data['shipping']['suburb'];
			$to_ret['shipping_state'] = $data['shipping']['state'];
			$to_ret['shipping_postcode'] = $data['shipping']['postcode'];
			$to_ret['shipping_phone'] = $data['shipping']['phone'];
			$to_ret['shipping_country_id'] = $data['shipping']['country_id'];
		}
		return $to_ret;			
	}
	
	function check_login($login)
	{
		$id = $GLOBALS['core.sql']->getOne("select user_id from #p#".$this->table." where login = ?",array($login));
		if (isset($this->key_info['key_value']) && !empty($id) && $id != $this->key_info['key_value']) return false;
		else return true;
	}
	
	function check_email($email)
	{
		$id = $GLOBALS['core.sql']->getOne("select user_id from #p#".$this->table." where email = ?",array($email));
		if (isset($this->key_info['key_value']) && !empty($id) && $id != $this->key_info['key_value']) return false;
		else return true;
	}
	function check_uniq_email($email)
        {
            if(count($GLOBALS['core.sql']->getAll('SELECT * FROM #p#user WHERE email = ?', array($email))) > 0)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
	function addPoints($addedd_amount)
	{
		$id = $this->get_key_value();
		
		if (!empty($id))
		{
			$points = $this->get_data('discount_point');
			$points += $addedd_amount;
			$this->set_data(array('discount_point' => $points));
			$this->save();
						
			$sh = new SettingsHolder();
			$settings = $sh->getSettings();
					
			if ($points >= $settings['discount_limit'] && ($points - $addedd_amount < $settings['discount_limit']))
			{
				$from_name = $settings['direct_deposit_from_name'];
				$from_email = $settings['direct_deposit_from_email'];
				$admin_email = $settings['direct_deposit_email'];
							
				$GLOBALS['core.mail']->init();
				$GLOBALS['core.mail']->addAddress($admin_email);
				$GLOBALS['core.mail']->setSubject('Reaching discount points limit');
				$GLOBALS['core.mail']->setFromName($from_name);
				$GLOBALS['core.mail']->setFrom($from_email);
						
				$GLOBALS['core.smarty']->assign('deposit',1);
				
				$GLOBALS['core.smarty']->assign('data', $this->getFullData());
				$email = $GLOBALS['core.smarty']->fetch('Emails/admin_email_discount_point.tpl');
	
				$GLOBALS['core.mail']->isHTML(true);
				$GLOBALS['core.mail']->setBody($email);
				
				$GLOBALS['core.mail']->send();
				
				$GLOBALS['core.mail']->init();
				$GLOBALS['core.mail']->addAddress($this->get_data('email'));
				$GLOBALS['core.mail']->setSubject('Reaching discount points limit');
				$GLOBALS['core.mail']->setFromName($from_name);
				$GLOBALS['core.mail']->setFrom($from_email);
				$email = "Congratulations! You exceed minimum limit to use discount points. Now you can use them to pay at bambinosandrugrats.com.au ";
				$GLOBALS['core.mail']->setBody($email);
				$GLOBALS['core.mail']->send();
			}
		}
	}
	
	function gatherBillingAndShipping()
	{
		$billing_info = array();
		$shipping_info = array();
			
		$data = array();
		$error = array();
		
		if (isset($_REQUEST['client_name'])) 
		{			
			$billing_info['name'] = $_REQUEST['client_name'];
		}
		else $error['client_name'] = 1;
		if (isset($_REQUEST['address']))
		{		
			$billing_info['address'] = $_REQUEST['address'];
		}
		else $error['address'] = 1;
		if (isset($_REQUEST['shipping_address'])) 
		{		
			$shipping_info['address'] = $_REQUEST['shipping_address'];
		}
		else $error['shipping_address'] = 1;

		if (isset($_REQUEST['address2'])) 
		{		
			$billing_info['address2'] = $_REQUEST['address2'];
		}
		if (isset($_REQUEST['shipping_address2'])) 
		{		
			$shipping_info['address2'] = $_REQUEST['shipping_address2'];
		}
		
		if (isset($_REQUEST['suburb'])) 
		{		
			$billing_info['suburb'] = $_REQUEST['suburb'];
		}
		else $error['suburb'] = 1;
		if (isset($_REQUEST['shipping_suburb'])) 
		{		
			$shipping_info['suburb'] = $_REQUEST['shipping_suburb'];
		}
		else $error['shipping_suburb'] = 1;
		
		if (isset($_REQUEST['state'])) 
		{			
			$billing_info['state'] = $_REQUEST['state'];
		}
		else $error['state'] = 1;
		if (isset($_REQUEST['shipping_state'])) 
		{		
			$shipping_info['state'] = $_REQUEST['shipping_state'];
		}
		else $error['shipping_state'] = 1;
		
		if (isset($_REQUEST['postcode'])) 
		{		
			$billing_info['postcode'] = $_REQUEST['postcode'];
		}
		else $error['postcode'] = 1;
		if (isset($_REQUEST['shipping_postcode'])) 
		{		
			$shipping_info['postcode'] = $_REQUEST['shipping_postcode'];
		}
		else $error['shipping_postcode'] = 1;
		
		if (isset($_REQUEST['phone'])) 
		{		
			$billing_info['phone'] = $_REQUEST['phone'];
		}
		else $error['phone'] = 1;
		if (isset($_REQUEST['shipping_phone'])) 
		{		
			$shipping_info['phone'] = $_REQUEST['shipping_phone'];
		}
		else $error['shipping_phone'] = 1;
		
		if (isset($_REQUEST['billing_country']) && !empty($_REQUEST['billing_country']))
		{
			$billing_info['country_id'] = $_REQUEST['billing_country'];
		}
		else 
		{
        	$error['billing_country'] = 1;
        }
        if (isset($_REQUEST['shipping_country']) && !empty($_REQUEST['shipping_country']))
        {
			$shipping_info['country_id'] = $_REQUEST['shipping_country'];
		}
		else 
		{
        	$error['shipping_country'] = 1;
        }

		
		/*
		if (isset($_REQUEST['billing_email']) && !empty($_REQUEST['billing_email'])) 
		{		
			$billing_info['email'] = $_REQUEST['billing_email'];
		}
		else $error['email'] = 1;
		*/
		
		return array('billing' => $billing_info,'shipping' => $shipping_info,'error' => $error);
	}
	
	function delete()
	{
		$id = $this->get_key_value();
		if (!empty($id))
		{
			$GLOBALS['core.store']->delete('user_billing', array('key_name' => 'user_id', 'key_value' => $id));
			$GLOBALS['core.store']->delete('user_shipping', array('key_name' => 'user_id', 'key_value' => $id));
		}
		parent::delete();
	}
}
?>