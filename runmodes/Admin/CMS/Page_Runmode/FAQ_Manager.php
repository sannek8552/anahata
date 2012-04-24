<?php
require_once('Admin_Header.php');
require_once('classes/CMS/FAQ_Holder.php');
require_once('classes/CMS/FAQ_Mass_Entry_Holder.php');
require_once('CMS/SettingsHolder.php');

class FAQ_Manager extends Runmode 
{
	function FAQ_Manager()
	{
            $GLOBALS['core.smarty']->assign('current_sub', 'FAQ Manager');
            $GLOBALS['core.smarty']->assign('current_menu','Modules');
            if($GLOBALS['core.runmode']->get_runmode_name() == 'FAQ_Manager')
            {
                $this->base_map[0] = 'action';
                $this->base_map[1] = 'id';
            }
            elseif ($GLOBALS['core.runmode']->get_runmode_name() == 'FAQ_Manager_Entry')
            {
                $this->base_map[0] = 'faq_id';
                
            }
            elseif($GLOBALS['core.runmode']->get_runmode_name() == 'FAQ_Manager_User_Entry')
            {
                $this->base_map[0] = 'faq_id';
                $this->base_map[1] = 'action';
                $this->base_map[2] = 'user_entry_id';
            }
            parent::Runmode();
	}
	
	function process()
	{
            if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
            {
                $data = array();
                $data['name'] = $_REQUEST['section_name'];
                if(isset($_REQUEST['user_questions']) && $_REQUEST['user_questions'] != '')
                {
                    $data['user_questions'] = 1;
                }
                else
                {
                    $data['user_questions'] = 0;
                }
                $id = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
                $faq_holder = new FAQ_Holder($id);
                $faq_holder->set_data($data);
                $faq_holder->save();
                $GLOBALS['core.smarty']->assign('status_code', 's_save_section');
            }

            if(isset($_REQUEST['action']) && 'edit' == $_REQUEST['action'])
            {
                $faq_holder = new FAQ_Holder($_REQUEST['id']);
                $edit_data = $faq_holder->get_data();
                $GLOBALS['core.smarty']->assign('edit_data', $edit_data);
            }
            elseif (isset($_REQUEST['action']) && 'delete' == $_REQUEST['action'])
            {
                $faq_holder = new FAQ_Holder($_REQUEST['id']);
                $faq_holder->delete();
            }

            $sections = FAQ_Holder::get_all();
            $GLOBALS['core.smarty']->assign('sections', $sections);
            $fmeh = new FAQ_Mass_Entry_Holder();
             //FAQ_Mass_Entry_Holder::count_mass_entries();
             $GLOBALS['core.smarty']->assign('c_mass', $fmeh->count_mass_entries());

            return Admin_Header::out('CMS/Page_Runmode/FAQ/faq_manager');
	}
	
	function faq_entry()
	{
            $faq_id = $_REQUEST['faq_id'];

            $faq_holder = new FAQ_Holder($faq_id);
            $faq_data = $faq_holder->get_data();

            $faq_entries = $faq_holder->get_entries();
            foreach ($faq_entries as $key => $value)
            {
                $faq_entries[$key]['content'] = str_replace("\n",'',$value['content']);
                $faq_entries[$key]['content'] = str_replace("\r",'',$faq_entries[$key]['content']);
            }
            $GLOBALS['core.smarty']->assign('faq_entries', $faq_entries);
            $GLOBALS['core.smarty']->assign('faq_data', $faq_data);

            return Admin_Header::out('CMS/Page_Runmode/FAQ/faq_manager_entry');
	}
	
