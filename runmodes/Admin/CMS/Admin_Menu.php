<?php
require_once('runmodes/Admin/CMS/Admin_Tree.php');

class Admin_Menu extends Admin_Tree_r 
{
	var $tree_holder;
	var $tpl = "CMS/menu";
	var $tree_holder_class_name = "Menu";
	
	function Admin_Menu()
	{
		parent::Admin_Tree();
	}
	
	function process()
	{
		$GLOBALS['core.smarty']->assign('current_menu','CMS');
		$GLOBALS['core.smarty']->assign('current_sub','Pages');
		
		
		$GLOBALS['core.smarty']->assign('templates', $this->scan_templates());
		
		return parent::process();
	}
	
	function scan_templates()
	{
		$templates = array();
    	if ($dh = opendir('./templates/Headers')) 
    	{
        	while (($file = readdir($dh)) !== false) 
        	{
            	//echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
            	if('.' != $file && '..' != $file)
            	{
            		$temp = pathinfo($file);
            		if('tpl' == $temp['extension'])
            		{
            			$templates[] = $temp['filename'];
            		}
            	}
        	}
        	closedir($dh);
    	}
    	sort($templates);
    	return $templates;
	}
	
	function ajax_process()
	{
		if (isset($_REQUEST['q']['action']))
		{
			switch ($_REQUEST['q']['action'])
			{
				case 'init' :	
						$this->ajax_get_menus();
						break;
				case 'delete' :	
						$this->ajax_delete_menu();
						break;
				case 'refresh_menu' :	
						$this->ajax_refresh_menu();
						break;
				case 'refresh_tree' :	
						$this->ajax_refresh_tree();
						break;
				case 'menu_move_up' :	
						$this->ajax_move_up_menu();
						break;
				case 'menu_move_down' :	
						$this->ajax_move_down_menu();
						break;
				case 'order_tree' :
						$this->ajax_order_tree();
						break;
				case 'move_node' :
						$this->ajax_move_node();
						break;						
			}
		}
	}
	
	function ajax_move_node()
	{
		parent::ajax_move_node();
	}
	
	function ajax_order_tree()
	{
		parent::ajax_order_tree();
	}
	
	function ajax_get_submenus()
	{
		parent::ajax_get_submenus();
	}
	
	function ajax_get_menus()
	{
		parent::ajax_get_menus();
	}
	
	function ajax_refresh_tree()
	{
		parent::ajax_refresh_tree();
	}
	
	function ajax_refresh_menu()
	{
		parent::ajax_refresh_menu();
	}
	
	function ajax_delete_menu()
	{
		parent::ajax_delete_menu();
	}
	
	function ajax_move_up_menu()
	{
		parent::ajax_move_up_menu();
	}
	
	function ajax_move_down_menu()
	{
		parent::ajax_move_down_menu();
	}
}
?>