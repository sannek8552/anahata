<?php
    require_once('Common_Header.php');
    require_once('classes/SettingsHolder.php');
    
    class RemindPassword extends Runmode
    {
        function RemindPassword()
		{
	    	//$this->base_map[0] = "new";
            $this->base_map[0] = "confirmation_code";
            parent::Runmode();		
		}

        function process()
        {
        	
            $smarty = $GLOBALS['core.smarty'];
            $dbh = $GLOBALS['core.sql'];
            $p = $GLOBALS['core.store']->prefix;
            $dbs = $GLOBALS['core.store'];
		    //pp($_REQUEST);         
            if (isset($_REQUEST['remind_password']))
            {      
            	     
            	/* 	            	
                if (isset($_REQUEST['login']) and $_REQUEST['login'])
                {
                    $res = $dbh->getRow("SELECT user_id,email FROM {$p}user WHERE login=?",array($_REQUEST['login']));
                    if (is_array($res) and count($res))
                    {
                        $user_id = $res['user_id'];
                        $email = $res['email'];
                    }
                }
	    		*/
                if (isset($_REQUEST['email']) and $_REQUEST['email'])
                {
                	
                    $res = $dbh->getRow("SELECT user_id,email,login FROM {$p}user WHERE email=?",array($_REQUEST['email']));
                    if (is_array($res) and count($res))
                    {
                        $user_id = $res['user_id'];
                        $email = $res['email'];
                        $login = $res['login'];
                    }
                }
	      
                if (isset($user_id) and $user_id)
                {
                	
                    $save = array();
                    $save['user_id'] = $user_id;
                    $save['confirmation_code'] = md5(microtime());
                    $save['password'] = substr($save['confirmation_code'],0,6);
                    $dbs->save('restore_password',$save,array('key_name' => 'id'));
                    $smarty->assign('new_password',$save['password']);
                    $smarty->assign('confirmation_code',$save['confirmation_code']);
                    $smarty->assign('login',$login);
                    $GLOBALS['core.mail']->init();
                    $GLOBALS['core.mail']->addAddress($email);                    
                    
                    //$mail_conf = $GLOBALS['core.config']->get_config('mail');
                    //$admin = $mail_conf['common'];
                    $sh = new SettingsHolder();
					$settings = $sh->getSettings();
                    
					$GLOBALS['core.mail']->setSubject($settings['remind_subject']);
                    $GLOBALS['core.mail']->setFrom($settings['remind_email']);
                    $GLOBALS['core.mail']->setFromName($settings['remind_name']);
                    $GLOBALS['core.mail']->isHTML(true);
                    $body = $smarty->fetch('Admin/recover_password_email.tpl');
                    $GLOBALS['core.mail']->setBody($body);
                    $res = $GLOBALS['core.mail']->send();
                    $smarty->assign('mail_sended',1);
                    //pp($GLOBALS['core.mail']);
                    
                }
                else
                {
                    $smarty->assign('not_finded',1);
                }
            }
	    
            if (isset($_REQUEST['confirmation_code']) and $_REQUEST['confirmation_code'])
            {
                $info = $dbh->getRow("SELECT * FROM {$p}restore_password WHERE confirmation_code=?",array($_REQUEST['confirmation_code']));
                if (is_array($info) and count($info) && isset($info['status']) && empty($info['status']))
                {
                    $password = $info['password'];
                    //$um = new UserManager();
                    //$um->SaveUserPassword($password,array('key_name' => 'user_id','key_value' => $info['user_id']));
                    $dbs->save('user',array('password' => md5($password)),array('key_name' => 'user_id','key_value' => $info['user_id']));

                    $dbs->save('restore_password',array('status' => 1),array('key_name' => 'id','key_value' => $info['id']));
                    $smarty->assign('confirmed',1);
        	}
            }
            
	    	//$pam = new PageManager();
            //$seo_data = $pam->GetByName('RemindPassword');
            //$GLOBALS['core.smarty']->assign('seo_data',$seo_data);
            return Common_Header::out('Admin/remind_password');
        }
    }
?>