<?php

$GLOBALS['time_start'] = microtime(true);
//date_default_timezone_set("America/Phoenix");

//pp($argv);exit();
if(!isset($argv[1]) || empty($argv[1]))
{
	print 'can not be used that way';
	exit();
}


$_REQUEST['params_to_pars'] = array();
$_REQUEST['rm'] = $argv[1];//'module_bpo_late_email';
$_GET['rm'] = $argv[1];//'module_bpo_late_email';
$_POST['rm'] = $argv[1];//'module_bpo_late_email';

//add any of the required path here
$to_look_at = array('./','./core','classes','classes/CMS','modules');

ini_set('include_path', implode(':', $to_look_at) . ':' . ini_get('include_path'));

$app =& new Application();
$config = &new Config('conf');
$GLOBALS['core.config'] = &$config;

$application_conf = $config->get_config('application');
$app->application_conf = $application_conf;

//$res = $app->run();
$_SESSION['_UID_'] = 1;
$app->init_module('logger');

$app->init_module('pear_callback_module');
$app->init_module('smarty_module');
$app->init_module('database_module');
$app->init_module('store_module');
//$app->init_module('memcached');
$app->init_module('auth_module');
$app->init_module('list',true);
$app->init_module('cache');
//$app->init_module('settings');
//$app->init_module('account_setting');
$app->init_module('mailer_module');
$app->init_module('runmode_module');



function pp($var)
{
	print '<pre>';
	print_r($var);
	print '</pre>';
}

function __autoload($class_name)
{
	//implement autoload,
	//if class have name CLASS_NAME then it located at CLASS/NAME.php

	$path  = explode('_', $class_name);
	$num = count($path)-1;
	$to_require = '';
	for ($i = 0; $i < $num; $i++)
	{
		$to_require .= $path[$i] . '/';
	}
	require_once($to_require . $class_name . '.php');
}

?>