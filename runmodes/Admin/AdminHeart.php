<?php
require_once('Admin_Header.php');

class AdminHeart extends Runmode 
{
	function AdminHeart()
	{
		parent::Runmode();
	}
	
	function process()
	{		
		//pp($_REQUEST);		
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			if (isset($_REQUEST['heart']))
			{				
				$row = $GLOBALS['core.sql']->getRow("select * from #p#heart where id = 1");
				$key_info = array('key_name' => 'id');
				if (!empty($row)) $key_info['key_value'] = 1;
				$GLOBALS['core.store']->save('heart',array('heart' => $_REQUEST['heart']),$key_info);
			}
		}
		
		$heart = $GLOBALS['core.sql']->getOne("select heart from #p#heart where id = 1");
		$GLOBALS['core.smarty']->assign('heart',$heart);
		//pp($heart);
		return Admin_Header::out('admin_heart');
	}
}

?>