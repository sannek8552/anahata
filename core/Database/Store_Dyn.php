<?php

class Store_Dyn extends Module
{
	var $query_object;
    var $prefix;
    var $observers = array();

	function Store_Dyn($cfg)
	{

	}

	function init()
	{

		if(!isset($GLOBALS['core.store']))
    		return PEAR::raiseError('required store object missed','required store object missed');
		if(!isset($GLOBALS['core.sql']))
    		return PEAR::raiseError('required query object missed','required query object missed');

		$cfg_object =& $GLOBALS['core.config'];
		$db_config = $cfg_object->get_config('db_config');
		$this->store_object =& $GLOBALS['core.store'];
		$this->query_object =& $GLOBALS['core.sql'];

		$this->prefix = $db_config['common']['prefix'];
		$this->data_tab_postfix = $db_config['dyntab_config']['data_tab_postfix'];
		$this->fields_tab_postfix = $db_config['dyntab_config']['fields_tab_postfix'];
	}

	function run()
	{

	}

	function last_id()
    {
		return $this->query_object->last_id();
    }


    function process_data($table,$data)
    {
		$list = array();
		$to_return = array();
		$f = $GLOBALS['core.dyntab_store']->get_field_list($table, '');

		foreach($f as $f_key => $f_value)
		{
			if(isset($data[$f_value['alias']]))
			{
				$temp = $data[$f_value['alias']];
				unset($data[$f_value['alias']]);
				$data[$f_value['name']] = $temp;
			}
		}

		return $data;
    }

    function save($table_name,$data,$key_info)
    {
		if(!is_string($table_name))
		{
		    //raise error
		    return PEAR::raiseError('no table given','no table given');
		}
		if(empty($key_info['key_name']))
		{
		    //raise error
		    return PEAR::raiseError('no key name','no key name');
		}
		if(!is_array($data))
		{
		    //raise error
		    return PEAR::raiseError('no data given','no data given');
		}
		$data = $this->process_data($table_name,$data);
		$now = time();
		if(empty($key_info['key_value']))
		{
		    $sql_string = "INSERT INTO " . $this->prefix . "$table_name (";
		    $modificators = array();
		    $fields = array();
		    $replacements = array();
		    $data['created'] = $now;
		    $data['updated'] = $now;
		    foreach($data as $key => $value)
		    {
			$fields[] = $key;
			$modificators[] = $value;
			$replacements[] = '?';
		    }
		    $sql_string .= join(",",$fields) . ") VALUES (" . join(",",$replacements) . ")";
		    foreach($this->observers as $key => $observer)
		    {
				$res = $observer->observe('insert','before',$table_name,$key_info,$data);
				if(PEAR::isError($res))
				    return $res;
		    }
		    $insert_result = $this->query_object->query($sql_string,$modificators);
		    if(PEAR::isError($insert_result))
			return $insert_result;
		    foreach($this->observers as $key => $observer)
		    {
				$res = $observer->observe('insert','after',$table_name,$key_info,$data);
				if(PEAR::isError($res))
				    return $res;
		    }
		    //print '<pre>';
		    //print_r($this->observers);
		    return $insert_result;
		}
		else
		{
		    $sql_string = "UPDATE " . $this->prefix . "$table_name SET ";
		    $modificators = array();
		    $fields_def = array();
		    $data['updated'] = $now;
		    foreach($data as $key => $value)
		    {
			$modificators[] = $value;
			$fields_def[] = $key . " = ?";
		    }
		    $operator = empty($key_info['o']) ? '=' : $key_info['o'];
		    $sql_string .= join(",",$fields_def) . " WHERE ${key_info['key_name']} " . $operator . " ?";
		    $modificators[] =  $key_info['key_value'];
		    foreach($this->observers as $key => $observer)
		    {
			$res = $observer->observe('update','before',$table_name,$key_info,$data);
			if(PEAR::isError($res))
			    return $res;
		    }
		    $update_result = $this->query_object->query($sql_string,$modificators);
		    if(PEAR::isError($update_result))
			return $update_result;
		    foreach($this->observers as $key => $observer)
		    {
			$res = $observer->observe('update','after',$table_name,$key_info,$data);
			if(PEAR::isError($res))
			    return $res;
		    }
		    return $update_result;
		}
    }

