<?php
/**
 *Base class of all runmodes, used to process standard tasks in runmodes
 *@author Alexandr Yusupov
 *@version 1.0
 *@copyright <a href="http://evaxsoft.com/">EvaxSoft</a>
 */
class Runmode
{
	/**
	 *Constructor
	 *
	 */
	
	var $base_map = array('action');
	
	function Runmode()
	{
		//make initialization of base SEO'urls map
		
		//$this->base_map[0] = ;
		$this->make_params();
	}
	
	function make_params()
	{
		$t = $GLOBALS['core.config']->get_config('templates');
		
		if($t['common']['use_seo'])
		{
			$params_num = isset($_REQUEST['params_to_pars']) ? count($_REQUEST['params_to_pars']) : 0;
			for ($i =0;$i < $params_num; $i++)
			{
				if(isset($this->base_map[$i]))
					$_REQUEST[$this->base_map[$i]] = $_REQUEST['params_to_pars'][$i];
				else 
					break;
			}
		}
		else 
		{		
			$i = 1;
			while(isset($_REQUEST['param' . $i]))
			{
				$_REQUEST[$this->base_map[$i-1]] = $_REQUEST['param' . $i];
				unset($_REQUEST['param' . $i]);
				$i++;
			}
		}
	}
	
	function get_js()
	{
		return array();
	}
}
?>