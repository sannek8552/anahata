<?php
require_once('CMS/Page_Modules/Page_Module.php');
class Simple_Page extends Page_Module 
{
	var $smarty = null;
	var $frontend_template = 'Admin/CMS/pages/simple_page_frontend.tpl';
	var $info_template = 'Admin/CMS/pages/general_info.tpl';
	//var $allowed_params = array('title');
	function Simple_Page()
	{
		$this->smarty =& $GLOBALS['core.smarty'];
	}
	
	/*function next_step($step)
	{
		if(1 == $_SESSION['Page_Module']['Simple_Page']['step'] && -1 == $step)
		{
			unset($_SESSION['Page_Module']['Simple_Page']);
			return INITIAL_CHOICE;
		}
		elseif(1 == $_SESSION['Page_Module']['Simple_Page']['step'] && 1 == $step)
		{
			//here wee need to save all data to database
			//and return back final message
			$data_to_save = array('title' => $_REQUEST['params_to_save']['title']);
			$data_to_save['page_title'] = $_REQUEST['params_to_save']['page_title'];
			$data_to_save['keywords'] = $_REQUEST['params_to_save']['keywords'];
			$data_to_save['page_description'] = $_REQUEST['params_to_save']['page_description'];
			$data_to_save['seo_url'] = $_REQUEST['params_to_save']['seo_url'];
			$data_to_save['google_priority'] = $_REQUEST['params_to_save']['google_priority'];
			//now we need to save main menu item
			$key_info = array('key_name' => 'id');
			if($_SESSION['Page_Module']['Simple_Page']['edit_id'] > 0)
			{
				//we need to modify existing menu
				$key_info['key_value'] = $_SESSION['Page_Module']['Simple_Page']['edit_id'];
			}
			else 
			{
				//we need to create new menu
				$data_to_save['parent_id'] = $_SESSION['Page_Module']['Simple_Page']['parent_id'];
				$max_order_id = $GLOBALS['core.sql']->getOne('SELECT max(order_id) FROM ' . $GLOBALS['core.store']->prefix . 'menu WHERE parent_id = ?',array($_SESSION['Page_Module']['Simple_Page']['parent_id']));
				if(empty($max_order_id))
				{
					$max_order_id = 1;
				}
				else 
				{
					$max_order_id++;
				}
				$data_to_save['order_id'] = $max_order_id;
			}
			$GLOBALS['core.store']->save('menu',$data_to_save,$key_info);
			if($_SESSION['Page_Module']['Simple_Page']['edit_id'] > 0)
			{
				$menu_id = $_SESSION['Page_Module']['Simple_Page']['edit_id'];
			}
			else 
			{
				$menu_id = $GLOBALS['core.store']->last_id();
			}
			$_SESSION['Page_Module']['Simple_Page']['menu_id'] = $menu_id;
			//now we need to save any additional params that required by module
			$data_to_save = array();
			$data_to_save['menu_id'] = $menu_id;
			$data_to_save['page_type'] = 'Simple_Page';
			$data_to_save['content'] = $_REQUEST['params_to_save']['simple_module_contentid'];
			$key_info = array('key_name' => 'id');
			$res = $GLOBALS['core.sql']->getOne('SELECT id FROM ' . $GLOBALS['core.store']->prefix . 'menu_attribute WHERE menu_id = ?', array($menu_id));
			if(!empty($res))
			{
				$key_info['key_value'] = $res;
			}
			$GLOBALS['core.store']->save('menu_attribute',$data_to_save, $key_info);
			$_SESSION['Page_Module']['Simple_Page']['step'] = 2;
			return $this->smarty->fetch('Admin/CMS/pages/simple_page_final.tpl');
			
		}
		//print 'here';
	}
	
	function first_step()
	{
		$this->smarty->assign('step', 1);
		$_SESSION['Page_Module']['Simple_Page']['step'] = 1;
		$_SESSION['Page_Module']['Simple_Page']['parent_id'] = isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : 0;
		$_SESSION['Page_Module']['Simple_Page']['edit_id'] = isset($_REQUEST['edit_id']) ? $_REQUEST['edit_id'] : 0;
		if($_SESSION['Page_Module']['Simple_Page']['edit_id'] > 0)
		{
			$this->smarty->assign('edit_mode', 1);
			$menu_row = $GLOBALS['core.sql']->getRow('SELECT * FROM ' . $GLOBALS['core.store']->prefix . 'menu WHERE id=?',array($_SESSION['Page_Module']['Simple_Page']['edit_id']));
			$this->smarty->assign('menu_row', $menu_row);
			$attribute_row = $GLOBALS['core.sql']->getRow('SELECT * FROM ' . $GLOBALS['core.store']->prefix . 'menu_attribute WHERE menu_id=?',array($_SESSION['Page_Module']['Simple_Page']['edit_id']));
			$this->smarty->assign('attribute_row', $attribute_row);
		}
		return $this->smarty->fetch('Admin/CMS/pages/simple_page.tpl');
	}
	
	function params_to_back()
	{
		if(isset($_SESSION['Page_Module']['Simple_Page']) && 1 == $_SESSION['Page_Module']['Simple_Page']['step'])
		{
			return array('title' => 'text', 'simple_module_contentid' => 'rich_edit','page_title' => 'text', 'keywords' => 'text','page_description' => 'text','seo_url' => 'text','google_priority' => 'text');
		}
		return array();
	}
	
	function final_step()
	{
		$to_return = $_SESSION['Page_Module']['Simple_Page'];
		unset($_SESSION['Page_Module']['Simple_Page']);
		return $to_return;
		//here we need to return params that needed by cms to reload menu item 
		
	}
	
	function is_final()
	{
		if(isset($_SESSION['Page_Module']['Simple_Page']) && 2 == $_SESSION['Page_Module']['Simple_Page']['step'])
		{
			return true;
		}
		return false;
	}
	*/
	
