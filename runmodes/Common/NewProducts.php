<?php
require_once('Common_Header.php');
require_once('classes/Specials/SpecialHolder.php');
require_once('classes/ProductHolder.php');
require_once('classes/SettingsHolder.php');

class NewProducts extends Runmode 
{
	var $items_per_page;// = 10;	
	var $new_period;
	
	function NewProducts()
	{
		$this->base_map[0] = 'page';
				
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		$this->items_per_page = $settings['products_per_page'];
		$this->new_timeline = time() - 86400 * $settings['new_product_days'];
		
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && $_REQUEST['page'] > 0) $page = $_REQUEST['page'];
		else $page = 1;
		
		$sh = new SpecialHolder();
		$specials = $sh->calculateAllSpecials();
		
		$ph = new ProductHolder();
		$products = $ph->getAll();
		$options = $ph->getAllOptions();
		$GLOBALS['core.smarty']->assign('options',$options);
		//pp($products);
		//pp($specials);
		foreach ($products as $key => $value)
		{
			if ($value['inactive'] == 1 || $value['created'] < $this->new_timeline) {unset($products[$key]);continue;}
			if (isset($specials[$key])) $products[$key] = $specials[$key];
		}
		//pp($products);
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		$rpc = $settings['rows_per_category'];
		$cpc = $settings['columns_per_category'];
		
		$new_products = array();
		$tmp = array();		
		foreach ($products as $key => $value)
		{			
			/*
			$prh = new ProductHolder($key);
			$value = $prh->get_data();
			
			if (count($tmp) == 3)
			{
				$new_products[] = $tmp;
				$tmp = array();
			}
			$tmp[$key] = $value;
			*/
			
			if (count($tmp) == $cpc)
			{
				$new_products[] = $tmp;
				$tmp = array();
			}
			$tmp[$key] = $value;
		}
		$new_products[] = $tmp;
		
		//pp($products);
		
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && is_numeric($_REQUEST['page'])) $page = $_REQUEST['page'];
		else $page = 1;
				
		$count = ceil(count($new_products)/$rpc);
		$new_products = array_slice($new_products,($page - 1) * $rpc,$rpc);

		$pages = array();
		for($i = 1; $i <= $count; $i++)	$pages[] = $i;
			
		//pp($new_products);
		$GLOBALS['core.smarty']->assign('products',$new_products);
		$GLOBALS['core.smarty']->assign('products_count',count($products));
		$GLOBALS['core.smarty']->assign('pages',$pages);
		$GLOBALS['core.smarty']->assign('page',$page);

		$ph->load_lists();

		return Common_Header::out('Common/new_products');
	}
}

?>