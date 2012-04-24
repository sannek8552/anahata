<?php
require_once('CMS/Popup_Holder.php');
require_once('CMS/Page_Factory.php');

class Page_Popup_Runmode extends Runmode
{
    function Page_Popup_Runmode()
    {
        parent::Runmode();
    }
    function process()
    {
        if(isset($_REQUEST['section']) && is_numeric($_REQUEST['section']))
        {
            $pph = new Popup_Holder($_REQUEST['section']);
            $GLOBALS['core.smarty']->assign('request', $pph->get_data());
            unset($_REQUEST['section']);
            return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/popup_module.tpl');
        }
        elseif(isset($_REQUEST['page_seo']) && $_REQUEST['page_seo'] != '')
        {
            $GLOBALS['core.smarty']->assign('request', $_REQUEST);
            return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/popup_module.tpl');
        }
        
    }
    function process_ajax()
    {
        $_REQUEST = $_REQUEST['q'];
        $GLOBALS['text_to_init'] = '';
        $factory = new Page_Factory();
        $page = $factory->create_by_seo($_REQUEST['page_seo'], $menu_id);
        if(isset($_REQUEST['page_width']) && is_numeric($_REQUEST['page_width']))
        {
            $GLOBALS['core.smarty']->assign('page_width', $_REQUEST['page_width']);
        }
        if(isset($_REQUEST['page_height']) && is_numeric($_REQUEST['page_height']))
        {
            $GLOBALS['core.smarty']->assign('page_height', $_REQUEST['page_height']);
        }
        if(is_null($page))
        {
            $GLOBALS['core.smarty']->assign('content', $GLOBALS['core.smarty']->fetch('Common/pear_error_runmode.tpl'));
        }
        else
        {

            $data = $page->display($menu_id);
            if(empty($_REQUEST['page_seo']))
            {
                $_REQUEST['page_seo'] = $data['seo_url'];
            }

            $GLOBALS['core.smarty']->assign('seo_url', $_REQUEST['page_seo']);
            $GLOBALS['core.CMS.seo_url'] = $_REQUEST['page_seo'];
            $GLOBALS['core.smarty']->assign('content', $data['content']);
        }


        $output_array = array('success' => 0);
        $output_array['html'] = $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/popup_page.tpl');
        $GLOBALS['core.ajax']->put_to_output($output_array);
    }
}
?>
