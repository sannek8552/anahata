<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty bit list modifier plugin
 *
 * Type:     modifier<br>
 * Name:     bit_list<br>
 * Date:     June 29, 2006
 * Input:    integer number, divider string
 * Example:  {$var|bit_list:";"}
 * @author   Silvero (silverozzo@gmail.com)
 * @version 1.0
 * @param number
 * @param string
 * @return string
 */
function smarty_modifier_bit_list($number, $divider = ', ')
{
	if (!is_numeric($number))
		return '';
	
	$list = '';
	for ($i = 0; $i < 64; $i++)
	{
		$bit = 1 << $i;
		if ($number & $bit)
			$list .= (($list != '') ? $divider : '') . ($i + 1);
		
		if ($bit > $number)
			break;
	}
    
	return $list;
}

/* vim: set expandtab: */

?>
