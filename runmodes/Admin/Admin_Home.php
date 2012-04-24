<?php
require_once('Admin_Header.php');
class Admin_Home extends Runmode
{
	function process()
	{
		$menu = $GLOBALS['core.config']->get_config('admin_menu');
		
		foreach($menu as $key => $value)
		{
			//check for access			
			if (isset($value['access']) && !empty($value['access']))	$access = Admin_Header::_check_access($value['access']);
			else $access = true;
			if (!$access) {unset($menu[$key]);continue;} 
			
			//sub_number_MenuName mean this menu is sub menu of MenuName
			if(preg_match('/sub_\d\d?_(.+)/',$key,$m))
			{
				if(!isset($menu[$m[1]]['sub']))
					$menu[$m[1]]['sub'] = array();
				$menu[$m[1]]['sub'][] = $value;
				unset($menu[$key]);
			}
		}
		
		//now we need to order menu
		usort($menu, array('Admin_Header','cmp'));
		foreach($menu as $key => $value)
		{
			usort($menu[$key]['sub'],array('Admin_Header', 'cmp'));
		}
		
		#var_dump($menu);
		
		$GLOBALS['core.smarty']->assign('menu',$menu);
		
		return Admin_Header::out('admin_home');
	}
}
?>