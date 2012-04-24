<?php
require_once('Admin_Header.php');
require_once('UserHolder.php');
require_once('classes/CMS/Contact_Holder.php');
require_once('classes/SettingsHolder.php');
require_once('classes/Coupon/CouponHolder.php');
require_once('classes/CategoryHolder.php');
require_once('classes/ProductHolder.php');

class SendCoupon extends Runmode 
{
	function SendCoupon()
	{
		$this->base_map[0] = 'addressee';
		$this->base_map[1] = 'coupon_id';
		$this->make_params();
		parent::Runmode();
	}
	function process()
	{
		$users = array();
		if(isset($_REQUEST['addressee']) && $_REQUEST['addressee'] == 'registered')
		{
			$user_object = new UserHolder();
			$users = $user_object->getAll();
			foreach ($users as $key => $value)
			{
				$u_ob = new UserHolder($key);
				$arr = array();
				$arr = $u_ob->getBilling();
				if(isset($arr['name']))
				{
					$users[$key]['name'] = $arr['name'];
				}
			}
		}
		elseif (isset($_REQUEST['addressee']) && $_REQUEST['addressee'] == 'contact')
		{
			$conact_object = new Contact_Holder(4);
			$users = $conact_object->get_entries();

			foreach ($users as $key => $value)
			{
				$a = explode('<b>Name</b>:', $value['entry']);//$entry = unserialize($value['entry']);
				$a = explode('<br/>', $a[1]);
				$users[$key]['name'] = $a[0];
			}
			
		}
		if(isset($_REQUEST['send']) && !empty($_REQUEST['send']))
		{
			if(isset($_REQUEST['addressees']) && count($_REQUEST['addressees']) > 0)
			{
				$sh = new SettingsHolder();
				$settings = $sh->loadSettings();
				foreach ($_REQUEST['addressees'] as $value)
				{
					$GLOBALS['core.mail']->isHTML(true);
					$GLOBALS['core.mail']->addAddress($value);
					$GLOBALS['core.mail']->setBody($_REQUEST['content']);
					$GLOBALS['core.mail']->setSubject($_REQUEST['subject']);
					$GLOBALS['core.mail']->setFrom($settings['remind_email']);
					$GLOBALS['core.mail']->setFromName($settings['remind_name']);
					$GLOBALS['core.mail']->send();
					//pp($GLOBALS['core.mail']);
				}
				$GLOBALS['core.smarty']->assign('message', 'E-Mail succesfully sent');
			}
			else 
			{
				$GLOBALS['core.smarty']->assign('message', 'List of addresses is empty');
			}
		}
		$text = '';
		if(isset($_REQUEST['coupon_id']) && is_numeric($_REQUEST['coupon_id']))
		{
			$coupon_object = new CouponHolder($_REQUEST['coupon_id']);
			$data = $coupon_object->get_data();
			$cat_obj = new CategoryHolder();
			$cats = $cat_obj->getAll();
			$prod_obj = new ProductHolder();
			$prods = $prod_obj->getAll();
			
			//$text = '';' <b>Description:</b> '.$data['description'].' <b>Type:</b> '.$data['type']
			$text = '<b>Name:</b> '.$data['name'];
			if($data['apply_type'] == 'everything')
			{
				$text.= ' <b>Type:</b> '.$data['apply_type'];
			}
			elseif ($data['apply_type'] == 'category')
			{
				$text.= ' <b>Type:</b> '.$cats[$data['item_id']]['title'].' category';
			}
			elseif ($data['apply_type'] == 'product')
			{
				$text.= ' <b>Type:</b> '.$prods[$data['item_id']]['name'].' product';
			}
			
			if($data['type'] == 'amount')
			{
				$text.= ' <b>Discount:</b> $'.$data['amount'];
			}
			else 
			{
				$text.= ' <b>Discount:</b> '.$data['amount'].' %';
			}
			$GLOBALS['core.smarty']->assign('c_id', $_REQUEST['coupon_id']);
		}
		$GLOBALS['core.smarty']->assign('content', $text);
		$GLOBALS['core.smarty']->assign('users', $users);
		$GLOBALS['core.smarty']->assign('addressee', $_REQUEST['addressee']);
		return Admin_Header::out('Coupon/send_coupon');
	}
}
?>