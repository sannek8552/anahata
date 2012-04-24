<?php
require_once('Common_Header.php');
require_once('classes/ProductHolder.php');
require_once('classes/SettingsHolder.php');

class Featured extends Runmode 
{
	function Featured()
	{
		$this->base_map[0] = 'page';
		
		//$sh = new SettingsHolder();
		//$settings = $sh->getSettings();
		//$this->items_per_page = 9;
		
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && $_REQUEST['page'] > 0) $page = $_REQUEST['page'];
		else $page = 1;
		
		$ph = new ProductHolder();
		$products = $ph->getFeatured();

		$new_products = array();
		$tmp = array();
		$cpc = 3;
                $rpc = 4;
		foreach ($products as $key => $value)
		{

			if (count($tmp) == $cpc) {
				$new_products[] = $tmp;
				$tmp = array();
			}
			$tmp[$key] = $value;
		}
		$new_products[] = $tmp;

		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && is_numeric($_REQUEST['page'])) $page = $_REQUEST['page'];
		else $page = 1;

		$count = ceil(count($new_products)/$rpc);


		$new_products = array_slice($new_products,($page - 1) * $rpc,$rpc);

		$pages = array();
		for($i = 1; $i <= $count; $i++)	$pages[] = $i;
		//pp($new_products);
		$GLOBALS['core.smarty']->assign('products',$new_products);
                //pp($new_products);
		$GLOBALS['core.smarty']->assign('products_count',count($products));
		$GLOBALS['core.smarty']->assign('pages',$pages);
		$GLOBALS['core.smarty']->assign('page',$page);
		$GLOBALS['core.smarty']->assign('page_count', $count);

		$ph->load_lists();

		
		return Common_Header::out('Common/featured');
	}
}

?>