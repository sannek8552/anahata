<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * Author: Pavel Magur
 */


/**
 * Smarty {random} function plugin
 *
 * Type:     function<br>
 * Name:     required<br>
 * Purpose:  get text for required field<br>
 * 
 */
function smarty_function_req($param,&$smarty)
{
	$string = "<span style='color:red;'>*</span>";
    return $string;
}

/* vim: set expandtab: */

?>