<?php

define('va_email','[^@]+@[^@]+\.[^.|@]+\S',true);
define('va_string','^\w+\S',true);

define('va_login','/^[\w|_|\d]{4,20}$/',true);
define('va_car_name_regexp', '/^[\w|_| |-|\d]{1,32}$/');
define('va_password','/^.{6,25}$/',true);
define('va_date','/^\d\d\/\d\d\/\d\d\d\d$/',true);

define('va_integer','^\d+\S',true);
define('va_number','^[0-9]+\.[0-9]+\S$',true);
define('va_empty','^\S$',true);

class Validator extends Module
{
	var $elements = array();

	function Validator($conf)
	{
		return 1;
	}

	function add($name, $value, $type, $handler = '')
	{
		if (empty($name))	return PEAR::raiseError("Name is undefined.");
//		if (empty($value))	return PEAR::raiseError("Value is undefined.");
		//if (empty($type))	return PEAR::raiseError("Type is undefined.");
		array_push($this->elements, array('name' => $name, 'value' => $value, 'type' => $type, 'handler' => $handler));
                //pp($this->elements);
	}

	function add_for_dyntab($table, $from_array, $prefix = '')
	{
		$dyntab =& $GLOBALS['core.dyntab_store'];

		$field_list = $dyntab->get_field_list($table);
		foreach ($field_list as $field)
		{
			if (!($field['flags'] & 1))
			{
				$data = $from_array[$prefix . $field['name']];

				$type = '';
				if (substr($field['type'], 0, 3) == 'int')
					$type = 'va_integer';
				elseif (substr($field['type'], 0, 7) == 'varchar')
					$type = 'va_string';
				elseif ($field['type'] = 'text')
					$type = 'va_string';
				elseif ($field['type'] = 'double')
					$type = 'va_number';

				if (!($field['flags'] & 4))
					$type .= '_empty';

				array_push($this->elements, array('name' => $field['name'], 'value' => $data, 'type' => '', 'handler' => $type));
			}
		}
	}

	function check()
	{
		$errors = array();
		//return $errors;
		foreach($this->elements as $element)
		{
			if (is_array($element['handler']))
			{
				$class = $element['handler'][0];
				$method = $element['handler'][1];
				eval("require_once \"{$class}.php\";");
				$new_errors = eval("return $class::$method(\$element);");
				if (PEAR::isError($new_errors))
				{
					return $new_errors;
				}
				if ((!is_array($new_errors)) || (count($new_errors) > 1) || ( (count($new_errors) == 1) and
					(!isset($new_errors[$element['name']])) ))
				{
					return PEAR::raiseError("Check function returned illegal value.");
				}
				$errors = array_merge($errors,$new_errors);
			}
			elseif (!empty($element['handler']))
			{
				$function = $element['handler'];
				$new_errors = $this->$function($element);
				if (PEAR::isError($new_errors))
				{
					return $new_errors;
				}
				if ((!is_array($new_errors)) || (count($new_errors) > 1) || ( (count($new_errors) == 1) and
					(!isset($new_errors[$element['name']])) ))
				{
					return PEAR::raiseError("Check function returned illegal value.");
				}

				if ($new_errors[$element['name']])
					$errors = array_merge($errors,$new_errors);
			}
			else
			{
				$errors = array_merge($errors,$this->__check($element));
			}
		}

		$this->elements = array();
		return $errors;
	}

	function __check($element)
	{
		$restrictions = explode("|",$element['type']);
		$checked = false;
		foreach($restrictions as $restriction)
		{
			$negative = false;
			$restriction = trim($restriction);
			$true_restriction = mb_ereg_replace('^\!','',$restriction);
			if ($true_restriction != $restriction)
			{
				$negative = true;
			}

			if ((!$negative and mb_ereg_match(constant($true_restriction),trim($element['value']) . ' ')) or
				($negative and !mb_ereg_match(constant($true_restriction),trim($element['value']).' ')))
			{
				$checked = true;
				break;
			}
		}
		if (!$checked)
		{
			return array($element['name'] => '1');
		}
		return array();
	}

