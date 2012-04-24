<?php
require_once('Common_Header.php');
require_once('classes/ProductHolder.php');
require_once('classes/DropdownManager.php');

class MyOrderDetails extends Runmode 
{
	function MyOrderDetails()
	{
		$this->base_map[0] = 'id';
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		{
			$data = $GLOBALS['core.sql']->getRow("select * from #p#payment where id = ?",array($_REQUEST['id']));
			$data['products'] = unserialize($data['cart_info']);
			$data['coupons'] = unserialize($data['coupons']);
			$ph = new ProductHolder();
			$products = $ph->getAll();
			$GLOBALS['core.smarty']->assign('products',$products);
			$options = $ph->getAllOptionsAdm();
			$GLOBALS['core.smarty']->assign('options',$options);

			$dm = new DropdownManager();
			$dm->load_lists();
			$GLOBALS['core.smarty']->assign('data',$data);
			$GLOBALS['core.smarty']->assign('coupons_m', $data['coupons']);
			
			$shippings = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ",array(),'id');
			$GLOBALS['core.smarty']->assign('shippings',$shippings);
			
			$item_shippings = $GLOBALS['core.sql']->getAll("select * from #p#item_shipping order by created ",array(),'id');
			$GLOBALS['core.smarty']->assign('item_shippings',$item_shippings);
		}
		//pp($data);
		return Common_Header::out('User/MyOrderDetails');
	}
}
?>