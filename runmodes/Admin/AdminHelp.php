<?php
require_once('Admin_Header.php');
class AdminHelp extends Runmode 
{
	function __construct()
	{
		
	}
	
	function process()
	{
		$page = $_REQUEST['q']['page'];
		$GLOBALS['core.smarty']->assign('page', $page);
		$html = $GLOBALS['core.smarty']->fetch('Admin/admin_help.tpl');
		$to_return = array('success' => 0,'html' => $html);
		$GLOBALS['core.ajax']->put_to_output($to_return);
	}
}
?>