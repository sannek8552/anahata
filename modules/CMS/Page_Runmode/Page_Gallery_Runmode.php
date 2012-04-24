<?php
require_once('classes/CMS/Gallery_Holder.php');

class Page_Gallery_Runmode extends Runmode 
{
	function Page_Gallery_Runmode()
	{
		$this->base_map[0] = 'num';
		parent::Runmode();
	}
	
	function process()
	{
		$section = $_REQUEST['section'];
		
		$gallery_holder = new Gallery_Holder($section);
		$p_holder = $gallery_holder->get_picture_holder();
		
		$num = 1;
		if(isset($_REQUEST['num']))
		{
			$num = $_REQUEST['num'];
		}
		
		$p_holder->get_page($num, true);
		return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/gallery_module.tpl');
	}
}
?>