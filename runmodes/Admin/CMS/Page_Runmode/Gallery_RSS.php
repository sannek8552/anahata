<?php

require_once('Admin_Header.php');
require_once('classes/CMS/RSS_Holder.php');

class Gallery_RSS extends Runmode
{
    function Gallery_RSS()
    {
        $this->base_map[0] = 'action';
        $this->base_map[1] = 'id_rss';
        $GLOBALS['core.smarty']->assign('current_sub', 'RSS');
        $GLOBALS['core.smarty']->assign('current_menu','Modules');
        parent::Runmode();
    }
    function process()
    {
        if(isset($_REQUEST['id_rss']) && is_numeric($_REQUEST['id_rss']))
        {
            $rh = new RSS_Holder($_REQUEST['id_rss']);
        }
        else
        {
            $rh = new RSS_Holder();
        }
        $data = array(  'rss_url'=>'',
                        'rss_ajax'=>0,
                        'rss_title'=>0,
                        'rss_pubdate'=>0,
                        'rss_description'=>0,
                        'rss_id' => 0,
                        'rss_list'=>15
                    );
        if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
        {
            $data1 = $data;
            if (isset($_REQUEST['rss_url'])	&& !empty($_REQUEST['rss_url']))    $data1['rss_url'] = $_REQUEST['rss_url'];
            if (isset($_REQUEST['rss_ajax']) && !empty($_REQUEST['rss_ajax']))  $data1['rss_ajax'] = 1;
            if (isset($_REQUEST['rss_title']) && !empty($_REQUEST['rss_title']))    $data1['rss_title'] = 1;
            if (isset($_REQUEST['rss_pubdate']) && !empty($_REQUEST['rss_pubdate']))    $data1['rss_pubdate'] = 1;
            if (isset($_REQUEST['rss_description']) && !empty($_REQUEST['rss_description']))    $data1['rss_description'] = 1;
            //if (isset($_REQUEST['hid_id']) && !empty($_REQUEST['hid_id'])&& preg_match('/[0-9]+/i', $_REQUEST["hid_id"]))$data1['rss_id'] = $_REQUEST['hid_id'];
            if (isset($_REQUEST['rss_list']) && !empty($_REQUEST['rss_list'])&& preg_match('/[0-9]+/i', $_REQUEST["rss_list"]))$data1['rss_list'] = $_REQUEST['rss_list'];
            //$this->save($data1);
            $rh->set_data($data1);
            $rh->save();
        }
        if (isset($_REQUEST['action']) && $_REQUEST['action']=='edit')
        {
            //$this->edit($_REQUEST['id_rss']);
            $data = $rh->get_data();
            $this->smarty($data);
        }
        else
        {
            $this->smarty($data);
        }
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
        {
            //$this->delete($_REQUEST['id_rss']);
            $rh->delete();
        }
        $data_all = $rh->get_all();
        $GLOBALS['core.smarty']->assign('data', $data_all);
        return Admin_Header::out('/CMS/Page_Runmode/admin_rss');
    }
   /* function delete($id)
    {
        $key_info = array('key_name'=>'rss_id', 'key_value' => $id);
        $GLOBALS['core.store']->delete('rss', $key_info);
    }
    function edit($id)
    {
        $sql='SELECT * FROM #p#rss WHERE rss_id=?';
        $data=$GLOBALS['core.sql']->getRow($sql,array($id));
        $this->smarty($data);
    }*/
    function smarty($data)
    {
        foreach ($data as $k => $v)
        {
            $GLOBALS['core.smarty']->assign($k, $v);
        }
    }
    /*function save($data)
    {
        if ($data['rss_id']!=0 && (preg_match('/[0-9]+/i',$data['rss_id'])))
        {
            $key_info = array('key_name'=>'rss_id','key_value' => $data['rss_id']);
            $GLOBALS['core.store']->save('rss', $data, $key_info);
        }
        else
        {
            $key_info = array('key_name'=>'rss_id');
            $GLOBALS['core.store']->save('rss', $data, $key_info);
        }
    }*/
}


?>