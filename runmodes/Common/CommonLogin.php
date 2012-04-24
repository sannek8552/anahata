<?php
class CommonLogin extends Runmode 
{
	function CommonLogin()
	{
		parent::Runmode();
	}
	
	function process()
	{
		if($GLOBALS['core.auth.user']->is_member_of('admin'))
		{
			$GLOBALS['core.runmode']->redirect('AdminMenuNew');
		}
		elseif ($GLOBALS['core.auth.user']->is_member_of('user'))
		{
			$GLOBALS['core.runmode']->redirect('Profile');
		}
	}
}
?>