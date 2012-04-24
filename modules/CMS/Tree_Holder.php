<?php

require_once('Data_Holder.php');

class Tree_Holder extends Data_Holder 
{
	var $table;
	var $key_info = array('key_name' => 'id');
	var $parent_field;
	var $order_field;
	var $title_field;
	var $data;
	
	function Tree_Holder($id = "")
	{
		$this->init($id);
	}
	
	function init($id)
	{
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
	}

	function get_data($field_name = '')
	{
		if(empty($field_name))
			return $this->data;
		if(isset($this->data[$field_name]))
			return $this->data[$field_name];
		return null;
	}

	function set_data($data)
	{
		foreach($data as $key => $value)
		{
			$this->data[$key] = $value;
		}
	}

	function save()
	{
		if(isset($this->key_info['key_value']) && !empty($this->key_info['key_value']))
		{
			unset($this->data[$this->key_info['key_name']]);
			return $GLOBALS['core.store']->save($this->table,$this->data,$this->key_info);
		}
		else
		{
			if (isset($this->data[$this->parent_field]))
			{
				$max_order = $GLOBALS['core.sql']->getOne("select max(".$this->order_field.") from ".$GLOBALS['core.store']->prefix.$this->table." where ".$this->parent_field." = ?",array($this->data[$this->parent_field]));
				if (!empty($max_order))
					$this->data[$this->order_field] = $max_order + 1;
				else $this->data[$this->order_field] = 1;
			}
			
			$res = $GLOBALS['core.store']->save($this->table,$this->data,$this->key_info);
			if(PEAR::isError($res))
				return $res;
			$this->key_info['key_value'] = $GLOBALS['core.store']->last_id();
		}
		return true;
	}

	function delete()
	{
		if(!isset($this->key_info['key_value']) || empty($this->key_info['key_value']))
			return false;
			
		$parent_id = $this->get_data($this->parent_field);	
		if ($parent_id != 0)
		{
			$sql = "delete from ".$GLOBALS['core.store']->prefix.$this->table." where ".$this->key_info['key_name']." = ? ";
			$mods = array();
			$mods[] = $this->key_info['key_value'];
			$cond = "";
			
			$data = $this->get_submenus($this->key_info['key_value']);
			if (isset($data[$this->key_info['key_value']]['sub_ids']))
				foreach ($data[$this->key_info['key_value']]['sub_ids'] as $id)
				{
					$cond .= " OR ".$this->key_info['key_name']." = ? ";
					$mods[] = $id;
					//$GLOBALS['core.store']->delete($this->table,array('key_name' => $this->key_info['key_name'],'key_value' => $id));
				}
			$sql .= $cond;	
			//$GLOBALS['core.store']->delete($this->table, $this->key_info);
			$GLOBALS['core.sql']->query($sql,$mods);
			return 1;
		}
		return 0;
	}

	function get_all($filters = array())
	{
		$all_data = $GLOBALS['core.tree']->get_tree(0,array($this->key_info['key_name'],$this->parent_field,$this->order_field,$this->title_field),$this->table,$this->key_info['key_name'],$this->parent_field,$this->order_field,$filters);
		return $all_data;
	}
	
	function get_submenus($parent_id,$filters = array())
	{
		$all_data = $GLOBALS['core.tree']->get_tree($parent_id,array($this->key_info['key_name'],$this->parent_field,$this->order_field,$this->title_field),$this->table,$this->key_info['key_name'],$this->parent_field,$this->order_field,$filters);
		return $all_data;
	}
}
?>