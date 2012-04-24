<?php
/**
 *@author Alexandr Yusupov
 *@copyright <a href="http://evaxsoft.com/">EvaxSoft</a>
 *
 */

function smarty_function_w_link($param, &$smarty)
{
	$t_config = $GLOBALS['core.config']->get_config('templates');
	$str_to_return = '';
	if(isset($param['p']))
	{
		$str_to_return = $t_config['common']['wordpress_url'] . '?p=' . $param['p'];
	}
	else 
	{
		$str_to_return = $t_config['wordpress_url'];
	}
	
	return $str_to_return;
}

?>