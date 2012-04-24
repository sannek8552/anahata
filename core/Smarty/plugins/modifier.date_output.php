<?php


function smarty_modifier_date_output($string, $format)
{
	if (empty($string)) return "";
	
	return date($format,$string);
}



?>