<?php
require_once('classes/PurchasedCertificateHolder.php');


class Admin_Header
{
	function out($tpl, $runmode = null)
	{
		$GLOBALS['core.do_not_parse'] = 1;
		Admin_Header::prepare_language();
		Admin_Header::prepare_menu();		
		
		if(!is_null($runmode))
        {
        	require_once('classes/JsFiles.php');
            $js_files = JsFiles::get_js_list($runmode->get_js());
            $GLOBALS['core.smarty']->assign('js_files', $js_files);
            $GLOBALS['core.smarty']->assign('css_files', JsFiles::get_css_list());
        }

        
        if (!empty($not_approved)) $GLOBALS['core.smarty']->assign('certificates_not_approved', 1);

		$GLOBALS['core.smarty']->assign('body', 'Admin/' . $tpl . '.tpl');
		return $GLOBALS['core.smarty']->fetch('Admin/admin_header.tpl');
	}
	
	function prepare_language()
	{		
		$templates = $GLOBALS['core.config']->get_config('templates');
		
		
		if (isset($templates['common']['default_lang']))
		{
			require_once('lang/'.$templates['common']['default_lang'].'.php');
			global $_LANG;
			if (isset($_LANG) and is_array($_LANG))
			{
				foreach ($_LANG as $key => $value) 
				{
					$GLOBALS['core.smarty']->assign($key,$value);
				}
			}
		}		
	}
	
	function prepare_menu()
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
		$GLOBALS['core.smarty']->assign('menu_panel', $menu);
	}
	
	function _check_access($group_string)
	{
		$groups = explode(",",$group_string);
		$access = false;
		foreach ($groups as $g)
			if ($GLOBALS['core.auth.user']->is_member_of($g))
			{
				$access = true;
				break;
			}
		return $access;	
	}  
	
	function cmp($a, $b)
	{
		if($a['order'] > $b['order'])
		{
			return 1;
		}
		elseif($a['order'] < $b['order'])
		{
			return -1;
		}
		return 0;
	}
}
?>