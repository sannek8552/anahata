<?php
class Ajax_Cover extends Module
{
	var $ajax;
	function Ajax_Cover($cfg)
	{
	}
	function init()
	{
		require_once('Ajax/AJAX.php');
		$this->ajax =  new JsHttpRequest('UTF-8');
	}
	function put_to_output($hash)
	{
		$GLOBALS['_RESULT'] = $hash;
	}	
	
	function yui_to_output($hash)
    {
            $js = $this->ajax->php2js($hash);
            print $js;
    }
}
?>