<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty without_params modifier plugin
 *
 * Type:     modifier<br>
 * Name:     without_params<br>
 * Purpose:  strip scobes from text
 * @param string
 * @return string
 */

function smarty_modifier_without_params($string)
{
	$pos = strpos($string, '(');
	
	if ($pos !== false)
		return substr($string, 0, $pos);
	else
		return $string;
}

/* vim: set expandtab: */

?>
