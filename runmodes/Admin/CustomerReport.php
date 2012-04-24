<?php
require_once('Admin_Header.php');
require_once('classes/UserHolder.php');
require_once('classes/ProductHolder.php');
require_once('classes/OptionHolder.php');
require_once('classes/DropdownManager.php');

class CustomerReport extends Runmode 
{
	function CustomerReport()
	{
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$filters = array();
			if (isset($_REQUEST['from_Day']) && isset($_REQUEST['from_Month']) && isset($_REQUEST['from_Year']))
			{
				$date_from = mktime(0,0,0,$_REQUEST['from_Month'],$_REQUEST['from_Day'],$_REQUEST['from_Year']);
				$filters[] = array('f' => 'created' ,'o'=>'>=','v' => $date_from);
				$_SESSION['customer_date_from'] = $date_from;
				
			}
			if (isset($_REQUEST['to_Day']) && isset($_REQUEST['to_Month']) && isset($_REQUEST['to_Year']))
			{
				$date_to = mktime(23,59,59,$_REQUEST['to_Month'],$_REQUEST['to_Day'],$_REQUEST['to_Year']);
				$filters[] = array('f' => 'created' ,'o'=>'<=','v' => $date_to);
				$_SESSION['customer_date_to'] = $date_to;
				
			}
			$_SESSION['filters'] = $filters;
		}
		
		$where = " where user_id != 0 ";
		if (isset($_SESSION['customer_date_from'])) 	$where .= " and created >= " . $_SESSION['customer_date_from'];
		if (isset($_SESSION['customer_date_to'])) 	$where .= " and created <= " . $_SESSION['customer_date_to'];
		
		$payments = $GLOBALS['core.sql']->getAll("select * from #p#payment $where ");
		
		$uh = new UserHolder();
		$users = $uh->getAllWithFullData();
		
		$customers = array();
		
		foreach ($payments as $key => $value)
		{
			if (!isset($customers[$value['user_id']]))	
			{
				$customers[$value['user_id']] = $users[$value['user_id']];
				$customers[$value['user_id']]['payments_count'] = 0;
				$customers[$value['user_id']]['payments_total'] = 0;
			}
			$value['products'] = unserialize($value['cart_info']);
			$customers[$value['user_id']]['payments'][] = $value;
			$customers[$value['user_id']]['payments_count'] ++;
			$customers[$value['user_id']]['payments_total'] += $value['total'];
		}

		$GLOBALS['core.smarty']->assign('customers', $customers);
		
		$list = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ",array(),'id');
		$GLOBALS['core.smarty']->assign('shipping_list',$list);
		
		if (isset($_SESSION['customer_date_from'])) 	$GLOBALS['core.smarty']->assign('date_from',$_SESSION['customer_date_from']);
		if (isset($_SESSION['customer_date_to'])) 	$GLOBALS['core.smarty']->assign('date_to',$_SESSION['customer_date_to']);
		
		$this->load_lists();
		
		return Admin_Header::out('customer_report');
	}
	
	function load_lists()
	{
		$ph = new ProductHolder();
		$products = $ph->getAll();
		$GLOBALS['core.smarty']->assign('products',$products);
		
		$options = $ph->getAllOptions();
		$GLOBALS['core.smarty']->assign('options',$options);
		
		$dm = new DropdownManager();
		$dm->load_lists();
	}
}

?>