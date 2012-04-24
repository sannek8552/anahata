<?php

class DB_DynTab_Store extends Module 
{
	var $store_object;
	var $query_object;
	
	var $prefix;
	var $data_tab_postfix;
	var $fields_tab_postfix;
	
	var $field_list_cash;
	var $last_added_field_name;
	
	function DB_DynTable_Store($cfg)
	{
		
	}
	
	function init()
	{
		if(!isset($GLOBALS['core.store']))
    		return PEAR::raiseError('required store object missed', 'required store object missed');
		if(!isset($GLOBALS['core.sql']))
    		return PEAR::raiseError('required query object missed', 'required query object missed');
		
		$cfg_object =& $GLOBALS['core.config'];
		$db_config = $cfg_object->get_config('db_config');
		$this->store_object =& $GLOBALS['core.store'];
		$this->query_object =& $GLOBALS['core.sql'];
		
		$this->prefix = $db_config['common']['prefix'];
		$this->data_tab_postfix = $db_config['dyntab_config']['data_tab_postfix'];
		$this->fields_tab_postfix = $db_config['dyntab_config']['fields_tab_postfix'];
		
		$this->field_list_cash = array();
		$this->last_added_field_name = '';

		return true;
	}
	
	function run()
	{
		return true;
	}
	
	function last_id()
	{
		return $this->store_object->last_id();
	}
	
	function last_added_field_name()
	{
		return $this->last_added_field_name;
	}
	
	function get_field_list($table_name, $key_name = '')
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
			
//		print '<pre>cash BEFORE (get_list):<br>';
//		print_r($this->field_list_cash);
			
		if (!isset($this->field_list_cash) || count($this->field_list_cash) == 0 || 
			!isset($this->field_list_cash[$table_name]) || count($this->field_list_cash[$table_name]) == 0)
		{
			$res = $this->query_object->getAll('select * from ' . $this->prefix . $table_name . 
				$this->fields_tab_postfix);
			if (PEAR::isError($res))	return $res;
			
			if (!isset($this->field_list_cash) || count($this->field_list_cash) == 0)
				$this->field_list_cash = array();
			$this->field_list_cash[$table_name] = $res;
		}
		
//		print '<pre>cash AFTER (get_list):<br>';
//		print_r($this->field_list_cash);
		
		$list = array();
		if (!empty($key_name))
			foreach ($this->field_list_cash[$table_name] as $index => $row)	$list[$index] = $row[$key_name];
		else
			$list = $this->field_list_cash[$table_name];
	
		return $list;
	}
	
	function get_field($table_name, $field_name)
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
			
		if (!is_string($field_name))
			return PEAR::raiseError('no field name specifed', 'no field name specifed');
			
		if (isset($this->field_list_cash) && isset($this->field_list_cash[$table_name]))
		{
			$result = '';
			foreach ($this->field_list_cash[$table_name] as $row)
				if ($row['name'] == $field_name)
				{
					$result = $row;
					break;
				}

			if ($result != '')
				return $result;
		}
		
		return $this->store_object->load($table_name . $this->fields_tab_postfix, 
			array('key_name' => 'name', 'key_value' => $field_name));
	}
	
	function table_exists($table_name)
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
			
		$find = false;
		$res = $this->query_object->getAll('show table status');
		foreach ($res as $row)
			if (($this->prefix . $table_name . $this->data_tab_postfix) == $row['Name'])
			{
				$find = true;
				break;
			}
		
//		print '<pre>';
//		print_r($res);
			
		return $find;
	}

	function fields_exist($table_name, $field_names, $and = true)
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
		    
		if (!is_array($field_names) && !is_string($field_names))
			return PEAR::raiseError('no field names specifed', 'no field names specifed');
			
		if (is_string($field_names))
			$field_names = array($field_names);
			
		$existed_list = $this->get_field_list($table_name, 'alias');
		$exist_and = true;
		$exist_or = false;
		foreach ($field_names as $field)
		{
			if (!in_array($field, $existed_list))
				$exist_and = false;
			if (in_array($field, $existed_list))
				$exist_or = true;
		}
		
		return ($and ? $exist_and : $exist_or);
	}
	
	function get_trash_field_list($table_name)
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
			
		$data_descr = $this->query_object->getAll('describe ' . $this->prefix . $table_name . $this->data_tab_postfix);
		if (PEAR::isError($data_descr))	return $data_descr;
		
		$field_list = $this->get_field_list($table_name, 'name');
		if (PEAR::isError($field_list))	return $field_list;
		
		foreach($data_descr as $index => $row)
			if (in_array($row['Field'], $field_list))
				unset($data_descr[$index]);
		
		return $data_descr;
	}
	
	function create_field($table_name, $field_name, $field_type, $field_flags, $field_alias)
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
			