	function faq_entry_ajax()
	{
            //pp($_REQUEST);
            $faq_id = $_REQUEST['faq_id'];
            $faq_holder = new FAQ_Holder($faq_id);
            $faq_holder->add_entries($_REQUEST['faq_entries']);
            $GLOBALS['core.ajax']->put_to_output(array('status' => true));
	}
        function process_user_question()
        {
            if(isset($_REQUEST['faq_id']) && is_numeric($_REQUEST['faq_id']))
            {
                if(isset($_REQUEST['user_entry_id']) && is_numeric($_REQUEST['user_entry_id']))
                {
                    $fmeh = new FAQ_Mass_Entry_Holder($_REQUEST['user_entry_id']);
                }
                else
                {
                    $fmeh = new FAQ_Mass_Entry_Holder();
                }
                $fh = new FAQ_Holder($_REQUEST['faq_id']);
                if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
                {
                    $fmeh->delete();
                }
                $GLOBALS['core.smarty']->assign('faq_id', $_REQUEST['faq_id']);
                $GLOBALS['core.smarty']->assign('faq_entries', $fh->get_entries());
                $GLOBALS['core.smarty']->assign('entries', $fmeh->group_by_entries($_REQUEST['faq_id']));

                return Admin_Header::out('CMS/Page_Runmode/FAQ/user_questions');
            }
        }
        function process_anwer_ajax()
        {
            if(isset($_REQUEST['q']))
            {
                $_REQUEST = $_REQUEST['q'];
            }
            if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
            {
                $fmeh = new FAQ_Mass_Entry_Holder($_REQUEST['id']);
            }
            if(isset($_REQUEST['faq_id']) && is_numeric($_REQUEST['faq_id']))
            {
                $GLOBALS['core.smarty']->assign('faq_id', $_REQUEST['faq_id']);
            }
            $out_data = array();
            $out_data['success'] = 0;
            if(isset($_REQUEST['send']) && !empty($_REQUEST['send']))
            {
                $data = array();
                $data['question'] = $_REQUEST['question'];
                $data['answer'] = $_REQUEST['answer'];                
                if(isset($_REQUEST['publish']) && !empty($_REQUEST['publish']))
                {
                    $data['publish'] = 1;
                }
                else
                {
                    $data['publish'] = 0;
                }
                $send_mail = false;
                if($fmeh->get_data('notice') != 1)
                {
                    $send_mail = true;
                    $data['notice'] = 1;
                }
                $fmeh->set_data($data);
                $fmeh->save();
                $GLOBALS['core.mail']->addAddress($fmeh->get_data('email'));
                $GLOBALS['core.mail']->isHTML(true);
                if($send_mail)
                {
                    $sh = new SettingsHolder();
                    $settings = $sh->getSettings();
                    if(isset($settings['smtp_check']) && $settings['smtp_check'] == 1)
                    {
                        $GLOBALS['core.mail']->isSMTP(true);
                        $GLOBALS['core.mail']->setUser($settings['smtp_username']);
                        $GLOBALS['core.mail']->setPassword($settings['smtp_password']);
                        $GLOBALS['core.mail']->setPort($settings['smtp_port']);
                        $GLOBALS['core.mail']->setServer($settings['smtp_server']);
                    }
                    $GLOBALS['core.mail']->setFromName($settings['smtp_admin_from']);
                    $GLOBALS['core.mail']->setSubject($settings['faq_user_subject']);
                    $GLOBALS['core.mail']->setFrom($settings['smtp_admin_from']);
                    $GLOBALS['core.smarty']->assign('entry', $fmeh->get_data());
                    $GLOBALS['core.mail']->setBody($GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/FAQ/faq_mail_user.tpl'));
                    $GLOBALS['core.mail']->send();
                }
                $GLOBALS['core.runmode']->redirect('FAQ_Manager_User_Entry/'.$_REQUEST['faq_id']);
                return '';
            }
            $GLOBALS['core.smarty']->assign('entry', $fmeh->get_data());
            $GLOBALS['core.smarty']->assign('id', $fmeh->get_key_value());
            
            $out_data['html'] = $GLOBALS['core.smarty']->fetch('Admin/CMS/Page_Runmode/FAQ/answer_form.tpl');
            
            $GLOBALS['core.ajax']->put_to_output($out_data);
        }
}
?>