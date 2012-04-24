<?php
require_once('Common_Header.php');
require_once('classes/Specials/SpecialHolder.php');
require_once('classes/ProductHolder.php');

class Specials extends Runmode 
{
	var $items_per_page = 10;
	
	function Specials()
	{
		$this->base_map[0] = 'page';
		
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['page']) && !empty($_REQUEST['page']) && $_REQUEST['page'] > 0) $page = $_REQUEST['page'];
		else $page = 1;
		
		$sh = new SpecialHolder();
		$specials = $sh->calculateAllSpecials();
		
		$page_count = ceil(count($specials) / $this->items_per_page);
		$page_array = array();
		for ($i = 1; $i <= $page_count; $i++) $page_array[$i] = $i;
		$GLOBALS['core.smarty']->assign('page_array',$page_array);
		$GLOBALS['core.smarty']->assign('page',$page);
		
		$specials = array_slice($specials,($page - 1)*$this->items_per_page,$this->items_per_page);		
		$GLOBALS['core.smarty']->assign('specials',$specials);

		$ph = new ProductHolder();
		$ph->load_lists();
		
		return Common_Header::out('Common/specials');
	}
}

?>