<?php
require_once('Common_Header.php');
class Pear_Error_Runmode extends Runmode 
{
	function Pear_Error_Runmode()
	{
		parent::Runmode();
	}
	
	function process()
	{
		$GLOBALS['core.log']->do_log('Pear_Error_Runmode: requested file: ' . print_r($_SERVER,1), 'runmode');
		return Common_Header::out('Common/pear_error_runmode');
	}
}
?>