<?php
require_once('Admin_Header.php');

class AdminDeposit extends Runmode 
{
	function AdminDeposit()
	{
		parent::Runmode();
		$GLOBALS['core.smarty']->assign('current_menu','Payments');
		//$GLOBALS['core.smarty']->assign('current_sub','Deposit Info');
	}
	
	function process()
	{
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			if (isset($_REQUEST['info']))
			{
				$id = $GLOBALS['core.sql']->getOne("select id from #p#deposit");
				$key_info = array('key_name' => 'id');
				if (!empty($id)) $key_info['key_value'] = $id;
				$GLOBALS['core.store']->save('deposit',array('info' => $_REQUEST['info']),$key_info);
			}
			if (isset($_REQUEST['url']))
			{
				$id = $GLOBALS['core.sql']->getOne("select id from #p#deposit");
				$key_info = array('key_name' => 'id');
				if (!empty($id)) $key_info['key_value'] = $id;
				$GLOBALS['core.store']->save('deposit',array('url' => $_REQUEST['url']),$key_info);
			}
		}
		
		$info = $GLOBALS['core.sql']->getRow("select * from #p#deposit");
		$GLOBALS['core.smarty']->assign('info',$info);
		return Admin_Header::out('admin_deposit');
	}
}
?>