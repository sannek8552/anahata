<?php
require_once('classes/ProductHolder.php');
require_once('classes/CMS/SettingsHolder.php');


class TellAFriend extends Runmode 
{
	function TellAFriend()
	{
		parent::Runmode();
	}
	
	function ajax_process()
	{
		//pp($_SESSION);
		$response = array('html' => '', 'success' => 1);
		$_REQUEST = $_REQUEST['q'];
		
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		$GLOBALS['core.smarty']->assign('data', $_REQUEST);
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$can_save = true;
			if (isset($settings['friend_captcha']) && !empty($settings['friend_captcha']))
			{
				if(isset($_REQUEST['check_captcha_tell_a_friend']) && !empty($_REQUEST['check_captcha_tell_a_friend']) && !empty($_SESSION['protect_tell_a_friend']) && $_REQUEST['check_captcha_tell_a_friend'] == $_SESSION['protect_tell_a_friend'])	$can_save = true;					
				else $can_save = false;
			}
			//pp($can_save);
			if ($can_save)
			{
				//send email
								
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					//single product tell a friend
					$ph = new ProductHolder($_REQUEST['id']);
					$GLOBALS['core.smarty']->assign('product', $ph->get_data());
				}
				else 
				{
					//whole site tell a friend			
					if ($settings['friend_site_name'])	$GLOBALS['core.smarty']->assign('site_name', $settings['friend_site_name']);
				}
				
				if ($GLOBALS['core.auth.user']->is_member_of('user'))
				{
					$GLOBALS['core.smarty']->assign('my_user_id', $GLOBALS['core.auth.user']->uid);
				}
				
				$email = $GLOBALS['core.smarty']->fetch('Emails/tell_a_friend_email.tpl');
				$GLOBALS['core.mail']->init();
				$GLOBALS['core.mail']->addAddress($_REQUEST['friend_email'], $_REQUEST['friend_name']);
				$GLOBALS['core.mail']->setFrom($_REQUEST['your_email']);
				$GLOBALS['core.mail']->setFromName($_REQUEST['your_name']);
				$GLOBALS['core.mail']->setSubject($settings['friend_subject']);
				$GLOBALS['core.mail']->setBody($email);
				$GLOBALS['core.mail']->isHTML(true);
				$send = $GLOBALS['core.mail']->send();
				$response['send'] = $send;
			}
			else 
			{
				$GLOBALS['core.smarty']->assign('wrong_captcha', 1);
				$GLOBALS['core.smarty']->assign('data', $_REQUEST);
				$load = 1;
			}
		}						
		else $load = 1;
			
			
		if ($load)
		{
			if (isset($settings['friend_captcha']) && !empty($settings['friend_captcha']))
			{
				$GLOBALS['core.smarty']->assign('section', 'tell_a_friend');
				$GLOBALS['core.smarty']->assign('captcha', 1);
			}
			$response['html'] = $GLOBALS['core.smarty']->fetch('Common/tell_a_friend_form.tpl');
			$response['success'] = 0;
		}
		
		
		$GLOBALS['core.ajax']->put_to_output($response);
	}
}

?>