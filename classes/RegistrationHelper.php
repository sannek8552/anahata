<?php
require_once('classes/UserHolder.php');
require_once('classes/SettingsHolder.php');
require_once('classes/DropdownManager.php');
class RegistrationHelper
{
	function RegistrationHelper()
	{
		
	}
	
	function gatherData($request)
	{
		$data = array();
		if (isset($request['login']) && !empty($request['login']))	$data['login'] = $request['login'];
		if (isset($request['email']) && !empty($request['email']))	$data['email'] = $request['email'];			
		if (isset($request['password']) && !empty($request['password'])) $data['password'] = $request['password'];
		if (isset($request['retype_password']) && !empty($request['retype_password'])) $data['retype_password'] = $request['retype_password'];
        if (isset($request['howhear']) && !empty($request['howhear'])) $data['howhear'] = $request['howhear'];
		if (isset($request['referral_id']) && !empty($request['referral_id'])) $data['referral_id'] = $request['referral_id'];
        if(isset($request['subscribe']) && $_REQUEST['subscribe'] == 1)
        {
            if(isset($request['subscribe_mail_type']) && is_numeric($request['subscribe_mail_type']))
            {
                $data['subscribe'] = $request['subscribe_mail_type'];
            }
            else
            {
                $data['subscribe'] = 0;
            }
        }
        else
        {
            $data['subscribe'] = 0;
        }
		return $data;
	}
	
	function checkForErrors($data)
	{
		$errors = array();
		if (isset($data['login']) && !empty($data['login']))
		{			
			$bool = $this->check_username($data['login']);			
			if (!$bool)	$errors['login'] = 'Username is unavailable';
		}
		else $errors['login'] = 'Please enter username';			
		
		if (isset($data['email']) && !empty($data['email']))
		{				
			$GLOBALS['core.validator']->add('email',$data['email'],'','va_email');
			$res = $GLOBALS['core.validator']->check();
                        $uh = new UserHolder();
                        

			if (!empty($res))
                        {
                            $errors['email'] = 'Please enter valid email';
                        }
                        elseif(!$uh->check_uniq_email($data['email']))
                        {
                            $errors['email'] = 'Please enter another email';
                        }
		}
		else $errors['email'] = 'Please enter email';
			
		if (isset($data['password']) && !empty($data['password']))
		{
			if (isset($data['retype_password']) && !empty($data['retype_password']))
			{
				if ($data['password'] == $data['retype_password']) $data['password'] = $data['password'];
				else $errors['retype_password'] = 'Password and retype password missmatch';
			}
			else $errors['retype_password'] = 'Please retype password';
		}
		else $errors['password'] = 'Please enter password';
		
		return $errors;
	}
	
	function check_username($username)
	{
		$res = $GLOBALS['core.sql']->getAll("select * from #p#user where login = ? ",array($username));
		return empty($res);
	}
	
	function registerUser($data)
	{
		$data['password'] = md5($data['password']);
		$data['groups'] = 'user';
		if (isset($data['retype_password']))	unset($data['retype_password']);
				
		$uh = new UserHolder();
		$uh->set_data($data);
		$uh->save();
        $sh = new SettingsHolder();
        $dh = new DropdownManager();
        $GLOBALS['core.smarty']->assign('hear_categories', $dh->get_hear_categories());
        $GLOBALS['core.smarty']->assign('edata', $data);
        $settings = $sh->getSettings();
        if (isset($settings['smtp_check']) && !empty($settings['smtp_check']))
        {
            $GLOBALS['core.mail']->isHTML(true);
            $GLOBALS['core.mail']->addAddress($settings['smtp_admin_register_email']);
            $GLOBALS['core.mail']->setSubject($settings['smtp_admin_subject']);
            $GLOBALS['core.mail']->setFromName($settings['smtp_admin_from']);;
            $GLOBALS['core.mail']->setFrom($settings['smtp_admin_from_email']);;
            $GLOBALS['core.mail']->setBody($GLOBALS['core.smarty']->fetch('Emails/admin_email_register.tpl'));
            $GLOBALS['core.mail']->send();
        }
		return $uh->get_key_value();
	}
	
	function authoriseUser($data)
	{
		$res = 'adafsdf';
		if (isset($data['login']) && isset($data['password'])) $res = $GLOBALS['core.auth']->authorise($data['login'],$data['password']);
	}
}

?>