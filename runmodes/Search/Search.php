<?php
require_once('Common_Header.php');

class Search extends Runmode 
{
	function Search()
	{
		parent::Runmode();
	}
	
	function process()
	{
		$seo_data = array();		
		$seo_data['page_title'] = 'Search';
		$seo_data['keywords'] = 'shdc.com.au, search';
		$seo_data['page_description'] = 'shdc.com.au search page';
		$search_string = (isset($_REQUEST['search_string']) && !empty($_REQUEST['search_string'])) ? $_REQUEST['search_string'] : '';
		
		$GLOBALS['core.smarty']->assign('seo_data', $seo_data);
		$GLOBALS['core.smarty']->assign('search_string', $search_string);
		
		return Common_Header::out('Search/search');
	}
}
?>