<?php
require_once('Admin_Header.php');
require_once('classes/ProductHolder.php');
require_once('classes/DropdownManager.php');
require_once('classes/UserHolder.php');
require_once('classes/CertificateHolder.php');

class AdminPayment extends Runmode 
{
	function AdminPayment()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();
		
		$GLOBALS['core.smarty']->assign('current_menu','Payments');
		//$GLOBALS['core.smarty']->assign('current_sub','Payment');
	}
	
	function process()
	{
		if (isset($_REQUEST['action']) && 'approve' == $_REQUEST['action'])
		{
			if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
			{
				$payment = $GLOBALS['core.sql']->getRow("select * from #p#payment where id = ? ",array($_REQUEST['id']));
				
				if (isset($payment['user_id']) && !empty($payment['user_id'])
					&& isset($payment['not_approved_points']) && !empty($payment['not_approved_points']))
					{
						$uh = new UserHolder($payment['user_id']);
						$uh->addPoints($payment['not_approved_points']);
						
						$GLOBALS['core.store']->save('payment', array('not_approved_points' => 0), array('key_name' => 'id', 'key_value' => $_REQUEST['id']));
					}
			}
		}
		
		
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$filters = array();
			if (isset($_REQUEST['from_Day']) && isset($_REQUEST['from_Month']) && isset($_REQUEST['from_Year']))
			{
				$date_from = mktime(0,0,0,$_REQUEST['from_Month'],$_REQUEST['from_Day'],$_REQUEST['from_Year']);
				$filters[] = array('f' => 'created' ,'o'=>'>=','v' => $date_from);
				$_SESSION['date_from'] = $date_from;
				
			}
			if (isset($_REQUEST['to_Day']) && isset($_REQUEST['to_Month']) && isset($_REQUEST['to_Year']))
			{
				$date_to = mktime(23,59,59,$_REQUEST['to_Month'],$_REQUEST['to_Day'],$_REQUEST['to_Year']);
				$filters[] = array('f' => 'created' ,'o'=>'<=','v' => $date_to);
				$_SESSION['date_to'] = $date_to;
				
			}
			$_SESSION['filters'] = $filters;
		}
		elseif (!isset($_REQUEST['action']))
		{
			$GLOBALS['core.list']->set_filters(array());
			if (isset($_SESSION['filters'])) unset($_SESSION['filters']);
			if (isset($_SESSION['date_from'])) unset($_SESSION['date_from']);
			if (isset($_SESSION['date_to'])) unset($_SESSION['date_to']);
		}
			
		$GLOBALS['core.list']->init('payment_list');
		$GLOBALS['core.list']->set_sql(" * from #p#payment");
		$GLOBALS['core.list']->set_param('order_by',array('created desc'));
		$GLOBALS['core.list']->set_param('items_per_page',10);				
		if (isset($filters)) $GLOBALS['core.list']->set_filters($filters);
		
		if (isset($_REQUEST['action']) && 'Page' == $_REQUEST['action']	&& isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		{
			$page_num = $_REQUEST['id'];
			if (isset($_SESSION['filters'])) $GLOBALS['core.list']->set_filters($_SESSION['filters']);
		}
		else $page_num = 1;
		
		//pp($GLOBALS['core.list']);
		//pp($_SESSION);
		
		$page = $GLOBALS['core.list']->get_page($page_num);
		
		
		foreach ($page as $key => $value)
		{
			$page[$key]['products'] = unserialize($value['cart_info']);
			if (isset($value['shipping_info'])) $page[$key]['shipping_info'] = unserialize($value['shipping_info']);
		}
		
		$info = $GLOBALS['core.list']->num_pages();
		$GLOBALS['core.smarty']->assign('info',$info);
		$GLOBALS['core.smarty']->assign('page',$page);
		
		//pp($info);
		//pp($page);
		if (isset($_SESSION['date_from'])) $GLOBALS['core.smarty']->assign('date_from',$_SESSION['date_from']);
		if (isset($_SESSION['date_to'])) $GLOBALS['core.smarty']->assign('date_to',$_SESSION['date_to']);
		
		/*
		$list = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ",array(),'id');
		$GLOBALS['core.smarty']->assign('shipping_list',$list);
		
		$item_list = $GLOBALS['core.sql']->getAll("select * from #p#item_shipping order by created ",array(),'id');
		$GLOBALS['core.smarty']->assign('item_shipping_list',$item_list);
		*/
				
		$this->load_lists();
		return Admin_Header::out('admin_payment');
	}
	
	function load_lists()
	{
		$ph = new ProductHolder();
		$products = $ph->getAll();
		$GLOBALS['core.smarty']->assign('products',$products);
		
		$options = $ph->getAllOptions();
		$GLOBALS['core.smarty']->assign('options',$options);
						
		$ch = new CertificateHolder();
		$certificates = $ch->get_all();
		$GLOBALS['core.smarty']->assign('certificates', $certificates);	
		
		$countries = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#country',array(),'country_id');
        $GLOBALS['core.smarty']->assign('countries',$countries);
	}
}
?>