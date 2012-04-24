<?php
require_once('Admin_Header.php');
class Test extends Runmode 
{
	function process()
	{
		return Admin_Header::out('test');
	}
}
?>