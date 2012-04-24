<?php
require_once('Common_Header.php');
require_once('classes/CMS/SettingsHolder.php');
require_once('classes/BrandHolder.php');
require_once('classes/CategoryHolder.php');

class Brands extends Runmode 
{
	var $items_per_page;
	
	function Brands()
	{
		$this->base_map[0] = 'brand_seo';
		$this->base_map[1] = 'page';
		parent::Runmode();

		$this->items_per_page = 12;
	}
	
	function process()
	{		
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && $_REQUEST['page'] > 0) $page = $_REQUEST['page'];
		else $page = 1;
		
		if (isset($_REQUEST['brand_id']) && !empty($_REQUEST['brand_id']))
		{
			$bh = new BrandHolder($_REQUEST['brand_id']);
			$brand = $bh->get_data();
			$GLOBALS['core.smarty']->assign('brand', $brand);
		}
		
		if (isset($_REQUEST['brand_seo']) && !empty($_REQUEST['brand_seo']))
		{
			$bh = new BrandHolder();			
			$bh->loadBySeo($_REQUEST['brand_seo']);			
			$brand = $bh->get_data();
			$GLOBALS['core.smarty']->assign('brand', $brand);
			$_REQUEST['brand_id'] = $bh->get_key_value();
		}
		
		if (isset($brand)) {
                    $GLOBALS['core.smarty']->assign('seo_data',$brand);
                    $GLOBALS['core.smarty']->assign('brand_id',$brand['id']);
                }
                else {
                    $bh = new BrandHolder();
                    $brands = $bh->get_all();
                    $GLOBALS['core.smarty']->assign('brands', $brands);
                }
		
		$category_ids = array();
		
		$ph = new ProductHolder();
		$products = $ph->getAll();
		
		foreach ($products as $key => $value)
		{
			if (isset($_REQUEST['brand_id']) && !empty($_REQUEST['brand_id']) && $value['brand_id'] != $_REQUEST['brand_id'])
			{
				unset($products[$key]);
				continue;
			}
			if ($value['inactive'] == 1) {unset($products[$key]);continue;}

			if (isset($value['category_id']) && !empty($value['category_id']) && !in_array($value['category_id'], $category_ids)) $category_ids[$value['category_id']] = $value['category_id'];
		}
		
		$page_count = ceil(count($products) / $this->items_per_page);
		$page_array = array();
		for ($i = 1; $i <= $page_count; $i++) $page_array[$i] = $i;
		$GLOBALS['core.smarty']->assign('page_array',$page_array);
		$GLOBALS['core.smarty']->assign('page',$page);
		$GLOBALS['core.smarty']->assign('page_count', $page_count);
                $GLOBALS['core.smarty']->assign('product_count', count($products));
		//pp($products);
		$products = array_slice($products,($page - 1)*$this->items_per_page,$this->items_per_page);
		
		$tmp = array();
		$new_products = array();
		foreach ($products as $key => $value)
		{			
			if (count($tmp) == 3)
			{
				$new_products[] = $tmp;
				$tmp = array();
			}
			$tmp[$key] = $value;
		}
		if (!empty($tmp))	$new_products[] = $tmp;		
		
		$GLOBALS['core.smarty']->assign('products',$new_products);

		$ph->load_lists();
		
		$ch = new CategoryHolder();
		$ch->loadCategoriesForSelect();
		$tree = $ch->getTree();		
		$tree = $this->process_tree($tree, $category_ids);		
		$GLOBALS['core.smarty']->assign('cat_tree', $tree);
		
		$GLOBALS['core.smarty']->assign('cat_ids', $category_ids);
		
		return Common_Header::out('Common/brands');
	}
	
	function process_tree($tree, $ids)
	{
		foreach ($tree as $key => $value)
		{
			if (isset($value['sub_ids']))
			{
				if (array_intersect($value['sub_ids'], $ids))
					$tree[$key]['sub'] = $this->process_tree($value['sub'], $ids);
				elseif (!in_array($key, $ids))
					unset($tree[$key]);
			}
			elseif (!in_array($key, $ids)) unset($tree[$key]);
		}
		return $tree;
	}
}

?>