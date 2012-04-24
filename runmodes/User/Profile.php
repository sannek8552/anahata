<?php
require_once('Common_Header.php');
require_once('classes/UserHolder.php');

class Profile extends Runmode 
{
	function Profile()
	{
		parent::Runmode();
	}
	
	function process()
	{
		$data = $GLOBALS['core.auth.user']->data;		
		$user = new UserHolder($data['user_id']);
		$full_data = $user->getFullData();
		
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{			
			$profile_data = $user->gatherBillingAndShipping();
		
			if (empty($profile_data['error']))
			{
				$profile_data['billing']['user_id'] = $user->get_key_value();
				$profile_data['shipping']['user_id'] = $user->get_key_value();
				$user->saveBilling($profile_data['billing']);
				$user->saveShipping($profile_data['shipping']);
								
			}
			else 
			{
				$GLOBALS['core.smarty']->assign('error',$profile_data['error']);
			}
			
			//$full_data = array();
			$full_data['billing'] = $profile_data['billing'];
			$full_data['shipping'] = $profile_data['shipping'];
		}
		
		$errors = array();
		if (isset($_REQUEST['change_password']) && !empty($_REQUEST['change_password']))
		{
			if (isset($_REQUEST['password']) && !empty($_REQUEST['password']))
			{
				if (isset($_REQUEST['retype_password']) && !empty($_REQUEST['retype_password']))
				{
					if ($_REQUEST['password'] != $_REQUEST['retype_password']) 					
						$errors['retype_password'] = 'Password and retype password missmatch';
				}
				else $errors['retype_password'] = 'Please retype password';
			}
			else $errors['password'] = 'Please enter password';
			
			if (isset($_REQUEST['email']) && !empty($_REQUEST['email']))
			{
				if (!$user->check_email($_REQUEST['email']))
				{
					$errors['email'] = 'This email unavailable';
				}
			}
			else  $errors['email'] = 'Please enter email';
					
			if (empty($errors))
			{
				$user->set_data(array('password' => md5($_REQUEST['password']), 'email' => $_REQUEST['email']));
				$user->save();
				$GLOBALS['core.smarty']->assign('change_data_success',1);
			}
			else $GLOBALS['core.smarty']->assign('errors',$errors);
		}
		
		$countries = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#country',array(),'country_id');
		$GLOBALS['core.smarty']->assign('countries',$countries);

		$GLOBALS['core.smarty']->assign('data',$full_data);
		return Common_Header::out('User/profile');
	}
}
?>