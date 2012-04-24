<?php
require_once('modules/CMS/MenuHolder.php');
require_once('classes/ProductHolder.php');
require_once('classes/CategoryHolder.php');

class Page_Sitemap extends Runmode 
{
	function Page_Sitemap()
	{
		
		parent::Runmode();
	}
	function process()
	{		
		$menu_holder = new MenuHolder();
		list($html_menus, $home_page) = $menu_holder->getSiteMap();//$menu_holder->getFrontEnd();
		array_unshift($html_menus, $home_page);
		$menus = $html_menus;
		
		$GLOBALS['core.smarty']->assign('map',$menus);
		$ph = new ProductHolder();
		$products = $ph->getAllActive();
		$GLOBALS['core.smarty']->assign('products', $products);				
		$ch = new CategoryHolder();
		$categories = $ch->getTree();
		$GLOBALS['core.smarty']->assign('map_categories', $categories);
		
		return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/sitemap.tpl');
	}
}
?>