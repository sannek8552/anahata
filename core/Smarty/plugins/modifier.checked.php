<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty cat modifier plugin
 * 
 * @author   Pavel Magur
 * @version 1.0 
 * @return string
 */
function smarty_modifier_checked($value)
{
	if ($value == 1) return 'checked';
}
?>