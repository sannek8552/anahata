<?php
require_once('Data_Holder.php');
class Popup_Holder extends Data_Holder_Simple
{
    function Popup_Holder($id = null)
    {
        $key_info = array('key_name' => 'id');
        if(!is_null($id))
        {
            $key_info['key_value'] = $id;
        }
        $this->init('popup_module',$key_info);
    }
    function get_all()
    {
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#popup_module', array(), 'id');
    }
    function get_module_list()
    {
        $to_ret = array();
        $res = $this->get_all();
        $GLOBALS['core.smarty']->assign('popup_tab', 1);
        foreach ($res as $key => $value)
        {
            $to_ret[] = array('code'=> '[popup_module?section=' . $value['id'] . ']','description' => $value['page_seo']);
        }
        return $to_ret;
    }
}

?>
