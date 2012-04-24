<?php
//require_once('Note_Holder.php');
require_once('classes/NewsLetter/PostingHistory.php');
require_once('classes/NewsLetter/GroupOptions.php');
require_once('classes/NewsLetter/ContactOptions.php');
require_once('classes/NewsLetter/SentMailOptions.php');
require_once('classes/NewsLetter/UserItem.php');
require_once('classes/NewsLetter/GroupItem.php');
class NLProcess{
	function Process()
	{
		$letter_count = 0;
		//get current active postings
		$postings = NLProcess::get_active_postings();		
		foreach($postings as $posting)
        {
        	try
        	{
                $posting_obj = new PostingItem($posting['id']);
                $state = $posting_obj->get_data('state');                
                //check if posting still active
                //because we can have not actual data in database
        
                if (in_array($state,array(1,2))) 
                {
                	$posting = $posting_obj->get_data();
                    $data = unserialize($posting['process_info']);
                    
                    //posting start date passed
                    if(time()>=$data['start_time'] && in_array($posting['state'], array(1,2)))
                    {
                    	//lock current posting from being process by another cron execution
                        $old_state = $posting['state'];
                        $posting_obj->set_data(array('state'=>3));
                    	$posting_obj->save();
                        //
						
                        if (!isset($data['mail']))
                        {
                        	//get info about email that we should send
                            $mail = new MailItem($posting['mail_id']);
                            $data['mail']['subject'] = $mail->subject;
                            $data['mail']['html'] = $mail->html;
                            $data['mail']['plain'] = $mail->plain;
                            $data['mail']['posting_title'] = $posting['title'];
                            $data['mail']['campaign_settings'] = $mail->campaign_settings;                            
                        }
                        
                        if (!isset($data['method']))
                        {
                        	//get info about method of sending
                            $method = new MethodItem($posting['method_id']);
                            $data['method']['time_interval'] = $method->time_interval*60;
                            $data['method']['mail_count'] = $method->mail_count;
                        }
                        
                        /*
                        if ($data['update_time']+$data['method']['time_interval']>time())
                        {
                            //check if we have time for sending next batch of emails
                            $posting_obj->set_data(array('state'=>$old_state));
                            $posting_obj->save();
                            continue;
                        }
                        */

                        if (!isset($data['current_user']))
                        {
                            $data['current_user'] = 0;
                        }
                        
                        //need to get users for current sending
						$users = $posting_obj->get_users_batch($data['current_user'], $data['method']['mail_count']);						
						
						if (empty($users))
						{
							//we should end this posting
							NLProcess::posting_end($posting_obj, $data);
                            $posting_obj->set_data(array('state'=>0, 'process_info'=>''));
                            $posting_obj->save();
                            $posting_obj->stop_posting();
                            continue;
						}
                        
                        //init mailer module once per posting
                        $GLOBALS['core.mail']->init();
                        if(NLSettings::value('smtp_host'))
						{
							$GLOBALS['core.mail']->isSMTP(1);
							$GLOBALS['core.mail']->setServer(NLSettings::value('smtp_host'));
							$GLOBALS['core.mail']->setPort(NLSettings::value('smtp_port'));
							if(NLSettings::value('smtp_username'))
							{
								$GLOBALS['core.mail']->setUser(NLSettings::value('smtp_username'));
								$GLOBALS['core.mail']->setPassword(NLSettings::value('smtp_password'));
							}
						}
						$GLOBALS['core.mail']->setFrom(NLSettings::value('from_email'));
						$GLOBALS['core.mail']->setFromName(NLSettings::value('from_name'));
                        
                        foreach ($users as $user)
                        {                           	
                        	//prepare record in sent emails    
							$sent_mail_data = array();
                            $sent_mail_data['posting_id'] = 0;
                            $sent_mail_data['user_id'] = 0;
                            $sent_mail_data['type'] = '';
                            $mail_id = SentMailOptions::save_mail($sent_mail_data);

                            //send mail
                            $is_sent = NLProcess::send_mail($user, $data['mail'], $mail_id);
                            //$is_sent = true;
                            if (!is_array($is_sent))
                            {                            	
                            	//save sent mail
                            	//sending success, update row in sent email table                            	
                            	$sent_mail_data = array();
                            	$sent_mail_data['posting_id'] = $posting['id'];
                            	$sent_mail_data['user_id'] = $user['user_id'];
                            	$sent_mail_data['type'] = 'group';                            
                            	SentMailOptions::save_mail($sent_mail_data, $mail_id);
                            	
                            	//mark as send in nl_posting_process table
                            	$posting_obj->mark_as_send($user['id']);
                            	$letter_count++;
                            }
                            else 
                            {                            	
                            	//send failed
                            	SentMailOptions::delete_mail($mail_id);
                            	//set reason into nl_posting_process
                            	$posting_obj->mark_as_not_send($user['id'], $is_sent[0]);
                            }
                            
                            //increase user counter
                            $data['current_user']++;
                        }
                        
                        $data['update_time'] = time();                        
                        
                        //if someone stop it in browser
                        //we should really stop it here
                        $new_posting_obj = new Postingitem($posting['id']);
                        $new_posting_state = $new_posting_obj->get_data('state');
                        if ($new_posting_state == 0) 
                        {
                        	$posting_obj->set_data(array('state' => 0, 'process_info' => serialize($data)));
                        	$posting_obj->save();
                        }
                        else
                        {
                        	//unlock current posting from another cron running
                        	$posting_obj->set_data(array('state'=>$old_state,'process_info' => serialize($data)));
                        	$posting_obj->save();
                        }
                        
                    }
                }
        	}
            catch (Exception  $e)
	        {
	        	//we got some unexpectable error
	        	//we should stop posting process at all
	        	//
	        	$GLOBALS['core.sql']->query("update #p#nl_posting set state = ? where id = ?",array(0,$posting['id']));
	        					        	
	        	//write log about error
	        	$f = fopen('./logs/pear.log',"a");
				fwrite($f, '---------------------------------------------------------------------------------------' . "\n\n\n\n");
				fwrite($f, 'Date : ' . date("m.d.Y H:i:s") . "\n\n\n\n");
				fwrite($f,print_r($e->getMessage(),true) . "\n\n\n\n\n");
				fwrite($f,print_r("Newsletter crash",true));
				fclose($f);
				
				//send notification to admin about crashing newsletter
				mail(NLSettings::value('admin_mail'),"Newsletter " . $posting['title'] . " crash", "Newsletter " . $posting['title'] . " was crashed. Please check that all postings are stopped. Contact administrator to get information about newsletter crash.");
				exit();							
	        } 
		}			
		echo date('Y-m-d H:i:s').' - '.$letter_count." letters\n";                
	}
	
