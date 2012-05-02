<?php
require_once('modules/CMS/MenuHolder.php');
require_once('modules/CMS/Menu.php');
require_once('classes/CMS/SettingsHolder.php');
require_once('classes/CategoryHolder.php');
require_once('classes/BrandHolder.php');
require_once('classes/UserHolder.php');
require_once('classes/ProductHolder.php');


class Common_Header
{
	function out($tpl = '', $template = '')
	{
		$menu_holder = new MenuHolder();
		list($html_menus, $home_page) = $menu_holder->getFrontEnd();
		
                $GLOBALS['core.smarty']->assign('html_menus',$html_menus);
                $GLOBALS['core.smarty']->assign('html_home_page', $home_page);


                $bh = new BrandHolder();
		$brands = $bh->get_all();
		$GLOBALS['core.smarty']->assign('brands',$brands);



                if (!empty($tpl)) {
                    $GLOBALS['core.smarty']->assign('body', $tpl . '.tpl');
                }
		
		if (empty($template)) {
                    return $GLOBALS['core.smarty']->fetch('common_header.tpl');
                }
		else {
                    return $GLOBALS['core.smarty']->fetch('./Headers/' . $template . '.tpl');
		}
	}
	
}
?>