<?php
require_once('Data_Holder.php');

class OptionHolder extends Data_Holder 
{
	function OptionHolder($id = null)
	{
		$table = 'product_option';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}
	
	
}

?>