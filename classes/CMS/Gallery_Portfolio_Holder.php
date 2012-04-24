<?php
require_once('Data_Holder.php');
require_once('classes/CMS/Gallery_Portfolio_Picture_Holder.php');

class Gallery_Portfolio_Holder extends Data_Holder_Simple 
{
	function Gallery_Portfolio_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('gallery_portfolio_module',$key_info);
	}
	
	function get_all()
	{
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#gallery_portfolio_module ORDER BY id',array(),'id');
	}
	
	function &get_picture_holder($id = null)
	{
		$picture_holder = new Gallery_Portfolio_Picture_Holder($id);
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
		Gallery_Portfolio_Picture_Holder::mass_delete($this->get_key_value());
		parent::delete();
	}
}
?>