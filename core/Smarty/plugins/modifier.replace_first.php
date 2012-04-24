<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty replace modifier plugin
 *
 * Type:     modifier<br>
 * Name:     replace_first<br>
 * Purpose:  simple search/replace first occurance
 * @param string
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_replace_first($string, $search, $replace)
{
//	print "string $string<br>search $search<br>replace $replace<br>";
	$res = '';//array();

	for($i=0;$i<strlen($string);$i++)
	{
		if ($string[$i] == $search)
		 {
		 
		 	for($j=0;$j<strlen($replace);$j++)
		 	{
		 		$res .= $replace[$j];
		 		$k++;
		 	}
			$i++;
		 }
		$res .= $string[$i];
	}
	
return $res;
//    $pos = strpos($string, $search);
//	print "string $string<br>search $search<br>pos $pos<br>";
//error_log($string . ' ' . $search . ' ' . $replace);
//    error_log('here' . $pos . 'here');
//    return substr_replace($string, $replace, $pos, 1);
}

/* vim: set expandtab: */

?>
