<?php
require_once('Admin_Header.php');
require_once('classes/CMS/Product_Tops_Holder.php');
class Product_Tops_Manager extends Runmode
{
	function Product_Tops_Manager()
	{		
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();
	}
	
	function process()
	{
                
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$data['count'] = $_REQUEST['count'];
			//$data['random'] = (isset($_REQUEST['random']) && !empty($_REQUEST['random'])) ? 1 : 0;
			
			$id = null;
			if(isset($_REQUEST['id']) && !empty($_REQUEST['id']))
			{
				$id = $_REQUEST['id'];
			}
			$holder = new Product_Tops_Holder($id);
			$holder->set_data($data);
			$holder->save();
		}
		elseif (isset($_REQUEST['action']) && 'edit' == $_REQUEST['action'])
		{
			$id = $_REQUEST['id'];
			$holder = new Product_Tops_Holder($id);
			$data = $holder->get_data();
			$GLOBALS['core.smarty']->assign('data', $data);			
		}
		elseif (isset($_REQUEST['action']) && 'delete' == $_REQUEST['action'])
		{
			$holder = new Featured_Manager_Holder($_REQUEST['id']);
			$holder->delete();
		}
		
		$holder = new Product_Tops_Holder();
		$GLOBALS['core.smarty']->assign('records', $holder->get_All());
		return Admin_Header::out('CMS/Page_Runmode/product_tops_manager');
	}
}
?>