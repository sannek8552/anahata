<?php
require_once('Data_Holder.php');
class PaymentHolder extends Data_Holder_Simple 
{
	function PaymentHolder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('paypal',$key_info);
	}
	
	function loadByCode($code)
	{
		$id = $GLOBALS['core.sql']->getOne("select id from #p#".$this->table." where code = ?",array($code));
		if (!empty($id))
		{
			$this->load($id);
		}
	}
	
	function load($id)
	{
		$this->init($this->table,array('key_name' => $this->key_info['key_name'],'key_value' => $id));
	}		
}
?>