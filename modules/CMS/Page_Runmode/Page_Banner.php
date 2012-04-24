<?php
//require_once('classes/CMS/FAQ_Holder.php');
require_once('classes/CMS/BannerItem.php');

class Page_Banner extends Runmode{
	function Page_Banner(){
		parent::Runmode();
	}
	
	function process()
	{
		$conf = $GLOBALS['core.config']->get_config('templates');
		$banner = new BannerItem($_REQUEST['banner']);
		$data = $banner->get_data();
		$GLOBALS['core.smarty']->assign('data', $data);
//var_dump(substr($data['img, -3, 3));
		$GLOBALS['core.smarty']->assign('swf', substr($data['img'], -3)=='swf');
		$GLOBALS['core.smarty']->assign('banner_id', md5(time().microtime().$data['id']));
		
		return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/banner.tpl');
	}
}
?>