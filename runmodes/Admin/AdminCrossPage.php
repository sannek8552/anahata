<?php
require_once('Admin_Header.php');
//require_once('modules/CMS/MenuHolder.php');
require_once('classes/CrossPageHolder.php');
//require_once('classes/CategoryHolder.php');

class AdminCrossPage extends Runmode
{
	function AdminCrossPage()
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
                if (isset($_REQUEST['clear']) && !empty($_REQUEST['clear']))
		{
                    if (isset($_REQUEST['pages']) && !empty($_REQUEST['pages']))
                    {
                        $cph = new CrossPageHolder();
                        $cph->batchDeleteCrossPages(array_values($_REQUEST['pages']));
                        
                    }
		}

		$this->load_lists();
		return Admin_Header::out('cross_page');
	}
	
	function process_product_save()
	{
		if (isset($_REQUEST['pages']) && !empty($_REQUEST['pages']))
		{			
			if (isset($_REQUEST['cross_pages']) && !empty($_REQUEST['cross_pages']))
			{
				$cph = new CrossPageHolder();
				//$cph->batchDeleteCrossPages(array_values($_REQUEST['pages']));
				$cph->batchAddCrossPages(array_values($_REQUEST['pages']), array_values($_REQUEST['cross_pages']));
			}
		}
	}
        
	function load_lists()
	{
		$cph = new CrossPageHolder();
                $pages = $cph->getPagesForSelect();
                $cross_pages = $cph->getAllCrossPages();
                //pp($cross_pages);
		
		$GLOBALS['core.smarty']->assign('pages',$pages);
		//$GLOBALS['core.smarty']->assign('categories',$categories);
		$GLOBALS['core.smarty']->assign('cross_pages',$cross_pages);
		
	}
}
?>