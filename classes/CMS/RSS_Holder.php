<?php
require_once('Data_Holder.php');

class RSS_Holder extends Data_Holder_Simple
{
    function RSS_Holder($id = null)
    {
        $key_info = array('key_name' => 'rss_id');
        if(!is_null($id))
        {
            $key_info['key_value'] = $id;
        }
        $this->init('rss', $key_info);
    }
    function get_module_list()
    {
        $to_ret = array();
        $res = $this->get_all();
        foreach ($res as $key => $value)
        {
            $to_ret[] = array('code'=> '[feed_reader?section=' . $value['rss_id'] . ']','description' => $value['rss_url']);

        }
        return $to_ret;
    }
    function get_all()
    {
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#rss ORDER BY rss_id', array(), 'rss_id');
    }
}
?>
