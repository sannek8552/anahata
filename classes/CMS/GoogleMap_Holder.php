<?php
require_once('Data_Holder.php');
class GoogleMap_Holder extends Data_Holder_Simple 
{
	function GoogleMap_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('googlemap_module', $key_info);
	}
	
	function get_module_list()
	{
		$to_ret = array();
		$res = $this->get_all();
		foreach ($res as $key => $value)
		{
			$to_ret[] = array('code'=> '[googlemap_module?section=' . $value['id'] . ']','description' => $value['location']);
			$to_ret[] = array('code'=> '[googlemap_module?section=' . $value['id'] . '&street_view=1]','description' => $value['location'] . '<br/>With Street View');
		}
		return $to_ret;
	}
	
	function get_all()
	{
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#googlemap_module ORDER BY id');
	}
}
?>