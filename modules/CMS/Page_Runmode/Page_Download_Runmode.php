<?php
require_once('classes/CMS/Download_Holder.php');
require_once('classes/CMS/Download_Entry_Holder.php');
class Page_Download_Runmode extends Runmode
{
    function Page_Download_Runmode()
    {
        //$this->base_map[0] = 'page_num';
        //$this->base_map[0] = 'seo_page';
        parent::Runmode();
    }
    function process()
    {
        if(isset($_REQUEST['section']))
        {
            $deh = new Download_Entry_Holder();
            $data = $deh->get_by_section($_REQUEST['section']);
            $dh = new Download_Holder($_REQUEST['section']);
            $section_name = $dh->get_data('name');
            if (count($GLOBALS['core.auth.user']->groups) > 1 || !empty($section_data['public']))
            {
                $GLOBALS['core.smarty']->assign('data',$data);
                $GLOBALS['core.smarty']->assign('section_name',$section_name);
            }
        }
        return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/download_module.tpl');
            
        
    }
  
}
?>