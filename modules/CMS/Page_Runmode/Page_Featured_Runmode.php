<?php
require_once('classes/CMS/Featured_Manager_Holder.php');
require_once('classes/ProductHolder.php');
class Page_Featured_Runmode extends Runmode 
{
	function Page_Featured_Runmode()
	{
		parent::Runmode();
	}
	
	function process()
	{
		$entry = $_REQUEST['entry'];
		$holder = new Featured_Manager_Holder($entry);
		$data = $holder->get_data();
		
		$ph = new ProductHolder();
		
		$products = $ph->getForFeaturedSection($data['count'],$data['random']);
		$GLOBALS['core.smarty']->assign('products',$products);

		return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/featured_module.tpl');
	}
}
?>