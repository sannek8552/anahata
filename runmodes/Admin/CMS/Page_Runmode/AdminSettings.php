<?php
require_once('Admin_Header.php');
require_once('CMS/SettingsHolder.php');

class AdminSettings extends Runmode 
{
	var $settings = array(														
                                array(  'title' => 'SMTP settings',
                                        'save_name' => 'smtp_settings',
                                        'success_message' => 'Settings changed',
                                        'fields' => array(
                                                            array('name' => 'smtp_check', 'alias' => 'SMTP send', 'type' => 'bool'),
                                                            array('name' => 'smtp_admin_email', 'alias' => 'Admin Email', 'type' => 'string'),
                                                            array('name' => 'smtp_from_email', 'alias' => 'From Email', 'type' => 'string'),
                                                            array('name' => 'smtp_admin_subject', 'alias' => 'Admin Subject', 'type' => 'string'),
                                                            array('name' => 'smtp_server', 'alias' => 'SMTP server', 'type' => 'string'),
                                                            array('name' => 'smtp_port', 'alias' => 'SMTP port', 'type' => 'int'),
                                                            array('name' => 'smtp_username', 'alias' => 'Username', 'type' => 'string'),
                                                            array('name' => 'smtp_password', 'alias' => 'Password', 'type' => 'password')
                                                        )
                                    ),
                                array(  'title' => 'FAQ settings',
                                    'save_name' => 'faq_settings',
                                    'success_message' => 'Settings changed',
                                    'fields' => array(
                                                        array('name' => 'faq_admin_subject', 'alias' => 'Admin FAQ Subject', 'type' => 'string'),
                                                        array('name' => 'faq_user_subject', 'alias' => 'User FAQ Subject', 'type' => 'string')
                                                    )
                                    ),
                                array(  'title' => 'Blog settings',
                                'save_name' => 'blog_settings',
                                'success_message' => 'Settings changed',
                                'fields' => array(
                                                    array('name' => 'blog_user', 'alias' => 'Blog User', 'type' => 'string'),
                                                    array('name' => 'blog_password', 'alias' => 'Blog Password', 'type' => 'password'),
                                                    array('name' => 'blog_login_page', 'alias' => 'Blog Login Page', 'type' => 'string'),
                                                    array('name' => 'blog_redirect_page', 'alias' => 'Blog Redirect Page', 'type' => 'string')
                                                )
                                ),
                                array(  'title' => 'Cross pages',
                                'save_name' => 'cross_settings',
                                'success_message' => 'Settings changed',
                                'fields' => array(
                                                    array('name' => 'cross_show_on_left', 'alias' => 'Show in side menu', 'type' => 'bool'),
                                                    array('name' => 'cross_show_sub_pages', 'alias' => 'Automatically display sub pages', 'type' => 'bool')

                                                )
                                ),
                                array(  'title' => 'Google Analytics',
                                'save_name' => 'analytics_settings',
                                'success_message' => 'Settings changed',
                                'fields' => array(
                                                    array('name' => 'analytics_login', 'alias' => 'Login', 'type' => 'string'),
                                                    array('name' => 'analytics_password', 'alias' => 'Password', 'type' => 'password'),
                                                    array('name' => 'analytics_profile_id', 'alias' => 'Profile id', 'type' => 'string')
                                                )
                                ),
                                array(  'title' => 'Side Box',
                                'save_name' => 'side_box_settings',
                                'success_message' => 'Settings changed',
                                'fields' => array(
                                                    array('name' => 'side_box_show', 'alias' => 'Show side box', 'type' => 'bool')

                                                )
                                ),
                                array(  'title' => 'Registration',
                                'save_name' => 'registration_settings',
                                'success_message' => 'Settings changed',
                                'fields' => array(
                                                    array('name' => 'registration_captcha_enable', 'alias' => 'Enable CAPTCHA', 'type' => 'bool'),
					            array('name' => 'registration_terms_enable', 'alias' => 'Enable terms and conditions', 'type' => 'bool')

                                                )
                                )


                            );
	
    function AdminSettings()
    {
        parent::Runmode();

    }

    function process()
    {
        $sm = new SettingsHolder();
        foreach ($this->settings as $section)
        {
            if (isset($_REQUEST[$section['save_name']]) && !empty($_REQUEST[$section['save_name']]))
            {
                $to_save = array();
                foreach ($section['fields'] as $field)
                    $to_save[$field['name']] = $this->process_setting_field($_REQUEST,$field);

                $sm->saveSettings($to_save);
            }
        }

        $new_settngs = $sm->loadSettings();
        foreach ($this->settings as $key => $section)
            foreach ($section['fields'] as $k => $field)
                if (isset($new_settngs[$field['name']])) $this->settings[$key]['fields'][$k]['value'] = $new_settngs[$field['name']];

        $GLOBALS['core.smarty']->assign('setting_list',$this->settings);
        
        return Admin_Header::out('CMS/Page_Runmode/admin_settings');
    }
	
    function process_setting_field($request,$field)
    {
        $to_ret = '';
        if ($field['type'] == 'bool')
        {
            $to_ret = (isset($_REQUEST[$field['name']]) && !empty($_REQUEST[$field['name']])) ? 1 : 0;
        }
        elseif ($field['type'] == 'int')
        {
            $to_ret = (isset($_REQUEST[$field['name']]) && !empty($_REQUEST[$field['name']])) ? $_REQUEST[$field['name']] : 0;
        }
        elseif ($field['type'] == 'string' || $field['type'] == 'password')
        {
            $to_ret = (isset($_REQUEST[$field['name']]) && !empty($_REQUEST[$field['name']])) ? $_REQUEST[$field['name']] : '';
        }
        return $to_ret;
        
    }
}


?>