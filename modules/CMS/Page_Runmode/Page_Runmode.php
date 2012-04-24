<?php
require_once('classes/CMS/FAQ_Holder.php');

class Page_Runmode extends Runmode
{
	function Page_Runmode()
	{
		parent::Runmode();
	}
	
	function process()
	{
		$GLOBALS['core.runmode']->init($_REQUEST['__runmodename']);

		$res = $GLOBALS['core.runmode']->execute($GLOBALS['core.auth.user']);
		if(PEAR::isError($res))	return '';
		if($res == E_AUTHENTICATION_FAILED)
		{
			$_SESSION['core.runmode.requested'] = $_REQUEST['__runmodename'];
			$_SESSION['request_uri'] = $_REQUEST['__runmodename'];
			$GLOBALS['core.runmode']->init('login_form');
			$res = $GLOBALS['core.runmode']->execute($GLOBALS['core.auth.user']);
			if(PEAR::isError($res))	return '';
		}

		return $res;
		#return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/faq_module.tpl');
	}
}
?>