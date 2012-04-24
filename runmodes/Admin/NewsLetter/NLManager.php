<?php
require_once('Admin_Header.php');
require_once('classes/CSV.php');

require_once('classes/NewsLetter/Process.php');
require_once('classes/NewsLetter/Settings.php');

require_once('classes/NewsLetter/UserItem.php');
require_once('classes/NewsLetter/UserList.php');

require_once('classes/NewsLetter/GroupItem.php');
require_once('classes/NewsLetter/GroupList.php');
require_once('classes/NewsLetter/GroupOptions.php');

require_once('classes/NewsLetter/MailItem.php');
require_once('classes/NewsLetter/MailList.php');

require_once('classes/NewsLetter/PostingItem.php');
require_once('classes/NewsLetter/PostingList.php');

require_once('classes/NewsLetter/MethodItem.php');
require_once('classes/NewsLetter/MethodList.php');

//require_once('classes/NewsLetter/StatusList.php');
//require_once('classes/NewsLetter/StatusOptions.php');

require_once('classes/NewsLetter/ContactList.php');
require_once('classes/NewsLetter/ContactOptions.php');

require_once('classes/NewsLetter/SentMailOptions.php');

require_once('classes/NewsLetter/ReadReportItem.php');
require_once('classes/NewsLetter/ReadReportList.php');

require_once('classes/NewsLetter/UnsubscribeReportItem.php');
require_once('classes/NewsLetter/UnsubscribeReportList.php');
require_once('classes/NewsLetter/Process.php');

class NLManager extends Runmode{

	function __construct(){
		//parent::Runmode();
                putenv("TZ=Australia/Sydney");
               

	}

	function process()
	{
              
		$helper_icons = array(
						"helper_icons_detalies" => " - Detalies",
						"helper_icons_edit" => " - Edit",
						"helper_icons_delete" => " - Delete"
					);
		$GLOBALS['core.smarty']->assign('helper_icons', $helper_icons);

		$user_list_class = new UserList();
		$GLOBALS['core.smarty']->assign('nl_user_column_defs', $user_list_class->get_column_defs());
		$GLOBALS['core.smarty']->assign('nl_user_source_fields', $user_list_class->get_source_fields());
                //pp($user_list_class->get_source_fields());
		$group_list_class = new GroupList();
		$GLOBALS['core.smarty']->assign('nl_group_column_defs', $group_list_class->get_column_defs());
		$GLOBALS['core.smarty']->assign('nl_group_source_fields', $group_list_class->get_source_fields());

		$mail_list_class = new MailList();
		$GLOBALS['core.smarty']->assign('nl_mail_column_defs', $mail_list_class->get_column_defs());
		$GLOBALS['core.smarty']->assign('nl_mail_source_fields', $mail_list_class->get_source_fields());

		$posting_list_class = new PostingList();
		$GLOBALS['core.smarty']->assign('nl_posting_column_defs', $posting_list_class->get_column_defs());
		$GLOBALS['core.smarty']->assign('nl_posting_source_fields', $posting_list_class->get_source_fields());

		$method_list_class = new MethodList();
		$GLOBALS['core.smarty']->assign('nl_method_column_defs', $method_list_class->get_column_defs());
		$GLOBALS['core.smarty']->assign('nl_method_source_fields', $method_list_class->get_source_fields());

		$group_list_class = new GroupList();

                $readreport_list_class = new ReadReportList();
		$GLOBALS['core.smarty']->assign('nl_readreport_column_defs', $readreport_list_class->get_column_defs());
		$GLOBALS['core.smarty']->assign('nl_readreport_source_fields', $readreport_list_class->get_source_fields());

                $unsubscribereport_list_class = new UnsubscribeReportList();
		$GLOBALS['core.smarty']->assign('nl_unsubscribereport_column_defs', $unsubscribereport_list_class->get_column_defs());
		$GLOBALS['core.smarty']->assign('nl_unsubscribereport_source_fields', $unsubscribereport_list_class->get_source_fields());

		$GLOBALS['core.smarty']->assign('groups', $group_list_class->GetAll());		
		return Admin_Header::out('NewsLetter/news_letter', $this);
	}
	//-- user --------------------------------------------------------------------------------------
	function process_user_list_ajax(){
		$start_index = isset($_REQUEST['startIndex']) ? $_REQUEST['startIndex'] : 0;
		$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
		$sort = isset($_REQUEST['sort'])? $_REQUEST['sort'] : '';
		$page_size = isset($_REQUEST['results']) ? $_REQUEST['results'] : null;
		$filters = (isset($_REQUEST['filter']) && !empty($_REQUEST['filter'])) ? $_REQUEST['filter'] : array();

		$list_class = new UserList();
		$to_return = $list_class->get_page($start_index, $sort, $dir, $page_size, $filters);
                //pp($to_return);exit();
		$GLOBALS['core.ajax']->yui_to_output($to_return);
	}
	
