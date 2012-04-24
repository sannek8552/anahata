<?php
require_once('Admin_Header.php');
require_once('classes/CMS/Contact_Holder.php');
require_once('classes/CSV.php');

class Contact_Manager extends Runmode 
{
	function Contact_Manager()
	{
		if($GLOBALS['core.runmode']->get_runmode_name() == 'Contact_Manager')
		{
			$this->base_map[0] = 'action';
			$this->base_map[1] = 'id';
		}
		elseif ($GLOBALS['core.runmode']->get_runmode_name() == 'Contact_Manager_Form')
		{
			$this->base_map[0] = 'contact_id';
			$this->base_map[1] = 'action';
			$this->base_map[2] = 'id';
		}
		elseif ($GLOBALS['core.runmode']->get_runmode_name() == 'Contact_Manager_Entry')
		{
			$this->base_map[0] = 'contact_id';
			$this->base_map[1] = 'action';
			$this->base_map[2] = 'id';
		}
		$GLOBALS['core.smarty']->assign('current_menu', 'Modules');
		$GLOBALS['core.smarty']->assign('current_sub', 'Contact Manager');
		parent::Runmode();
	}
	
	function process()
	{
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$id = null;
			if(isset($_REQUEST['id']))
				$id = $_REQUEST['id'];
			$data = array();
			$data['from_name'] = $_REQUEST['from_name'];
			$data['from_email'] = $_REQUEST['from_email'];
			$data['subject'] = $_REQUEST['subject'];
			$data['mail_text'] = $_REQUEST['mail_text'];
			$data['thank_you_page'] = $_REQUEST['thank_you_page'];
			$contact_holder = new Contact_Holder($id);
			$contact_holder->set_data($data);
			$contact_holder->save();
		}
		
		if(isset($_REQUEST['action']) && 'edit' == $_REQUEST['action'])
		{
			$contact_holder = new Contact_Holder($_REQUEST['id']);
			$edit_data = $contact_holder->get_data();
			$GLOBALS['core.smarty']->assign('edit_data', $edit_data);

		}
		elseif (isset($_REQUEST['action']) && 'delete' == $_REQUEST['action'])
		{
			$contact_holder = new Contact_Holder($_REQUEST['id']);
			$contact_holder->delete();
		}
		elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'make_csv')
		{
			$contact_holder = new Contact_Holder($_REQUEST['id']);
			$contact_holder->make_csv();
			return '';
			
		}
		
		$settings = Contact_Holder::get_all();
		$GLOBALS['core.smarty']->assign('settings', $settings);
		
		return Admin_Header::out('CMS/Page_Runmode/contact_manager');
	}
	
	function process_form()
	{
		$contact_id = $_REQUEST['contact_id'];
		
		$contact_holder = new Contact_Holder($contact_id);
		$contact_data = $contact_holder->get_data();
		$GLOBALS['core.smarty']->assign('contact_data', $contact_data);
		
		$GLOBALS['core.smarty']->assign('contact_id', $contact_id);
		
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			//need to save form values
			$id = null;
			if(isset($_REQUEST['id']))
				$id = $_REQUEST['id'];
			$form_holder = $contact_holder->get_formholder($id);
			
			$data = array();
			$data['field_name'] = $_REQUEST['field_name'];
			$data['field_type'] = $_REQUEST['field_type'];
			$data['field_validation'] = $_REQUEST['field_validation'];
			$data['field_error'] = $_REQUEST['field_error'];
			$data['order_id'] = $_REQUEST['order_id'];
			
			
			$form_holder->set_data($data);
			$select_answer = isset($_REQUEST['select_answer']) ? $_REQUEST['select_answer'] : array();
			$form_holder->set_answer($select_answer);
			
			$file_types = isset($_REQUEST['file_type']) ? $_REQUEST['file_type'] : '';
			$form_holder->set_types($file_types);
			$form_holder->save();
		}
		elseif (isset($_REQUEST['action']) && 'edit' == $_REQUEST['action'])
		{
			$form_holder = $contact_holder->get_formholder($_REQUEST['id']);
			$edit_data = $form_holder->get_data();
			$GLOBALS['core.smarty']->assign('edit_data', $edit_data);
                       
		}
		elseif (isset($_REQUEST['action']) && 'delete' == $_REQUEST['action'])
		{
			$form_holder = $contact_holder->get_formholder($_REQUEST['id']);
			Contact_Holder::delete_file_types($_REQUEST['id']);
			$form_holder->delete();
		}
		
		// here we need to display already entered form fields
		$fields = Contact_Form_Holder::get_all($contact_id);
		$GLOBALS['core.smarty']->assign('fields', $fields);
		
		return Admin_Header::out('CMS/Page_Runmode/contact_manager_form');
	}
	
	function process_entry()
	{
		$contact_id = $_REQUEST['contact_id'];
		$contact_holder = new Contact_Holder($contact_id);
		if(isset($_REQUEST['action']) && 'delete' == $_REQUEST['action'])
		{
			Contact_Holder::delete_files($_REQUEST['id']);
			$contact_holder->delete_entry($_REQUEST['id']);
		}
		
		$entries = $contact_holder->get_entries();
                $edit_data = $contact_holder->get_data();
		foreach ($entries as $key => $value)
		{
			$entries[$key]['entry'] = unserialize($value['entry']);
		}
		$GLOBALS['core.smarty']->assign('contact_id', $contact_id);
		$GLOBALS['core.smarty']->assign('edit_data', $edit_data);
		$GLOBALS['core.smarty']->assign('entries', $entries);
                //pp($entries);
                //pp($edit_data);
		
		return Admin_Header::out('CMS/Page_Runmode/contact_manager_entry');
	}
}
?>