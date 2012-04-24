<?php
require_once('Admin_Header.php');
require_once('classes/ProductHolder.php');
require_once('classes/CrossSellHolder.php');
require_once('classes/CategoryHolder.php');

class AdminCrossSell extends Runmode 
{
	function AdminCrossSell()
	{
		$this->base_map[0] = 'type';
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$this->process_product_save();
		}

		$this->load_lists();
		return Admin_Header::out('cross_sell');
	}
	
	function process_product_save()
	{
		if (isset($_REQUEST['products']) && !empty($_REQUEST['products']))
		{			
			if (isset($_REQUEST['cross_products']) && !empty($_REQUEST['cross_products']))
			{
				$csh = new CrossSellHolder();
				$csh->batchDeleteCrossSells(array_values($_REQUEST['products']));
				$csh->batchAddCrossSells(array_values($_REQUEST['products']), array_values($_REQUEST['cross_products']));
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
				
		$csh = new CrossSellHolder();
		$cross_sells = $csh->getAllCrossSells();
		
		$GLOBALS['core.smarty']->assign('products',$products);
		$GLOBALS['core.smarty']->assign('categories',$categories);
		$GLOBALS['core.smarty']->assign('cross_sells',$cross_sells);
		
	}
}
?>