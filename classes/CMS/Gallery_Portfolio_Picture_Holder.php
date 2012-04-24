<?php
require_once('Data_Holder.php');

class Gallery_Portfolio_Picture_Holder extends Data_Holder_Simple 
{
	
	var $gallery_holder = null;
	function Gallery_Portfolio_Picture_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		
		$this->init('gallery_portfolio_module_picture', $key_info);
	}
	
	function get_page($page_num = '', $status = false)
	{
		
		$GLOBALS['core.application']->init_module('list', true);
		$filters = array();
		if($status)
			$filters[] = array('f' => 'status', 'v' => '1');
		$filters[] = array('f' => 'gallery_id', 'v' => $this->data['gallery_id']);
		$GLOBALS['core.list']->custom_init('gallery_portfolio_list_' . $this->get_key_value());
		
		$GLOBALS['core.list']->set_filters($filters);
		$GLOBALS['core.list']->set_sql('* FROM #p#gallery_portfolio_module_picture');
		
		$GLOBALS['core.list']->set_param('order_by', array('order_no'));
		$GLOBALS['core.list']->set_param('items_per_page', $this->gallery_holder->get_data('items_per_page'));
		
		$page = $GLOBALS['core.list']->get_page($page_num);
		$num = $GLOBALS['core.list']->num_pages();
				
		$GLOBALS['core.smarty']->assign('page', $page);
		$GLOBALS['core.smarty']->assign('num', $num);
	}
	
	function assign_to_smarty()
	{
		foreach ($this->data as $key => $value)
		{
			$GLOBALS['core.smarty']->assign($key, $value);
		}
	}
	
	function gather_data_from_request($double=null)
	{
		$this->save();
		
		$data = array();
		$err = array();
		
		if(isset($_REQUEST['name'])){
			$data['name'] = $_REQUEST['name'];
		} else {
			$err['name'] = 1;
		}
		
		if(isset($_REQUEST['description'])){
			$data['description'] = $_REQUEST['description'];
		} else {
			$err['description'] = 1;
		}

		if(isset($_REQUEST['elements']))
			$data['elements'] = $_REQUEST['elements'];
		if(isset($_REQUEST['url']))
			$data['url'] = $_REQUEST['url'];
		
		if(isset($_REQUEST['order_no'])){
			$data['order_no'] = $_REQUEST['order_no'];
		} else {
			$err['order_no'] = 1;
		}
		
		//now need to process pic1 and pic2
		
		$cur_id = $this->get_key_value();
		//pp($_FILES);
		if($_FILES['pic1']['size'] > 0 && $_FILES['pic1']['error'] == 0){
			
		}elseif (is_null($cur_id)){
			$err['pic1'] = 1;
		}
		
		/*if($_FILES['pic2']['size'] > 0 && $_FILES['pic2']['error'] == 0){
			
		} elseif (is_null($cur_id)) {
			$err['pic2'] = 1;
		}*/
		
		$GLOBALS['core.application']->init_module('gd_module', true);
		if(empty($err))
		{
			
			if($_FILES['pic1']['size'] > 0 && $_FILES['pic1']['error'] == 0){
				$this->delete_pictures();
				//$_FILES['pic1']['name'] = strtolower($_FILES['pic1']['name']);
				$data['pic1'] = $this->create_file_name($_FILES['pic1']['tmp_name'], 1);
				move_uploaded_file($_FILES['pic1']['tmp_name'], './gallery/'.$data['pic1']);
				$GLOBALS['core.image']->create_thumb('./gallery/'.$data['pic1'], './gallery/525_'.$data['pic1'], 529, 345);
				$GLOBALS['core.image']->create_thumb_crop('./gallery/'.$data['pic1'], './gallery/thumb_'.$data['pic1'], 170, 112);
			}
			/*if($_FILES['pic2']['size'] > 0 && $_FILES['pic2']['error'] == 0){
				$this->delete_pictures(2);
				//$_FILES['pic2']['name'] = strtolower($_FILES['pic2']['name']);
				$data['pic2'] = $this->create_file_name($_FILES['pic2']['tmp_name'], 2);
				move_uploaded_file($_FILES['pic2']['tmp_name'], './gallery/'.$data['pic2']);
				$GLOBALS['core.image']->create_thumb('./gallery/'.$data['pic2'], './gallery/240_'.$data['pic2'], 240, 180, '', 0xffffff);
				$GLOBALS['core.image']->create_thumb_crop('./gallery/'.$data['pic2'], './gallery/100_'.$data['pic2'], 100, 80);
				$GLOBALS['core.image']->create_thumb_height('./gallery/'.$data['pic2'], './gallery/h180_'.$data['pic2'], 180);
			}*/
			$this->set_data($data);
			$this->save();

			if($double && $_FILES['pic1']['size']>0 && $_FILES['pic1']['error']==0 && $_FILES['pic2']['size']>0 && $_FILES['pic2']['error']==0){
				$GLOBALS['core.image']->image_union(
					'./gallery/'.$data['pic1'],
					'./gallery/'.$data['pic2'],
					$double['w'],
					$double['h'],
					'./gallery/double_'.$data['pic1']
					);
			}

		}
	}
	
	
	function delete()
	{
		$this->delete_pictures();
		parent::delete();
	}
	
	function mass_delete($gallery_id)
	{
		$all = $GLOBALS['core.sql']->getAll('SELECT pic1,pic2 FROM #p#gallery_portfolio_module_picture WHERE gallery_id=?',array($gallery_id));
		foreach ($all as $key => $value)
			$this->delete_pictures($value['pic1']);
		
		$GLOBALS['core.sql']->query('DELETE FROM #p#gallery_portfolio_module_picture WHERE gallery_id=?',array($gallery_id));
	}
	
	function delete_pictures($pic=null){
		if(!$pic && isset($this->data['pic1'])) $pic = $this->data['pic1'];
		@unlink('./gallery/'.$pic);
		@unlink('./gallery/525_'.$pic);
		@unlink('./gallery/thumb_'.$pic);
	}

	function create_file_name($fn){
		$ext = array(1 =>'.gif', 2 => '.jpg', 3 => '.png');
		$size = getimagesize($fn);
		return  str_repeat(0, 4-strlen($this->get_key_value())).$this->get_key_value().$ext[$size[2]];
	}
	
	function get_for_home($gallery_id=1){
		return $GLOBALS['core.sql']->getAll(
			"SELECT p.* ".
			"FROM #p#gallery_portfolio_module_picture AS p ".
			"WHERE gallery_id=? ".
			"ORDER BY RAND()".
			"LIMIT 0, 2",
			array($gallery_id)
			);
	}

	function get_galery_pic($gallery_id){
		return $GLOBALS['core.sql']->getAll(
			"SELECT p.* ".
			"FROM #p#gallery_portfolio_module_picture AS p ".
			"WHERE p.gallery_id=? ".
			"ORDER BY p.order_no, p.id",
			array($gallery_id)
			);
	}
}
?>