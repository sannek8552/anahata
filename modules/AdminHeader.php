<?php
class AdminHeader
{
	function out($template = '')
	{
		$conf = $GLOBALS['core.config']->get_config('templates');
		if (isset($conf['common']['site_url'])) $GLOBALS['core.smarty']->assign('ajax_prefix',$conf['common']['site_url']);
		if (isset($conf['common']['img_url'])) $GLOBALS['core.smarty']->assign('img_prefix',$conf['common']['img_url']);
		
		
		if(!empty($template))
		{
			$GLOBALS['core.smarty']->assign('body', $GLOBALS['core.smarty']->fetch($template . '.tpl'));
		}
		return $GLOBALS['core.smarty']->fetch('Admin/admin_header.tpl');		
	}
}
?>