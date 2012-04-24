<?php
class Session_File extends Module 
{
	function Session_File($cfg)
	{
		
	}
	function init()
	{
	}
	
	function run()
	{	
		session_start();
	}
}
?>