<?php
require_once('Admin_Header.php');
require_once('classes/Coupon/CouponHolder.php');
require_once('classes/CategoryHolder.php');
require_once('classes/ProductHolder.php');

class CouponManager extends Runmode 
{
	function CouponManager()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		$this->load_lists();
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['action']) && !empty($_REQUEST['action']))
		{
			if ('add' == $_REQUEST['action'])
			{
				return Admin_Header::out('Coupon/add_coupon');
			}
			
			if ('edit' == $_REQUEST['action'])
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					$ch = new CouponHolder($_REQUEST['id']);
					$GLOBALS['core.smarty']->assign('coupon',$ch->get_data());
					
					return Admin_Header::out('Coupon/add_coupon');
				}
			}
			
			if ('save' == $_REQUEST['action'])
			{
				$data = $this->process_save();
				$id = null;
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))	$id = $_REQUEST['id'];
				
				$ch = new CouponHolder($id);
				$ch->set_data($data);
				$ch->save();				
			}
			
			if ('delete' == $_REQUEST['action'])
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					$ch = new CouponHolder($_REQUEST['id']);
					$ch->delete();
				}
			}
		}
		
		$cm = new CouponHolder();
		$coupons = $cm->getAll();
		$GLOBALS['core.smarty']->assign('coupons',$coupons);
			
		return Admin_Header::out('Coupon/admin_coupon');
	}
	
	function load_lists()
	{		
		$ch = new CategoryHolder();	
		$to_ret = $ch->getCategoriesForSelect();
		$GLOBALS['core.smarty']->assign('categories',$to_ret);
		
		$ph = new ProductHolder();
		$products = $ph->getAll();
		$GLOBALS['core.smarty']->assign('products',$products);
	}
	
	function process_save()
	{
		$data = array();
				
		if (isset($_REQUEST['name']) && !empty($_REQUEST['name'])) $data['name'] = $_REQUEST['name'];
		else $data['name'] = '';
		if (isset($_REQUEST['description']))	$data['description'] = $_REQUEST['description'];
		else $data['description'] = '';		
		if (isset($_REQUEST['code']))	$data['code'] = $_REQUEST['code'];
		else $data['code'] = '';
		if (isset($_REQUEST['minimum_order']))	$data['minimum_order'] = $_REQUEST['minimum_order'];
		else $data['minimum_order'] = 0;
		if (isset($_REQUEST['uses_per_coupon']))	$data['uses_per_coupon'] = $_REQUEST['uses_per_coupon'];
		else $data['uses_per_coupon'] = 0;
		if (isset($_REQUEST['uses_per_customer']))	$data['uses_per_customer'] = $_REQUEST['uses_per_customer'];
		else $data['uses_per_customer'] = 0;
		if (isset($_REQUEST['type']))	$data['type'] = $_REQUEST['type'];
		else $data['type'] = 'amount';
		if (isset($_REQUEST['amount']))	$data['amount'] = $_REQUEST['amount'];
		else $data['amount'] = 0;
		
		
		if (	isset($_REQUEST['startDay']) && !empty($_REQUEST['startDay'])
				&&	isset($_REQUEST['startMonth']) && !empty($_REQUEST['startMonth'])
				&&	isset($_REQUEST['startYear']) && !empty($_REQUEST['startYear']))
				{
						$data['start_date'] = mktime(0,0,0,$_REQUEST['startMonth'],$_REQUEST['startDay'],$_REQUEST['startYear']);
				}
		else $data['start_date'] = mktime(0,0,0,date("m"),date("d"),date("Y"));
		
		if (	isset($_REQUEST['endDay']) && !empty($_REQUEST['endDay'])
				&&	isset($_REQUEST['endMonth']) && !empty($_REQUEST['endMonth'])
				&&	isset($_REQUEST['endYear']) && !empty($_REQUEST['endYear']))
				{
						$data['end_date'] = mktime(0,0,0,$_REQUEST['endMonth'],$_REQUEST['endDay'],$_REQUEST['endYear']);
				}
		else $data['end_date'] = mktime(23,59,59,date("m"),date("d"),date("Y"));
		
		if (isset($_REQUEST['apply_type']) && !empty($_REQUEST['apply_type']))
		{
			$data['apply_type'] = $_REQUEST['apply_type'];
			if ('category' == $_REQUEST['apply_type'] && isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) $data['item_id'] = $_REQUEST['category_id'];
			if ('product' == $_REQUEST['apply_type'] && isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id'])) $data['item_id'] = $_REQUEST['product_id'];
		}

		return $data;
	}
}

?>