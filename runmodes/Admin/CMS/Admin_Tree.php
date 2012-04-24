<?php
require_once('Admin_Header.php');

class Admin_Tree_r extends Runmode
{
	var $tree_holder;
	var $tpl;
	var $tpl_table;
	var $tree_holder_class_name = "Tree_Holder";
	var $tree_tpl = 'Admin/CMS/order_tree.tpl';
	
	function Admin_Tree()
	{
		parent::Runmode();
		require_once($this->tree_holder_class_name.".php");
		eval("\$this->tree_holder = new ".$this->tree_holder_class_name."();");
	}
	
	function process()
	{
		//$data = $this->tree_holder->get_submenus(1);
		//if (isset($data[1]['sub']))	$GLOBALS['core.smarty']->assign('data',$data[1]['sub']);
		
		//print '<pre>';
		//print_r($data);
		
		//$GLOBALS['core.smarty']->assign('current_menu','site_controls');
		//$GLOBALS['core.smarty']->assign('current_sub','manage_pages');
		
		return Admin_Header::out($this->tpl);
	}
	
	function ajax_move_node()
	{		
		if (isset($_REQUEST['q']['id']) && !empty($_REQUEST['q']['id'])
			&& isset($_REQUEST['q']['parent_id']) && !empty($_REQUEST['q']['parent_id']))
			{				
				$id = $_REQUEST['q']['id'];
				$parent_id = $_REQUEST['q']['parent_id'];				
				if ($id != $parent_id)
				{
					$data = $this->tree_holder->get_submenus($id);					
					if ((isset($data[$id]['sub_ids']) && !in_array($parent_id,$data[$id]['sub_ids'])) || !isset($data[$id]['sub_ids']))
					{
						eval("\$m = new ".$this->tree_holder_class_name."(".$id.");");
						$m->set_data(array($m->parent_field => $parent_id));
						$m->save();						
					}
				}
			}
			$GLOBALS['core.ajax']->put_to_output(array('success' =>1));
	}

	function ajax_order_tree()
	{
		$tree = $this->tree_holder->get_all();
		if (isset($tree[0]['sub']))	
		$GLOBALS['core.smarty']->assign('tree',$tree[0]['sub']);
		if (isset($_REQUEST['q']['id'])) $GLOBALS['core.smarty']->assign('cur_node',$_REQUEST['q']['id']);
		$html = $GLOBALS['core.smarty']->fetch($this->tree_tpl);
		$text_to_init = $GLOBALS['core.smarty']->fetch('Admin/CMS/order_tree_js.tpl');
		$text_to_init = str_replace("\n",'',$text_to_init);
		$text_to_init = str_replace("\r",'',$text_to_init);
		//$text_to_init = json_encode($text_to_init);
		$GLOBALS['core.ajax']->put_to_output(array('html' => $html,'text_to_init' => $text_to_init));
		//return $html;
	}
	
	function ajax_get_html()
	{		
		$ret = array();
		$html = "";
		$sub = $this->tree_holder->get_submenus(1);
		if (isset($sub[1]['sub']))
		{
			$ret = $sub[1]['sub'];
			$GLOBALS['core.smarty']->assign('data',$ret);
			$html = $GLOBALS['core.smarty']->fetch($this->tpl_table);
		}
		$GLOBALS['core.ajax']->put_to_output(array('html' => $html));
	}
	
	function ajax_get_submenus()
	{
		$ret = array();
		if (isset($_REQUEST['q']))
		{
			$data = $_REQUEST['q'];
			if (isset($data['id']))
			{				
				$sub = $this->tree_holder->get_submenus($data['id']);
				if (isset($sub[$data['id']]['sub'])) $ret = $sub[$data['id']]['sub'];
			}
		}
		$GLOBALS['core.ajax']->put_to_output(array('submenus' => $ret));
	}
	
	function ajax_get_menus()
	{
		$ret = array();
		$sub = $this->tree_holder->get_all();
		if (isset($sub[0]['sub'])) $ret = $sub[0]['sub'];
		$GLOBALS['core.ajax']->put_to_output(array('tree' => $ret));
	}
	
	function ajax_refresh_tree()
	{
		$tree = array();
		$success = 0;
		if (isset($_REQUEST['q']['id']))
		{
			$sub = $this->tree_holder->get_submenus($_REQUEST['q']['id']);
			if (isset($sub[$_REQUEST['q']['id']]['sub'])) 
			{
				$tree = $sub[$_REQUEST['q']['id']]['sub'];
				$success = 1;
			}
		}
		//print_r($tree);
		$GLOBALS['core.ajax']->put_to_output(array('tree' => $tree,'success' => $success));
	}
	
	function ajax_refresh_menu()
	{
		$menu = array();
		if (isset($_REQUEST['q']['id']))
		{
			//$m = new Menu($_REQUEST['q']['id']);			
			eval("\$m = new ".$this->tree_holder_class_name."(".$_REQUEST['q'][$this->tree_holder->key_info['key_name']].");");
			$menu = $m->get_data();
		}
		$GLOBALS['core.ajax']->put_to_output(array('menu' => $menu));
	}
	
	function ajax_delete_menu()
	{
		$success = 0;
		if (isset($_REQUEST['q'][$this->tree_holder->key_info['key_name']]))
		{
			eval("\$m = new ".$this->tree_holder_class_name."(".$_REQUEST['q'][$this->tree_holder->key_info['key_name']].");");
			$success = $m->delete();
		}
		$GLOBALS['core.ajax']->put_to_output(array('success' => $success));
	}

