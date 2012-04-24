<?php
class Page_Factory
{
	function Factory($name)
	{
	}
	
	/*function page_list()
	{
		$to_return = array();
		$to_return['Simple_Page'] = array('name' => 'Simple', 'page' => 'Simple_Page');
		//$to_return['FAQ_Page'] = array('name' => 'FAQ Page', 'page' => 'FAQ_Page');
		//$to_return['Contact_Page'] = array('name' => 'Contact Us', 'page' => 'Contact_Page');
		//$to_return['Modules_Page'] = array('name' => 'Modules Page', 'page' => 'Module_Page');
		return $to_return;
	}*/
	
	function module_list($name)
	{
		//$to_return = array();
		$to_return = $GLOBALS['core.config']->get_config('modules');
		
		//$to_return['faq_module'] = array('processor' => 'modules/CMS/Page_Runmode/Page_FAQ_Runmode.php','class_name' => 'Page_FAQ_Runmode');
		//$to_return['contact_module'] = array('processor' => 'modules/CMS/Page_Runmode/Page_Contact_Runmode.php','class_name' => 'Page_Contact_Runmode');
		//$to_return['googlemap_module'] = array('processor' => 'modules/CMS/Page_Runmode/Page_GoogleMap_Runmode.php','class_name' => 'Page_GoogleMap_Runmode');
		//$to_return['gallery_module'] = array('processor' => 'modules/CMS/Page_Runmode/Page_Gallery_Runmode.php','class_name' => 'Page_Gallery_Runmode');
		//$to_return['gallery_one_module'] = array('processor' => 'modules/CMS/Page_Runmode/Page_Gallery_One_Runmode.php','class_name' => 'Page_Gallery_One_Runmode');
		//$to_return['contact_news'] = array('processor' => 'modules/CMS/Page_Runmode/Page_Contact_News.php','class_name' => 'Page_Contact_News');

		if(isset($to_return[$name]))
			return $to_return[$name];
		else 
			return array();
	}

	function &create()
	{
		require_once('CMS/Page_Modules/Simple_Page.php');
		$item = new Simple_Page();
		return $item;
	}
	
	function &create_by_id()
	{
		$page_list = $this->page_list();
		$menu_id = $_REQUEST['edit_id'];
		$type = $GLOBALS['core.sql']->getOne('SELECT page_type FROM ' . $GLOBALS['core.store']->prefix . 'menu_attribute WHERE menu_id = ?',array($menu_id));
		return $type;
		//return $this->create($type);
	}
	
	function &create_by_seo($seo_url = '', &$menu_id)
	{
		if(empty($seo_url))
		{
			$menu_id = 1;
			return $this->create($GLOBALS['core.sql']->getOne('SELECT page_type FROM #p#menu_attribute WHERE menu_id = ?',array(1)));
		}
		else 
		{
			$res =  $GLOBALS['core.sql']->getRow('SELECT page_type, menu_id FROM #p#menu_attribute as m_a INNER JOIN #p#menu as m ON m.id=m_a.menu_id WHERE seo_url = ? LIMIT 1',array($seo_url));
			if(empty($res))
			{
				//here we need to make interface to fetch default 404 page
			}
			if(!empty($res))
			{
				$menu_id = $res['menu_id'];
				return $this->create($res['page_type']);
			}
			else 
			{
				$temp = null;
				return $temp;
			}
		}
			
	}
}
?>