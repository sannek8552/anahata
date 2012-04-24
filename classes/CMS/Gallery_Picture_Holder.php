<?php
require_once('Data_Holder.php');

class Gallery_Picture_Holder extends Data_Holder_Simple 
{
	
	var $gallery_holder = null;
	function Gallery_Picture_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		
		$this->init('gallery_module_picture', $key_info);
	}
	
	function get_page($page_num = '', $status = false)
	{
		
		$GLOBALS['core.application']->init_module('list', true);
		$filters = array();
		if($status)
			$filters[] = array('f' => 'status', 'v' => '1');
		$filters[] = array('f' => 'gallery_id', 'v' => $this->data['gallery_id']);
		$GLOBALS['core.list']->custom_init('gallery_list_' . $this->get_key_value());
		
		$GLOBALS['core.list']->set_filters($filters);
		$GLOBALS['core.list']->set_sql('* FROM #p#gallery_module_picture');
		
		$GLOBALS['core.list']->set_param('order_by', array('order_no'));
		$GLOBALS['core.list']->set_param('items_per_page', $this->gallery_holder->get_data('items_per_page'));
		
		$page = $GLOBALS['core.list']->get_page($page_num);
		$num = $GLOBALS['core.list']->num_pages();
		
		
		
		$GLOBALS['core.smarty']->assign('page', $page);
		$GLOBALS['core.smarty']->assign('num', $num);
		//pp($num);
		
		
	}
	
	function assign_to_smarty()
	{
		foreach ($this->data as $key => $value)
		{
			$GLOBALS['core.smarty']->assign($key, $value);
		}
	}
	
	function gather_data_from_request()
	{
		$data = array();
		$err = array();
		
		if(isset($_REQUEST['name']))
		{
			$data['name'] = $_REQUEST['name'];
		}
		else 
		{
			$err['name'] = 1;
		}
		
		if(isset($_REQUEST['description']))
		{
			$data['description'] = $_REQUEST['description'];
		}
		else 
		{
			$err['description'] = 1;
		}
		
		if(isset($_REQUEST['order_no']))
		{
			$data['order_no'] = $_REQUEST['order_no'];
		}
		else 
		{
			$err['order_no'] = 1;
		}
		
		//now need to process pic1 and pic2
		
		$cur_id = $this->get_key_value();
		//pp($_FILES);
		if($_FILES['pic1']['size'] > 0 && $_FILES['pic1']['error'] == 0)
		{
			
		}
		elseif (is_null($cur_id)) 
		{
			$err['pic1'] = 1;
		}
		
		if($_FILES['pic2']['size'] > 0 && $_FILES['pic2']['error'] == 0)
		{
			
		}
		elseif (is_null($cur_id)) 
		{
			$err['pic2'] = 1;
		}
		
		$GLOBALS['core.application']->init_module('gd_module', true);
		if(empty($err))
		{
			if($_FILES['pic1']['size'] > 0 && $_FILES['pic1']['error'] == 0)
			{
				$_FILES['pic1']['name'] = strtolower($_FILES['pic1']['name']);
				if(!is_null($cur_id))
				{
					unlink('./gallery/' . $this->data['pic1']);
					unlink('./gallery/240_' . $this->data['pic1']);
				}
				move_uploaded_file($_FILES['pic1']['tmp_name'],'./gallery/' . $_FILES['pic1']['name']);
				$data['pic1'] = $_FILES['pic1']['name'];
				$GLOBALS['core.image']->create_thumb('./gallery/' . $data['pic1'],'./gallery/240_' . $data['pic1'],240,180,'',0xffffff);
			}
			if($_FILES['pic2']['size'] > 0 && $_FILES['pic2']['error'] == 0)
			{
				$_FILES['pic2']['name'] = strtolower($_FILES['pic2']['name']);
				if(!is_null($cur_id))
				{
					unlink('./gallery/' . $this->data['pic2']);
					unlink('./gallery/240_' . $this->data['pic2']);
				}
				move_uploaded_file($_FILES['pic2']['tmp_name'],'./gallery/' . $_FILES['pic2']['name']);
				$data['pic2'] = $_FILES['pic2']['name'];
				$GLOBALS['core.image']->create_thumb('./gallery/' . $data['pic2'],'./gallery/240_' . $data['pic2'],240,180,'',0xffffff);
			}
			
			$this->set_data($data);
			$this->save();
		}
	}
	
	
	function delete()
	{
		$pic1 = $this->data['pic1'];
		$pic2 = $this->data['pic2'];
		
		unlink('./gallery/240_' . $pic1);
		unlink('./gallery/' . $pic1);
		unlink('./gallery/240_' . $pic2);
		unlink('./gallery/' . $pic2);
		
		parent::delete();
	}
	
	function mass_delete($gallery_id)
	{
		$all = $GLOBALS['core.sql']->getAll('SELECT pic1,pic2 FROM #p#gallery_module_picture WHERE gallery_id=?',array($gallery_id));
		foreach ($all as $key => $value)
		{
			unlink('./gallery/240_' . $value['pic1']);
			unlink('./gallery/' . $value['pic1']);
			unlink('./gallery/240_' . $value['pic2']);
			unlink('./gallery/' . $value['pic2']);
		}
		
		$GLOBALS['core.sql']->query('DELETE FROM #p#gallery_module_picture WHERE gallery_id=?',array($gallery_id));
	}
}
?>