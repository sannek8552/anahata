<?php
require_once('Admin_Header.php');
require_once('classes/CMS/GoogleMap_Holder.php');
class GoogleMap_Manager extends Runmode 
{
	function GoogleMap_Manager()
	{
		$GLOBALS['core.smarty']->assign('current_menu','Modules');
		$GLOBALS['core.smarty']->assign('current_sub', 'Google Map Manager');
		
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();
	}
	
	function process()
	{
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$data = array();
			$data['google_key'] = $_REQUEST['google_key'];
			$data['location'] = $_REQUEST['location'];
			$id = null;
			if(isset($_REQUEST['id']))
				$id = $_REQUEST['id'];
			$googlemap_holder = new GoogleMap_Holder($id);
			$googlemap_holder->set_data($data);
			$googlemap_holder->save();
		}
		elseif (isset($_REQUEST['action']) && 'edit' == $_REQUEST['action'])
		{
			$googlemap_holder = new GoogleMap_Holder($_REQUEST['id']);
			$edit_data = $googlemap_holder->get_data();
			$GLOBALS['core.smarty']->assign('edit_data', $edit_data);
		}
		elseif (isset($_REQUEST['action']) && 'delete' == $_REQUEST['action'])
		{
			$googlemap_holder = new GoogleMap_Holder($_REQUEST['id']);
			$googlemap_holder->delete();
		}
		
		$maps = GoogleMap_Holder::get_all();
		$GLOBALS['core.smarty']->assign('maps', $maps);
		return Admin_Header::out('CMS/Page_Runmode/googlemap_manager');
	}
}
?>