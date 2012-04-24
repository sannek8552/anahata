<?php
require_once('classes/CMS/Before_After_Gallery_Portfolio_Holder.php');

class Page_Before_After_Gallery_Portfolio_Runmode extends Runmode{
    
        function Page_Before_After_Gallery_Portfolio_Runmode()
	{
		$this->base_map[0] = 'num';
		parent::Runmode();
	}

        function process()
	{
		$section = $_REQUEST['section'];

		$gallery_holder = new Before_After_Gallery_Portfolio_Holder($section);
		$p_holder = $gallery_holder->get_picture_holder();

		$num = 1;
		if(isset($_REQUEST['num']))
		{
			$num = $_REQUEST['num'];
		}
                //pp($num);
		$p_holder->get_page($num, true);

		return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/before_after_gallery_portfolio_module.tpl');
	}
}
?>