	function new_page($parent_id, $params)
	{
		$data_to_save = array('title' => $params['title']);
		$data_to_save['page_title'] = $params['page_title'];
		$data_to_save['keywords'] = $params['keywords'];
		$data_to_save['page_description'] = $params['page_description'];
		$data_to_save['seo_url'] = $params['seo_url'];
		$data_to_save['google_priority'] = $params['google_priority'];
		//$data_to_save['template'] = $params['template'];
		//now we need to save main menu item
		$key_info = array('key_name' => 'id');
		
		//we need to create new menu
		$data_to_save['parent_id'] = $parent_id;
		$max_order_id = $GLOBALS['core.sql']->getOne('SELECT max(order_id) FROM ' . $GLOBALS['core.store']->prefix . 'menu WHERE parent_id = ?',array($parent_id));
		if(empty($max_order_id))
		{
			$max_order_id = 1;
		}
		else 
		{
			$max_order_id++;
		}
		$data_to_save['order_id'] = $max_order_id;
		
		$GLOBALS['core.store']->save('menu',$data_to_save,$key_info);
		
		$menu_id = $GLOBALS['core.store']->last_id();
		
		//now we need to save any additional params that required by module
		$data_to_save = array();
		$data_to_save['menu_id'] = $menu_id;
		$data_to_save['content'] = $params['simple_module_contentid'];
		$data_to_save['template'] = $params['template'];
		$key_info = array('key_name' => 'id');
		$res = $GLOBALS['core.sql']->getOne('SELECT id FROM ' . $GLOBALS['core.store']->prefix . 'menu_attribute WHERE menu_id = ?', array($menu_id));
		if(!empty($res))
		{
			$key_info['key_value'] = $res;
		}
		$GLOBALS['core.store']->save('menu_attribute',$data_to_save, $key_info);
	}
	
	function save_page($page_id, $params)
	{
		$data_to_save = array('title' => $params['title']);
		$data_to_save['page_title'] = $params['page_title'];
		$data_to_save['keywords'] = $params['keywords'];
		$data_to_save['page_description'] = $params['page_description'];
		$data_to_save['seo_url'] = $params['seo_url'];
		$data_to_save['google_priority'] = $params['google_priority'];
		//now we need to save main menu item
		$key_info = array('key_name' => 'id', 'key_value' => $page_id);
		
		//we need to create new menu
		$GLOBALS['core.store']->save('menu',$data_to_save,$key_info);
		
		$menu_id = $page_id;
		
		//now we need to save any additional params that required by module
		$data_to_save = array();
		$data_to_save['menu_id'] = $menu_id;
		$data_to_save['content'] = $params['simple_module_contentid'];
		$data_to_save['template'] = $params['template'];
		$key_info = array('key_name' => 'id');
		$res = $GLOBALS['core.sql']->getOne('SELECT id FROM ' . $GLOBALS['core.store']->prefix . 'menu_attribute WHERE menu_id = ?', array($menu_id));
		if(!empty($res))
		{
			$key_info['key_value'] = $res;
		}
		$GLOBALS['core.store']->save('menu_attribute',$data_to_save, $key_info);
	}
	
	function get_params($menu_id)
	{
		$params = $this->_get_page_info($menu_id);
		$params['simple_module_contentid'] = $params['content'];
		unset($params['content']);
		
		return $params;
	}
	
	
	function delete($menu_id)
	{
		$GLOBALS['core.store']->delete('menu_attribute', array('key_name' => 'menu_id','key_value' => $menu_id));
		return true;
	}
	
	function display($menu_id)
	{
		$out = "";
		$page_info = $this->_get_page_info($menu_id);
		
		$this->smarty->assign('simple_page_content',$page_info['content']);
		$GLOBALS['core.do_not_parse'] = 1;
		$out = $this->smarty->fetch($this->frontend_template);
		unset($GLOBALS['core.do_not_parse']);
		#pp($page_info);
		return array('active' => $page_info['active'],'seo_url' => $page_info['seo_url'], 'content' => $out, 'page_title' => $page_info['page_title'], 'keywords' => $page_info['keywords'],'text_to_init' => '','page_description' => $page_info['page_description'],'template' => $page_info['template']);
	}
	
	function info($menu_id)
	{
		$page_info = $this->_get_page_info($menu_id);
		$out = "";
		$this->smarty->assign('info',$page_info);
		$out = $this->smarty->fetch($this->info_template);
		
		return array('content' => $out);
	}
	
	function activate($menu_id,$active)
	{
		$val = 0;
		if ($active != 0) $val = 1;
		$GLOBALS['core.store']->save("menu",array('active' => $val),array('key_name' => 'id' ,'key_value' => $menu_id));
		return 'Page info updated';
	}
	
	function publish($menu_id,$active)
	{
		$val = 0;
		if ($active != 0) $val = 1;
		$GLOBALS['core.store']->save("menu",array('published' => $val),array('key_name' => 'id' ,'key_value' => $menu_id));
		return 'Page info updated';
	}	
	
	function _get_page_info($menu_id)
	{
		return $GLOBALS['core.sql']->getRow("select * from ".$GLOBALS['core.store']->prefix."menu_attribute as a INNER JOIN ".$GLOBALS['core.store']->prefix . "menu as m ON a.menu_id=m.id  where menu_id = ?",array($menu_id));		
	}
}
?>