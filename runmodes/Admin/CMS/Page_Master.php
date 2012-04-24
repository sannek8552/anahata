<?php
require_once('AdminHeader.php');
class Page_Master extends Runmode
{
	function Page_Master()
	{
		
	}
	
	function process()
	{
		require_once('CMS/Page_Creator.php');
		$GLOBALS['core.do_not_parse'] = 1;
		$page_creator = new Page_Creator();
		$content = $page_creator->run();
		$GLOBALS['core.smarty']->assign('master_content', $content);
		return AdminHeader::out('Admin/CMS/page_master');
	}
	
	function process_ajax()
	{
		$GLOBALS['core.do_not_parse'] = 1;
		require_once('CMS/Page_Creator.php');
		$page_creator = new Page_Creator();
		$content = $page_creator->run_ajax();
		$GLOBALS['core.ajax']->put_to_output($content);
	}
}
?>