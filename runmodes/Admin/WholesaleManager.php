<?php
require_once('Admin_Header.php');
require_once('classes/WholesaleHolder.php');
require_once('classes/CategoryHolder.php');

class WholesaleManager extends Runmode 
{
	function WholesaleManager()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$id = null;
			if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))	$id = $_REQUEST['id'];
			$wh = new WholesaleHolder($id);
			
			$data = array();
			if (isset($_REQUEST['name']) && !empty($_REQUEST['name'])) $data['name'] = $_REQUEST['name'];
			$category_ids = array();
			if (isset($_REQUEST['category_ids']))
				$category_ids = $_REQUEST['category_ids'];
			
			if (isset($_REQUEST['discount']) && !empty($_REQUEST['discount'])) $data['discount'] = $_REQUEST['discount'];
			$data['active'] = (isset($_REQUEST['active'])) ? 1 : 0;
			
			$wh->set_data($data);
			$wh->save();
			$wh->setCategoriesAndSave($category_ids);
		}
		
		if (isset($_REQUEST['action']) && !empty($_REQUEST['action']) && isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		{
			$wh = new WholesaleHolder($_REQUEST['id']);
			if ('Edit' == $_REQUEST['action'])
			{				
				$GLOBALS['core.smarty']->assign('data',$wh->get_data());
			}
			
			if ('Delete' == $_REQUEST['action'])
			{
				$wh->delete();
			}
		}
		
		$ch = new CategoryHolder();
		$ch->loadCategoriesForSelect();
		
		$wh = new WholesaleHolder();
		$wholesales = $wh->getAllWithCategories();
		$GLOBALS['core.smarty']->assign('wholesales', $wholesales);
		
		return Admin_Header::out('wholesale_manager');
	}
}

?>