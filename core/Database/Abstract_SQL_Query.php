<?php
class Abstract_SQL_Query extends Module
{
    var $query_object;
    var $config;
	var $names = '';
    
    function Abstract_SQL_Query($cfg)
    {
    	$this->config = $cfg;
    	if(isset($cfg['path']) && !empty($cfg['path']))
    	{
    		require_once($cfg['path'] . '/DB_Factory.php');
    	}
    	else
    	{
    		require_once('DB_Factory.php');
    	}
    	if(isset($cfg['names']))
    		$this->names = $cfg['names'];
    }

    function init()
    {
    	$this->query_object = DB_Factory::create($this->config);
    	
    }

    function run()
    {
    	if(!empty($this->names))
    	{
    		$res = $this->query('SET NAMES ?',array($this->names));
    		if(PEAR::isError($res))
    			return $res;
    	}
    	return true;
    }

    function getAll($sql_string,$modificators = array(),$id = null,$replacement = '?')
    {
		$true_sql_string = $this->prepare_string($sql_string,$modificators,$replacement);
		if(PEAR::isError($true_sql_string))
		    return $true_sql_string;
		if(isset($id) && !empty($id))
		{
			$records = $this->query_object->query($true_sql_string);
			$new_records = array();
			foreach ($records as $key => $value)
			{
				$new_records[$value[$id]] = $value;
			}
			unset($records);
			return $new_records;
		}
		return $this->query_object->query($true_sql_string);
    }

    function getRow($sql_string,$modificators = array(),$replacement = '?')
    {
		$true_sql_string = $this->prepare_string($sql_string,$modificators,$replacement);
		if(PEAR::isError($true_sql_string))
		    return $true_sql_string;
		$result = $this->query_object->query($true_sql_string);
		if(PEAR::isError($result))
		    return $result;
		return count($result) ? $result[0] : array();
    }

    function getOne($sql_string,$modificators = array(),$replacement = '?')
    {
		$true_sql_string = $this->prepare_string($sql_string,$modificators,$replacement);
		if(PEAR::isError($true_sql_string))
		    return $true_sql_string;
		return $this->query_object->query_one($true_sql_string);
    }

    function query($sql_string,$modificators = array(),$replacement = '?')
    {
		$true_sql_string = $this->prepare_string($sql_string,$modificators,$replacement);
		if(PEAR::isError($true_sql_string))
		    return $true_sql_string;
		return $this->query_object->query_update($true_sql_string);
    }

    function last_id()
    {
		return $this->query_object->last_autoincrement_id();
    }

    function prepare_string($sql_string,$modificators,$replacement = '?', $quot = "'")
    {
    	if(isset($GLOBALS['core.store']))
    		$sql_string = str_replace('#p#', $GLOBALS['core.store']->prefix, $sql_string);
    	
		if(!is_string($sql_string))
		{
		    //raise error
		    return PEAR::raiseError('not a sting in prepare sting','not a string');
		}
		if(!is_array($modificators))
		{

			$modificators = array($modificators);
		    //return PEAR::raiseError('not a array in prepare string','not a array');
		}
		$prepared_string = '';
		for($i = 0;$i < strlen($sql_string);$i++)
		{
		    if($sql_string[$i] == $replacement)
		    {
				if(isset($sql_string[$i + 1]) && ($sql_string[$i + 1] == $replacement))
				{
				    $prepared_string .= $replacement;
				    $i++;
				}
				else
				{
				    if(!count($modificators))
				    {
						//raise error
						print 'no more modificators';
				    }
				    $current_modificator = array_shift($modificators);
				    if(is_null($current_modificator))
				    {
				    	$prepared_string .= $this->query_object->quote($current_modificator);
				    }
				    else 
				    {
				    	$prepared_string .= $quot . $this->query_object->quote($current_modificator) . $quot;
				    }
				}

		    }
		    else
		    {
				$prepared_string .= $sql_string[$i];
		    }
		}
		if(count($modificators))
		{
		    //raise error
		    //print 'modificators count error';
		    return PEAR::raiseError('incorrent number of modificators', 'modifacators incorrect');
		}
		//print $prepared_string;
		return $prepared_string;
    }
}
?>
