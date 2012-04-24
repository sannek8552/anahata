<?php
	require_once('Admin_Header.php');
	class PaypalSettings
	{
		function PaypalSettings()
		{
			$GLOBALS['core.smarty']->assign('current_menu','Payments');
			$GLOBALS['core.smarty']->assign('current_submenu','PaypalInfo');
		}
		
		function process()
		{
			if (isset($_REQUEST['save']) and $_REQUEST['save'])
			{
				$fp = fopen("conf/paypal.ini","w");
				fwrite($fp,"[common]\n");
				fwrite($fp,"API_USERNAME = \"".$_REQUEST['API_USERNAME']."\"\n");
				fwrite($fp,"API_PASSWORD = \"".$_REQUEST['API_PASSWORD']."\"\n");
				fwrite($fp,"API_SIGNATURE = \"".$_REQUEST['API_SIGNATURE']."\"\n");
				fwrite($fp,"API_ENDPOINT = \"".$_REQUEST['API_ENDPOINT']."\"\n");
				fwrite($fp,"PAYPAL_URL = \"".$_REQUEST['PAYPAL_URL']."\"\n");
				fwrite($fp,"VERSION = \"".$_REQUEST['VERSION']."\"\n");
			}

			$paypal = $GLOBALS['core.config']->get_config('paypal');
			$GLOBALS['core.smarty']->assign('paypal',$paypal['common']);

			return Admin_Header::out('paypal_settings');
		}				
	}
?>