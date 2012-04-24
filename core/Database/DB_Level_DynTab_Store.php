<?php

class DB_Level_DynTab_Store extends DB_DynTab_Store
{
	function DB_Level_DynTab_Store($cfg)
	{
		
	}
	
	function init()
	{
		DB_DynTab_Store::init();
	}
	
	function run()
	{
		return true;
	}
	
	function get_level_field_list($table_name, $level = '', $add_system = 0, $key_name = '')
	{
		$full_field_list = DB_DynTab_Store::get_field_list($table_name);
		if (PEAR::isError($full_field_list))	return $full_field_list;
		
		$level_field_list = array();
		if ($level != '')
		{
			$level_bit = 1 << ($level - 1);
			foreach ($full_field_list as $field)
			{
				if (($field['levels'] & $level_bit) || ($add_system && !$field['levels']))
					$level_field_list[] = $field;
			}
		}
		else
			$level_field_list = $full_field_list;
			
		$list = array();
		if (!empty($key_name))
			foreach ($level_field_list as $index => $row)	$list[$index] = $row[$key_name];
		else
			$list = $level_field_list;
		
		return $list;
	}
	
	function get_other_levels_field_list($table_name, $level)
	{
		$full_field_list = DB_DynTab_Store::get_field_list($table_name);
		if (PEAR::isError($full_field_list))	return $full_field_list;
		
		$level_field_list = array();
		$level_bit = 1 << ($level - 1);
		foreach ($full_field_list as $field)
		{
			if ($field['levels'] && !($field['levels'] & $level_bit))
			{
				$level_field_list[] = $field;
			}
		}
		
		return $level_field_list;
	}
	
	function create_field($table_name, $field_name, $field_type, $field_flags, $field_alias, $field_levels = 0)
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
		if (!is_string($field_type))
			return PEAR::raiseError('no field type specifed', 'no field type specifed');
		if (!is_string($field_alias))
			return PEAR::raiseError('no field alias specifed', 'no field alias specifed');
			
		$data_descr = $this->query_object->getAll('describe ' . $this->prefix . $table_name . $this->data_tab_postfix);
		if (PEAR::isError($data_descr))	return $data_descr;

		$ex_data_field_list = array();
		foreach ($data_descr as $row)
			$ex_data_field_list[] = $row['Field'];
		
		if ($field_name == '')
		{
			$max_id = count($data_descr);
			$field_name = $table_name . ($max_id);
			while (in_array($field_name, $ex_data_field_list))
			{
				$max_id++;
				$field_name = $table_name . ($max_id);
			}
		}
		
		$exi_field_list = $this->get_field_list($table_name, 'alias');
		if (PEAR::isError($exi_field_list))	return $exi_field_list;
		
		if (in_array($field_name, $exi_field_list))
			return PEAR::raiseError('field exists', 'field exists');

		$data = array
			(
				'name'		=>	$field_name,
				'alias'		=>	$field_alias,
				'flags'		=>	$field_flags,
				'type'		=>	$field_type
			);

		if ($field_levels != 0)
			$data['levels'] = $field_levels;
			
		if (count($data_descr) > count($exi_field_list) && in_array($field_name, $ex_data_field_list))
		{
			$res = $this->store_object->save_insert($table_name . $this->fields_tab_postfix, $data, 
				array('key_name' => 'name', 'key_value' => $field_name));
			if (PEAR::isError($res))	return $res;
			
			$res = $this->query_object->query('alter table ' . $this->prefix . $table_name . $this->data_tab_postfix . 
				' modify ' . $field_name . ' ' . $field_type . ' not null');
			if (PEAR::isError($res))	return $res;
		}
		else
		{
			$res = $this->store_object->insert($table_name . $this->fields_tab_postfix, $data);
			if (PEAR::isError($res))	return $res;
			$res = $this->query_object->query('alter table ' . $this->prefix . $table_name . $this->data_tab_postfix .
				' add ' . $field_name . ' ' . $field_type . ' not null');
			if (PEAR::isError($res))	return $res;
		}
		
		if (!isset($this->field_list_cash) || count($this->field_list_cash) == 0)
			$this->field_list_cash = array();
		$this->field_list_cash[$table_name] = array();
		$this->last_added_field_name = $field_name;
	
		return true;
	}
	
	function set_field_level($table_name, $field_name, $level, $value)
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
		if (!is_string($field_name))
			return PEAR::raiseError('no field name specifed', 'no field name specifed');
		if (!is_numeric($level))
			return PEAR::raiseError('no level specifed', 'no level specifed');
		if (!is_numeric($value))
			return PEAR::raiseError('no level value specifed', 'no level value specifed');
			
		$level_bit = 1 << ($level - 1);
			
		$bit_string = '';
		if ($value)		$bit_string = 'levels=levels|' . $level_bit;
		else			$bit_string = 'levels=levels& ~' . $level_bit;
		
		if (!isset($this->field_list_cash) || count($this->field_list_cash) == 0)
			$this->field_list_cash = array();
		$this->field_list_cash[$table_name] = array();
		
		return $this->query_object->query('update ' . $this->prefix . $table_name . $this->fields_tab_postfix . 
			' set ' . $bit_string . ' where name=\'' . $field_name . '\'');
	}
	
	function set_full_level_up($table_name, $field_array, $level)
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
		if (!is_array($field_array))
			return PEAR::raiseError('no field list specifed', 'no field name specifed');
			
		$level_bit = 1 << ($level - 1);
		$mod_string = implode(',', array_fill(0, count($field_array), '?'));
		
		$res = $this->query_object->query('update ' . $this->prefix . $table_name . $this->fields_tab_postfix . 
			' set levels=levels& ~' . $level_bit);
		if (PEAR::isError($res))	return $res;

		$res = $this->query_object->query('update ' . $this->prefix . $table_name . $this->fields_tab_postfix . 
			' set levels=levels|' . $level_bit . ' where name in (' . $mod_string . ')', $field_array);
		if (PEAR::isError($res))	return $res;
		
		if (!isset($this->field_list_cash) || count($this->field_list_cash) == 0)
			$this->field_list_cash = array();
		$this->field_list_cash[$table_name] = array();
		
		return true;
	}
}

?>