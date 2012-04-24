<?php
require_once('Data_Holder.php');
require_once('classes/CertificateHolder.php');
require_once('classes/CMS/SettingsHolder.php');

class PurchasedCertificateHolder extends Data_Holder_Simple 
{
	function PurchasedCertificateHolder($id = null)
	{
		$table = 'certificate_purchased';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}
	function get_all($status = '')
	{
		if (!empty($status))
		{
			return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#" . $this->table . " where status = ? ",array($status), 'id');
		}
		else return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#" . $this->table,array(), 'id');
	}
		
	function load_lists()
	{
		$purchased_certificates = $this->get_all();
		$GLOBALS['core.smarty']->assign('purchased_certificates', $purchased_certificates);
	}
	
	function generateCode()
	{
		while (true)
		{
			$code = substr(md5(time().microtime()),0,10);
			$another_code = $GLOBALS['core.sql']->getAll("select * from #p#" . $this->table . " where code = ?",array($code));
			if (empty($another_code))	break;
		}
		return $code;
	}
	
	function loadByCode($code)
	{
		$id = $GLOBALS['core.sql']->getOne("select id from #p#".$this->table." where code = ?",array($code));
		if (!empty($id))
		{
			$this->load($id);
			return true;
		}
		return false;
	}
	
	function get_data($field = '')
	{
		if(empty($field_name))
		{
			$cert = new CertificateHolder($this->data['certificate_id']);
			$data = $this->data;
			$data['name'] = $cert->get_data('name');
			return $data;
		}
		if(isset($this->data[$field_name]))
			return $this->data[$field_name];
		return null;
	}
	
	function processCart($cart, $update = null)
	{		
		$id = $this->get_key_value();
		$to_ret = array('discount' => 0,'error_message' => '');
		
		if (!empty($id))
		{
			$ch = new CartManager();
			$ch->calculate_total($cart);
		
			$data = $this->get_data();
			$c_array = array();
			if(isset($_SESSION['certificates']))
			{	
				foreach ($_SESSION['certificates'] as $k => $val)
				{
					$c_array[] = $k;
				}
			}
			if(!in_array($data['id'], $c_array) || !is_null($update))
			{				
				if (!$data['used'])
				{
					if ($data['status'] == 'Approved')
					{					
		    			$cert = new CertificateHolder($data['certificate_id']);
		    			$to_ret['discount'] = $cert->get_data('price');
					}
					else 
					{
						$to_ret['error_message'] = 'This certificate not approved.';
					}
				}
				else 
				{
					$to_ret['error_message'] = 'This certificate can\'t be used more.';
				}				
			}
			else 
			{
				$to_ret['error_message'] = 'This certificate aready used';
			}
		}
		return $to_ret;
	}
	
	function approve()
	{
		$data = $this->get_data();
		if (isset($data['status']) && $data['status'] == 'Not approved')
		{
			$this->set_data(array('status' => 'Approved'));
			$this->save();
			
			//send emails
			$cert = new CertificateHolder($data['certificate_id']);
			$data['price'] = $cert->get_data('price');
			
			$GLOBALS['core.smarty']->assign('data', $data);
			$email = $GLOBALS['core.smarty']->fetch('Emails/certificate_email.tpl');
			
			$sh = new SettingsHolder();
			$settings = $sh->getSettings();
			
			$GLOBALS['core.mail']->init();
			$GLOBALS['core.mail']->addAddress($data['person_email'], $data['person_name']);
			$GLOBALS['core.mail']->setFrom($settings['direct_deposit_from_email']);
			$GLOBALS['core.mail']->setFromName($settings['direct_deposit_from_name']);
			$GLOBALS['core.mail']->setSubject('Certificate received');			
			$GLOBALS['core.mail']->setBody($email);
			$GLOBALS['core.mail']->isHTML(true);
			$GLOBALS['core.mail']->send();
		}
	}
	
}
?>