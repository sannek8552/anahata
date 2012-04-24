<?php
require_once('Data_Holder.php');
class Text_Manager_Holder extends Data_Holder_Simple 
{
	function Text_Manager_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('text_module', $key_info);
	}
	
	function get_module_list()
	{
		$to_ret = array();
		$res = $this->get_all();
		foreach ($res as $key => $value)
		{
			$to_ret[] = array('code'=> '[text_module?entry=' . $value['id'] . ']','description' => $value['module_text'],'escape' => true);		
		}
		return $to_ret;
	}
	
	function get_all()
	{
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#text_module ORDER BY id');
	}
	
	
}
?>