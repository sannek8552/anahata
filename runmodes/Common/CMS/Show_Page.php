<?php
require_once('Common_Header.php');
//require_once('CMS/Page_Factory.php');
require_once('classes/CMS/Creator/PageHolder.php');
require_once('classes/CMS/Header_Image_Holder.php');
class Show_Page extends Runmode 
{
	function Show_Page()
	{
		if(isset($_REQUEST['rm']))
			$_REQUEST['page_link'] = $_REQUEST['rm'];
		else 
			$_REQUEST['page_link'] = '';
		//$this->base_map[0] = 'param1';
		//parent::Runmode();
	}
	function process()
	{
		$GLOBALS['text_to_init'] = '';
		//$factory = new Page_Factory();
		//$page = $factory->create_by_seo($_REQUEST['page_link'], $menu_id);
		//pp($page);
		
		$page = new PageHolder();
		$result = $page->create_by_seo($_REQUEST['page_link']);
		
		if(!$result)
		{
			//user request not know cms page
			//for now display home page
			//$page = $factory->create_by_seo('', $menu_id);
			$GLOBALS['core.runmode']->init('pear_error_runmode');
			$GLOBALS['core.runmode']->run();
			return '';
		}
		
		//$data = $page->display($menu_id);
		$data = $page->get_data();
		if($data['active'] != 1)
		{
			$GLOBALS['core.runmode']->init('pear_error_runmode');
			$GLOBALS['core.runmode']->run();
			return '';
		}
		
		if(empty($_REQUEST['page_link']))
		{
			//we are from home page not found link
			//$GLOBALS['core.smarty']->assign('seo_url', $data['seo_url']);
			$_REQUEST['page_link'] = $data['seo_url'];
		}
                
                $breadcrumbs = $GLOBALS['core.tree']->get_place($data['id'], 'title', 'id');
		$GLOBALS['core.smarty']->assign('breadcrumbs', $breadcrumbs);

		$GLOBALS['core.smarty']->assign('seo_url', $_REQUEST['page_link']);
		$GLOBALS['core.CMS.seo_url'] = $_REQUEST['page_link'];

		$GLOBALS['core.smarty']->assign('body_as_text', $data['content']);
                //$GLOBALS['core.smarty']->assign('header_image', Header_Image_Holder::getImageById($data['header_image']));
                //pp($data);
		$GLOBALS['core.smarty']->assign('seo_data', $data);
		$GLOBALS['core.smarty']->assign('text_to_init', $GLOBALS['text_to_init']);
                //pp($data);
		
		return Common_Header::out('', $data['template']);
	}
}
?>