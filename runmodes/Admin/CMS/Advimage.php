<?php

class Advimage extends Runmode
{

	function __construct()
	{
		parent::Runmode();
	}

	function process()
	{
		return $GLOBALS['core.smarty']->fetch('Admin/CMS/advimage.tpl');
	}
}
?>