	function get_active_postings()
	{
		$posting_list_class = new PostingList();
		$filters = array('state'=>array(1,2));
                //$filters = array('state'=>0);
		return $posting_list_class->GetAll($filters);
	}	
	
	function send_mail($user, &$mail, $mail_id = null)
	{		
		$GLOBALS['core.mail']->addAddress($user['email']);
		$GLOBALS['core.mail']->setSubject($mail['subject']);
        
        if (isset($user['text_type'])) 
        {
        	$GLOBALS['core.mail']->isHTML($user['text_type'] ? false : true);
        }
        else 
        {
        	$GLOBALS['core.mail']->isHTML(false);
        }		
        
        if (isset($user['text_type']) && $user['text_type'] == 0)
        {
        	$body = $mail['html'];
        }
        else
        {
            $body = $mail['plain'];
        }
        
        $GLOBALS['core.smarty']->assign('user_key', md5($user['email']));
        
        if (isset($user['user_id'])) 
        {
            $GLOBALS['core.smarty']->assign('user', $user);
            $GLOBALS['core.smarty']->assign('posting_title', $mail['posting_title']);
            $body = $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/view_html.tpl')."\n\n".$body."\n\n".$GLOBALS['core.smarty']->fetch('Admin/NewsLetter/unsubscribe.tpl');
        }

        if (!is_null($mail_id) && (isset($user['text_type']) && $user['text_type'] == 0))
        {
            $GLOBALS['core.smarty']->assign('mail_id', $mail_id);
            $GLOBALS['core.smarty']->assign('read_key', SentMailOptions::get_read_hash($mail_id));
            $body .= $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/set_read.tpl');
        }                
        
        $name = '';
        if (isset($user['first_name'])) $name .= $user['first_name'] . ' ';
        else $user['first_name'] = '';
        if (isset($user['last_name'])) $name .= $user['last_name'];
        else $user['last_name'] = '';                        
      	
        $body = str_replace(
                array('[name]', '[now]','[first_name]','[last_name]'),
                array($name, date('Y-m-d H:i:s'), $user['first_name'], $user['last_name']),
                $body);
                
		$GLOBALS['core.mail']->setBody($body);
		$res = $GLOBALS['core.mail']->send();

		if (empty($res))
		{
			$erro_info = $GLOBALS['core.mail']->viewErrorInfo();
			return array($erro_info);
		}
		else return true;
	}
	
