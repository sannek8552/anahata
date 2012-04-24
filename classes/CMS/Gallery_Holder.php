<?php
require_once('Data_Holder.php');
require_once('classes/CMS/Gallery_Picture_Holder.php');

class Gallery_Holder extends Data_Holder_Simple 
{
	function Gallery_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('gallery_module',$key_info);
	}
	
	function get_module_list()
	{
		$to_ret = array();
		$res = $this->get_all();
		foreach ($res as $key => $value)
		{
			$to_ret[] = array('code'=> '[gallery_module?section=' . $value['id'] . ']','description' => $value['name']);
		}
		return $to_ret;
	}
	
	function get_all()
	{
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#gallery_module ORDER BY id',array(),'id');
	}
	
	function &get_picture_holder($id = null)
	{
		$picture_holder = new Gallery_Picture_Holder($id);
		$picture_holder->set_data(array('gallery_id' => $this->get_key_value()));
		$picture_holder->gallery_holder = &$this;
		return $picture_holder;
	}
	
	function assign_to_smarty()
	{
		foreach ($this->data as $key => $value)
		{
			$GLOBALS['core.smarty']->assign($key, $value);
		}
	}
	
	function delete()
	{
		Gallery_Picture_Holder::mass_delete($this->get_key_value());
		parent::delete();
	}
}
?>