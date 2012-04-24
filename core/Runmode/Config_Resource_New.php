<?php
/**
 *description will appear later
 *@author Alexandr Yusupov
 *@version 1.0
 *@copyright <a href="http://evaxsoft.com/">EvaxSoft</a>
 */
include_once "Resource.php";
require_once('Runmode/Runmode.php');
//include_once "Config.php";
define ("E_AUTHENTICATION_FAILED","auth_error");

class Config_Resource_New extends Resource
{
	var $config_filename = 'runmodes';
	var $class_name = '';
	var $method_name = '';
	var $access_groups = array();
	var $runmode_name = '';
	var $runmode_path = '';
	var $rm_parameter = 'rm';
	var $rm_default = '';
	var $rm_auth = '';
	var $rm_not_found = '';
	function Config_Resource_New($conf)
	{

		$this->rm_parameter = $conf['rm_parameter'];
		$this->rm_default = $conf['default'];
		$this->rm_auth = $conf['auth'];
		$this->rm_not_found = $conf['not_found'];
	}

	 function redirect($runmode_name = '')
    {
        $t_conf = $GLOBALS['core.config']->get_config('templates');
        if(empty($runmode_name))
        {
            header('Location:' . $t_conf['common']['script_url']);
        }
        else
        {
            header('Location:' . $t_conf['common']['script_url'] . $runmode_name . '.html');
        }
    }
	
	function get_runmode_name()
	{
		return $this->runmode_name;
	}
	function init($runmode = '')
	{

		$config_obj = &$GLOBALS['core.config'];
	    $config_content = $config_obj->get_config($this->config_filename);
	    if(isset($_REQUEST[$this->rm_parameter]) && !empty($_REQUEST[$this->rm_parameter]))
	    	$this->runmode_name = $_REQUEST[$this->rm_parameter];
	    else
	    	$this->runmode_name = $this->rm_default;
            
	    if(!empty($runmode))
	    	$this->runmode_name = $runmode;
            //pp($this->rm_not_found);
	    if(!isset($config_content[$this->runmode_name]))
	    {
	    	//return PEAR::raiseError('invalid runmode name ' . $this->runmode_name,'invalid runmode name');
	    	$this->runmode_name = $this->rm_not_found;
	    }
	    $config_content = $config_content[$this->runmode_name];

	    $this->class_name = $config_content['class'];
	    $this->method_name = $config_content['method'];
	    if(!empty($config_content['path']))
			$this->runmode_path = preg_replace("/\/$/",'',$config_content['path']);
		else
			$this->runmode_path = '';
            if($this->runmode_name == $this->rm_not_found)
            {
                $seo = !empty($_REQUEST[$this->rm_parameter])?$_REQUEST[$this->rm_parameter]:'index';
                $groups = $GLOBALS['core.sql']->getOne('SELECT access FROM #p#menu WHERE seo_url=?',array($seo));
                if(!empty($groups))
                    $this->access_groups = explode(",",$groups);
                else
                    $this->access_groups[] = 'anonymous';
            }
            else
                $this->access_groups = explode(",",$config_content['access']);

            //pp($this->access_groups);
	    if(isset($config_content['pre_load']))
	    {
	    	$pre_load = $config_content['pre_load'];
	    	$pre_load = explode(',', $pre_load);
	    	foreach ($pre_load as $value)
	    		$GLOBALS['core.application']->init_module($value, true);

	    }

	}

	function run()
	{
		$GLOBALS['core.runmode.auth_failed'] = false;
		$res = $this->execute($GLOBALS['core.auth.user']);
		if(PEAR::isError($res))
			return $res;
		if($res == E_AUTHENTICATION_FAILED)
		{
			if(!isset($_SESSION['core.runmode.requested']))
			{
				$_SESSION['core.runmode.requested'] = $this->runmode_name;//$_SERVER['REQUEST_URI'];
			}
			$GLOBALS['core.runmode.auth_failed'] = true;
			$this->init($this->rm_auth);
			
			$res = $this->execute($GLOBALS['core.auth.user']);
			if(PEAR::isError($res))
				return $res;
		}
		print $res;

		return true;
	}

	function execute(&$user_obj)
	{

	    if (!isset($user_obj)) return new PEAR_Error();
	    $config_obj = &$GLOBALS['core.config'];

	    $class = $this->class_name;
	    if(!empty($this->runmode_path))
			$class = $this->runmode_path . '/' . $this->class_name;

	    if(empty($class))
			return PEAR::raiseError('empty runmode','empty runmode');

	    require_once "$class.php";
	    if (!class_exists($this->class_name)) return PEAR::raiseError('no such runmode','no such runmode');
	    if ($this->runmode_name != $this->rm_auth && !$this->authenticate($user_obj))
			return E_AUTHENTICATION_FAILED;
	    $method = $this->method_name;
	    //$str = "return " . $this->class_name . "::$method();";
	    $str = "\$runmode_class = new " . $this->class_name . "();return \$runmode_class->" . $method . "();";
	    
	    $GLOBALS['core.log']->do_log('Runmode: run ' . $this->runmode_name,'core');
	    //print $str;
	    $res = eval($str);

	    return $res;
	}

	function authenticate(&$user_obj)
	{
            
	    $authenticated = 0;
	    foreach($this->access_groups as $group)
	    if ($user_obj->is_member_of($group))
	    {
	        $authenticated = 1;
	        break;
	    }
            return $authenticated;
	}
}
?>