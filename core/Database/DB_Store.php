<?php
require_once('Database/Observer.php');
class DB_Store extends Module
{
    var $query_object;
    var $prefix;
    var $observers = array();
    function DB_Store($cfg)
    {

    }

    function init()
    {
    	if(!isset($GLOBALS['core.sql']))
    		return PEAR::raiseError('required object missed','required object missed');
		$cfg_object =& $GLOBALS['core.config'];
		$db_config = $cfg_object->get_config('db_config');
		$this->prefix = $db_config['common']['prefix'];
		$this->query_object =& $GLOBALS['core.sql'];
		$observer = $cfg_object->get_config('observer');
		foreach($observer as $key => $value)
		{
		    $this->observers[] = new Observer($key);
		}
    }

    function last_id()
    {
		return $this->query_object->last_id();
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
		
		$GLOBALS['core.log']->do_log('DB_Store: delete from ' . $table_name . ' key=' . $key_info['key_name'] . ' value='. $key_info['key_value'],'core');
		
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

    function insert($table_name, $data)
    {
    	if(!is_string($table_name))
		    return PEAR::raiseError('no table given','no table given');
		if(!is_array($data))
		    return PEAR::raiseError('no data given','no data given');
		$now = time();

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
	    return $insert_result;
    }
    
    function fast_insert($table_name,$info)
    {
    	if(!is_string($table_name))
		    return PEAR::raiseError('no table given','no table given');
		if(!is_array($info))
		    return PEAR::raiseError('no data given','no data given');
		$now = time();

	    $sql_string = "INSERT INTO " . $this->prefix . "$table_name (";
	    
	    if (isset($info[0]))
	    {
	    	$data = $info[0];
		    $fields = array();
		    $replacements = array();
		    if (!isset($data['created']))	$data['created'] = $now;
		    if (!isset($data['updated']))	$data['updated'] = $now;
		    foreach($data as $key => $value)
		    {
				$fields[] = $key;
				$modificators[] = $value;
				$replacements[] = '?';
		    }
		    $sql_string .= join(",",$fields) . ") VALUES (" . join(",",$replacements) . ")";
		    unset($info[0]);
		    
		    foreach ($info as $data)
		    {
		    	if (!isset($data['created']))	$data['created'] = $now;
		    	if (!isset($data['updated']))	$data['updated'] = $now;
		    	$replacements = array();
		    	foreach($data as $key => $value)
		    	{
					$modificators[] = $value;
					$replacements[] = '?';
		    	}
			    $sql_string .= " , (" . join(",",$replacements) . ")";
		    }
		    
		    $insert_result = $this->query_object->query($sql_string,$modificators);
		    
		    
		    if(PEAR::isError($insert_result))
				return $insert_result;

	    }
	    return $insert_result;
    }

    function load($table_name, $key_info)
    {
    	if(!is_string($table_name))
		    return PEAR::raiseError('no table given','no table given');
		if(strlen($key_info['key_name']) == 0 || strlen($key_info['key_value']) == 0)
		{
		    return PEAR::raiseError('keys is not specifed in load','key is not specifed in load');
		}
		$operator = empty($key_info['o']) ? '=' : $key_info['o'];
		$sql_string = "SELECT * FROM " . $this->prefix . "$table_name WHERE ${key_info['key_name']} " . $operator . " ?";

		return $this->query_object->getRow($sql_string,array($key_info['key_value']));
    }
}
?>