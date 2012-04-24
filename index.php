<?php
@date_default_timezone_set(@date_default_timezone_get());
error_reporting(E_ALL);
$GLOBALS['time_start'] = microtime(true);
require_once 'classes/FirePHPCore/fb.php';

if(isset($_REQUEST['params_to_parse']) && !empty($_REQUEST['params_to_parse']))
{
	$to_parse = explode('/',$_REQUEST['params_to_parse']);
	if(count($to_parse) > 0)
	{
		//we have paramse first is rm
		$_REQUEST['rm'] = $to_parse[0];
		$_GET['rm'] = $to_parse[0];
		$_POST['rm'] = $to_parse[0];
		array_shift($to_parse);
		$_REQUEST['params_to_pars'] = $to_parse;
	}
}
else 
{
	$_REQUEST['params_to_pars'] = array();
}

if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])) $_SESSION['referral_id'] = $_REQUEST['user_id'];

ini_set('include_path','./;./core;./internal;./modules;./classes;' . ini_get('include_path'));
require_once 'Application.php';

$app = new Application();
$res = $app->run();
if (isset($_SERVER['HTTP_REFERER']) and !isset($_SESSION['HTTP_REFERER'])) $_SESSION['HTTP_REFERER'] = $_SERVER['HTTP_REFERER'];
session_write_close();
$GLOBALS['core.log']->do_log('memory max ' . number_format(memory_get_peak_usage(), 0, '.', ','), 'application');
$GLOBALS['core.log']->do_log('time: ' .  (microtime(true) - $GLOBALS['time_start']),'application');
$GLOBALS['core.log']->do_log('sql: ' . $GLOBALS['core.sql.count'],'application');
$GLOBALS['core.log']->do_log('sql time' . $GLOBALS['core.sql.time'],'application');

function pp($var)
{
	print '<pre>';
	print_r($var);
	print '</pre>';
}
?>