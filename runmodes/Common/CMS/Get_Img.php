<?php
require_once('classes/CMS/kcaptcha/kcaptcha.php');
class Get_Img extends Runmode 
{
	function Get_Img()
	{
		$this->base_map[0] = 'section';
		parent::Runmode();
	}
	function process()
	{
		if(!isset($_REQUEST['section']))
			exit();
		$captch = new KCAPTCHA();
		$_SESSION['protect_' . $_REQUEST['section']] = $captch->getKeyString();
		//$GLOBALS['core.log']->do_log('capcha code=' .$_SESSION['protect_' . $_REQUEST['section']],'test');
		return '';
	}
}
?>