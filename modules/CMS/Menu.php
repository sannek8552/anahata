<?php
require_once("Tree_Holder.php");

class Menu extends Tree_Holder 
{
	var $table = "menu";
	var $key_info = array('key_name' => 'id');
	var $parent_field = "parent_id";
	var $order_field = "order_id";
	var $title_field = "title";
	var $data;
	
	function Menu($id = "")
	{
		$this->init($id);
	}
	
	function init($id)
	{
		/*
		if (!empty($id))	$this->key_info['key_value'] = $id;
		if(isset($this->key_info['key_value']) && !empty($this->key_info['key_value']))
		{
			$this->data = $GLOBALS['core.sql']->getRow("SELECT * FROM " . $GLOBALS['core.store']->prefix . $this->table . " WHERE " . $this->key_info['key_name'] . " = ?",array($this->key_info['key_value']));
			
			if(PEAR::isError($this->data))
				return $this->data;
			if(empty($this->data))
				unset($this->key_info['key_value']);
		}
		else
		{
			$this->data = array();
		}

		return true;
		*/
		return parent::init($id);
	}

	function get_data($field_name = '')
	{
		/*
		if(empty($field_name))
			return $this->data;
		if(isset($this->data[$field_name]))
			return $this->data[$field_name];
		return null;
		*/
		return parent::get_data($field_name);
	}

	function set_data($data)
	{
		/*
		foreach($data as $key => $value)
		{
			$this->data[$key] = $value;
		}
		*/
		parent::set_data($data);
	}

	function save()
	{
		/*
		if(isset($this->key_info['key_value']) && !empty($this->key_info['key_value']))
		{
			unset($this->data[$this->key_info['key_name']]);
			return $GLOBALS['core.store']->save($this->table,$this->data,$this->key_info);
		}
		else
		{
			$res = $GLOBALS['core.store']->save($this->table,$this->data,$this->key_info);
			if(PEAR::isError($res))
				return $res;
			$this->key_info['key_value'] = $GLOBALS['core.store']->last_id();
		}
		return true;
		*/
		return parent::save();
	}

	function delete()
	{
		/*
		if(!isset($this->key_info['key_value']) || empty($this->key_info['key_value']))
			return false;
			
		$parent_id = $this->get_data($this->parent_field);	
		if ($parent_id != 0)
		{
			$data = $this->get_submenus($this->key_info['key_value']);
			if (isset($data[$this->key_info['key_value']]['sub_ids']))
				foreach ($data[$this->key_info['key_value']]['sub_ids'] as $id)
					$GLOBALS['core.store']->delete($this->table,array('key_name' => $this->key_info['key_name'],'key_value' => $id));
			$GLOBALS['core.store']->delete($this->table, $this->key_info);
			return 1;
		}
		return 0;
		*/
		return parent::delete();
	}

	function get_all($filters = array())
	{
		/*
		$all_data = $GLOBALS['core.tree']->get_tree(0,array($this->key_info['key_name'],$this->parent_field,$this->order_field,'title'),$this->table,$this->key_info['key_name'],$this->parent_field,$this->order_field,$filters);
		return $all_data;
		*/
		return parent::get_all($filters);
	}
	
	function get_submenus($parent_id,$filters = array())
	{
		/*
		$all_data = $GLOBALS['core.tree']->get_tree($parent_id,array($this->key_info['key_name'],$this->parent_field,$this->order_field,'title'),$this->table,$this->key_info['key_name'],$this->parent_field,$this->order_field,$filters);
		return $all_data;
		*/
		return parent::get_submenus($parent_id,$filters);
	}
        function get_all_pages()
	{
		return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#menu",array(),'id');
        }
}
?>