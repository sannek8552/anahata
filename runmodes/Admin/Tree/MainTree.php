<?php
require_once('Structure.php');
require_once('Admin_Header.php');

class MainTree extends Runmode
{
	var $config = 'dropdown';
	
	function MainTree()
	{
		//$GLOBALS['core.smarty']->assign('current_menu','CMS');
		$GLOBALS['core.smarty']->assign('current_menu', 'Administration');
		$this->base_map[0] = 'name';
		parent::Runmode();
	}
	
	function process()
	{
		//$GLOBALS['core.smarty']->assign('current_menu','site_controls');
		//$GLOBALS['core.smarty']->assign('current_sub','dropdown');
		//read config
		$conf = $this->_config_process();
		//print_r($conf);
		if (isset($_REQUEST['name']) && !empty($_REQUEST['name']))
		{
			$name = $_REQUEST['name'];
			if (isset($conf[$name]) && !empty($conf[$name]))
			{
				$runmode = new Structure($conf[$name],$name);
				return $runmode->process();
			}
		}
		else
		{
			if (!empty($conf))
			{
				$GLOBALS['core.smarty']->assign('cfg',$conf);
			}
		}
		return Admin_Header::out('Tree/main_tree');
	}

	function ajax_process()
	{
		$conf = $this->_config_process();
		if (isset($_REQUEST['q']['sn']) && !empty($_REQUEST['q']['sn']))
		{
			if (isset($conf[$_REQUEST['q']['sn']]) && !empty($conf[$_REQUEST['q']['sn']]))			
			{
				$runmode = new Structure($conf[$_REQUEST['q']['sn']],$_REQUEST['q']['sn']);
				$runmode->ajax_process();
			}
		}
	}
	
	function _config_process()
	{
		return $GLOBALS['core.config']->get_config($this->config);
	}
}
?>