	function posting_end(&$posting_obj, &$data)
	{
		//here administrator notification
		$GLOBALS['core.mail']->init();
		$GLOBALS['core.mail']->addAddress(NLSettings::value('admin_mail'));
		$GLOBALS['core.mail']->setSubject('Newsletter/Mailout Report');
		$GLOBALS['core.mail']->setFrom(NLSettings::value('from_email'));
		$GLOBALS['core.mail']->setFromName(NLSettings::value('from_name'));
		$GLOBALS['core.mail']->isHTML(1);

		if(NLSettings::value('smtp_host'))
		{
			$GLOBALS['core.mail']->isSMTP(1);
			$GLOBALS['core.mail']->setServer(NLSettings::value('smtp_host'));
			$GLOBALS['core.mail']->setPort(NLSettings::value('smtp_port'));
			if(NLSettings::value('smtp_username'))
			{
				$GLOBALS['core.mail']->setUser(NLSettings::value('smtp_username'));
				$GLOBALS['core.mail']->setPassword(NLSettings::value('smtp_password'));
			}
		}
		
		$GLOBALS['core.smarty']->assign('posting', $posting_obj->get_data());
		$GLOBALS['core.smarty']->assign('data', $data);		
		$users = $posting_obj->get_users_batch_full();
		$GLOBALS['core.smarty']->assign('users', $users);
		
		$body = $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/admin_notification.tpl');

		$GLOBALS['core.mail']->setBody($body);
		$res = $GLOBALS['core.mail']->send();
		
        //need to save data to history
        $posting_info = $posting_obj->get_data();
        $hist_holder = new PostingHistory();
        $hist_holder->set_data($posting_info);
        $hist_holder->set_data(array('posting_id'=>$posting_info['id']));
        switch ($posting_info['type'])
        {
            case 'group':
                $group = PostingGroup::get_posting_groups_string($posting_info['id'],true);
                $hist_holder->set_data(array('group_id'=>$group));
                break;
            case 'contact':
                $contact = PostingContact::get_posting_contacts_string($posting_info['id'],true);
                $hist_holder->set_data(array('contact_id'=>$contact));
                break;
            default:
                break;
        }
        $process_info = unserialize($posting_info['process_info']);
        if (isset($posting_info['start_time']) && !is_null($posting_info['start_time']))
        	$hist_holder->set_data(array('start_time'=>$process_info['start_time']));
        if (isset($posting_info['update_time']) && !is_null($posting_info['update_time']))
        	$hist_holder->set_data(array('end_time'=>$data['update_time']));
        $hist_holder->save();
	}

	function prepare_links(&$body,$settings)
	{
	    //pp($body);
	    $to_add = "";
	    $self_url = "";
	    $url_replace = array();
	    $conf = $GLOBALS['core.config']->get_config('templates');
	    $settings = unserialize($settings);
	    if(!empty($settings))
	    {
	        foreach ($settings as $key => $value)
	        {
	            if(!empty($value))
	                $settings[$key] = $key.'='.$value;
	            else
	                unset($settings[$key]);
	        }
	        $to_add = join('&',$settings);
	    }
	
	    if(isset($conf)) $self_url = $conf['common']['domain_name'];
	    $self_url = str_replace(array('/','.'),array('\/','\.'),$self_url);
	    
	    //preg_match_all("/<a.*href=[\'|\"]($self_url.*)[\'|\"].*>.*<\/a>/U", $body, $matches);
	    preg_match_all("/<a\s.*(href=[\"|'].*)[\"|'].*<\/a>/Uis", $body, $matches);
	    if(isset($matches[1]))
	    {
	        $i=0;
	        foreach($matches[1] as $url)
	        {
	            $temp = (!preg_match("/.+\?.*/",$url))? $url.'?'.$to_add : $url.'&'.$to_add;
	            $url_replace[$i] = str_replace($url, $temp, $matches[0][$i]);
	            $i++;
	        }
	        $body = str_replace($matches[0], $url_replace, $body);
	    }
	
	    preg_match_all("/<a\s.*(href=[^\"'].*)[\s|>].*<\/a>/Uis", $body, $matches2);
	
	    if(isset($matches2[1]) && !empty($matches2[1]))
	    {
	        $i=0;
	        foreach($matches2[1] as $url)
	        {
	            $temp = (!preg_match("/.+\?.*/",$url))? $url.'?'.$to_add : $url.'&'.$to_add;
	            $url_replace2[$i] = str_replace($url, $temp, $matches2[0][$i]);
	            $i++;
	        }
	    	$body = str_replace($matches2[0], $url_replace2, $body);
    	}             
	}
	
