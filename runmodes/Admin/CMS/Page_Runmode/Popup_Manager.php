<?php
require_once('Admin_Header.php');
require_once('CMS/Popup_Holder.php');

class Popup_Manager extends Runmode
{
    function Popup_Manager()
    {
        $this->base_map[0] = 'action';
        $this->base_map[1] = 'id';
        parent::Runmode();
    }
    function process()
    {
        if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
        {
            $pph = new Popup_Holder($_REQUEST['id']);
        }
        else
        {
            $pph = new Popup_Holder();
        }

        if(isset($_REQUEST['send']) && !empty($_REQUEST['send']))
        {
            $fields = array(
                'page_seo' => 'va_string_empty',
                'link_text' => 'va_string_empty',
                'width' => 'va_integer_empty',
                'height' => 'va_string_empty'
            );
            $data = array();
            foreach ($fields as $key => $value)
            {
                if(isset($_REQUEST[$key]))
                {
                    $data[$key] = $_REQUEST[$key];
                }
            }
            $pph->set_data($data);
            $pph->save();
        }
        elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
        {
            $data = $pph->get_data();
            $GLOBALS['core.smarty']->assign('data', $data);
        }
        elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
        {
            $pph->delete();
        }
        $GLOBALS['core.smarty']->assign('popups', $pph->get_all());
        return Admin_Header::out('CMS/Page_Runmode/popup_manager');
    }
}
?>
