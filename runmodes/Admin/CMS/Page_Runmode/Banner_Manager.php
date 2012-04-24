<?php
require_once('Admin_Header.php');
require_once('classes/CMS/BannerItem.php');
require_once('classes/CMS/BannerList.php');

class Banner_Manager extends Runmode 
{
	function Banner_Manager()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		//$this->base_map[2] = 'action2';
		//$this->base_map[3] = 'num';
		parent::Runmode();
		//$GLOBALS['core.smarty']->assign('current_sub', 'Gallery');
		//$GLOBALS['core.smarty']->assign('current_menu','Modules');
	}
	
	function process(){
		if(isset($_REQUEST['action']) && $_REQUEST['action']=='save'){
			$id = isset($_REQUEST['id']) && $_REQUEST['id']>0 ? $_REQUEST['id'] : null;
			$banner = new BannerItem($id);
			$banner->set_data($_REQUEST['data']);
			$banner->save();

			if(isset($_FILES['img']) && $_FILES['img']['size']>0 && $_FILES['img']['error'] == 0){
				$fn = $_FILES['img']['tmp_name'];
				if(strtolower(substr($_FILES['img']['name'], -3))=='swf'){
					$newfile = str_repeat(0, 4-strlen($banner->id)).$banner->id.'.swf';
					copy($fn, './upload/banner/'.$newfile);
				} else {
					$ext = array(1 =>'.gif', 2 => '.jpg', 3 => '.png');
					$size = getimagesize($fn);
	
					$newfile = str_repeat(0, 4-strlen($banner->id)).$banner->id.$ext[$size[2]];
	
					$old_img = null;
					switch($size[2]){
						case 1: $old_img = imagecreatefromgif($fn); break;
						case 2: $old_img = imagecreatefromjpeg($fn); break;
						case 3: $old_img = imagecreatefrompng($fn); break;
					}
	
					$new_img = imagecreatetruecolor($_REQUEST['data']['width'], $_REQUEST['data']['height']);
					imagecopyresampled($new_img, $old_img, 0, 0, 0, 0, $_REQUEST['data']['width'], $_REQUEST['data']['height'], $size[0], $size[1]);
					
					switch($size[2]){
						case 1: $old_img = imagegif($new_img, './upload/banner/'.$newfile); break;
						case 2: $old_img = imagejpeg($new_img, './upload/banner/'.$newfile, 100); break;
						case 3: $old_img = imagepng($new_img, './upload/banner/'.$newfile); break;
					}
				}
				$banner->set_data(array('img'=>$newfile));
				$banner->save();
			}
		}
		if(isset($_REQUEST['action']) && $_REQUEST['action']=='edit'){
			$id = isset($_REQUEST['id']) && $_REQUEST['id']>0 ? $_REQUEST['id'] : null;
			$banner = new BannerItem($id);
			$GLOBALS['core.smarty']->assign('data', $banner->get_data());
			$GLOBALS['core.smarty']->assign('swf', substr($banner->img, -3, 3)=='swf');
		}
		if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete'){
			$id = isset($_REQUEST['id']) && $_REQUEST['id']>0 ? $_REQUEST['id'] : null;
			$banner = new BannerItem($id);
			@unlink('./upload/banner/'.$banner->url);
			$banner->delete();
		}

		$list_class = new BannerList();
		$items = $list_class->getAll();
		$GLOBALS['core.smarty']->assign('items', $items);
		return Admin_Header::out('CMS/Page_Runmode/banner');
	}
}
?>