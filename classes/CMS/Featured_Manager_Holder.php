<?php
require_once('Data_Holder.php');
class Featured_Manager_Holder extends Data_Holder_Simple 
{
	function Featured_Manager_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('featured_module', $key_info);
	}
	function get_all()
	{
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table.' ORDER BY id');
	}
	
	
	
}
?>