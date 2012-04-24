<?php
require_once('Menu.php');
require_once('CMS/Page_Factory.php');
//require_once('inc/CommonHeader.php');

class Common_Menu extends Runmode 
{
	var $home_page = array();
	
	function Common_Menu()
	{
		$this->base_map[0] = 'menu_id';
		parent::Runmode();
	}
	
	function get_menus()
	{
		$menu = new Menu();
		$data = $menu->get_submenus(1);
		$this->home_page = $data[1];
		unset($this->home_page['sub']);
		if (isset($data[1]['sub'])) return $data[1]['sub'];
		//return $data;
		return array();
	}
	
	function clear_active($menu)
	{
		foreach ($menu as $key => $value)
		{
			if($value['published'] != 1 || $value['active'] != 1)
			{
				unset($menu[$key]);
				continue;
			}
			if(isset($value['sub']) && is_array($value['sub']))
			{
				$menu[$key]['sub'] = $this->clear_active($value['sub']);
				if(empty($menu[$key]['sub']))
				{
					unset($menu[$key]['sub']);
				}
			}
		}
		return $menu;
	}
	
	function clear_published($menu)
	{
		foreach ($menu as $key => $value)
		{
			if($value['active'] != 1)
			{
				unset($menu[$key]);
				continue;
			}
			if(isset($value['sub']) && is_array($value['sub']))
			{
				$menu[$key]['sub'] = $this->clear_published($value['sub']);
				if(empty($menu[$key]['sub']))
				{
					unset($menu[$key]['sub']);
				}
			}
		}
		return $menu;
	}
	
	function process_seo($menu)
	{
		foreach ($menu as $key => $value)
		{
			if(preg_match('/^http/',$value['seo_url']))
			{
				$menu[$key]['direct_link'] = 1;
			}
			if(isset($value['sub']) && is_array($value['sub']))
			{
				$menu[$key]['sub'] = $this->process_seo($value['sub']);
			}
		}
		return $menu;
	}
	
	function get_home_page()
	{
		return $this->home_page;
	}
	
	
	function build_html_menu()
	{
		$menus = Common_Menu::get_menus();
		$GLOBALS['core.smarty']->assign('html_menus',$menus);
	}
	
	function show_page()	
	{
		$content = "";
		if (isset($_REQUEST['menu_id']) && !empty($_REQUEST['menu_id']))
		{
			$type = $GLOBALS['core.sql']->getOne("select page_type from ".$GLOBALS['core.store']->prefix."menu_attribute where menu_id = ?",array($_REQUEST['menu_id']));
			if (!empty($type))
			{
				$factory = new Page_Factory();
				$page = $factory->create($type);
				$content = $page->display($_REQUEST['menu_id']);
				
			}
		}
		$GLOBALS['core.smarty']->assign('body',$content['content']);
		$GLOBALS['core.smarty']->assign('page_title',$content['page_title']);
		$GLOBALS['core.smarty']->assign('keywords',$content['keywords']);
		$GLOBALS['core.smarty']->assign('text_to_init', $content['text_to_init']);
		return CommonHeader::out();
	}
	
	function ajax_show_page()
	{
		$content = "";
		$to_return['content'] = "";
		if (isset($_REQUEST['q']['menu_id']) && !empty($_REQUEST['q']['menu_id']))
		{
			$type = $GLOBALS['core.sql']->getOne("select page_type from ".$GLOBALS['core.store']->prefix."menu_attribute where menu_id = ?",array($_REQUEST['q']['menu_id']));
			if (!empty($type))
			{
				$factory = new Page_Factory();
				$page = $factory->create($type);
				$content = $page->display($_REQUEST['q']['menu_id']);
				$to_return['content'] = $content['content'];
				$to_return['page_title'] = $content['page_title'];
				$to_return['text_to_init'] = isset($content['text_to_init']) ? $content['text_to_init'] : '';
			}
		}
		$GLOBALS['core.ajax']->put_to_output($to_return);
	}
}
?>