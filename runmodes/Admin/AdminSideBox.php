<?php
require_once('Admin_Header.php');
require_once('classes/CMS/SideBox_Holder.php');

class AdminSideBox extends Runmode
{
	function AdminSideBox()
	{
		$this->base_map[0] = 'action';
                $this->base_map[1] = 'id';
                parent::Runmode();
	}
	
	function process()
	{
		//pp($_REQUEST);
                $id = (isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))?$_REQUEST['id']:null;
                
                if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
                {
                    $this->process_save($id);
                }
                elseif(isset($_REQUEST['action']) && $_REQUEST['action']=='edit')
                {
                    $this->process_edit($id);
                }
                elseif(isset($_REQUEST['action']) && $_REQUEST['action']=='delete')
                {
                    $this->process_delete($id);
                }

                $sbh = new SideBox_Holder();
                $all_data = $sbh->get_all_sideboxes();
                $GLOBALS['core.smarty']->assign('all_data',$all_data);

                $pages = $sbh->getPagesForSelect();
                $GLOBALS['core.smarty']->assign('pages',$pages);
                //pp($pages);


		return Admin_Header::out('CMS/admin_side_box');
	}
	
	function process_save($id)
	{
		$data = array();
                $data['title']      =   (isset($_REQUEST['title']) && !empty($_REQUEST['title']))?$_REQUEST['title']:'';
                $data['text']       =   (isset($_REQUEST['text']) && !empty($_REQUEST['text']))?$_REQUEST['text']:'';
                $data['active']     =   (isset($_REQUEST['active']) && !empty($_REQUEST['active']))?1:0;
                $data['order_no']   =   (isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no']) && is_numeric($_REQUEST['order_no']))?$_REQUEST['order_no']:0;
                $data['cms_url']    =   (isset($_REQUEST['cms_url']) && !empty($_REQUEST['cms_url']))?$_REQUEST['cms_url']:'';
                $data['external_url'] = (isset($_REQUEST['external_url']) && !empty($_REQUEST['external_url']))?$_REQUEST['external_url']:'';
                
                if(!empty($data))
                {
                    $sbh = new SideBox_Holder($id);
                    $sbh->set_data($data);
                    $sbh->save();
                }
                
	}
        function process_edit($id)
	{
		if(!is_null($id))
                {
                    $sbh = new SideBox_Holder($id);
                    $GLOBALS['core.smarty']->assign('data',$sbh->get_data());
                }

	}
        function process_delete($id)
	{
                if(!is_null($id))
                {
                    $sbh = new SideBox_Holder($id);
                    $sbh->delete();
                    //$GLOBALS['core.smarty']->assign('data',$sbh->get_data());
                }

	}
        
	
}
?>