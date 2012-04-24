<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty size modifier plugin
 *
 * Type:     modifier<br>
 * Name:     size<br>
 * Author: Yusupov Alexandr (grobokop@gmail.com)
 * Purpose:  convert bytes size to string representation
 * @param string
 * @return string
 */
function smarty_modifier_size($string)
{
    $alias = array('B','Kb','Mb','Gb','Tb');
    $a_n = 0;
    while($string / 1024 > 1)
    {
	$a_n++;
	$string = $string / 1024;
    }
    $string = round($string,2) . ' ' . $alias[$a_n];
    return $string;
    //return strtoupper($string);
}

?>
