<?php
	require_once('Data_Holder.php');
	require_once('classes/ProductHolder.php');
	class LashHolder extends Data_Holder_Simple 
	{
		function LashHolder($id = null)
		{
			$table = 'lash';
			$key_info = array('key_name' => 'id');
			if (!is_null($id)) $key_info['key_value'] = $id;
			$this->init($table,$key_info);
		}
		function get_all()
		{
			return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#lash",array(), 'id');
		}
	}
?>