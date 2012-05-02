<?php
require_once('Common_Header.php');
require_once('classes/CMS/Gallery_One_Holder.php');

class Photogallery extends Runmode
{
	function Photogallery()
	{
		$this->base_map[0] = 'gallery_id';
                $this->base_map[1] = 'page';
		
		parent::Runmode();

                $seo_data['page_title'] = 'Фотогалерея';
                $GLOBALS['core.smarty']->assign('seo_data', $seo_data);
	}
	
	function process()
	{
                
                if (isset($_REQUEST['gallery_id'])) {
                    $gh = new Gallery_One_Holder($_REQUEST['gallery_id']);
                    $ph = $gh->get_picture_holder();
                    $galleryInfo = $gh->get_data();
                    $GLOBALS['core.smarty']->assign('galleryInfo', $galleryInfo);

                    $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
                    $ph->get_page($page, true);


                    return Common_Header::out('Common/CMS/Page_Runmode/gallery_one_module');

                } else {
                    $gh = new Gallery_One_Holder();
                    $galleries = $gh->get_all();

                    $GLOBALS['core.smarty']->assign('galleries', $galleries);

                    return Common_Header::out('Common/photogallery');
                }
		
	}
}

?>