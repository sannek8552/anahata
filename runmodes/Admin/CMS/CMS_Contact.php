<?php
require_once('Admin_Header.php');
require_once('CMS/Page_Factory.php');
class CMS_Contact extends Runmode 
{
	function CMS_Contact()
	{
		$GLOBALS['core.smarty']->assign('current_menu', 'Modules');
		$GLOBALS['core.smarty']->assign('current_sub', 'Contacts');
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();
	}
	
	function process()
	{
		$factory = new Page_Factory();
		$contact_page = $factory->create('Contact_Page');
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$contact_page->gather_settings();
			$GLOBALS['core.smarty']->assign('updated', 1);
		}
		$settings = $contact_page->get_settings();
		$GLOBALS['core.smarty']->assign('settings', $settings);
		
		if(isset($_REQUEST['action']) && 'delete' == $_REQUEST['action'])
		{
			$contact_page->delete_message($_REQUEST['id']);
		}
		
		$messages = $contact_page->get_messages();
		foreach ($messages as $key => $value)
		{
			$messages[$key]['entry'] = unserialize($value['entry']);
		}
		//pp($messages);
		$GLOBALS['core.smarty']->assign('messages', $messages);
		
		return Admin_Header::out('CMS/cms_contact');
	}
}
?>