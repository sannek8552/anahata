<?php
/**
 *@author Alexandr Yusupov
 *@copyright <a href="http://evaxsoft.com/">EvaxSoft</a>
 *
 */

function smarty_function_seo_url($param, &$smarty)
{
	//params can be 
	//rm --runmore name if omitted used from globals
	//and then any number of params, like param1,param2,param3
	$str_to_return = '';
	if(isset($param['rm']))
	{
		$str_to_return = $param['rm'] . '/';
	}
	else 
	{
		$str_to_return = $GLOBALS['core.runmode']->get_runmode_name() . '/';
	}
	$i = 1;
	while (isset($param['param' . $i]))
	{
		$str_to_return .= $param['param' . $i] . '/';
		$i++;
	}
	$str_to_return = substr($str_to_return, 0, -1);
	$str_to_return .= '.html';
	return $str_to_return;
}

?>