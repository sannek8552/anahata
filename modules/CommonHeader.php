<?php
require_once('modules/Common_Menu.php');

class CommonHeader
{
	function out($template = '')
	{		
		$smarty = $GLOBALS['core.smarty'];		
		if (isset($GLOBALS['core.auth.user']->data['user_id'])) {
			$smarty->assign('logged',1);			
		}
		
		if ($GLOBALS['core.auth.user']->is_member_of('admin')) $GLOBALS['core.smarty']->assign('is_admin',1);
		
		if(!empty($template))
		{
			$GLOBALS['core.smarty']->assign('body', $GLOBALS['core.smarty']->fetch($template . '.tpl'));
		}
		
		
		
		$menus = Common_Menu::get_menus();
		#var_dump($menus);
		$GLOBALS['core.smarty']->assign('html_menus',$menus);
		
		$t_config = $GLOBALS['core.config']->get_config('templates');
		if(isset($t_config['common']['debug']) && 1 == $t_config['common']['debug'])
		{
			/*
			$debug_info['total_time'] = $GLOBALS['time_end'] - $GLOBALS['time_start'];
			$debug_info['sql_count'] = $GLOBALS['core.sql.count'];
			$debug_info['sql_time'] = $GLOBALS['core.sql.time'];
			$debug_info['php_time'] = $debug_info['total_time'] - $debug_info['sql_time'];
			$GLOBALS['core.smarty']->assign('debug_info', $debug_info);
			*/
		}
		
		
		#var_dump($GLOBALS['core.smarty']);
		#var_dump($GLOBALS['core.smarty']->fetch('Header/common_header.tpl'));
		return $GLOBALS['core.smarty']->fetch('Header/common_header.tpl');
	}
}
?>