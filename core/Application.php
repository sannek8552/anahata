<?php
require_once('PEAR.php');
require_once('Config.php');

define('E_CREATE_ERROR','e_create_error');
class Application
{
    var $application_conf;
    var $global_prefix;
	function Application()
	{
		$this->global_prefix = 'core.';
		$GLOBALS[$this->global_prefix . 'application'] = &$this;
	}

	function run()
	{
		$config = new Config('conf');
		$GLOBALS['core.config'] = &$config;

		$application_conf = $config->get_config('application');

		if(PEAR::isError($application_conf))
			return $application_conf;
		$this->application_conf = $application_conf;

		foreach ($application_conf as $module => $module_config)
		{
			$result = $this->init_module($module);
			if(PEAR::isError($result))
			{
				return $result;
			}
			$GLOBALS['core.log']->do_log('memory after init module ' . $module . ' '.number_format(memory_get_usage(), 0, '.', ','),'application');
		}
	}

	function init_module($module, $auto_ignore = false)
	{
		
		
		$module_conf = $this->application_conf[$module];

		$global_name = isset($module_conf['global']) ? $module_conf['global'] : '';
		if(!$global_name)
		    return PEAR::raiseError('no global variable set', E_INVALID_PARAM);
		if($auto_ignore == false && isset($module_conf['auto']) && $module_conf['auto'] == 'n')
		{
		    //no need to create module
		    return true;
		}
		elseif(isset($GLOBALS[$this->global_prefix . $global_name]))
		{
		    return true;
		}
		else
		{
		    //here code to create module
		    if(!isset($module_conf['class']) || empty($module_conf['class']))
	    	{
	    		return PEAR::raiseError('missing class name in self create module',E_INVALID_PARAM);
    		}

    		$to_include = isset($module_conf['path']) ? $module_conf['path'] . '/' : '';
	    	$to_include .= $module_conf['class'] . '.php';

	    	$include_result = include_once($to_include);

	    	if($include_result == false)
	    		return PEAR::raiseError('invalid class or path name for inclusion',E_INVALID_PARAM);



	    	if(!class_exists($module_conf['class']))
	    		return PEAR::raiseError('required class ' . $module_conf['class']. ' not exists in module',E_INVALID_PARAM);

		    
	    	$GLOBALS[$this->global_prefix . $global_name] = Factory::create($module_conf);
	    	if(PEAR::isError($GLOBALS[$this->global_prefix . $global_name]))
	    		return $GLOBALS[$this->global_prefix . $global_name];
		    
		    if(!is_subclass_of($GLOBALS[$this->global_prefix . $global_name], 'Module'))
		    {
		    	return PEAR::raiseError('created module not subclass of module', E_CREATE_ERROR);
		    }

		    $init_result = $GLOBALS[$this->global_prefix . $global_name]->init();

		    if(PEAR::isError($init_result))
		    	return $init_result;

		    $run_result = $GLOBALS[$this->global_prefix . $global_name]->run();

		    if(PEAR::isError($run_result))
		    	return $run_result;
		    return true;
		}
	}
}

class Factory
{
	function &create($module_conf = '')
	{
		$to_create = "\$result = new ${module_conf['class']}(\$module_conf);";
		eval($to_create);
		if(is_object($result))
			return $result;
		else
			return PEAR::raiseError('error in module creating',E_CREATE_ERROR);
	}
}

class Module
{
	function Module($conf)
	{

	}

	function init()
	{

	}

	function run()
	{

	}
}

?>