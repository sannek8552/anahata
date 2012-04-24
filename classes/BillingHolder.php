<?php
require_once('Data_Holder.php');
class BillingHolder extends Data_Holder_Simple 
{
	function BillingHolder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('billing',$key_info);
	}
}
?>