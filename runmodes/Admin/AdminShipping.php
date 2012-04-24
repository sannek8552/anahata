<?php
require_once('Admin_Header.php');

class AdminShipping extends Runmode 
{
	function AdminShipping()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();
	}
	
	function process()
	{
		//shipping by weight code
		
		if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		{
			if (isset($_REQUEST['action']))
			{
				if ('edit' == $_REQUEST['action'])
				{
					$data = $GLOBALS['core.sql']->getRow("select * from #p#shipping where id = ? ",$_REQUEST['id']);
					$GLOBALS['core.smarty']->assign('data',$data);
				}
				
				if ('delete' == $_REQUEST['action'])
				{
					$GLOBALS['core.store']->delete('shipping',array('key_name' => 'id','key_value' => $_REQUEST['id']));
				}
			}
		}
		
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$data = array();
			if (isset($_REQUEST['method']) && !empty($_REQUEST['method'])) $data['method'] = $_REQUEST['method'];
			if (isset($_REQUEST['price']) && !empty($_REQUEST['price'])) $data['price'] = $_REQUEST['price'];
			if (isset($_REQUEST['from_w'])) $data['from_w'] = $_REQUEST['from_w'];
			if (isset($_REQUEST['to_w'])) $data['to_w'] = $_REQUEST['to_w'];
			
			$key_info = array('key_name' => 'id');
			if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) $key_info['key_value'] = $_REQUEST['id'];
			$GLOBALS['core.store']->save('shipping',$data,$key_info);
		}
		
		$list = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ");
		$GLOBALS['core.smarty']->assign('list',$list);		
		
		//end of shipping by weight code
		
		//fixed shipping code
		
		if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		{
			if (isset($_REQUEST['action']))
			{
				if ('fixed_edit' == $_REQUEST['action'])
				{
					$data = $GLOBALS['core.sql']->getRow("select * from #p#fixed_shipping where id = ? ",$_REQUEST['id']);
					$GLOBALS['core.smarty']->assign('fixed_data',$data);
				}
				
				if ('fixed_delete' == $_REQUEST['action'])
				{
					$GLOBALS['core.store']->delete('fixed_shipping',array('key_name' => 'id','key_value' => $_REQUEST['id']));
				}
			}
		}

		
		if (isset($_REQUEST['save_fixed']) && !empty($_REQUEST['save_fixed']))
		{
			$data = array();
			if (isset($_REQUEST['method']) && !empty($_REQUEST['method'])) $data['method'] = $_REQUEST['method'];
			if (isset($_REQUEST['price']) && !empty($_REQUEST['price'])) $data['price'] = $_REQUEST['price'];
						
			$key_info = array('key_name' => 'id');
			if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) $key_info['key_value'] = $_REQUEST['id'];
			$GLOBALS['core.store']->save('fixed_shipping',$data,$key_info);
		}
		
		$list = $GLOBALS['core.sql']->getAll("select * from #p#fixed_shipping order by created ");
		$GLOBALS['core.smarty']->assign('fixed_list',$list);	
		
		//end of fixed shipping code
		
		//shipping by items code
		
		if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		{
			if (isset($_REQUEST['action']))
			{
				if ('item_edit' == $_REQUEST['action'])
				{
					$data = $GLOBALS['core.sql']->getRow("select * from #p#item_shipping where id = ? ",$_REQUEST['id']);
					$GLOBALS['core.smarty']->assign('item_data',$data);
				}
				
				if ('item_delete' == $_REQUEST['action'])
				{
					$GLOBALS['core.store']->delete('item_shipping',array('key_name' => 'id','key_value' => $_REQUEST['id']));
				}
			}
		}
		
		if (isset($_REQUEST['save_item']) && !empty($_REQUEST['save_item']))
		{
			$data = array();
			if (isset($_REQUEST['method']) && !empty($_REQUEST['method'])) $data['method'] = $_REQUEST['method'];
			if (isset($_REQUEST['price']) && !empty($_REQUEST['price'])) $data['price'] = $_REQUEST['price'];
			if (isset($_REQUEST['from_w'])) $data['from_w'] = $_REQUEST['from_w'];
			if (isset($_REQUEST['to_w'])) $data['to_w'] = $_REQUEST['to_w'];
			
			$key_info = array('key_name' => 'id');
			if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) $key_info['key_value'] = $_REQUEST['id'];
			$GLOBALS['core.store']->save('item_shipping',$data,$key_info);
		}
		
		$list = $GLOBALS['core.sql']->getAll("select * from #p#item_shipping order by created ");
		$GLOBALS['core.smarty']->assign('item_list',$list);	
		
		//end of shipping by items code
		
		return Admin_Header::out('admin_shipping');
	}
}
?>