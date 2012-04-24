<?php
require_once('classes/UserHolder.php');
require_once('Admin_Header.php');
require_once('classes/WholesaleHolder.php');

class UserList extends Runmode 
{
	function UserList()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();		
	}
	
	function process()
	{
		$highlight_id = 0;
		
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{			
			$data = array();
			$error = false;
			$id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
			$highlight_id = $id;
			if (isset($_REQUEST['login']) && !empty($_REQUEST['login']))
			{	
				$data['login'] = $_REQUEST['login'];
				if (!$this->_check_login($_REQUEST['login'],$id))
				{
					$error = true;
					$GLOBALS['core.smarty']->assign('status_code','login_unique_e');
				}
			}

			if (isset($_REQUEST['email']) && !empty($_REQUEST['email']))
			{
				$data['email'] = $_REQUEST['email'];		
				if (!$this->_check_email($data['email'],$id))
				{
					$error = true;
					$GLOBALS['core.smarty']->assign('status_code','email_unique_e');
				}
			}
			else $error = true;
			
			if (isset($_REQUEST['discount_point']))
			{
				$data['discount_point'] = $_REQUEST['discount_point'];
			}
			
			if (isset($_REQUEST['pass']) && !empty($_REQUEST['pass'])
				&& isset($_REQUEST['password_confirmation']) 
				&& $_REQUEST['pass'] == $_REQUEST['password_confirmation'])
				{
					$data['password'] = md5($_REQUEST['pass']);
				}
				else 
				{
					if (empty($id) || !empty($_REQUEST['pass']))
					{					
						$error = true;
						$GLOBALS['core.smarty']->assign('status_code','password_mismatch_e');
					}
				}
			$data['wholesale'] = (isset($_REQUEST['wholesale'])) ? 1 : 0;	
			
			$data['groups'] = 'user';
					
			if (!$error)
			{												
				$to_save = new UserHolder($id);
				$to_save->set_data($data);
				$to_save->save();
				$highlight_id = $to_save->get_key_value();
				
				$wh = new WholesaleHolder();				
				if (empty($data['wholesale']) || !isset($_REQUEST['wholesales_ids']))	$wh->deleteWholesalesForUser($highlight_id);
				if (isset($_REQUEST['wholesales_ids']) && !empty($data['wholesale']))	$wh->addWholesalesForUser($highlight_id,$_REQUEST['wholesales_ids']);
				
				$profile_data = $to_save->gatherBillingAndShipping();
				$profile_data['billing']['user_id'] = $to_save->get_key_value();
				$profile_data['shipping']['user_id'] = $to_save->get_key_value();
				$to_save->saveBilling($profile_data['billing']);
				$to_save->saveShipping($profile_data['shipping']);
				
				if (!empty($id)) $GLOBALS['core.smarty']->assign('status_code','agent_updated');
				else $GLOBALS['core.smarty']->assign('status_code','agent_added');
			}			
			else 
			{
				$data['user_id'] = $id;
				$GLOBALS['core.smarty']->assign('data',$data);
			}
		}
				
		if (isset($_REQUEST['action']))
		{
			if ($_REQUEST['action'] == 'edit')
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					$curagent = new UserHolder($_REQUEST['id']);
					$group = $curagent->get_data('groups');					
					if (substr_count($group,'admin') == 0)
					{
						$GLOBALS['core.smarty']->assign('data',$curagent->getFullData());
						$highlight_id = $curagent->get_key_value();
					}
				}
			}
			if ($_REQUEST['action'] == 'delete')
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					$curagent = new UserHolder($_REQUEST['id']);
					$group = $curagent->get_data('groups');					
					if (substr_count($group,'admin') == 0)
					{
						//$curagent->set_data(array('disabled' => 1));
						//$curagent->save();
						$curagent->delete();
						$GLOBALS['core.smarty']->assign('status_code','agent_deleted');
					}
				}
			}
		}

		$agent = new UserHolder();
		$list = $agent->getAllWithFullData();
		$search = array();
		if (isset($_REQUEST['search']) && !empty($_REQUEST['search']))
		{
			if (isset($_REQUEST['search_name']) && !empty($_REQUEST['search_name']))
				$search['name'] = $_REQUEST['search_name'];
			if (isset($_REQUEST['search_login']) && !empty($_REQUEST['search_login']))
				$search['login'] = $_REQUEST['search_login'];
				
			foreach ($list as $key => $value)
			{
				if (isset($_REQUEST['search_name']) && !empty($_REQUEST['search_name']))
				{
					if (substr_count($value['billing']['name'],$_REQUEST['search_name']) == 0) 
					{
						unset($list[$key]);
						continue;
					}
				}
				if (isset($_REQUEST['search_login']) && !empty($_REQUEST['search_login']))
				{
					if (substr_count($value['login'],$_REQUEST['search_login']) == 0) 
					{
						unset($list[$key]);
						continue;
					}
				}
			}
		}
		$GLOBALS['core.smarty']->assign('search', $search);
		$GLOBALS['core.smarty']->assign('highlight_id',$highlight_id);
		$GLOBALS['core.smarty']->assign('agents',$list);
		
		$wh = new WholesaleHolder();
		$wholesales = $wh->getAll();
		$GLOBALS['core.smarty']->assign('wholesales', $wholesales);
				
		return Admin_Header::out('user_list');
	}
	
	function _check_login($login , $id)
	{
		$agent = new UserHolder($id);
		return $agent->check_login($login);
	}
	
	function _check_email($email, $id)
	{
		$agent = new UserHolder($id);
		return $agent->check_email($email);
	}
}
?>