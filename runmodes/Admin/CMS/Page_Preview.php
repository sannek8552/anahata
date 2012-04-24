<?php
require_once('Common_Header.php');
class Page_Preview extends Runmode
{
	function Page_Preview()
	{
		
	}
	
	function ajax_process()
	{
            //pp($_REQUEST);
            $_SESSION['preview'] = $_REQUEST;
            if(isset($_REQUEST['action']) && $_REQUEST['action']!='edit') unset($_SESSION['preview']['id']);
		
            $conf = $GLOBALS['core.config']->get_config('templates');
            if(isset($conf)) $out['url'] = $conf['common']['domain_name'].$conf['common']['script_url'];
            $out['success'] = true;
            $GLOBALS['core.ajax']->put_to_output($out);
	}
        function process()
	{
            $data = array();
            if(isset($_SESSION['preview']))
            {
                $data = $_SESSION['preview'];
                $GLOBALS['core.smarty']->assign('data',$data);
                $GLOBALS['core.smarty']->assign('body_as_text', $data['content']);
		$GLOBALS['core.smarty']->assign('seo_data', $data);
		
            }
            return Common_Header::out('', $data['template']);
	}
	
	
}
?>