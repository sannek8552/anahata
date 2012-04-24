<?php
require_once('classes/CMS/FAQ_Holder.php');
require_once('classes/CMS/FAQ_Mass_Entry_Holder.php');
require_once('CMS/SettingsHolder.php');;
class Page_FAQ_Runmode extends Runmode 
{
    function Page_FAQ_Runmode()
    {
        parent::Runmode();
    }
	
    function process()
    {
        $faq_holder = new FAQ_Holder($_REQUEST['section']);
        $faq_data = $faq_holder->get_data();
        $fmeh = new FAQ_Mass_Entry_Holder();
        $faq_entries = $faq_holder->get_entries();
        $GLOBALS['core.smarty']->assign('faq_name', $faq_data['name']);
        $GLOBALS['core.smarty']->assign('faq_data', $faq_data);
        $GLOBALS['core.smarty']->assign('faq_entries', $faq_entries);
        $GLOBALS['core.smarty']->assign('entries', $fmeh->group_by_entries($_REQUEST['section']));
        $GLOBALS['core.smarty']->assign('to_init_faq',  "accordion = new Accordion('h3.atStart', 'div.atStart', {"
                ."}, $('faq_accordion'));");

        return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/FAQ/faq_module.tpl');
    }
    function process_ajax()
    {
        $to_out = array();
        if(isset($_REQUEST['q']))
        {
            $_REQUEST = $_REQUEST['q'];
        }

        if(isset($_REQUEST['send']) && !empty($_REQUEST['send']))
        {
            if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
            {
                $to_out['success'] = 0;
                $entry = new FAQ_Mass_Entry_Holder();
                $entry->set_data(array('name' => $_REQUEST['name'], 'email' => $_REQUEST['email'], 'question' => $_REQUEST['question'], 'faq_entry_id' => $_REQUEST['id']));
                $entry->save();
                //send note
                $to_out['html'] = $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/FAQ/report_ask.tpl');
                $sh = new SettingsHolder();
                $settings = $sh->getSettings();
                $GLOBALS['core.mail']->addAddress($settings['smtp_admin_email']);
                $GLOBALS['core.mail']->isHTML(true);
                $GLOBALS['core.smarty']->assign('data', $entry->get_data());
                $GLOBALS['core.smarty']->assign('section_name', $_REQUEST['section_name']);
                if(isset($settings['smtp_check']) && $settings['smtp_check'] == 1)
                {
                    $GLOBALS['core.mail']->isSMTP(true);
                    $GLOBALS['core.mail']->setUser($settings['smtp_username']);
                    $GLOBALS['core.mail']->setPassword($settings['smtp_password']);
                    $GLOBALS['core.mail']->setPort($settings['smtp_port']);
                    $GLOBALS['core.mail']->setServer($settings['smtp_server']);
                }
                $GLOBALS['core.mail']->setFromName($settings['smtp_admin_from']);
                $GLOBALS['core.mail']->setSubject($settings['faq_admin_subject']);
                $GLOBALS['core.mail']->setFrom($settings['smtp_admin_from']);
                $GLOBALS['core.mail']->setBody($GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/FAQ/faq_mail_admin.tpl'));
                
                $GLOBALS['core.mail']->send();

                $GLOBALS['core.mail']->addAddress($_REQUEST['email']);
                $GLOBALS['core.mail']->isHTML(true);
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
                $GLOBALS['core.mail']->setBody($GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/FAQ/faq_add_mail_user.tpl'));

                $GLOBALS['core.mail']->send();
            }
        }
        else
        {
            $GLOBALS['core.smarty']->assign('id', $_REQUEST['id']);
            $GLOBALS['core.smarty']->assign('section_name', $_REQUEST['section_name']);
            $to_out['html'] = $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/FAQ/ask_question.tpl');
            $to_out['success'] = 0;
        }
        $GLOBALS['core.ajax']->put_to_output($to_out);
    }
}
?>