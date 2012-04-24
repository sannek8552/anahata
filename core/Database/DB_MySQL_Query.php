<?php
require_once 'DB_Query.php';
require_once 'Config.php';
class DB_MySQL_Query extends DB_Query
{
    var $db_object;
    var $db_user;
    var $db_password;
    var $db_host;
    var $database;
    var $persistent;
    var $real_escape = false;
    
    function DB_MySQL_Query()
    {
    	$GLOBALS['core.sql.count'] = 0;
    	$GLOBALS['core.sql.time'] = 0;
		$cfg_object =& $GLOBALS['core.config'];
		$sql_config = $cfg_object->get_config('db_config');
		if(!$sql_config)
		{
		    //rasise error
		    return PEAR::raiseError('can not connect to config','can not connect to config');
		}
		$this->persistent = $sql_config['MySQL']['use_persistent'];
		$this->db_user = $sql_config['MySQL']['db_user'];
		$this->db_password = $sql_config['MySQL']['db_password'];
		$this->db_host = $sql_config['MySQL']['db_host'];
		$this->database = $sql_config['common']['database'];
		if(empty($this->db_user) || empty($this->db_password) || empty($this->db_host) || empty($this->database))
		{
		    
		    return PEAR::raiseError('invalid config values','invalid config values');
		}
		if($this->persistent == 'y')
		{
		    $this->db_object = mysql_pconnect($this->db_host,$this->db_user,$this->db_password);
		}
		elseif($this->persistent == 'n')
		{
		    $this->db_object = mysql_connect($this->db_host,$this->db_user,$this->db_password);
		}
		else
		{
		    
		    return PEAR::raiseError('wrong config values','wrong config values');
		}
		if(!$this->db_object)
		{
		    
		    return PEAR::raiseError('object not defined','object not defined');
		}
		if(!mysql_select_db($this->database))
		{
		    return PEAR::raiseError('can not select db','can not select db');
		}
		$this->last_id = '';
		
		if(function_exists('mysql_real_escape_string'))
			$this->real_escape = true;
		
    }
    
    function query($sql_string)
    {
		if(!is_string($sql_string))
		{
		    
		    return PEAR::raiseError('not a string','not a string');
		    
		}
		$query_result = $this->m_query($sql_string);//mysql_query($sql_string,$this->db_object);
		if(!$query_result)
		{
		    
		    return PEAR::raiseError(mysql_error(),$sql_string);
		}
		$return_result = array();
		while($row = mysql_fetch_assoc($query_result))
		    $return_result[] = $row;
		    
		$GLOBALS['core.log']->do_log('MySQL_Query: query '.$sql_string ,'core');
		return $return_result;
    }
    
    function m_query($sql_string)
    {
    	
    	$GLOBALS['core.sql.count']++;
    	$t_start = microtime(true);
    	$res  = mysql_query($sql_string, $this->db_object);
    	$t_end = microtime(true);
    	$GLOBALS['core.sql.time'] += $t_end - $t_start;
    	return $res;
    }
    
    function query_one($sql_string)
    {
		if(!is_string($sql_string))
		{
		    
		    return PEAR::raiseError('not a string','not a string');
		    
		}
		$query_result = $this->m_query($sql_string);//mysql_query($sql_string,$this->db_object);
		if(!$query_result)
		{
		    
		    return PEAR::raiseError(mysql_error(),$sql_string);
		}
		$return_result = mysql_fetch_array($query_result);
		
		return $return_result[0];
    }
    
    function query_update($sql_string)
    {
		if(!is_string($sql_string))
		{
		    return PEAR::raiseError('not a string','not a string');
		}
		$query_result = $this->m_query($sql_string);//mysql_query($sql_string,$this->db_object);
		if(!$query_result)
		{
		    return PEAR::raiseError(mysql_error(),$sql_string);
		}
		$return_result = true;
		
		return $return_result;
    }
    
    function quote($string)
    {
    	if(is_null($string))
    		return 'NULL';
		if(!is_string($string) && !is_numeric($string))
		{
			
		    return PEAR::raiseError('invalid argument in quote','invalid argument in quote');
		}
		if($this->real_escape)
			return mysql_real_escape_string($string,$this->db_object);
			
		return mysql_escape_string($string);
    }
    
    function last_autoincrement_id()
    {
		return mysql_insert_id($this->db_object);
    }
}

?>