	function ajax_move_up_menu()
	{
		$success = 0;
		
		if (isset($_REQUEST['q']['id']))
		{
			$id = $_REQUEST['q']['id'];
			$info = array();
			//$info = $GLOBALS['core.sql']->getRow("select * from ".$GLOBALS['core.store']->prefix."menu where id = ?",array($id));
			$info = $GLOBALS['core.sql']->getRow("select * from ".$GLOBALS['core.store']->prefix.$this->tree_holder->table." where ".$this->tree_holder->key_info['key_name']." = ?",array($id));
			if (!empty($info) && isset($info[$this->tree_holder->parent_field]) && isset($info[$this->tree_holder->order_field]))
			{
				//$max_order = $GLOBALS['core.sql']->getAll("select * from ".$GLOBALS['core.store']->prefix."menu where order_id < ? and parent_id = ? ",array($info['order_id'],$info['parent_id']));
				$max_order = $GLOBALS['core.sql']->getAll("select * from ".$GLOBALS['core.store']->prefix.$this->tree_holder->table." where ".$this->tree_holder->order_field." < ? and ".$this->tree_holder->parent_field." = ? ",array($info[$this->tree_holder->order_field],$info[$this->tree_holder->parent_field]));
				$max_order_id = 0;
				$max_id = 0;
				foreach ($max_order as $value)
				{
					if (isset($value[$this->tree_holder->order_field]) && $value[$this->tree_holder->order_field] > $max_order_id)
					{
						$max_order_id = $value[$this->tree_holder->order_field];
						$max_id = $value['id'];
					}
				}
				
				if (!empty($max_order_id) && !empty($max_id))
				{
					$GLOBALS['core.store']->save($this->tree_holder->table,array($this->tree_holder->order_field => $max_order_id),array('key_name' => $this->tree_holder->key_info['key_name'],'key_value' => $info[$this->tree_holder->key_info['key_name']]));
					$GLOBALS['core.store']->save($this->tree_holder->table,array($this->tree_holder->order_field => $info[$this->tree_holder->order_field]),array('key_name' => $this->tree_holder->key_info['key_name'],'key_value' => $max_id));
					$success = 1;
				}
			}
		}
		$GLOBALS['core.ajax']->put_to_output(array('success' => $success));
	}
	
	function ajax_move_down_menu()
	{
		$success = 0;
		if (isset($_REQUEST['q']['id']))
		{
			$id = $_REQUEST['q']['id'];
			$info = array();
			$info = $GLOBALS['core.sql']->getRow("select * from ".$GLOBALS['core.store']->prefix.$this->tree_holder->table." where ".$this->tree_holder->key_info['key_name']." = ?",array($id));
			if (!empty($info) && isset($info[$this->tree_holder->parent_field]) && isset($info[$this->tree_holder->order_field]))
			{
				$max_order = $GLOBALS['core.sql']->getAll("select * from ".$GLOBALS['core.store']->prefix.$this->tree_holder->table." where ".$this->tree_holder->order_field." > ? and ".$this->tree_holder->parent_field." = ? ",array($info[$this->tree_holder->order_field],$info[$this->tree_holder->parent_field]));
				$max_order_id = 10000000;
				$max_id = 0;
				foreach ($max_order as $value)
				{
					if (isset($value[$this->tree_holder->order_field]) && $value[$this->tree_holder->order_field] < $max_order_id)
					{
						$max_order_id = $value[$this->tree_holder->order_field];
						$max_id = $value[$this->tree_holder->key_info['key_name']];
					}
				}
				
				if (!empty($max_order_id) && !empty($max_id))
				{
					$GLOBALS['core.store']->save($this->tree_holder->table,array($this->tree_holder->order_field => $max_order_id),array('key_name' => $this->tree_holder->key_info['key_name'],'key_value' => $info[$this->tree_holder->key_info['key_name']]));
					$GLOBALS['core.store']->save($this->tree_holder->table,array($this->tree_holder->order_field => $info[$this->tree_holder->order_field]),array('key_name' => $this->tree_holder->key_info['key_name'],'key_value' => $max_id));
					$success = 1;
				}
			}
		}
		$GLOBALS['core.ajax']->put_to_output(array('success' => $success));
	}
	
	function ajax_order_menu()
	{
		$success = 0;
		if (isset($_REQUEST['q']['id']) && !empty($_REQUEST['q']['id']))
		{
			$id = $_REQUEST['q']['id'];
			if (isset($_REQUEST['q']['data']) && !empty($_REQUEST['q']['data']))
			{
				$data = $_REQUEST['q']['data'];
				
				$tree_data = $this->tree_holder->get_submenus($id);
				if (isset($tree_data[$id]['sub_ids']))
				{
					$update_data = array();
					
					foreach ($tree_data[$id]['sub_ids'] as $value)
					{
						if (isset($data[$id."input".$value]))
						{
							 $this->tree_holder->init($value);
							 $this->tree_holder->set_data(array($this->tree_holder->order_field => $data[$id."input".$value]));
							 $this->tree_holder->save();
						}
					}
				}
				$success = 1;
			}
		}
		$GLOBALS['core.ajax']->put_to_output(array('success' => $success));
	}
}
?>