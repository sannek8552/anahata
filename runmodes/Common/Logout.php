<?php
require_once('Common_Header.php');
class Logout extends Runmode 
{
	function process()
	{
	
		$GLOBALS['core.auth']->deauthorise();
		
		//if (isset($_SESSION['user_login'])) unset($_SESSION['user_login']);
		
		
		/*if (isset($_SESSION['back_true']) && $_SESSION['back_true'])
		{
			unset($_SESSION['back_true']);
			if (isset($_SESSION['back_user']))
			{
				$GLOBALS['core.auth.user'] = unserialize($_SESSION['back_user']);
				$_SESSION['_UID_'] = $GLOBALS['core.auth.user']->data['user_id'];
				unset($_SESSION['back_user']);
				if (isset($_SESSION['back_runmode']) && !empty($_SESSION['back_runmode']))
				{
					$GLOBALS['core.runmode']->init($_SESSION['back_runmode']);
					unset($_SESSION['back_runmode']);
					$GLOBALS['core.runmode']->run();
					return;
				}
			}
		}*/
		
		$GLOBALS['core.runmode']->init('Login');		
		$GLOBALS['core.runmode']->run();
		return ;
	}
}
?>