//		if (!is_string($field_name))
//			return PEAR::raiseError('no field name specifed', 'no field name specifed');
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
				'name'	=>	$field_name,
				'alias'	=>	$field_alias,
				'flags'	=>	$field_flags,
				'type'	=>	$field_type
			);
			
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
	
	function delete_field($table_name, $field_info)
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
			
		if (!isset($field_info) || !isset($field_info['type']) || !isset($field_info['value']) || 
			!in_array($field_info['type'], array('alias', 'name')))
			return PEAR::raiseError('no field info specifed', 'no field info specifed');
			
		if (!isset($this->field_list_cash) || count($this->field_list_cash) == 0)
			$this->field_list_cash = array();
		$this->field_list_cash[$table_name] = array();
			
		return $this->store_object->delete($table_name . $this->fields_tab_postfix, 
			array('key_name' => $field_info['type'], 'key_value' => $field_info['value']));
	}
	
	function update_field($table_name, $field_info, $new_params)
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
			
		if (!isset($field_info) || !isset($field_info['type']) || !isset($field_info['value']) || 
			!in_array($field_info['type'], array('alias', 'name')))
			return PEAR::raiseError('no field info specifed', 'no field info specifed');
			
		if (!isset($new_params))
			return PEAR::raiseError('no field params specifed', 'no field params specifed');
			
		$field_name = '';
		$field_type = '';
		$not_exists = false;
		if (isset($new_params['name']) || isset($new_params['type']))
		{
			$ex_field_list = $this->get_field_list($table_name);
			if (PEAR::isError($ex_field_list))	return $ex_field_list;
			
//			print '<pre>field_list:<br>';
//			print_r($ex_field_list);
			
			$not_exists = true;
			foreach($ex_field_list as $ex_field)
			{
				if (($field_info['type'] == 'name' && $field_info['value'] == $ex_field['name']) ||
					($field_info['type'] == 'alias' && $field_info['value'] == $ex_field['alias']))
				{
					$field_name = $ex_field['name'];
					$field_type = $ex_field['type'];
					$not_exists = false;
					break;
				}
			}
		}
		
		if ($not_exists)
			return PEAR::raiseError('set field doesn\'t exist', 'set field doesn\'t exist');
			
		$data = array();
		$data_tab_change_name = false;
		$data_tab_change_type = false;
		$new_field_name = '';
		$new_field_type = '';
		$data_tab_change_string = '';
		foreach($new_params as $param_key => $param_val)
		{
			if ($param_key == 'name')
			{
				$data['name'] = $param_val;
				$data_tab_change_name = true;
				$new_field_name = $param_val;
			}
			if ($param_key == 'type')
			{
				$data['type'] = $param_val;
				$data_tab_change_type = true;
				$new_field_type = $param_val;
			}
			if ($param_key == 'flags')
				$data['flags'] = $param_val;
			if ($param_key == 'alias')
				$data['alias'] = $param_val;
			if ($param_key == 'levels')
				$data['levels'] = $param_val;
		}
		
		if ($data_tab_change_name || $data_tab_change_type)
		{
			$data_tab_change_string .= 'alter table ' . $this->prefix . $table_name . $this->data_tab_postfix .
				' change ' . $field_name . ' ' . ($data_tab_change_name ? $new_field_name : $field_name) . ' ' . 
				($data_tab_change_type ? $new_field_type : $field_type) . ' not null';
			$res = $this->query_object->query($data_tab_change_string);
			if (PEAR::isError($res))	return $res;
		}
		
		$res = $this->store_object->save($table_name . $this->fields_tab_postfix, $data, 
			array('key_name' => $field_info['type'], 'key_value' => $field_info['value']));
		if (PEAR::isError($res))	return $res;
		
		if (!isset($this->field_list_cash) || count($this->field_list_cash) == 0)
			$this->field_list_cash = array();
		$this->field_list_cash[$table_name] = array();
			
		return true;
	}
	
	function remove_trash($table_name)
	{
		if (!is_string($table_name))
			return PEAR::raiseError('no table specifed', 'no table specifed');
			
		$data_descr = $this->query_object->getAll('describe ' . $this->prefix . $table_name . $this->data_tab_postfix);
		if (PEAR::isError($data_descr))	return $data_descr;
		
		$exi_field_list = $this->get_field_list($table_name, 'name');
		if (PEAR::isError($exi_field_list))	return $exi_field_list;

		$query_string = '';
		foreach ($data_descr as $row)
			if (!in_array($row['Field'], $exi_field_list))
				$query_string .= (strlen($query_string) ? ',' : '') . ' drop ' . $row['Field'];
		
		return $this->query_object->query('alter table ' . $this->prefix . $table_name . $this->data_tab_postfix . 
			$query_string);
	}
	
}

?>