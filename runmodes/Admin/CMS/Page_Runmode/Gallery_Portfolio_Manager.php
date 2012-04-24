<?php
require_once('Admin_Header.php');
require_once('classes/CMS/Gallery_Portfolio_Holder.php');
class Gallery_Portfolio_Manager extends Runmode 
{
	function Gallery_Portfolio_Manager()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		$this->base_map[2] = 'action2';
		$this->base_map[3] = 'num';
		parent::Runmode();
		$GLOBALS['core.smarty']->assign('current_sub', 'Gallery');
		$GLOBALS['core.smarty']->assign('current_menu','Modules');
	}
	
	function process()
	{
		if(isset($_REQUEST['action']) && 'picture' == $_REQUEST['action'])
		{
			return $this->process_picture();
		}
		elseif (isset($_REQUEST['action']) && 'edit' == $_REQUEST['action'])
		{
			$gallery_holder = new Gallery_Portfolio_Holder($_REQUEST['id']);
			$gallery_holder->assign_to_smarty();
		}
		elseif (isset($_REQUEST['action']) && 'delete' == $_REQUEST['action'])
		{
			$gallery_holder = new Gallery_Portfolio_Holder($_REQUEST['id']);
			$gallery_holder->delete();
		}
		
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$id = null;
			if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) && !empty($_REQUEST['id']))
			{
				$id = $_REQUEST['id'];
			}
			
			$gallery_holder = new Gallery_Portfolio_Holder($id);
			$data = array('name' => $_REQUEST['name'],'items_per_page' => $_REQUEST['items_per_page']);
			$gallery_holder->set_data($data);
			$gallery_holder->save();
		}
		
		$gallery = Gallery_Portfolio_Holder::get_all();		
		$GLOBALS['core.smarty']->assign('gallery', $gallery);
		
		return Admin_Header::out('CMS/Page_Runmode/gallery_portfolio_manager');
	}
	
	function process_picture()
	{
		$gallery_holder = new Gallery_Portfolio_Holder($_REQUEST['id']);
		$gallery_data = $gallery_holder->get_data();
		$GLOBALS['core.smarty']->assign('gallery_data', $gallery_data);
		
		
		if(isset($_REQUEST['save']))
		{
			$picture_id = null;
			if (isset($_REQUEST['picture_id']) && !empty($_REQUEST['picture_id'])) 
			{
				$picture_id = $_REQUEST['picture_id'];
			}
			$picture_holder = $gallery_holder->get_picture_holder($picture_id);
			$picture_holder->gather_data_from_request();
		}
		
		$p_holder = $gallery_holder->get_picture_holder(null);
		
		$num = 0;
		//pp($_REQUEST);
		if(isset($_REQUEST['action2']) && 'list' == $_REQUEST['action2'])
		{
			$num = $_REQUEST['num'];
		}
		if(isset($_REQUEST['action2']) && 'clear' == $_REQUEST['action2'])
		{
			$num = 1;
		}
		if(isset($_REQUEST['action2']) && 'edit' == $_REQUEST['action2'])
		{
			$picture_holder = $gallery_holder->get_picture_holder($_REQUEST['num']);
			$picture_holder->assign_to_smarty();
		}
		elseif (isset($_REQUEST['action2']) && 'delete' == $_REQUEST['action2'])
		{
			$picture_holder = $gallery_holder->get_picture_holder($_REQUEST['num']);
			$picture_holder->delete();
		}
		
		$p_holder->get_page($num);
		
		return Admin_Header::out('CMS/Page_Runmode/gallery_portfolio_manager_picture');
	}
}
?>