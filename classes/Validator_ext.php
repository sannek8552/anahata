<?php
class Validator_ext
{
	function va_between($element)
    {
        if( $element['value'] < 10 || $element['value'] > 50)
        {
        	return array($element['name'] => '1');
        }
        else 
        {
        	return array();
        }
    }
}
?>