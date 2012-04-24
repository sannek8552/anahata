<?php
require_once('Admin_Header.php');
require_once('classes/ProductHolder.php');
require_once('classes/CategoryHolder.php');
require_once('classes/CMS/SettingsHolder.php');
require_once('classes/BrandHolder.php');

class LowStockReport extends Runmode 
{
	function LowStockReport()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['action']))
		{
			if ('page' == $_REQUEST['action'])
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))	$page = $_REQUEST['id'];
			}
		}
		
		$GLOBALS['core.list']->custom_init('low_stock_list');
		$GLOBALS['core.list']->set_sql(' #p#product.*, #p#product_option.name as option_name, #p#product_option.quantity as option_quantity 
										 FROM #p#product LEFT OUTER JOIN #p#product_option ON #p#product.id = #p#product_option.product_id ');
		$GLOBALS['core.list']->set_param('items_per_page',30);
		$GLOBALS['core.list']->set_param('order_by',array('quantity,option_quantity'));
		
		$filters = array();
		$filters = $GLOBALS['core.list']->get_filters();
		
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		
		if (isset($settings['low_stock_limit']) && !empty($settings['low_stock_limit']))
		{
			$filters['limit'] = array(
			'sub' => array(
							array(	'sub' => array(
												array('f' => '#p#product.has_options', 'v' => 0),
												array('f' => '#p#product.quantity','v' => $settings['low_stock_limit'], 'o' => '<='),
												'logik' => 'and'
											),
									
							),
							array(	'sub' => array(
												array('f' => '#p#product.has_options', 'v' => 1),
												array('f' => '#p#product_option.quantity', 'v' => $settings['low_stock_limit'], 'o' => '<='),
												'logik' => 'and'
											),							
							),
							'logik' => 'or'
						)			
			);
			
			//$filters['low_stock_limit'] = array('f' => '#p#product.quantity', 'o' => '<=', 'v' => $settings['low_stock_limit']);
		}
				
 		if (isset($_REQUEST['filter']) && !empty($_REQUEST['filter']))
		{
			if (isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id']))
			{
				$ch = new CategoryHolder();
				$products = $ch->getProductsForCategory($_REQUEST['category_id']);
				$products = array_keys($products);				
				if (!empty($products))	$filters['category_id'] = array('f' => '#p#product.id', 'v' => $products, 'o' => 'in', 'cat_id' => $_REQUEST['category_id']);
				else $filters['category_id'] = array('f' => '#p#product.category_id', 'v' => -1);				
			}
			elseif (isset($filters['category_id'])) 
			{
				unset($filters['category_id']);
			}
			
			if (isset($_REQUEST['brand_id']) && !empty($_REQUEST['brand_id']))
			{
				$filters['brand_id'] = array('f' => '#p#product.brand_id' ,'v' => $_REQUEST['brand_id']);
			}
			elseif (isset($filters['brand_id'])) 
			{
				unset($filters['brand_id']);
			}
		}
		
		$GLOBALS['core.list']->set_filters($filters);
		
		$GLOBALS['core.smarty']->assign('filters',$filters);
		
		if (!isset($page)) $page = 1;
		$products = $GLOBALS['core.list']->get_page($page);
		//pp($products);
		//pp($GLOBALS['core.list']);
		$info = $GLOBALS['core.list']->num_pages();
		$GLOBALS['core.smarty']->assign('pages_info',$info);
		$GLOBALS['core.smarty']->assign('products',$products);
		
		$this->load_lists();
		
		return Admin_Header::out('low_stock_report');
	}
	
	function load_lists()
	{
		$ch = new CategoryHolder();	
		$to_ret = $ch->getCategoriesForSelect();
		$GLOBALS['core.smarty']->assign('categories',$to_ret);
		$category_product = $ch->getCategoriesForAllProducts();
		$GLOBALS['core.smarty']->assign('category_product', $category_product);		
		
		$bh = new BrandHolder();
		$GLOBALS['core.smarty']->assign('brands', $bh->get_all());
	}
	
}

?>