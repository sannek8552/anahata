<?php
require_once('Admin_Header.php');
require_once('classes/CMS/Text_Manager_Holder.php');
class Text_Manager extends Runmode 
{
	function Text_Manager()
	{
		$GLOBALS['core.smarty']->assign('current_sub', 'Text Manager');
		$GLOBALS['core.smarty']->assign('current_menu','Modules');
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();
	}
	
	function process()
	{
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$data['module_text'] = $_REQUEST['module_text'];
                        $data['title'] = $_REQUEST['title'];
			
			$id = null;
			if(isset($_REQUEST['id']) && !empty($_REQUEST['id']))
			{
				$id = $_REQUEST['id'];
			}
			$holder = new Text_Manager_Holder($id);
			$holder->set_data($data);
			$holder->save();
		}
		elseif (isset($_REQUEST['action']) && 'edit' == $_REQUEST['action'])
		{
			$id = $_REQUEST['id'];
			$holder = new Text_Manager_Holder($id);
			$data = $holder->get_data();
			$GLOBALS['core.smarty']->assign('edit_id', $holder->get_key_value());
			$GLOBALS['core.smarty']->assign('edit_text', $data['module_text']);
                        $GLOBALS['core.smarty']->assign('edit_title', $data['title']);
                        //pp($data);
		}
		elseif (isset($_REQUEST['action']) && 'delete' == $_REQUEST['action'])
		{
			$holder = new Text_Manager_Holder($_REQUEST['id']);
			$holder->delete();
		}
		
		$GLOBALS['core.smarty']->assign('records', Text_Manager_Holder::get_all());
		return Admin_Header::out('CMS/Page_Runmode/text_manager');
	}
}
?>