    function save_insert($table_name,$data,$key_info)
    {
		if(!is_string($table_name))
		{
		    //raise error
		    return PEAR::raiseError('no table specifed','no table specifed');
		}
		if(empty($key_info['key_name']))
		{
		    //raise error
		    return PEAR::raiseError('no key name given','no key name given');
		}
		if(!is_array($data))
		{
		    //raise error
		    return PEAR::raiseError('no data specifed','no data specifed');
		}
		$operator = empty($key_info['o']) ? '=' : $key_info['o'];
		$sql_string = "SELECT * FROM " . $this->prefix . $table_name . " WHERE ${key_info['key_name']} " . $operator . " ?";
		$result = $this->query_object->getRow($sql_string,array($key_info['key_value']));
		if(PEAR::isError($result))
		    return $result;
		if(!empty($result))
		{
		    return $this->save($table_name,$data,$key_info);
		}
		else
		{
		    $data[$key_info['key_name']] = $key_info['key_value'];
		    unset($key_info['key_value']);
		    return $this->save($table_name,$data,$key_info);
		}
    }


    function insert($table_name, $data)
    {
    	if(!is_string($table_name))
		    return PEAR::raiseError('no table given','no table given');
		if(!is_array($data))
		    return PEAR::raiseError('no data given','no data given');
		$now = time();

		$data = $this->process_data($table_name,$data);
	    $sql_string = "INSERT INTO " . $this->prefix . "$table_name (";
	    $modificators = array();
	    $fields = array();
	    $replacements = array();
	    $data['created'] = $now;
	    $data['updated'] = $now;
	    foreach($data as $key => $value)
	    {
			$fields[] = $key;
			$modificators[] = $value;
			$replacements[] = '?';
	    }
	    $sql_string .= join(",",$fields) . ") VALUES (" . join(",",$replacements) . ")";
	    foreach($this->observers as $key => $observer)
	    {
			$res = $observer->observe('insert','before',$table_name,$key_info,$data);
			if(PEAR::isError($res))
			    return $res;
	    }
	    $insert_result = $this->query_object->query($sql_string,$modificators);
	    if(PEAR::isError($insert_result))
			return $insert_result;
	    foreach($this->observers as $key => $observer)
	    {
			$res = $observer->observe('insert','after',$table_name,$key_info,$data);
			if(PEAR::isError($res))
			    return $res;
	    }
	    //print '<pre>';
	    //print_r($this->observers);
	    return $insert_result;
    }

    function delete($table_name,$key_info)
    {
		if(!is_string($table_name))
		{
		    return PEAR::raiseError('no table specifed','no table specifed');
		}
		if(empty($key_info['key_name']) || empty($key_info['key_value']))
		{

		    return PEAR::raiseError('keys is not specifed in delete','key is not specifed in delete');
		}
		$operator = empty($key_info['o']) ? '=' : $key_info['o'];
		$sql_string = "DELETE FROM " . $this->prefix . "$table_name WHERE ${key_info['key_name']} " . $operator . " ?";
		foreach($this->observers as $key => $observer)
		{
		    $empty = array();
		    $res = $observer->observe('delete','before',$table_name,$key_info,$empty);
		    if(PEAR::isError($res))
		        return $res;
		}
		$delete_result = $this->query_object->query($sql_string,array($key_info['key_value']));
		if(PEAR::isError($delete_result))
		    return $delete_result;
		foreach($this->observers as $key => $observer)
		{
		    $res = $observer->observe('delete','after',$table_name,$key_info,$empty);
		    if(PEAR::isError($res))
		        return $res;
		}
    }
}

?>