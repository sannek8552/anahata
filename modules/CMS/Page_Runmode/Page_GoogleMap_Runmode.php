<?php
require_once('classes/CMS/GoogleMap_Holder.php');
class Page_GoogleMap_Runmode extends Runmode 
{
	function Page_GoogleMap_Runmode()
	{
		parent::Runmode();
	}
	
	function process()
	{
		$googlemap_holder = new GoogleMap_Holder($_REQUEST['section']);
		$data = $googlemap_holder->get_data();
                if(isset($data['location']) && $data['location'] != '')
                {
                    $GLOBALS['core.smarty']->assign('location', str_replace(' ', '+', $data['location']));
                }
		$GLOBALS['core.smarty']->assign('googlemap_data', $data);
                if(isset($_REQUEST['street_view']) && $_REQUEST['street_view'] == 1)
                {
                    $GLOBALS['core.smarty']->assign('street_view', 1);
                }
		return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/googlemap_module.tpl');
	}
}
?>