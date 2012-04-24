<?php

////////////////
//	����� ������� ������������ ��� �������� ��� ������
//
//
////////////////
require_once('PEAR.php');
define('E_INVALID_PARAM','e_invalid_param');
require_once('Lang.php');
class Config
{
	var $config_path;
	var $config_array; 

	function Config($new_path = '')
	{
		$this->config_path = $new_path;
		$this->config_array = array();
	}

	function get_config($config_name)
	{
		if (!isset($config_name) || !is_string($config_name))
			return PEAR::raiseError('empty config name', E_INVALID_PARAM);
		if (!isset($this->config_array[$config_name]))
		{
			$full_path = $this->config_path. "/" .$config_name . ".ini";
			$this->config_array[$config_name] = parse_ini_file($full_path,true);
			if(!$this->config_array[$config_name])
			    return PEAR::raiseError("config with name $config could not be parsed. Full name to config is $full_path", E_INVALID_PARAM);
		}
		return $this->config_array[$config_name];
	}
}
?>