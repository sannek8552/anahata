<?php
require_once('Common_Header.php');
require_once('classes/Specials/SpecialHolder.php');
require_once('classes/ProductHolder.php');
require_once('classes/SettingsHolder.php');

class Products extends Runmode 
{
	var $items_per_page;// = 10;
	
	function Products()
	{
                if (!empty($_REQUEST['params_to_pars']) && $_REQUEST['params_to_pars'][0] == 'search') {
                     $this->base_map[0] = 'action';
                     $this->base_map[1] = 'search_value';
                     $this->base_map[2] = 'page';
                }
                else {
                    $this->base_map[0] = 'page';
                }
		
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		$this->items_per_page = $settings['products_per_page'];
		
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && $_REQUEST['page'] > 0) $page = $_REQUEST['page'];
		else $page = 1;
		
		$sh = new SpecialHolder();
		$specials = $sh->calculateAllSpecials();
		
		$ph = new ProductHolder();
                $products = array();
                if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'search' && isset($_REQUEST['search_value'])) {
                    $products = $ph->searchProducts($_REQUEST['search_value']);
                    $GLOBALS['core.smarty']->assign('search',1);
                    $GLOBALS['core.smarty']->assign('search_value',$_REQUEST['search_value']);
                } else {
                    $products = $ph->getAll();
                }
		
		$options = $ph->getAllOptions();
		$GLOBALS['core.smarty']->assign('options',$options);
		
		$ch = new CategoryHolder();
		$active_categories = $ch->getAll();
		$product_categories = $ch->getCategoriesForAllProducts();
		
		foreach ($products as $key => $value)
		{
			if ($value['inactive'] == 1) {unset($products[$key]);continue;}
			$active = false;
			if (isset($product_categories[$key]))
			{				
				foreach ($product_categories[$key] as $cid => $category)
				{
					if (isset($active_categories[$cid])) $active = true;
				}				
			}
			elseif (isset($active_categories[$value['category_id']])) $active = true;
			
			if (!$active) 
			{
				unset($products[$key]);
				continue;
			}
			
			if (isset($specials[$key])) $products[$key] = $specials[$key];
		}
		
		$page_count = ceil(count($products) / $this->items_per_page);
		$page_array = array();
		for ($i = 1; $i <= $page_count; $i++) $page_array[$i] = $i;
		$GLOBALS['core.smarty']->assign('page_array',$page_array);
		$GLOBALS['core.smarty']->assign('page',$page);
		
		$products = array_slice($products,($page - 1)*$this->items_per_page,$this->items_per_page);
		$GLOBALS['core.smarty']->assign('products',$products);

		$ph->load_lists();

		return Common_Header::out('Common/products');
	}		
}

?>