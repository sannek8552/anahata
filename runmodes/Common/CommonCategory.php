<?php
require_once('Common_Header.php');
require_once('classes/CategoryHolder.php');
require_once('classes/SettingsHolder.php');
require_once('classes/CertificateHolder.php');
require_once('classes/BrandHolder.php');

class CommonCategory extends Runmode 
{
	function CommonCategory()
	{
		//$this->base_map[0] = 'seo_url';
                $this->base_map[0] = 'id';
		$this->base_map[1] = 'page';
		$this->base_map[2] = 'brand_id';
		parent::Runmode();
	}
	
	function process()
	{
            if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
            {
                    $category = new CategoryHolder($_REQUEST['id']);
                    //$category->loadByUrl($_REQUEST['seo_url']);
                    $GLOBALS['core.smarty']->assign('seo_data',$category->get_data());
                    
                    $id = $_REQUEST['id'];

                    $active = $category->get_data('active');

                    if ($active)
                    {
                            $has_access = $category->checkAccess();

                            if (!$has_access) {
                                    $GLOBALS['core.runmode']->redirect('Login');
                                    return;
                            }
								
                            //top category
                            $this->load_open_cats($id);
                            $childs = $category->getPublishedChilds();
                            //pp($childs);
                            if (count($childs) > 1) {
                                    $GLOBALS['core.smarty']->assign('current_category',$category->get_data());
                                    $GLOBALS['core.smarty']->assign('cur_cat', $_REQUEST['id']);
                                    /*$sh = new SettingsHolder();
                                    $settings = $sh->getSettings();
                                    $rpc = $settings['rows_per_category'];
                                    $cpc = $settings['columns_per_category'];

                                    $new_products = array();
                                    $tmp = array();

                                    foreach ($childs as $key => $value)
                                    {
                                            if (count($tmp) == $cpc)
                                            {
                                                    $new_products[] = $tmp;
                                                    $tmp = array();
                                            }
                                            $tmp[$key] = $value;
                                    }
                                    $new_products[] = $tmp;
                                    pp($new_products);*/
                                    $GLOBALS['core.smarty']->assign('childs', $childs);
                            }
                            elseif (count($childs) == 1) {
                                    $subcat = array_shift($childs);
                                    $this->load_subcategory($subcat['id']);
                            }
                            elseif (count($childs) == 0) {
                                    $this->load_subcategory($id);
                            }

                    }
                    else {
                        $GLOBALS['core.smarty']->assign('category_inactive', 1);
                    }
            }
            return Common_Header::out('Common/category');
	}
	
	function load_subcategory($id)
	{
		$sub = new CategoryHolder($id);
		$data = $sub->get_data();
		$this->load_open_cats($data['parent_id']);		
		$GLOBALS['core.smarty']->assign('current_subcat',$data);
                $GLOBALS['core.smarty']->assign('cur_cat',$data['id']);
		
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		$rpc = $settings['rows_per_category'];
		$cpc = $settings['columns_per_category'];
		
		$bh = new BrandHolder();
		$brands = $bh->get_all();
		
		//get products
		$ph = new ProductHolder();
		if (isset($data['seo_url']) && $data['seo_url'] == 'Certificates')
		{
			$ch = new CertificateHolder();
			$products = $ch->get_all();
		}
		else 
		{
			$products = $ph->getByCategory($id,true);
			$brand_ids = array();
			foreach ($products as $key => $value)
			{
				if (isset($value['brand_id']) && !empty($value['brand_id']))	$brand_ids[] = $value['brand_id'];
				if (isset($_REQUEST['brand_id']) && $value['brand_id'] != $_REQUEST['brand_id']) unset($products[$key]);
			}
			//pp($brand_ids);
			
			if (!empty($brand_ids))
			{
				foreach ($brands as $key => $value)
				{
					if (!in_array($value['id'], $brand_ids))	unset($brands[$key]);
				}
				if (!empty($brands)) $GLOBALS['core.smarty']->assign('category_brands', $brands);
				//pp($brands);
			}
		}

		$new_products = array();
		$tmp = array();		
		$cpc = 3;
                $rpc = 4;
		foreach ($products as $key => $value)
		{
			//$prh = new ProductHolder($value['id']);
			//$value = $prh->get_data();
			
			if (count($tmp) == $cpc)
			{
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
		$GLOBALS['core.smarty']->assign('products_count',count($products));
		$GLOBALS['core.smarty']->assign('pages',$pages);
		$GLOBALS['core.smarty']->assign('page',$page);
		$GLOBALS['core.smarty']->assign('page_count', $count);
                
	}
	
	function load_open_cats($parent_id)
	{
		$category = new CategoryHolder($parent_id);
		$category->load_open_cats();
	}
}
?>