    function import_contact_form()
    {
        $new_users = 0;
        $new_groups = 0;
        $new_user_groups = 0;

        $contact_entries = $GLOBALS['core.sql']->getAll("SELECT e.contact_id, m.subject, e.email, e.entry FROM #p#contact_module_entry e INNER JOIN #p#contact_module m ON e.contact_id=m.id",array());
        //pp($contact_entries);
        foreach ($contact_entries as $value)
        {                
            $uh = new UserItem();
            $already_imported = $uh->already_imported($value['email']);
            if (empty($already_imported)) {
                //проверяем наличие имени и фамилии
                $value['entry'] = unserialize($value['entry']); //pp($value['entry']);exit;
                if (!empty($value['entry'])) {
                    foreach ($value['entry'] as $key=>$e_value)
                    {
                        if (in_array(strtolower($key),array('first_name','first name','name'))) {
                            $uh->set_data(array('first_name'=>$e_value));
                        }
                        if (in_array(strtolower($key),array('last_name','last name'))) {
                            $uh->set_data(array('last_name'=>$e_value));
                        }
                    }
                }
                
                //импортим юзера
                $uh->set_data(array('old_email'=>$value['email'],'email'=>$value['email'])); //pp($uh);exit;
                $uh->save();
                $new_users++;
                //запоминаем ID
                $created_user_ID = $GLOBALS['core.store']->last_id();
                //проверяем существование группы с таким именем
                $group_ID = $GLOBALS['core.sql']->getOne("SELECT id FROM #p#nl_group WHERE contact_id = ?",array($value['contact_id']));
                //если такая группа есть - берем ID и записываем в базу группа_юзер
                if (!empty($group_ID)) {
                    $GLOBALS['core.store']->save('nl_user_group_link',array('user_id'=>$created_user_ID,'group_id'=>$group_ID),array('key_name'=>'id'));
                    $new_user_groups++;
                    //обновляем имя группы
                    $gh = new GroupItem($group_ID);
                    $gh->set_data(array('title'=>$value['subject']));
                    $gh->save();
                    //$GLOBALS['core.store']->save('nl_group',array('title'=>$value['subject']),array('key_name'=>'id','key_value'=>$group_ID));
                } else {
                    //если нет, создаём запись, берем ID и записываем в базу группа_юзер
                    $gh = new GroupItem();
                    $gh->set_data(array('title'=>$value['subject'],'contact_id'=>$value['contact_id']));
                    $gh->save();
                    //$GLOBALS['core.store']->save('nl_group',array('title'=>$value['subject'],'contact_id'=>$value['contact_id']),array('key_name'=>'id'));
                    $new_groups++;
                    $group_ID = $GLOBALS['core.store']->last_id();
                    $GLOBALS['core.store']->save('nl_user_group_link',array('user_id'=>$created_user_ID,'group_id'=>$group_ID),array('key_name'=>'id'));
                    $new_user_groups++;
                }
            } else {
                $user_ID = $already_imported;
                //проверяем существование группы с таким именем
                $group_ID = $GLOBALS['core.sql']->getOne("SELECT id FROM #p#nl_group WHERE contact_id = ?",array($value['contact_id']));
                if (!empty($group_ID)) {
                    //если такая группа есть - берем ID и ищем запись в базе с таким юзером и  с такой группой
                    $user_group_exists = $GLOBALS['core.sql']->getOne("SELECT id FROM #p#nl_user_group_link WHERE user_id = ? AND group_id = ?",array($user_ID,$group_ID));
                    if (empty($user_group_exists)) {
                        //если записи нет - добавляем
                        $GLOBALS['core.store']->save('nl_user_group_link',array('user_id'=>$user_ID,'group_id'=>$group_ID),array('key_name'=>'id'));
                        $new_user_groups++;
                    }
                    //обновляем имя группы
                    $gh = new GroupItem($group_ID);
                    $gh->set_data(array('title'=>$value['subject']));
                    $gh->save();
                    //$GLOBALS['core.store']->save('nl_group',array('title'=>$value['subject']),array('key_name'=>'id','key_value'=>$group_ID));

                } else {
                    //если такой группы нет, создаём запись, берем ID и записываем в базу группа_юзер
                    $gh = new GroupItem();
                    $gh->set_data(array('title'=>$value['subject'],'contact_id'=>$value['contact_id']));
                    $gh->save();
                    //$GLOBALS['core.store']->save('nl_group',array('title'=>$value['subject'],'contact_id'=>$value['contact_id']),array('key_name'=>'id'));
                    $new_groups++;
                    $group_ID = $GLOBALS['core.store']->last_id();
                    $GLOBALS['core.store']->save('nl_user_group_link',array('user_id'=>$user_ID,'group_id'=>$group_ID),array('key_name'=>'id'));
                    $new_user_groups++;
                }
            }
        }
        echo "Import has finished. \nResults:\n";
        echo "New users: \t$new_users \n";
        echo "New groups: \t$new_groups \n";
        echo "New users/groups: \t$new_user_groups \n";
        //exit;
    }
}

?>