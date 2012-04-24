<?php
require_once('Common_Header.php');
class Login extends Runmode
{
	function Login()
	{
		/*$this->base_map[0] = 'param0';
		$this->base_map[1] = 'param1';
		$this->base_map[2] = 'param2';
		$this->base_map[3] = 'param3';
		$this->base_map[4] = 'param4';
		$this->base_map[5] = 'param5';
		$this->base_map[6] = 'param6';
		$this->base_map[7] = 'param7';
		$this->base_map[8] = 'param8';
		$this->base_map[9] = 'param9';*/
		parent::Runmode();
	}
	
	function process()
	{
		if(isset($_REQUEST['login']) && !empty($_REQUEST['login']))
		{
			
			$GLOBALS['core.smarty']->assign('login_failed', 1);
			
		}
		$request_uri = $_SERVER['REQUEST_URI'];
		if(!empty($request_uri) && $GLOBALS['core.runmode.auth_failed'] == true)
		{
			
			$GLOBALS['core.smarty']->assign('request_uri', $request_uri);
		}
		return Common_Header::out('Common/login');
	}
}
?>