<?php
require_once('Common_Header.php');
require_once('classes/CategoryHolder.php');
require_once('classes/CMS/SettingsHolder.php');

class Search extends Runmode 
{
	function Search()
	{
		$this->base_map[0] = 'search';
                $this->base_map[1] = 'page';
		parent::Runmode();				
	}
	
	function process()
	{
		
		$GLOBALS['core.list']->custom_init('search_products');
		
		if (isset($_REQUEST['search']) && !empty($_REQUEST['search']))
		{
                    $search = mysql_real_escape_string($_REQUEST['search']);
                    $GLOBALS['core.list']->set_sql(" #p#product.* FROM #p#product WHERE #p#product.name LIKE '%".$search."%' OR #p#product.description LIKE '%$search%' OR #p#product.full_description LIKE '%$search%'", true);
                    $GLOBALS['core.smarty']->assign('search', $_REQUEST['search']);
		}
		
		
		
		

		
		$rpc = 1;
		$cpc = 3;
			
				
		$GLOBALS['core.list']->set_param('items_per_page',$rpc * $cpc);
		$GLOBALS['core.list']->set_param('order_by',array('#p#product.order_no '));
		
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && $_REQUEST['page'] > 0) $page = $_REQUEST['page'];
		else $page = 1; 
		
		$products = $GLOBALS['core.list']->get_page($page);
                $GLOBALS['core.smarty']->assign('products_count', count($products));
                $info = $GLOBALS['core.list']->num_pages();


                
		$tmp = array();
		$new_products = array();
		foreach ($products as $key => $value)
		{			
			if (count($tmp) == $cpc)
			{
				$new_products[] = $tmp;
				$tmp = array();
			}
                        //Добавим название категорий
                        $value['category_name'] = $GLOBALS['core.sql']->getOne("SELECT title FROM #p#category WHERE id = ?", $value['category_id']);
			$tmp[$key] = $value;
		}
		if (!empty($tmp))	$new_products[] = $tmp;
		
		
		//fb($info);
		//pp($filters);
		$n = "";
		
		
		//fb($new_products);
		$GLOBALS['core.smarty']->assign('products', $new_products);
		$GLOBALS['core.smarty']->assign('info', $info);
		$GLOBALS['core.smarty']->assign('page', $page);
	
		return Common_Header::out('Common/search');
	}
}

?>