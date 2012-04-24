<?php

define("E_AUTHORISATION_FAILED","auth_failed");
define("E_UID_FAILED","id_error");
define("E_PARAMETERS","param_mismatch");
require_once('User/Config_User.php');

class Authoriser_Database extends Module 
{

	var $login_field;
	var $password_field;
    function Authoriser_Database($cfg)
    {
    	$this->login_field = $cfg['login_field'];
    	$this->password_field = $cfg['password_field'];
    }	

    function init()
    {
    	return true;
    }
    
    function run()
    {
    	$login = '';
    	$password = '';
    	if(isset($_REQUEST[$this->login_field]) && isset($_REQUEST[$this->password_field]))
    	{
    		$login = $_REQUEST[$this->login_field];
    		$password = $_REQUEST[$this->password_field];
    	}
    	
    	$res = $this->authorise($login, $password);
    	if(PEAR::isError($res))
    		return $res;
    	if(is_array($res))
    	{
    		$res = $this->create_user($res);
    		if(PEAR::isError($res))
    			return $res;
    	}
    	else 
    	{
    		$res = $this->create_user();
    		if(PEAR::isError($res))
    			return $res;
    	}
    	return true;
    }
    
    function authorise($login = '',$password = '')
    {
		if (!empty($login) && !empty($password))
		{
			//������� � ����
			$code_string = md5($login.$password);			
			$sql_string = "SELECT * FROM ".$GLOBALS['core.store']->prefix."user WHERE login = ? AND password = ? AND deleted = 0";
			$mod = array($login,$code_string);
			$res = $GLOBALS['core.sql']->getRow($sql_string,$mod);
			if(PEAR::isError($res))
				return $res;
			if (empty($res)) 
			    return E_AUTHORISATION_FAILED;
			$_SESSION['_UID_'] = $res['user_id'];
			return $res;
		}
		elseif (empty($login) || empty($password))
		{
		    
			//����� �� ������ ���� _UID_ 
			if (!isset($_SESSION['_UID_']) || empty($_SESSION['_UID_']))
			    return E_UID_FAILED;
			
			$sql_string = "SELECT * FROM ".$GLOBALS['core.store']->prefix."user WHERE user_id = ?";
			$mod = array($_SESSION['_UID_']);
			$res = $GLOBALS['core.sql']->getRow($sql_string,$mod);
			if(PEAR::isError($res))
				return $res;
			if (empty($res)) 
			    return E_AUTHORISATION_FAILED;
			return $res;
		}
	    else return E_PARAMETERS;

    }
    
    function deauthorise()
    {
		unset($_SESSION['_UID_']);
		//$cur_user =& $GLOBALS['core.user'];
		//$app =& $GLOBALS['core.application']; 
		//$app->recreate_user();
		$this->create_user();
    }
    
    function create_user($user_data = array())
    {
		$GLOBALS['core.auth.user'] = &new Config_User();
		$res = $GLOBALS['core.auth.user']->init('', $user_data);
		if(PEAR::isError($res))
			return $res;
    }
}
?>