	function process_user_edit_ajax(){
		$id = (isset($_REQUEST['item_id']) && $_REQUEST['item_id']>0) ? $_REQUEST['item_id'] : null;

		$obj = new UserItem($id);
		$success = false;
		$err = null;
		
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save'])){
			//need to save data to the broker
			$data = $_REQUEST;
			if (!isset($data['unsubscribe'])){
                            $data['unsubscribe'] = 0;
                        }
                        
			$err = $obj->validate($data);

			if (UserItem::mail_unique($data['email'], $id)) {
                            $err['email_unique']=1;
                        }
			
			if (empty($err)){
                            if (isset($_REQUEST['unsubscribe']) && $_REQUEST['unsubscribe'] == 1) {
                                $already_unsubscribed = $GLOBALS['core.sql']->getOne("SELECT unsubscribe FROM #p#nl_user WHERE id = ?",array($id));
                                if ($already_unsubscribed != 1) {
                                    $_REQUEST['unsubscribe_date'] = time();
                                }
                            }
                            $obj->set_data($_REQUEST);
                            $obj->save();
                            UserGroup::user_update_groups($obj->id, $_REQUEST['groups']);
                            $GLOBALS['core.smarty']->assign('saved', 1);
                            $success = true;
			} else {
                            $GLOBALS['core.smarty']->assign('err', $err);
                            $GLOBALS['core.smarty']->assign('data', $_REQUEST);
			}
		}
		
		$group_list_class = new GroupList();
		$GLOBALS['core.smarty']->assign('groups', $group_list_class->GetAll());
		
		if(!isset($err) || empty($err)){
			$data = $obj->get_data();
			$data['groups'] = UserGroup::get_user_groups($id);
			$GLOBALS['core.smarty']->assign('data', $data);
		} else {
			$_REQUEST['id'] = $id;
			$GLOBALS['core.smarty']->assign('data', $_REQUEST);
		}
		
