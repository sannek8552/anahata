<?php
require_once('Common_Header.php');
require_once('classes/ProductHolder.php');
require_once('classes/CertificateHolder.php');

class MyOrders extends Runmode 
{
	function MyOrders()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		
		parent::Runmode();
	}
	
	function process()
	{
		$user_filter = array('f' => 'user_id','v' => $GLOBALS['core.auth.user']->data['user_id']);		
		
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$filters = array($user_filter);
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
			$GLOBALS['core.list']->set_filters(array($user_filter));
			if (isset($_SESSION['filters'])) unset($_SESSION['filters']);
			if (isset($_SESSION['date_from'])) unset($_SESSION['date_from']);
			if (isset($_SESSION['date_to'])) unset($_SESSION['date_to']);
		}
		else $filters = array($user_filter);
			
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
				
		$page = $GLOBALS['core.list']->get_page($page_num);		
		
		foreach ($page as $key => $value)
		{
			$page[$key]['products'] = unserialize($value['cart_info']);
			$page[$key]['shipping_info'] = unserialize($value['shipping_info']);
		}
		
		$info = $GLOBALS['core.list']->num_pages();
		$GLOBALS['core.smarty']->assign('info',$info);
		$GLOBALS['core.smarty']->assign('page',$page);
				
		if (isset($_SESSION['date_from'])) $GLOBALS['core.smarty']->assign('date_from',$_SESSION['date_from']);
		if (isset($_SESSION['date_to'])) $GLOBALS['core.smarty']->assign('date_to',$_SESSION['date_to']);
		
		/*
		$list = $GLOBALS['core.sql']->getAll("select * from #p#shipping order by created ");
		$GLOBALS['core.smarty']->assign('shipping_list',$list);
		
		$item_list = $GLOBALS['core.sql']->getAll("select * from #p#item_shipping order by created ");
		$GLOBALS['core.smarty']->assign('item_shipping_list',$item_list);				
		*/
		
		$this->load_lists();
		return Common_Header::out('User/MyOrders');
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