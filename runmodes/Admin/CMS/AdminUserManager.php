<?php
require_once('Admin_Header.php');
require_once('classes/CMS/User/CMSUser.php');
require_once('classes/CMS/User/CMSUserList.php');
class AdminUserManager extends Runmode 
{
	protected $user_list;
	function AdminUserManager()
	{
		$this->user_list = new CMSUserList();
		parent::make_params();
	}
	
	function process()
	{
		$GLOBALS['core.smarty']->assign('user_column_defs', $this->user_list->get_column_defs());
                $GLOBALS['core.smarty']->assign('user_source_fields', $this->user_list->get_source_fields());
		return Admin_Header::out('CMS/admin_user_manager', $this);
	}
	
	function get_js()
	{
		return array('tabview','datatable','user','container');
	}
	
	function process_ajax()
	{
                
		$start_index = 0;
                if(isset($_REQUEST['startIndex']))
                    $start_index = $_REQUEST['startIndex'];
                $dir = 'asc';
                if(isset($_REQUEST['dir']))
                    $dir = $_REQUEST['dir'];
                $sort = '';
                if(isset($_REQUEST['sort']))
                    $sort = $_REQUEST['sort'];
                $page_size = '';
                if(isset($_REQUEST['results']))
                        $page_size = $_REQUEST['results'];
                $filters = array();
                //$filters['login'] = 'adm';

                if(isset($_REQUEST['filter']) && !empty($_REQUEST['filter']))
                {
                        $filters = $_REQUEST['filter'];
                }
                $to_return = $this->user_list->get_page($start_index,$sort, $dir, $page_size, $filters);
               // $to_return ='';
                return $GLOBALS['core.ajax']->yui_to_output($to_return);
                //pp($GLOBALS['core.ajax']->yui_to_output($to_return));
	}
	
	function get_user_information()
	{
		$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
                $user = new CMSUser($user_id);

                $GLOBALS['core.smarty']->assign('user_info', $user->get_data());
                            
                $GLOBALS['core.ajax']->put_to_output(array('html' => $GLOBALS['core.smarty']->fetch('Admin/CMS/User/user_info.tpl')));
	}
        
        function edit_user()
	{
		$user_id = (isset($_REQUEST['user_id']) && $_REQUEST['user_id']>0) ? $_REQUEST['user_id'] : null;

		$user = new CMSUser($user_id);
		$success = false;
		$err = null;
		
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
                {
                    
                    $data = $_REQUEST;
                    $err = $user->validate($data);
                    //pp($err);
                    if(empty($err))
                    {
                        $user->set_data($_REQUEST);
                        $user->save();
                        $GLOBALS['core.smarty']->assign('saved', 1);
                        $success = true;
                    } 
                    else
                    {
                        $GLOBALS['core.smarty']->assign('err', $err);

                        $data_to_assign = $data;
                        $groups = array();
                        foreach($data_to_assign['groups'] as $group)
                        {
                            $groups[$group] = $group;
                        }
                        $GLOBALS['core.smarty']->assign('groups', $groups);
                        $GLOBALS['core.smarty']->assign('user_info', $data_to_assign);
                    }
                    
                }
                else
                {
                    $data_to_assign = $user->get_data();
                    $data_to_assign['groups'] = explode(',', $data_to_assign['groups']);
                    $groups = array();
                    foreach($data_to_assign['groups'] as $group)
                    {
                        $groups[$group] = $group;
                    }
                    $GLOBALS['core.smarty']->assign('groups', $groups);
                    $GLOBALS['core.smarty']->assign('user_info', $data_to_assign);
                }
                

                if(!is_null($user_id))
                    $GLOBALS['core.ajax']->put_to_output(array('success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/CMS/User/edit_user.tpl')));
                else
                    $GLOBALS['core.ajax']->put_to_output(array('success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/CMS/User/add_user.tpl')));
	}
        function change_password()
	{
		$user_id = (isset($_REQUEST['user_id']) && $_REQUEST['user_id']>0) ? $_REQUEST['user_id'] : null;

		$user = new CMSUser($user_id);
		$success = false;
		$err = null;
                //pp($_REQUEST);
		if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
                {

                    $data = $_REQUEST;
                    //pp($data);
                    $err = $user->validate_password($data);
                    //pp($err);
                    if(empty($err))
                    {
                        $user->set_data($_REQUEST);
                        $user->save();
                        //$GLOBALS['core.smarty']->assign('saved', 1);
                        $success = true;
                    }
                    else
                    {
                        $GLOBALS['core.smarty']->assign('err', $err);
                        $GLOBALS['core.smarty']->assign('user_info', $user->get_data());
                    }

                }
                else
                    $GLOBALS['core.smarty']->assign('user_info', $user->get_data());
                


                $GLOBALS['core.ajax']->put_to_output(array('success' => $success, 'html' => $GLOBALS['core.smarty']->fetch('Admin/CMS/User/change_password.tpl')));
	}
        function delete_user()
        {
                
                
                $success = false;
		$user_id = (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : null;
		$user = new CMSUser($user_id);
                $err = $user->validate_last_user();
                if(isset($err['isLastUser']) && !$err['isLastUser'])
                {
                    $success = true;
                    $user->delete();
                }
                $GLOBALS['core.ajax']->put_to_output(array('success'=>$success,'errors'=>$err));
	}
}
?>