<?php
class Data_Holder extends Data_Holder_Simple
{
	function Data_Holder()
	{

	}

	function init($table,$key_info)
	{
		parent::init($table,$key_info);
	}
	
	function load($id)
	{
		$this->init($this->table, array('key_name' => $this->key_info['key_name'], 'key_value' => $id));
	}

	function save()
	{
		parent::save();
	}

	function get_data($field_name = '')
	{
		return parent::get_data($field_name);
	}

	function set_data($data)
	{
		parent::set_data($data);
	}

	function delete()
	{
		parent::delete();
	}
}

class Data_Holder_Simple
{
	var $table;
	var $key_info;
	var $data;
	function init($table, $key_info)
	{
		if(!is_string($table))
			return PEAR::raiseError('table_name not a string','table_name not a string');
		if(!is_array($key_info))
			return PEAR::raiseError('key_info not array','key_info not array');
		if(!isset($key_info['key_name']) || empty($key_info['key_name']))
			return PEAR::raiseError('table key name not specified','table key name not specified');
		$this->table = $table;
		$this->key_info = $key_info;
		#var_dump($this);

		if(isset($key_info['key_value']) && !empty($key_info['key_value']))
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
		return $GLOBALS['core.store']->delete($this->table, $this->key_info);
	}
	
	function get_key_value()
	{
		if(isset($this->key_info['key_value']))
		{
			return $this->key_info['key_value'];
		}
		else 
		{
			return null;
		}	  
	}
	
	function load($id)
	{
		$this->init($this->table, array('key_name' => $this->key_info['key_name'], 'key_value' => $id));
	}
}
?>