<?php
require_once('classes/CMS/Text_Manager_Holder.php');
class Page_Text_Runmode extends Runmode 
{
	function Page_Text_Runmode()
	{
		parent::Runmode();
	}
	
	function process()
	{
		$entry = $_REQUEST['entry'];
		$holder = new Text_Manager_Holder($entry);
		return $holder->get_data('module_text');
	}
}
?>