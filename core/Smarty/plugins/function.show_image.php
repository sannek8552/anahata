<?php
/**
 *@author Pavel Magur
 *@copyright <a href="http://evaxsoft.com/">EvaxSoft</a>
 *
 */

function smarty_function_show_image($param, &$smarty)
{
	//params can be 
	//id -- product_id
	//width -- name of setting to set as width of image
	//height -- name of setting to set as height of image
	//and then any number of params, like param1,param2,param3
	$str_to_return = 'ShowImage/';
	if(isset($param['id']))
	{
		$str_to_return .= $param['id'] . '/';
	}	
	
	if(isset($param['width']))
	{
		$str_to_return .= $param['width'] . '/';
	}
	
	if(isset($param['height']))
	{
		$str_to_return .= $param['height'] . '/';
	}
	
	$i = 1;
	while (isset($param['param' . $i]))
	{
		$str_to_return .= $param['param' . $i] . '/';
		$i++;
	}
	$str_to_return = substr($str_to_return, 0, -1);
	$str_to_return .= '.html';
	return $str_to_return;
}

?>