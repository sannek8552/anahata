<?php
require_once('Common_Header.php');
require_once('classes/CategoryHolder.php');
require_once('classes/LashHolder.php');
require_once('classes/SettingsHolder.php');
class Category_Preview extends Runmode
{
	function Category_Preview()
	{
		
	}
	
	function ajax_process()
	{
            //pp($_REQUEST);exit();
            $_SESSION['preview'] = $_REQUEST;
            if(isset($_REQUEST['action']) && $_REQUEST['action']!='edit') unset($_SESSION['preview']['id']);
		
            $conf = $GLOBALS['core.config']->get_config('templates');
            if(isset($conf)) $out['url'] = $conf['common']['domain_name'].$conf['common']['script_url'];
            $out['success'] = true;
            $GLOBALS['core.ajax']->put_to_output($out);
	}

	
        function process()
	{	
                $data = isset($_SESSION['preview'])?$_SESSION['preview']:'';
                
                if(!empty($data))
                {
                        $id = isset($data['id'])?$data['id']:0;
                        if (!empty($id))
                        {
                                $category = new CategoryHolder($id);
                                $this->load_open_cats($id);
                                $childs = $category->getChilds();
                                $GLOBALS['core.smarty']->assign('current_category',$data);
                                $GLOBALS['core.smarty']->assign('childs', $childs);


                        }
                        else
                        {
                                $GLOBALS['core.smarty']->assign('current_subcat',$data);
                                $GLOBALS['core.smarty']->assign('products',array());
                                $GLOBALS['core.smarty']->assign('products_count',0);
                                $GLOBALS['core.smarty']->assign('pages',array(1));
                                $GLOBALS['core.smarty']->assign('page',1);
                                $GLOBALS['core.smarty']->assign('pages_count', 1);
                        }
                        
                        //$GLOBALS['core.smarty']->assign('current_category',$data);
                        $GLOBALS['core.smarty']->assign('seo_data',$data);
                }
		return Common_Header::out('Common/category');
	}
	
	function load_subcategory($id)
	{
		$sub = new CategoryHolder($id);
		$data = $sub->get_data();
		$this->load_open_cats($data['parent_id']);		
		$GLOBALS['core.smarty']->assign('current_subcat',$data);
		
		$ph = new ProductHolder();
		$products = $ph->getByCategory($id,true);

		$new_products = array();
		$tmp = array();
		foreach ($products as $key => $value)
		{
			$prh = new ProductHolder($value['id']);
			$value = $prh->get_data();
			
			if (count($tmp) == 3)
			{
				$new_products[] = $tmp;
				$tmp = array();
			}
			$tmp[$key] = $value;
		}
		$new_products[] = $tmp;
		
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && is_numeric($_REQUEST['page'])) $page = $_REQUEST['page'];
		else $page = 1;
		
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		$rpc = $settings['rows_per_category'];
		
		$count = ceil(count($new_products)/$rpc);
		$new_products = array_slice($new_products,($page - 1) * $rpc,$rpc);

		$pages = array();
		for($i = 1; $i <= $count; $i++)	$pages[] = $i;
			
		//pp($new_products);
		$GLOBALS['core.smarty']->assign('products',$new_products);
		$GLOBALS['core.smarty']->assign('products_count',count($products));
		$GLOBALS['core.smarty']->assign('pages',$pages);
		$GLOBALS['core.smarty']->assign('page',$page);
		$GLOBALS['core.smarty']->assign('pages_count', $count);
		//pp($products);
	}
	
	function load_open_cats($parent_id)
	{
		$category = new CategoryHolder($parent_id);
		$category->load_open_cats();
	}
	
}
?>