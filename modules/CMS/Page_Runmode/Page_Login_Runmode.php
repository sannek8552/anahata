<?php

class Page_Login_Runmode extends Runmode 
{
	function Page_Login_Runmode()
	{
		parent::Runmode();
	}
	
	function process()
	{
		if ($GLOBALS['core.auth.user']->uid)
		{
			$GLOBALS['core.smarty']->assign('logged_in',1);
			$GLOBALS['core.smarty']->assign('user_data',$GLOBALS['core.auth.user']->data);
		}
		return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/login_module.tpl');
	}
}

?>