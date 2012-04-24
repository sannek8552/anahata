<?php
require_once('Common_Header.php');
require_once('classes/CategoryHolder.php');
require_once('classes/SettingsHolder.php');

class Categories extends Runmode 
{
	var $items_per_page;
	
	function Categories()
	{
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		$this->items_per_page = $settings['categories_per_page'];
		
		$this->base_map[0] = 'page';
		parent::Runmode();
	}

	function process()
	{
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && $_REQUEST['page'] > 0) $page = $_REQUEST['page'];
		else $page = 1;
		
		$ch = new CategoryHolder();
		$tops = $ch->getTops(1);
		$childs = $ch->getBottoms(1);
                
		$page_count = ceil(count($tops) / $this->items_per_page);
		$page_array = array();
		for ($i = 1; $i <= $page_count; $i++) $page_array[$i] = $i;
		$GLOBALS['core.smarty']->assign('page_array',$page_array);
		$GLOBALS['core.smarty']->assign('page',$page);

		$tops = array_slice($tops,($page - 1)*$this->items_per_page,$this->items_per_page);
		$GLOBALS['core.smarty']->assign('tops',$tops);
		$GLOBALS['core.smarty']->assign('childs',$childs);
		//pp($tops);

		return Common_Header::out('Common/categories');
	}
}
?>