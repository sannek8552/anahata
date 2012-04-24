<?php
require_once('Admin_Header.php');

class AdminEmail extends Runmode 
{
	function AdminEmail()
	{
		parent::Runmode();
	}
	
	function process()
	{
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$data = array();
			if (isset($_REQUEST['from_name']) && !empty($_REQUEST['from_name']))
			{
				$data['from_name'] = $_REQUEST['from_name'];
				if (isset($_REQUEST['from_email']) && !empty($_REQUEST['from_email']))
				{
					$data['from_email'] = $_REQUEST['from_email'];
					if (isset($_REQUEST['admin_email']) && !empty($_REQUEST['admin_email']))
					{
						$data['admin_email'] = $_REQUEST['admin_email'];
						$GLOBALS['core.store']->save('email',$data,array('key_name' => 'id','key_value' => 1));
						$GLOBALS['core.smarty']->assign('saved',1);
					}
				}
			}
		}
		$info = $GLOBALS['core.sql']->getRow("select * from #p#email where id = ?",array(1));
		$GLOBALS['core.smarty']->assign('info',$info);
		return Admin_Header::out('admin_email');		
	}
}
?>