	/*function megacheck($element)
	{
		$restrictions = explode("|",$element['type']);
		$checked = false;
		foreach($restrictions as $restriction)
		{
			$negative = false;
			$restriction = trim($restriction);
			$true_restriction = mb_ereg_replace('^\!','',$restriction);
			if ($true_restriction != $restriction)
			{
				$negative = true;
			}
			if ((!$negative and mb_ereg_match(constant($true_restriction),trim($element['value']) . ' ')) or
				($negative and !mb_ereg_match(constant($true_restriction),trim($element['value']) . ' ')))
			{
				$checked = true;
				break;
			}
		}
		if (!$checked)
		{
			return array($element['name'] => '1');
		}
		return array();
	}*/

	function va_number($val)
	{
	  return array($val['name'] => intval(!is_numeric($val['value'])));
	}

	function va_integer($val)
	{
	  return array($val['name'] => intval(!(is_numeric($val['value']) && is_int((int)$val['value']) && (int)$val['value'] == (float)$val['value'])));
	}

	function va_string($val)
	{
		return array($val['name'] => intval(!(is_scalar($val['value']) && strlen(trim($val['value'])) > 0 )));
	}	

	function va_text($val)
	{
		return array($val['name'] => intval(!(is_scalar($val['value']) && strlen(trim($val['value'])) > 0)));
	}
	
	function va_text_empty($val)
	{
		return array($val['name'] => intval(!is_scalar($val['value'])));
	}

	function va_number_empty($val)
	{
		#print $val['name']." ".$val['value']."<br>";
		return array($val['name'] => intval(!(is_numeric($val['value']) || empty($val['value']))));
	}

	function va_integer_empty($val)
	{
		return array($val['name'] => intval(
	!((is_numeric($val['value']) && is_int((int)$val['value']) && ((int)$val['value'] == (float)$val['value'])) || empty($val['value']))
	                                           ));
	}

	function va_string_empty($val)
	{		
		return array($val['name'] => intval(!(is_scalar($val['value']) || empty($val['value']))));
	}
        function va_empty($val)
	{
		return array($val['name'] => empty($val['value']));
	}
	function va_date($val)
	{
		$res = preg_match(va_date,$val['value']);
		return array($val['name'] => intval(!$res));
	}

	function va_date_empty($val)
	{
		return array($val['name'] => intval(
	!(is_numeric(substr($val['value'], 0, 4))
	|| is_numeric(substr($val['value'], 5, 2))
	|| is_numeric(substr($val['value'], 8, 2))
	|| empty($val['value']))));
	}
	
	function va_email($val)
	{
            if(!empty($val['value']))
            {
		$res = preg_match("/^[^@]+@[^@]+\.[^.|@]+$/",$val['value']);
                return array($val['name'] => intval(!$res));
            }
            else
                return array($val['name'] => 0);
		//if($res)
			
		
	}
	
	function va_email_empty($val)
	{
	  $res = preg_match("/^[^@]+@[^@]+\.[^.|@]+$/",$val['value']);
	  return array($val['name'] => intval(!($res || $val['value'] == '')));
	}
	
	function va_login($val)
	{
		if(empty($val['value']))
			return array($val['name'] => 1);
		$res = $GLOBALS['core.store']->load('user', array('key_name' => 'login', 'key_value' => $val['value']));
		if(empty($res))
			return array($val['name'] => 0);
		else 
		{
                   
			if(isset($GLOBALS['core.validator.user_id']) && $GLOBALS['core.validator.user_id'] == $res['user_id'])
			{
				return array($val['name'] => 0);
			}
			return array($val['name'] => 1);
		}
	}
	
	function va_password($val)
	{
		return $this->va_string($val);
	}
        
}
?>
