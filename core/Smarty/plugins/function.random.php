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
function smarty_function_random($param, &$smarty)
{

    //if(!isset($GLOBALS['core.smarty.rand'][$params['id']]))
    if(isset($param['old']))
	return $GLOBALS['core.smarty.rand'][$param['id']];
    //$rand = rand($param['min'],$param['max']);
    $GLOBALS['core.smarty.rand'][$param['id']]++;// = $rand;
    return $GLOBALS['core.smarty.rand'][$param['id']];//$rand;
}

/* vim: set expandtab: */

?>
