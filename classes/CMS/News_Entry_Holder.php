<?php
require_once('Data_Holder.php');
class News_Entry_Holder extends Data_Holder_Simple 
{
	function News_Entry_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('news_module_entry',$key_info);
	}
}
?>