<?php
require_once('Common_Header.php');
require_once('classes/ProductHolder.php');

class Discount extends Runmode
{
	function Discount()
	{
		$this->base_map[0] = 'page';
		
		$this->items_per_page = 10;
		
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && $_REQUEST['page'] > 0) $page = $_REQUEST['page'];
		else $page = 1;
		
		$ph = new ProductHolder();
		$products = $ph->getDiscounts();

		$page_count = ceil(count($products) / $this->items_per_page);
		$page_array = array();
		for ($i = 1; $i <= $page_count; $i++) $page_array[$i] = $i;
		$GLOBALS['core.smarty']->assign('page_array',$page_array);
		$GLOBALS['core.smarty']->assign('page',$page);
		
		$products = array_slice($products,($page - 1)*$this->items_per_page,$this->items_per_page);		
		$GLOBALS['core.smarty']->assign('products',$products);

		$ph->load_lists();

		
		return Common_Header::out('Common/discount');
	}
}

?>