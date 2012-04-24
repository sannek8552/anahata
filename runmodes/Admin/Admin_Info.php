<?php
require_once('Admin_Header.php');

class Admin_Info extends Runmode 
{
	function Admin_Info()
	{
		$GLOBALS['core.smarty']->assign('current_menu', 'Administration');
		$GLOBALS['core.smarty']->assign('current_sub', 'Profile');
		parent::Runmode();
	}
	
	function process()
	{
		//for now will insert code logic here, replace with Holder solution later
		if (isset($_REQUEST['save_user_name'])) 
		{
			$new_user_name = $_REQUEST['user_name'];
			
			if(empty($new_user_name))
			{
				$GLOBALS['core.smarty']->assign('user_name_error', 1);
			}
			else 
			{
				//check if user name already taken
				$res = $GLOBALS['core.sql']->getRow('SELECT * FROM #p#user WHERE login=?',array($new_user_name));
				if(!empty($res))
				{
					if($res['user_id'] != $GLOBALS['core.auth.user']->data['user_id'])
					{
						//we have error
						$GLOBALS['core.smarty']->assign('user_name_error', 1);
					}
					else 
					{
						//save user here
						$GLOBALS['core.store']->save('user', array('login' => $new_user_name),array('key_name' => 'user_id','key_value' => $GLOBALS['core.auth.user']->data['user_id']));
						$GLOBALS['core.auth.user']->data['login'] = $new_user_name;
						$GLOBALS['core.smarty']->assign('user_name_good',1);
					}
				}
				else 
				{
					//save user here
					$GLOBALS['core.store']->save('user', array('login' => $new_user_name),array('key_name' => 'user_id','key_value' => $GLOBALS['core.auth.user']->data['user_id']));
					$GLOBALS['core.auth.user']->data['login'] = $new_user_name;
					$GLOBALS['core.smarty']->assign('user_name_good',1);
				}
			}
		}
		elseif (isset($_REQUEST['save_password']))
		{
			$new_password = $_REQUEST['new_password'];
			$retype_new_password = $_REQUEST['retype_new_password'];
			if(empty($new_password) || $new_password != $retype_new_password)
			{
				$GLOBALS['core.smarty']->assign('invalid_password',1);
			}
			else 
			{
				$GLOBALS['core.store']->save('user', array('password' => md5($new_password)), array('key_name' => 'user_id','key_value' => $GLOBALS['core.auth.user']->data['user_id']));
				$GLOBALS['core.smarty']->assign('password_good', 1);
			}
		}
		$u_data = $GLOBALS['core.auth.user']->get_data();
		$GLOBALS['core.smarty']->assign('u_data', $u_data);
		return Admin_Header::out('admin_info');
	}
}
?>