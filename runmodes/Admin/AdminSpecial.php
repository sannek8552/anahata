<?php
require_once('Admin_Header.php');
require_once('classes/ProductHolder.php');
require_once('classes/Specials/SpecialHolder.php');
require_once('classes/CategoryHolder.php');

class AdminSpecial extends Runmode 
{
	function AdminSpecial()
	{
		$this->base_map[0] = 'type';
		parent::Runmode();
	}
	
	function process()
	{
		//pp($_REQUEST);
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			if (isset($_REQUEST['type']))
			{
				if ('product' == $_REQUEST['type'])	$this->process_product_save();
				if ('category' == $_REQUEST['type'])	$this->process_category_save();
			}
		}
		
		if (isset($_REQUEST['remove']) && !empty($_REQUEST['remove']))
		{
			if (isset($_REQUEST['remove']))
			{
				if ('product' == $_REQUEST['type'])	$this->process_product_remove();
				if ('category' == $_REQUEST['type'])	$this->process_category_remove();
			}
		}
		
		$this->load_lists();		
		
		if (isset($_REQUEST['type']) && 'category' == $_REQUEST['type'])
			return Admin_Header::out('Special/admin_special_category');
		else	return Admin_Header::out('Special/admin_special');
	}
	
	function process_product_remove()
	{
		if (isset($_REQUEST['products']) && !empty($_REQUEST['products']))
		{
			$sh = new SpecialHolder();
			$sh->removeOldSpecials('product', $_REQUEST['products']);
		}
	}
	
	function process_category_remove()
	{
		if (isset($_REQUEST['categories']) && !empty($_REQUEST['categories']))
		{
			$sh = new SpecialHolder();
			$sh->removeOldSpecials('category', $_REQUEST['categories']);
		}
	}
	
	function process_product_save()
	{
		if (isset($_REQUEST['products']) && !empty($_REQUEST['products']))
		{
			$sh = new SpecialHolder();
			$res = $sh->specialSave();			
			if (empty($res['errors']))
			{
				$specials = array();
				foreach ($_REQUEST['products'] as $key => $value)
				{
					$data = array();
					$data = $res['data'];
					$data['object_type'] = 'product';
					$data['object_id'] = $value;
					$specials[] = $data;
				}
				$sh->removeOldSpecials('product',$_REQUEST['products']);
				$sh->fastInsert($specials);
			}
			else
			{							
				$_REQUEST['products'][-1] = $_REQUEST['products'][0];				
				$GLOBALS['core.smarty']->assign('special_error',$res['errors']);
				$GLOBALS['core.smarty']->assign('special_data',$res['data']);
				$GLOBALS['core.smarty']->assign('selected_products',array_flip($_REQUEST['products']));
			}
		}
	}
	
	function process_category_save()
	{
		if (isset($_REQUEST['categories']) && !empty($_REQUEST['categories']))
		{
			$sh = new SpecialHolder();
			$res = $sh->specialSave();			
			if (empty($res['errors']))
			{
				$specials = array();
				foreach ($_REQUEST['categories'] as $key => $value)
				{
					$data = array();
					$data = $res['data'];
					$data['object_type'] = 'category';
					$data['object_id'] = $value;
					$specials[] = $data;
				}
				$sh->removeOldSpecials('category',$_REQUEST['categories']);
				$sh->fastInsert($specials);
			}
			else
			{							
				$_REQUEST['categories'][-1] = $_REQUEST['categories'][0];				
				$GLOBALS['core.smarty']->assign('special_error',$res['errors']);
				$GLOBALS['core.smarty']->assign('special_data',$res['data']);
				$GLOBALS['core.smarty']->assign('selected_categories',array_flip($_REQUEST['categories']));
			}
		}
	}
	
	function load_lists()
	{
		$ph = new ProductHolder();
		$products = $ph->getAll();
		
		$ch = new CategoryHolder();
		$categories = $ch->getCategoriesForSelect();
		
		$sh = new SpecialHolder();
		$specials = $sh->getAllProducts();
		$category_specials = $sh->getAllCategories();
		//pp($specials);
		
		$GLOBALS['core.smarty']->assign('products',$products);
		$GLOBALS['core.smarty']->assign('categories',$categories);
		$GLOBALS['core.smarty']->assign('specials',$specials);
		$GLOBALS['core.smarty']->assign('category_specials',$category_specials);
	}
}
?>