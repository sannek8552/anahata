<?php
    
    class Observer
    {
	//var $config_filename = 'runmodes';
	var $class_name = '';
	var $method_name = '';
	//var $access_groups = array();
	var $observer_name = '';
	var $observer_path = '';
	var $table = '';
	var $run = '';
	var $action = '';
	function Observer($observer_name)
	{
	    $config_obj = $GLOBALS['core.config'];
	    $config_content = $config_obj->get_config('observer');
	    $config_content = $config_content[$observer_name];
	    $this->observer_name = $observer_name;
	    $this->class_name = $config_content['class'];
	    $this->method_name = $config_content['method'];
	    $this->table = $config_content['table'];
	    $this->run = $config_content['run'];
	    $this->action = $config_content['action'];
	    if(!empty($config_content['path']))
		$this->observer_path = preg_replace("/\/$/",'',$config_content['path']);
	    //$this->access_groups = split(",",$config_content['access']);
	    //print $runmode_name;
	    //print '<pre>';
	    //print_r($this);
	}
	
	function observe($action,$run,&$table,&$key_info,&$data)
	{
	    //if (!isset($method)) return new PEAR_Error('method not defined');
	    //print $table;
	    //print $thod . '=' . $this->method_name . '<br>';
	//    print $run . '=' . $this->run . '<br>';
	//    print $table . '=' . $this->table . '<br>';
	    if($action != $this->action || $run != $this->run || $table != $this->table)
		return false;
	    //print 'here';
	    //$config_obj = $GLOBALS['core.config'];
	    //$config_content = $config_obj->get_config('application');
	    //$config_content = $config_content['common'];
	    //$error_runmode = $config_content['error_runmode'];
	    //$auth_runmode = $config_content['auth_runmode'];
	    //if (!($this->runmode_name == $error_runmode) and !($this->runmode_name == $auth_runmode) and !$this->authenticate($user_obj)) 
		//return E_AUTHENTICATION_FAILED;
	    $class = $this->class_name;
	    if(!empty($this->observer_path))
		$class = $this->observer_path . '/' . $this->class_name;
	    //print $class;
	    if(empty($class))
		return PEAR::raiseError('empty observer class','empty observer class');
	    //print $class;
	    include_once "$class.php";
	    if (!class_exists($this->class_name)) return new PEAR_Error();
	    
	    $method = $this->method_name;
	    $str = "return " . $this->class_name . "::$method(\$action,\$run,\$table,\$key_info,\$data);";
	    //print $str;
	    $res = eval($str);
	    //if (PEAR::isError($res)) return $res;
	    return $res;
	}
	
    }
?>