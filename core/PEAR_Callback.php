<?php
class PEAR_Callback extends Module
{
	function PEAR_Callback($cfg)
	{

	}

	function init()
	{

		$res = PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, array(&$this,'handle'));
	}

	function handle($error)
	{
		$t_conf = $GLOBALS['core.config']->get_config('templates');
		if(isset($t_conf['common']['debug']) && 1 == $t_conf['common']['debug'])
		{
			print '<pre>';
			print_r($_REQUEST);
			print_r($error);			
			throw new Exception("System error occured. Please contact with administrator.");			
			exit();
		}
		
		$f = fopen('./logs/pear.log',"a");
		fwrite($f, '---------------------------------------------------------------------------------------' . "\n\n\n\n");
		fwrite($f, 'Date : ' . date("m.d.Y H:i:s") . "\n\n\n\n");
		fwrite($f,print_r($_REQUEST,true));
		fwrite($f,print_r($error,true));
		fclose($f);		
		throw new Exception("System error occured. Please contact with administrator.");
		exit();
		if(isset($GLOBALS['core.runmode']))
		{
			$GLOBALS['core.runmode']->init('pear_error_runmode');
			$GLOBALS['core.runmode']->run();
			
		}
		else 
		{
			print 'some error';
			exit();
		}
		
	}
}
?>