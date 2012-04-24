<?php
//require_once 'Abstract_SQL_Query.php';
//require_once 'DB_Store.php';
//require_once 'DB_MySQL_Query.php';

class DB_Factory extends Factory 
{
    function &create($cfg)
    {	
    	
    	$cfg_object =& $GLOBALS['core.config'];
		
		$db_config = $cfg_object->get_config('db_config');
		
		$class_name = $db_config['factory']['class_name'];
    	if(isset($cfg['path']) && !empty($cfg['path']))
    	{
    		//require_once($cfg['path'] . '/DB_MySQL_Query.php');
    		require_once($cfg['path'] . '/'.$class_name.'.php');
    	}
    	else
    	{
    		require_once($class_name . '.php');
    	}
    		
		
		$query_object = new $class_name;
		
		return $query_object;
    }
}
?>