		$GLOBALS['core.ajax']->put_to_output(array('id' => $obj->id, 'success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/user_edit.tpl')));
	}

	function process_user_info_ajax(){
		$id = (isset($_REQUEST['item_id']) && $_REQUEST['item_id']>0) ? $_REQUEST['item_id'] : null;
		$obj = new UserItem($id);
		$data = $obj->get_data();
		$data['groups'] = UserGroup::get_user_groups($id);
		$GLOBALS['core.smarty']->assign('data', $data);
		
		$group_list_class = new GroupList();
		$GLOBALS['core.smarty']->assign('groups', $group_list_class->GetAll());

		$GLOBALS['core.ajax']->put_to_output(array('id' => $obj->id, 'success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/user_info.tpl')));
	}

	function process_user_delete_ajax(){
		$success = false;
		$id = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
		$obj = new UserItem($id);
		UserGroup::user_update_groups($obj->id, array());
		$obj->real_delete();
		$success = true;
		$GLOBALS['core.ajax']->put_to_output(array('id'=>$obj->id, 'success'=>$success));
	}

        function process_user_delete_all_ajax(){
		$success = false;
                //pp($_REQUEST['ids']);exit();
		$ids = (isset($_REQUEST['ids']) && !empty($_REQUEST['ids'])) ? $_REQUEST['ids'] : null;
                if(!is_null($ids))
                {
                    foreach($ids as $value)
                    {
                        $obj = new UserItem($value);
                        UserGroup::user_update_groups($obj->id, array());
                        $obj->real_delete();
                    }
                }
                
		
		$success = true;
		$GLOBALS['core.ajax']->put_to_output(array('id'=>$obj->id, 'success'=>$success));
	}
	
	function process_user_unsubscribe(){
		
		$id = (isset($_REQUEST['id']) && $_REQUEST['id']>0) ? $_REQUEST['id'] : null;
		$key = (isset($_REQUEST['key']) && !empty($_REQUEST['key'])) ? $_REQUEST['key'] : null;
		$obj = new UserItem($id);
		$hash = md5($obj->email);
		if($hash == $key)
		{
			$obj->set_data(array('unsubscribe'=>1,'unsubscribe_date'=>time()));
			$obj->save();
			$GLOBALS['core.smarty']->assign('body_as_text','<div style="padding:20px;">You unsubscribed successfully!<br /></div>');
		}
		else 
		{
			$GLOBALS['core.smarty']->assign('body_as_text','<div style="padding:20px;">Sorry. Error occured during unsubscribe. Please try again later.<br /></div>');
		}
		
		//return "Unsubscribe successful!<br />";
		require_once('Common_Header.php');
		return Common_Header::out();
	}
	
	function process_user_csv(){
            
		if(isset($_FILES['csv_file']) && $_FILES['csv_file']['error']==0){
                    //echo "!!!!!";
			$templates = $GLOBALS['core.config']->get_config('templates');
			$titles = array('first_name', 'last_name', 'email', 'postcode', 'text_type', 'group');
			//$text_type = array('html'=>0, 'plain'=>1, 'plain text'=>1);
			$groups = GroupItem::get_title_id_group();

			$users = CSV::parseCSV($_FILES['csv_file']['tmp_name'], $templates['common']['csv_separator'], "\"", 1, $titles);
            //pp($users);exit();
			//$result = array();
			$res = "total: ".count($users)." record(s)<br /><table>";
			foreach($users as $i=>$user)
            {
                $first_name	= isset($user['first_name'])?$user['first_name']:'';
                $last_name	= isset($user['last_name'])?$user['last_name']:'';
                $postcode	= isset($user['postcode'])?$user['postcode']:'';
                $email		= isset($user['email'])?$user['email']:'';
                $text_type	= isset($user['text_type'])?$user['text_type']:0;
                $group          = isset($user['group'])?$user['group']:0;                                
                                
				//$result[$i]['name'] = $user['first_name'].' '.$user['last_name'];
				$res .= "<tr><td>{$first_name} {$last_name}: </td>";
				
				$data = array(
					'first_name'	=> $first_name,
					'last_name'	=> $last_name,
					'postcode'	=> $postcode,
					'email'		=> $email,
                                        'text_type'	=> $text_type);
				
				$obj = new UserItem();
				$obj->set_data($data);
				$obj->save();

				if(!empty($group))
				UserGroup::user_update_groups($obj->id, array($group));
				//$result[$i]['state'] = 'added';
				$res .= "<td style='color: #080;'>added</td>";
			}
			$res .= "</table>";
			
			echo "<script type='text/javascript'>\n".
				"parent.document.getElementById('import_report_box').innerHTML=\"{$res}\";\n".
				"parent.nluser_list.onPaginatorChangeRequest(parent.nluser_list.getState().pagination);\n".
				"</script>\n";
		}
	}
	
	//-- group -------------------------------------------------------------------------------------
	function process_group_list_ajax(){
		$start_index = isset($_REQUEST['startIndex']) ? $_REQUEST['startIndex'] : 0;
		$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
		$sort = isset($_REQUEST['sort'])? $_REQUEST['sort'] : '';
		$page_size = isset($_REQUEST['results']) ? $_REQUEST['results'] : null;
		$filters = (isset($_REQUEST['filter']) && !empty($_REQUEST['filter'])) ? $_REQUEST['filter'] : array();

		$list_class = new GroupList();
		$to_return = $list_class->get_page($start_index, $sort, $dir, $page_size, $filters);
		$GLOBALS['core.ajax']->yui_to_output($to_return);
	}
	
	function process_group_edit_ajax(){
		$id = (isset($_REQUEST['item_id']) && $_REQUEST['item_id']>0) ? $_REQUEST['item_id'] : null;

		$obj = new GroupItem($id);
		$success = false;
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save'])){
			//need to save data to the broker
			$data = $_REQUEST;
			$err = $obj->validate($data);
			if(empty($err)){
				$obj->set_data($_REQUEST);
				$obj->save();
				$GLOBALS['core.smarty']->assign('saved', 1);
				$success = true;
			} else {
				$GLOBALS['core.smarty']->assign('err', $err);
				$GLOBALS['core.smarty']->assign('data', $_REQUEST);
			}
		}
		if(!isset($err) || !empty($err))
			$GLOBALS['core.smarty']->assign('data', $obj->get_data());
		$GLOBALS['core.ajax']->put_to_output(array('id' => $obj->id, 'success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/group_edit.tpl')));
	}

	function process_group_info_ajax(){
		$id = (isset($_REQUEST['item_id']) && $_REQUEST['item_id']>0) ? $_REQUEST['item_id'] : null;
		$obj = new GroupItem($id);
		$data = $obj->get_data();
		$data['users'] = UserGroup::get_group_users($id);pp($data['users']);
                foreach ($data['users'] as $key => $value) {
                    if (empty($value['first_name']) && empty($value['last_name'])) {
                        $data['users'][$key]['first_name'] = 'unnamed user';
                    }
                }
		$GLOBALS['core.smarty']->assign('data', $data);

		$success = true;
		$GLOBALS['core.ajax']->put_to_output(array('id' => $obj->id, 'success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/group_info.tpl')));
	}
	
	function process_group_delete_ajax(){
		$success = false;
		$id = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
		$obj = new GroupItem($id);
		$obj->delete();
		$success = true;
		$GLOBALS['core.ajax']->put_to_output(array('id'=>$obj->id, 'success'=>$success));
	}
	
	//-- mail --------------------------------------------------------------------------------------
	function process_mail_list_ajax(){
		$start_index = isset($_REQUEST['startIndex']) ? $_REQUEST['startIndex'] : 0;
		$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
		$sort = isset($_REQUEST['sort'])? $_REQUEST['sort'] : '';
		$page_size = isset($_REQUEST['results']) ? $_REQUEST['results'] : null;
		$filters = (isset($_REQUEST['filter']) && !empty($_REQUEST['filter'])) ? $_REQUEST['filter'] : array();

		$list_class = new MailList();
		$to_return = $list_class->get_page($start_index, $sort, $dir, $page_size, $filters);
		$GLOBALS['core.ajax']->yui_to_output($to_return);
	}
	
	function process_mail_edit_ajax(){
		$id = (isset($_REQUEST['item_id']) && $_REQUEST['item_id']>0) ? $_REQUEST['item_id'] : null;

		$obj = new MailItem($id);
		$success = false;
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save'])){
			$data = $_REQUEST;
                        $err = $obj->validate($data);
                        $_REQUEST['campaign_settings'] = serialize($_REQUEST['utm']);
                        //pp($data['campaign_settings']);
			if(empty($err)){
				$obj->set_data($_REQUEST);
				$obj->save();
				$GLOBALS['core.smarty']->assign('saved', 1);
				$success = true;
			} else {
				$GLOBALS['core.smarty']->assign('err', $err);
				$GLOBALS['core.smarty']->assign('data', $_REQUEST);
			}
		}
		if(!isset($err) || !empty($err))
                {
                        $data = $obj->get_data();
                        $data['utm'] = unserialize($data['campaign_settings']);
			$GLOBALS['core.smarty']->assign('data', $data);
                }

                $GLOBALS['core.ajax']->put_to_output(array('id' => $obj->id, 'success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/mail_edit.tpl')));
	}

	function process_mail_delete_ajax(){
		$success = false;
		$id = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
		$obj = new MailItem($id);
		$obj->delete();
		$success = true;
		$GLOBALS['core.ajax']->put_to_output(array('id'=>$obj->id, 'success'=>$success));
	}

	//-- posting -------------------------------------------------------------------------------------
	function process_posting_list_ajax(){
		$start_index = isset($_REQUEST['startIndex']) ? $_REQUEST['startIndex'] : 0;
		$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
		$sort = isset($_REQUEST['sort'])? $_REQUEST['sort'] : '';
		$page_size = isset($_REQUEST['results']) ? $_REQUEST['results'] : null;
		$filters = (isset($_REQUEST['filter']) && !empty($_REQUEST['filter'])) ? $_REQUEST['filter'] : array();

		$list_class = new PostingList();
		$to_return = $list_class->get_page($start_index, $sort, $dir, $page_size, $filters);
		$GLOBALS['core.ajax']->yui_to_output($to_return);
	}
	
	function process_posting_edit_ajax(){
		$id = (isset($_REQUEST['item_id']) && $_REQUEST['item_id']>0) ? $_REQUEST['item_id'] : null;
                $obj = new PostingItem($id);
		$success = false;
                
                $getdate = true;
                if(!isset($_REQUEST['Time_Hour']))
                    $getdate = false;
                elseif(!isset($_REQUEST['Time_Minute']))
                    $getdate = false;
                elseif(!isset($_REQUEST['date']))
                    $getdate = false;
                /*elseif(!isset($_REQUEST['Date_Year']))
                    $getdate = false;
                elseif(!isset($_REQUEST['Date_Day']))
                    $getdate = false;*/
                $date_array = explode('/',$_REQUEST['date']);  
                $datetime = 0;
                if($getdate)
                {
                   $datetime = mktime ($_REQUEST['Time_Hour'], $_REQUEST['Time_Minute'],0,$date_array[1],$date_array[0],$date_array[2]);
                }

		if(isset($_REQUEST['save']) && !empty($_REQUEST['save'])){
			//need to save data to the broker
			$data = $_REQUEST;
			$err = $obj->validate($data);
			if (empty($err)){
				$obj->set_data($_REQUEST);
                                $obj->set_data(array('date_time'=>$datetime));
                                $obj->save();
                                
                                if (isset($_REQUEST['groups'])) {
                                    
                                    PostingGroup::posting_update_groups($obj->id, $_REQUEST['groups']);
                                    //PostingStatus::posting_update_statuses($obj->id, null);
                                    //PostingContact::posting_update_contacts($obj->id, null);
                                    //break;
                                        
                                       /* case 'status':
                                            //PostingStatus::posting_update_statuses($obj->id, $_REQUEST['statuses']);
                                            PostingGroup::posting_update_groups($obj->id, null);
                                            PostingContact::posting_update_contacts($obj->id, null);
                                            break;
                                        
                                        case 'contact':
                                            PostingContact::posting_update_contacts($obj->id, $_REQUEST['contacts']);
                                            PostingGroup::posting_update_groups($obj->id, null);
                                            //PostingStatus::posting_update_statuses($obj->id, null);
                                            break;*/
                                }
                                
                                
				$GLOBALS['core.smarty']->assign('saved', 1);
				$success = true;
			} else {
				$GLOBALS['core.smarty']->assign('err', $err);
				$GLOBALS['core.smarty']->assign('data', $_REQUEST);
			}
		}

		$group_list_class = new GroupList();
		$GLOBALS['core.smarty']->assign('groups', $group_list_class->GetAll());

                //$status_list_class = new StatusList();
                //$GLOBALS['core.smarty']->assign('statuses', $status_list_class->getAll());

                //$contact_list_class = new ContactList();
                //$GLOBALS['core.smarty']->assign('contacts', $contact_list_class->GetAll());

		$method_list_class = new MethodList();
		$GLOBALS['core.smarty']->assign('methods', $method_list_class->GetAll());

		$mail_list_class = new MailList();
		$GLOBALS['core.smarty']->assign('mails', $mail_list_class->GetAll());
		
		if(!isset($err) || !empty($err)){
			$data = $obj->get_data();
			$data['groups'] = PostingGroup::get_posting_groups($id);
                        //$data['statuses'] = PostingStatus::get_posting_statuses($id);
                        //$data['contacts'] = PostingContact::get_posting_contacts($id);
			$GLOBALS['core.smarty']->assign('data', $data);
		} else {
			foreach($_REQUEST as $i=>$v)
				$GLOBALS['core.smarty']->assign($i, $v);
		}
                             
		$GLOBALS['core.ajax']->put_to_output(array('id' => $obj->id, 'success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/posting_edit.tpl')));
	}

	function process_posting_info_ajax(){
		$id = (isset($_REQUEST['item_id']) && $_REQUEST['item_id']>0) ? $_REQUEST['item_id'] : null;
		$obj = new PostingItem($id);
		$data = $obj->get_data();
		$data['groups'] = PostingGroup::get_posting_groups($id);
                //$data['statuses'] = PostingStatus::get_posting_statuses($id);
                //$data['contacts'] = PostingContact::get_posting_contacts($id);
		$GLOBALS['core.smarty']->assign('data', $data);
		if($data['state']){
			$GLOBALS['core.smarty']->assign('info', unserialize($data['process_info']));
		}

		$group_list_class = new GroupList();
		$GLOBALS['core.smarty']->assign('groups', $group_list_class->GetAll());
                //$status_list_class = new StatusList();
                //$GLOBALS['core.smarty']->assign('statuses', $status_list_class->getAll());
                $contact_list_class = new ContactList();
		$GLOBALS['core.smarty']->assign('contacts', $contact_list_class->GetAll());
		$success = true;
		$GLOBALS['core.ajax']->put_to_output(array('id' => $obj->id, 'success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/posting_info.tpl')));
	}
	
	function process_posting_delete_ajax(){
		$success = false;
		$id = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
		$obj = new PostingItem($id);
		$obj->delete();
		$success = true;
		$GLOBALS['core.ajax']->put_to_output(array('id'=>$obj->id, 'success'=>$success));
	}
	
	function process_posting_start_ajax(){
		$success = false;
		$id = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
        $state = isset($_REQUEST['all_users']) ? 1 : 2;
        
		$obj = new PostingItem($id);
        $date_time = $obj->__get('date_time');
        if (is_null($date_time) or $date_time<time()) 
        {
        	$time = time();
        } 
        else 
        {
        	$time = $date_time;
        }
        
		$process_info = array(
			'start_time'	=> $time,
			'update_time'	=> null,
			'end_time'	=> null,
			);

		$obj->set_data(array('state'=>$state, 'process_info'=>serialize($process_info)));
		$obj->save();
		$obj->start_posting();
		

		$success = true;
		$GLOBALS['core.ajax']->put_to_output(array('id'=>$obj->id, 'success'=>$success));
	}

	function process_posting_stop_ajax(){
		$success = false;
		$id = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
		$obj = new PostingItem($id);
		
		$process_info = unserialize($obj->process_info);
		$process_info['stop_time'] = 
		array(
			'stop_time'	=> time(),
		);

		$obj->set_data(array('state'=>0, 'process_info'=>serialize($process_info)));
		$obj->save();
		$obj->stop_posting();

		$success = true;
		$GLOBALS['core.ajax']->put_to_output(array('id'=>$obj->id, 'success'=>$success));
	}

	function process_posting(){
	// pp($_REQUEST);
            NLProcess::import_contact_form();
            NLProcess::Process();
            

	}

        function import_contact_form(){
	// pp($_REQUEST);
            NLProcess::import_contact_form();
	}
	//-- method ------------------------------------------------------------------------------------
	function process_method_list_ajax(){
		$start_index = isset($_REQUEST['startIndex']) ? $_REQUEST['startIndex'] : 0;
		$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
		$sort = isset($_REQUEST['sort'])? $_REQUEST['sort'] : '';
		$page_size = isset($_REQUEST['results']) ? $_REQUEST['results'] : null;
		$filters = (isset($_REQUEST['filter']) && !empty($_REQUEST['filter'])) ? $_REQUEST['filter'] : array();

		$list_class = new MethodList();
		$to_return = $list_class->get_page($start_index, $sort, $dir, $page_size, $filters);
		$GLOBALS['core.ajax']->yui_to_output($to_return);
	}
	
	function process_method_edit_ajax(){
		$id = (isset($_REQUEST['item_id']) && $_REQUEST['item_id']>0) ? $_REQUEST['item_id'] : null;

		$obj = new MethodItem($id);
		$success = false;
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save'])){
			//need to save data to the broker
			$data = $_REQUEST;
			$err = $obj->validate($data);
			if(empty($err)){
				$obj->set_data($_REQUEST);
				$obj->save();
				$GLOBALS['core.smarty']->assign('saved', 1);
				$success = true;
			} else {
				$GLOBALS['core.smarty']->assign('err', $err);
				$GLOBALS['core.smarty']->assign('data', $_REQUEST);
			}
		}
		if(!isset($err) || !empty($err))
			$GLOBALS['core.smarty']->assign('data', $obj->get_data());
		$GLOBALS['core.ajax']->put_to_output(array('id' => $obj->id, 'success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/method_edit.tpl')));
	}

	function process_method_delete_ajax(){
		$success = false;
		$id = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : null;
		$obj = new MethodItem($id);
		$obj->delete();
		$success = true;
		$GLOBALS['core.ajax']->put_to_output(array('id'=>$obj->id, 'success'=>$success));
	}
	//-- method ------------------------------------------------------------------------------------
	function process_settings_list_ajax(){
		$GLOBALS['core.smarty']->assign('path', getcwd());
		$GLOBALS['core.smarty']->assign('settings', NLSettings::get_all());
		$GLOBALS['core.ajax']->put_to_output(array(
			'success' => true, 
			'html' => $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/settings.tpl')));
	}

	function process_settings_save_ajax(){
		NLSettings::save_all($_REQUEST);
		$this->process_settings_list_ajax();
	}
	
	function get_js()
	{
		return array();
	}

        function process_view_html()
        {
            //pp($_REQUEST);
		$title = (isset($_REQUEST['params_to_pars'][0])&&!empty($_REQUEST['params_to_pars'][0])) ? $_REQUEST['params_to_pars'][0] : null;
                $user_id = (isset($_REQUEST['params_to_pars'][1])&&!empty($_REQUEST['params_to_pars'][1])) ? $_REQUEST['params_to_pars'][1] : null;
                $html = "";
                if(!is_null($title) && !is_null($user_id))
                {
                    $mail_id = $GLOBALS['core.sql']->getOne('SELECT p.mail_id FROM #p#nl_posting p WHERE p.title=?',$title);
                    $mail_holder = new MailItem($mail_id);
                    $mail = $mail_holder->get_data();
                    $html = $mail['html'];
                    $user = $GLOBALS['core.sql']->getRow('SELECT u.* FROM #p#nl_user u WHERE u.id=?',$user_id);
                    if(isset($user['first_name']) && isset($user['last_name']))
                    {
                        $html = str_replace(
                                array('[name]', '[now]','[first_name]','[last_name]'),
                                array($user['first_name'].' '.$user['last_name'], date('Y-m-d H:i:s'),$user['first_name'],$user['last_name']),
                                $html);
                    }
                    NLProcess::prepare_links($html,$mail['campaign_settings']);
                }
		return $html;
	}

        function process_sent_mail_read()
        {
			$id = (isset($_REQUEST['id']) && $_REQUEST['id']>0) ? $_REQUEST['id'] : null;
			$key = (isset($_REQUEST['key']) && !empty($_REQUEST['key'])) ? $_REQUEST['key'] : null;
	
            $hash = SentMailOptions::get_read_hash($id);
			if ($hash==$key)
			{
	        	SentMailOptions::set_read($id);
			}
			
			$conf = $GLOBALS['core.config']->get_config('templates');
			$img_url = $conf['common']['img_url'];
			//print $img_url;
			
			$handle = fopen("./css/images/1px.gif", "rb");
			
			header("Content-type:image/gif");
			while (!feof($handle))
			{
				print fread($handle, 8192);
			}
			fclose($handle);
		}

        //-- readreport -------------------------------------------------------------------------------------
	function process_readreport_list_ajax(){
		$start_index = isset($_REQUEST['startIndex']) ? $_REQUEST['startIndex'] : 0;
		$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
		$sort = isset($_REQUEST['sort'])? $_REQUEST['sort'] : '';
		$page_size = isset($_REQUEST['results']) ? $_REQUEST['results'] : null;
		$filters = (isset($_REQUEST['filter']) && !empty($_REQUEST['filter'])) ? $_REQUEST['filter'] : array();
        $group_by = ReadReportItem::prepare_group_by();
		$list_class = new ReadReportList();
		$to_return = $list_class->get_page($start_index, $sort, $dir, $page_size, $filters, $group_by);
		$GLOBALS['core.ajax']->yui_to_output($to_return);
	}

         //-- unsubscribereport -------------------------------------------------------------------------------------
	function process_unsubscribereport_list_ajax(){
		$start_index = isset($_REQUEST['startIndex']) ? $_REQUEST['startIndex'] : 0;
		$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
		$sort = isset($_REQUEST['sort'])? $_REQUEST['sort'] : '';
		$page_size = isset($_REQUEST['results']) ? $_REQUEST['results'] : null;
		$filters = (isset($_REQUEST['filter']) && !empty($_REQUEST['filter'])) ? $_REQUEST['filter'] : array();

		$list_class = new UnsubscribeReportList();
		$to_return = $list_class->get_page($start_index, $sort, $dir, $page_size, $filters);
		$GLOBALS['core.ajax']->yui_to_output($to_return);
	}

        function process_send_test_mail_ajax(){

                $success = false;
                $id = (isset($_REQUEST['posting_id']) && $_REQUEST['posting_id']>0) ? $_REQUEST['posting_id'] : null;
		//$obj = new MethodItem($id);
		if (isset($_REQUEST['send']) && !empty($_REQUEST['send']) && !is_null($id)) {
                    
                    $GLOBALS['core.validator']->add('email',$_REQUEST['email'],'va_email');
                    $errors = $GLOBALS['core.validator']->check();
                    if (isset($errors['email'])) {
                        $GLOBALS['core.smarty']->assign('errors',$errors);
                        $GLOBALS['core.smarty']->assign('data',$_REQUEST);
                    } else {
                        $posting_holder = new PostingItem($id);
                        $mail_id = $posting_holder->__get('mail_id');
                        $mail_holder = new MailItem($mail_id);
                        $mail = $mail_holder->get_data();
                        $user = array('email'=>$_REQUEST['email'],'text_type'=>0);
                        NLProcess::send_mail($user, $mail);
                        $success = true;
                    }
                    
		}

                $GLOBALS['core.smarty']->assign('id',$id);
		$GLOBALS['core.ajax']->put_to_output(array('success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/NewsLetter/send_test_mail.tpl')));
	}

    function import_test_users()
    {
		for ($i=1001; $i<3001; $i++)
		{                                
            $email = 'quantumtest_' . $i . '@evaxsoft.com';
			$data = array(
				'first_name'	=> 'first_' . $i,
				'last_name'	=> 'last_' . $i,
				'postcode'	=> 2045,
				'email'		=> $email,
                'text_type'	=> 0);
                
			$obj = new UserItem();
			$obj->set_data($data);
			$obj->save();

			UserGroup::user_update_groups($obj->id, array(1));
		}
		
    	//$posting_obj = new PostingItem(61);
    	//$users = $posting_obj->get_users_batch(0, 50);
    	//pp($users);
    	/*
    	require_once('classes/NewsLetter/SentMailOptions.php');
    	$sent_mail_data = array();
        $sent_mail_data['posting_id'] = 61;
        $sent_mail_data['user_id'] = 18001;
        $sent_mail_data['type'] = 'group';
        $mail_id = SentMailOptions::save_mail($sent_mail_data);
        $mail_id = SentMailOptions::save_mail($sent_mail_data);
        */
    	//NLProcess::Process();
    	
	}
}
