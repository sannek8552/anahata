<?php

class Home extends Runmode 
{
	function Home()
	{
		parent::Runmode();
	}
	
	function process()
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location:index.html",true,301);
		return '';
	}
}

?>