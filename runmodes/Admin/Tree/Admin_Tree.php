<?php
require_once('Admin_Header.php');
require_once('Secure.php');

class Admin_Tree
{
	var $tree_holder;
	var $tpl_prefix;
	var $tpl;
	var $tpl_table;
	var $tree_holder_class_name = "Tree_Holder";
	var $secure_class_name = "Secure";
	var $secure;
	var $cfg;
	var $sn;
	
	function Admin_Tree($cfg)
	{
		//parent::Runmode();
		require_once('modules/Tree/'.$this->tree_holder_class_name.".php");
		$this->cfg = $cfg;
		eval("\$this->tree_holder = new ".$this->tree_holder_class_name."(\$cfg);");
		require_once("Secure.php");
		eval("\$this->secure = new ".$this->secure_class_name."();");
	}
	
	function process()
	{
		return Admin_Header::out($this->tpl);
	}
	
	function ajax_get_html()
	{
		
		$ret = array();
		$html = "";
		$sub = $this->tree_holder->get_submenus(0,array(),0);
		if (isset($sub[0]['sub']))
		{
			$ret = $sub[0]['sub'];
			$GLOBALS['core.smarty']->assign('data',$ret);
		}
		$html = $GLOBALS['core.smarty']->fetch($this->tpl_prefix.$this->tpl_table);
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
		if (isset($_REQUEST['q']['id']))
		{
			$sub = $this->tree_holder->get_submenus($_REQUEST['q']['id']);
			if (isset($sub[$_REQUEST['q']['id']]['sub']))
			{
				$tree = $sub[$_REQUEST['q']['id']]['sub'];	
			}
		}
		//print_r($tree);
		$GLOBALS['core.ajax']->put_to_output(array('tree' => $tree));
	}
	
	function ajax_refresh_menu()
	{
		$menu = array();
		if (isset($_REQUEST['q']['id']))
		{
			//eval("\$m = new ".$this->tree_holder_class_name."(".$_REQUEST['q'][$this->tree_holder->key_info['key_name']].");");
			$this->tree_holder->init($_REQUEST['q'][$this->tree_holder->key_info['key_name']]);
			$menu = $this->tree_holder->get_data();
		}
		$GLOBALS['core.ajax']->put_to_output(array('menu' => $menu));
	}
	
	function ajax_delete_menu()
	{
		$success = 0;		
		if (isset($_REQUEST['q'][$this->tree_holder->key_info['key_name']]) && $this->secure->secure_delete($_REQUEST['q'][$this->tree_holder->key_info['key_name']]))
		{
			//eval("\$this->tree_holder = new ".$this->tree_holder_class_name."(\$this->cfg);");
			$this->tree_holder->init($_REQUEST['q'][$this->tree_holder->key_info['key_name']]);
			//eval("\$m = new ".$this->tree_holder_class_name."(".$_REQUEST['q'][$this->tree_holder->key_info['key_name']].");");
			$success = $this->tree_holder->delete();
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
			$info = $GLOBALS['core.sql']->getRow("select * from ".$GLOBALS['core.store']->prefix.$this->tree_holder->table." where ".$this->tree_holder->key_info['key_name']." = ?",array($id));
			if (!empty($info) && isset($info[$this->tree_holder->parent_field]) && isset($info[$this->tree_holder->order_field]))
			{
				$max_order = $GLOBALS['core.sql']->getAll("select * from ".$GLOBALS['core.store']->prefix.$this->tree_holder->table." where ".$this->tree_holder->order_field." < ? and ".$this->tree_holder->parent_field." = ?  ",array($info[$this->tree_holder->order_field],$info[$this->tree_holder->parent_field]));
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
				$max_order = $GLOBALS['core.sql']->getAll("select * from ".$GLOBALS['core.store']->prefix.$this->tree_holder->table." where ".$this->tree_holder->order_field." > ? and ".$this->tree_holder->parent_field." = ?  ",array($info[$this->tree_holder->order_field],$info[$this->tree_holder->parent_field]));
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
		if (isset($_REQUEST['q']['id'])/* && !empty($_REQUEST['q']['id'])*/)
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
	
	function get_add_form()
	{
		//parent method for call
		return $this->place_dyn_fields();
	}
	
	function prepare_edit(&$holder)
	{
		$fields = $this->place_dyn_fields(false);
		foreach ($fields as $key => $value)
		{
			$fields[$key]['value'] = $holder->get_data($value['request_name']);
		}
		$GLOBALS['core.smarty']->assign('additional_fields', $fields);
		return $fields;
	}
	
	function place_dyn_fields($assign = true)
	{
		$section = $this->cfg;
		
		//we gather 3 fields from config is name, request_name and type
		$fields = array();
		foreach($section as $key => $value)
		{
			if(preg_match('/field_(\d\d?)_(.*)/',$key,$match))
			{
				$fields[$match[1]][$match[2]] = $value;
			}
		}		
		//pp($GLOBALS['fceditor.init']);
		$GLOBALS['core.smarty']->assign('additional_fields', $fields);
		return $fields;
	}
	
	function prepare_set_data(&$prepare_data)
	{
		$data = $_REQUEST['q'];
		$fields = $this->place_dyn_fields(false);
		foreach ($fields as $key => $value)
		{
			if(isset($data[$value['request_name']]))
				$prepare_data[$value['request_name']] = $data[$value['request_name']];
			else 
				$prepare_data[$value['request_name']] = '';
		}		
	}
}
?>