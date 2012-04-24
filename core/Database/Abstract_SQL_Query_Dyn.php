<?php

class Abstract_SQL_Query_Dyn extends Module
{
	function Abstract_SQL_Query_Dyn($cfg)
	{

	}

	function init()
	{

	}

	function run()
	{

	}

	function prepare_fields($fields,$tables)
	{
		$list = array();
		$to_return = array();
		if(!empty($tables))
		{
			foreach($tables as $key => $value)
			{
				$f = $GLOBALS['core.dyntab_store']->get_field_list($value, '');
				//print_r($f);
				foreach($f as $f_key => $f_value)
				{
					if(in_array($f_value['alias'], $fields))
					{
						$list[$f_value['alias']] = $f_value['name'];
					}
				}
			}


			foreach($fields as $key => $value)
			{
				$to_return[] = $list[$value];
			}
		}
		return $to_return;
	}

	function getAll($sql_string, $modificators = array(), $fields = array(), $tables = array())
	{
		$fields = $this->prepare_fields($fields, $tables);

		$prepared_string = $GLOBALS['core.sql']->prepare_string($sql_string, $fields, '^','`');

		$res = $GLOBALS['core.sql']->getAll($prepared_string, $modificators);

		if(PEAR::isError($res))
			return $res;
		if(!empty($tables))
		{

			$list = array();
			foreach($tables as $key => $value)
			{
				$f = $GLOBALS['core.dyntab_store']->get_field_list($value, '');
				foreach($f as $f_key => $f_value)
				{
						$list[$f_value['name']] = $f_value['alias'];
				}
			}

			foreach($res as $key => $value)
			{
				foreach($list as $l_key => $l_value)
				{
					$res[$key][$l_value] = $res[$key][$l_key];
					if($l_value != $l_key)
						unset($res[$key][$l_key]);
				}
			}
		}

		return $res;
	}


	function getRow($sql_string, $modificators = array(), $fields = array(), $tables = array())
	{
		$fields = $this->prepare_fields($fields, $tables);

		$prepared_string = $GLOBALS['core.sql']->prepare_string($sql_string, $fields, '^','`');

		$res = $GLOBALS['core.sql']->getRow($prepared_string, $modificators);
//print_r($res);
		if(PEAR::isError($res))
			return $res;
		if(!empty($tables))
		{

			$list = array();
			foreach($tables as $key => $value)
			{
				$f = $GLOBALS['core.dyntab_store']->get_field_list($value, '');
				foreach($f as $f_key => $f_value)
				{
						$list[$f_value['name']] = $f_value['alias'];
				}
			}
//print_r($list);
			/*foreach($res as $key => $value)
			{*/
				foreach($list as $l_key => $l_value)
				{
					$res[$l_value] = $res[$l_key];
					if($l_value != $l_key)
						unset($res[$l_key]);
				}
			//}
		}

		return $res;
	}

	function getOne($sql_string, $modificators = array(), $fields = array(), $tables = array())
	{
		$fields = $this->prepare_fields($fields, $tables);

		$prepared_string = $GLOBALS['core.sql']->prepare_string($sql_string, $fields, '^','`');

		$res = $GLOBALS['core.sql']->getOne($prepared_string, $modificators);
/*print_r($res);
		if(PEAR::isError($res))
			return $res;
		if(!empty($tables))
		{

			$list = array();
			foreach($tables as $key => $value)
			{
				$f = $GLOBALS['core.dyntab_store']->get_field_list($value, '');
				foreach($f as $f_key => $f_value)
				{
						$list[$f_value['name']] = $f_value['alias'];
				}
			}
print_r($list);
			/*foreach($res as $key => $value)
			{*/
			/*	foreach($list as $l_key => $l_value)
				{
					$res[$l_value] = $res[$l_key];
					if($l_value != $l_key)
						unset($res[$l_key]);*/
		//		}
			//}
	//	}

		return $res;
	}
	/*function prepare_string($sql_string,$modificators,$replacement = '^')
	{
		if(!is_string($sql_string))
		{
		    //raise error
		    //print 'ne stroka';
		    return new PEAR_Error('not a sting in prepare sting','not a string');
		}
		if(!is_array($modificators))
		{
		    //raise error
		    //print 'ne massiv';
		    return new PEAR_Error('not a array in prepare string','not a array');
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
				    $prepared_string .= "'" . $this->query_object->quote($current_modificator) . "'";
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
		    return new PEAR_Error('incorrent number of modificators', 'modifacators incorrect');
		}
		return $prepared_string;
	}*/
}
?>