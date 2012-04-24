<?php
/*
*@copyright <a href="http://evaxsoft.com">EvaxSoft</a>
Class used to process page creation
It handle all request and current step of creation
At initial it return availiable types of page
*/
require_once('Page_Strategy.php');
require_once('Page_Factory.php');
class Page_Creator
{
	/*
		Constructor
		@param $page_id id of page that shoud be modified
	*/
	var $id = null;
	var $strategy = null;
	var $factory = null;
	var $smarty = null;
	var $template_prefix = 'Admin/CMS/page_creator/';
	function Page_Creator($page_id = null)
	{
		$this->factory = new Page_Factory();
		$this->smarty =& $GLOBALS['core.smarty'];
	}

	/*function strategy_run()
	{

	}*/

	/*function run()
	{
		$availiable_types = $this->factory->page_list();
		$this->smarty->assign('availiable_types', $availiable_types);
		$this->smarty->assign('step', 'type_select');
		return $this->smarty->fetch($this->template_prefix . 'type_select.tpl');
	}*/

	function run_ajax()
	{
		$page_item = $this->factory->create();
		$to_return = array();

		/*if(isset($_REQUEST['action']) && 'delete' == $_REQUEST['action'])
		{
			$to_delete = $_REQUEST['to_delete'];
			require_once('Menu.php');
			$menu = new Menu($to_delete);
			$all_subs = $menu->get_submenus($to_delete);
			if (!isset($all_subs[$to_delete]['sub_ids']))
			{
				$all_subs[$to_delete]['sub_ids'] = array();
			}
			$all_subs[$to_delete]['sub_ids'][] = $to_delete;
			$all_to_delete = $GLOBALS['core.sql']->getAll('SELECT * FROM ' . $GLOBALS['core.store']->prefix . 'menu_attribute WHERE menu_id in(' . join(',', $all_subs[$to_delete]['sub_ids']) . ')');
			foreach ($all_to_delete as $key => $value)
			{
				$obj = $this->factory->create($value['page_type']);
				$obj->delete($value['menu_id']);
			}

			//}
			$menu->delete();
			$to_return['status'] = 'true';
			$to_return['content'] = 'Menu deleted succesfully';
			$to_return['final_params']['parent_id'] = $menu->get_data('parent_id');
			$to_return['final_params']['edit_id'] = $menu->get_data('id');
		}*/

		if(isset($_REQUEST['current_action']) && 'new_page' == $_REQUEST['current_action'])
		{
			$to_return['status'] = 'true';
			$page_item->new_page($_REQUEST['parent_id'], $_REQUEST['params_to_save']);
			$to_return['content'] = '';
		}
		elseif (isset($_REQUEST['current_action']) && 'delete_item' == $_REQUEST['current_action'])
		{

			$to_delete = $_REQUEST['to_delete'];
			if(1 == $to_delete)
			{
				print 'can not delete root';
				exit();
			}
			require_once('Menu.php');
			$menu = new Menu($to_delete);
			$all_subs = $menu->get_submenus($to_delete);
			if (!isset($all_subs[$to_delete]['sub_ids']))
			{
				$all_subs[$to_delete]['sub_ids'] = array();
			}
			$all_subs[$to_delete]['sub_ids'][] = $to_delete;
			$all_to_delete = $GLOBALS['core.sql']->getAll('SELECT * FROM ' . $GLOBALS['core.store']->prefix . 'menu_attribute WHERE menu_id in(' . join(',', $all_subs[$to_delete]['sub_ids']) . ')');
			foreach ($all_to_delete as $key => $value)
			{
				$obj = $this->factory->create();
				$obj->delete($value['menu_id']);
			}
			$menu->delete();
			$to_return['status'] = 'true';
			$to_return['content'] = '';
		}
		elseif (isset($_REQUEST['current_action']) && 'edit_item' == $_REQUEST['current_action'])
		{
			$to_return['status'] = 'true';
			$to_return['params'] = $page_item->get_params($_REQUEST['edit_id']);
			$to_return['content'] = '';
		}
		elseif(isset($_REQUEST['current_action']) && 'save_item' == $_REQUEST['current_action'])
		{
			$to_return['status'] = 'true';
			$page_item->save_page($_REQUEST['edit_id'], $_REQUEST['params_to_save']);
			$to_return['content'] = '';
		}
		elseif (isset($_REQUEST['current_action']) && 'view_item' == $_REQUEST['current_action'])
		{
			unset($GLOBALS['core.do_not_parse']);
			$arr = $page_item->display($_REQUEST['view_id']);
			$to_return['status'] = 'true';
			$to_return['content'] = $arr['content'];


		}
		elseif (isset($_REQUEST['current_action']) && 'active_item' == $_REQUEST['current_action'])
		{
			$content = $page_item->activate($_REQUEST['edit_id'], $_REQUEST['active']);
			$to_return['status'] = 'true';
			$to_return['content'] = $content;
		}
		elseif (isset($_REQUEST['current_action']) && 'publish_item' == $_REQUEST['current_action'])
		{
			$content = $page_item->publish($_REQUEST['edit_id'], $_REQUEST['publish']);
			$to_return['status'] = 'true';
			$to_return['content'] = $content;
		}
		else
		{
			$to_return['status'] = 'false';
			$to_return['message'] = 'Selected type not exists';
		}

		/*else
		{
			$strategy = new Page_Strategy($page_item);
			$content = $strategy->strategy();
			if(INITIAL_CHOICE == $content['content'])
			{
				$content['content'] = $this->run();
			}
			$to_return['status'] = 'true';
			$to_return['content'] = $content['content'];
			$to_return['params_to_back'] = $content['params_to_back'];
			$to_return['type'] = $selected_type;
			$to_return['final'] = isset($content['final']) ? 'true' : 'false';
			$to_return['final_params'] = isset($content['final_params']) ? $content['final_params'] : array();
			if(isset($GLOBALS['text_to_init']))
			{
				$to_return['text_to_init'] = $GLOBALS['text_to_init'];
			}
		}
		*/
		return $to_return;
	}
}
?>