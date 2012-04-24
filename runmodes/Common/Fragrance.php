<?php
require_once('Common_Header.php');
require_once('classes/CMS/SettingsHolder.php');
require_once('classes/FragranceHolder.php');
require_once('classes/CategoryHolder.php');

class Fragrance extends Runmode
{
	var $items_per_page;
	
	function __construct()
	{
		$this->base_map[0] = 'fragrance_seo';
		$this->base_map[1] = 'page';
		parent::Runmode();
		
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		$this->items_per_page = $settings['products_per_page'];
	}
	
	function process()
	{		
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && $_REQUEST['page'] > 0) $page = $_REQUEST['page'];
		else $page = 1;

                $fragrance_id = 0;
		if (isset($_REQUEST['fragrance_seo']) && !empty($_REQUEST['fragrance_seo']))
		{
			$fh = new FragranceHolder();
			$fh->loadBySeo($_REQUEST['fragrance_seo']);
                        $fragrance_id = $fh->get_key_value();
		}
                $GLOBALS['core.smarty']->assign('current_fragrance', $fragrance_id);

		$sh = new SpecialHolder();
		$specials = $sh->calculateAllSpecials();
                
                $ph = new ProductHolder();
		$options = $ph->getAllOptions();
		$GLOBALS['core.smarty']->assign('options',$options);

		$ch = new CategoryHolder();
		$active_categories = $ch->getAll();
		$product_categories = $ch->getCategoriesForAllProducts();

                
                $products = $ph->getAllbyFragrance($fragrance_id);

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