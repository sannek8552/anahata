<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * Author: Yusupov Alexandr
 */


/**
 * Smarty {random} function plugin
 *
 * Type:     function<br>
 * Name:     random<br>
 * Purpose:  get random value<br>
 * @param min
 * @param max
 * @param Smarty
 */
function smarty_function_random_style_file($param, &$smarty)
{

   // error_log(print_r($param,1));
    //error_log('c_' . $GLOBALS['core.smarty.rand_file'][$param['id']] . '_' . $param['id']);
    if('f_' . $GLOBALS['core.smarty.rand_file'][$param['id']] . '_' . $param['id'] == $param['last_node'])
	return 'font-weight:bold;';
    
}

/* vim: set expandtab: */

?>