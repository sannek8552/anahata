<?php
require_once('Data_Holder.php');

class Gallery_One_Picture_Holder extends Data_Holder_Simple 
{
	
	var $gallery_holder = null;
	function Gallery_One_Picture_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		
		$this->init('gallery_one_module_picture', $key_info);
	}
	
	function get_page($page_num = '', $status = false)
	{
		
		$GLOBALS['core.application']->init_module('list', true);
		$filters = array();
		if($status)
			$filters[] = array('f' => 'status', 'v' => '1');
		$filters[] = array('f' => 'gallery_id', 'v' => $this->data['gallery_id']);
		$GLOBALS['core.list']->custom_init('gallery_one_list_' . $this->get_key_value());
		
		$GLOBALS['core.list']->set_filters($filters);
		$GLOBALS['core.list']->set_sql('* FROM #p#gallery_one_module_picture');
		
		$GLOBALS['core.list']->set_param('order_by', array('order_no'));
		$GLOBALS['core.list']->set_param('items_per_page', $this->gallery_holder->get_data('items_per_page'));
		
		$page = $GLOBALS['core.list']->get_page($page_num);
                
		$num = $GLOBALS['core.list']->num_pages();
		

		$GLOBALS['core.smarty']->assign('page', $page);
		$GLOBALS['core.smarty']->assign('num', $num);
		
			$pre = $GLOBALS['core.sql']->getRow('SELECT * FROM #p#gallery_one_module WHERE id=?', array($this->data['gallery_id']));
			$p = $pre['width'].'_'.$pre['type'].'_';
                       
			$GLOBALS['core.smarty']->assign('pre', $p);
		
		
		
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
		
		if (isset($_REQUEST['name'])) {
			$data['name'] = $_REQUEST['name'];
		}
		else {
			$err['name'] = 1;
		}
		if (isset($_REQUEST['description'])) {
			$data['description'] = $_REQUEST['description'];
		}
		else {
			$err['description'] = 1;
		}
		if(isset($_REQUEST['order_no'])) {
			$data['order_no'] = $_REQUEST['order_no'];
		}
		else {
			$err['order_no'] = 1;
		}
		//now need to process pic1 and pic2
		
		$cur_id = $this->get_key_value();
		
		if($_FILES['pic1']['size'] > 0 && $_FILES['pic1']['error'] == 0)
		{
			
		}
		elseif (is_null($cur_id)) 
		{
			$err['pic1'] = 1;
		}

		$GLOBALS['core.application']->init_module('gd_module', true);
		if(empty($err))
		{
                        $main_w  = 800;
                        $main_h  = 600;
                        $thumb_w = 120;
                        $thumb_h = 100;

			$conf = $GLOBALS['core.config']->get_config('templates');
			$path = $conf['common']['gallery'];

                        if (isset($_FILES['pic1']['name']) && $_FILES['pic1']['error'] != 4)
                        {
                            if (!is_null($cur_id)) {
                                if (file_exists("./$path/".$this->data['pic1']))       unlink("./$path/".$this->data['pic1']);
                                if (file_exists("./$path/main_".$this->data['pic1']))  unlink("./$path/main_".$this->data['pic1']);
                                if (file_exists("./$path/thumb_".$this->data['pic1'])) unlink("./$path/thumb_".$this->data['pic1']);
                            }
                            $filename = $this->check_file($_FILES['pic1']['name'],"./$path/");
                            if (move_uploaded_file($_FILES['pic1']['tmp_name'],"./$path/".$filename)) {
                                $data['pic1'] = $filename;
                                //$GLOBALS['core.image']->create_thumb_crop("./$path/".$filename, "./$path/main_". $filename, $main_w,  $main_h);
                                $GLOBALS['core.image']->create_thumb_crop("./$path/".$filename, "./$path/thumb_".$filename, $thumb_w, $thumb_h);
                            }
                        }
			
			
			$this->set_data($data);
			$this->save();
		}
	}
	
	
	function delete()
	{
		$conf = $GLOBALS['core.config']->get_config('templates');
		$path = $conf['common']['gallery'];
                if (file_exists("./$path/".$this->data['pic1']))       unlink("./$path/".$this->data['pic1']);
                if (file_exists("./$path/main_".$this->data['pic1']))  unlink("./$path/main_".$this->data['pic1']);
                if (file_exists("./$path/thumb_".$this->data['pic1'])) unlink("./$path/thumb_".$this->data['pic1']);

		parent::delete();
	}
	
	function mass_delete($gallery_id)
	{
		$conf = $GLOBALS['core.config']->get_config('templates');
		$path = $conf['common']['gallery'];
		$all = $GLOBALS['core.sql']->getAll('SELECT pic1 FROM #p#gallery_one_module_picture WHERE gallery_id=?',array($gallery_id));
		foreach ($all as $key => $value) {
                    if (file_exists("./$path/".$value['pic1']))       unlink("./$path/".$value['pic1']);
                    if (file_exists("./$path/main_".$value['pic1']))  unlink("./$path/main_".$value['pic1']);
                    if (file_exists("./$path/thumb_".$value['pic1'])) unlink("./$path/thumb_".$value['pic1']);
		}
		
		$GLOBALS['core.sql']->query('DELETE FROM #p#gallery_one_module_picture WHERE gallery_id=?',array($gallery_id));
	}
	function check_file($file, $filedirectory)
	{
		if(!is_null($filedirectory) && is_dir($filedirectory))
		{
			$filedirectory = trim($filedirectory, "/");
			$pathfile = pathinfo($file);
			$j = 1;
			while(file_exists($filedirectory.'/'.$file))
			{
				$file = $pathfile['filename'].'('.$j.').'.$pathfile['extension'];
				$j++;
			}
			return $file;
		}
		else 
		{
			exit('dirrectory error');
		}
			
	}
	function get_by_gallery($gallery_id)
	{
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table.' WHERE gallery_id=?', array($gallery_id));
	}
}
?>