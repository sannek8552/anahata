<?php
require_once('Admin_Header.php');
require_once('classes/ProductHolder.php');
require_once('classes/CertificateHolder.php');

class PaymentDetails extends Runmode 
{
	function PaymentDetails()
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
			$data['certificates'] = unserialize($data['certificates']);
			$data['shipping_info'] = unserialize($data['shipping_info']);
			
			$ph = new ProductHolder();
			$products = $ph->getAll();
			$GLOBALS['core.smarty']->assign('products',$products);
			
			$options = $ph->getAllOptionsAdm();
			$GLOBALS['core.smarty']->assign('options',$options);						
			
			$ch = new CertificateHolder();
			$certificates = $ch->get_all();
			$GLOBALS['core.smarty']->assign('certificates', $certificates);
			
			$GLOBALS['core.smarty']->assign('data', $data);
			$GLOBALS['core.smarty']->assign('coupons_m', $data['coupons']);
			$GLOBALS['core.smarty']->assign('certificates_m', $data['certificates']);			
			
			/*
			$shippings = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ",array(),'id');
			$GLOBALS['core.smarty']->assign('shippings',$shippings);
			
			$item_shippings = $GLOBALS['core.sql']->getAll("select * from #p#item_shipping order by created ",array(),'id');
			$GLOBALS['core.smarty']->assign('item_shippings',$item_shippings);
			*/
			
			$countries = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#country',array(),'country_id');
        	$GLOBALS['core.smarty']->assign('countries',$countries);
		}
		
		return Admin_Header::out('payment_details');
	}
}
?>