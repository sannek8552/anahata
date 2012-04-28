<?php
require_once('Common_Header.php');
require_once('classes/PrepsHolder.php');

class Preps extends Runmode
{
	function Preps()
	{

		parent::Runmode();
                $seo_data['page_title'] = 'Преподаватели';
                $GLOBALS['core.smarty']->assign('seo_data', $seo_data);
	}
	
	function process()
	{
                
                $ph = new PrepsHolder();
                $preps = $ph->get_all();

                $GLOBALS['core.smarty']->assign('preps', $preps);

                return Common_Header::out('Common/preps');
		
	}
}

?>