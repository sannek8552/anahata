<?php
require_once('Admin_Header.php');
require_once('classes/CMS/News_Holder.php');
require_once('classes/CMS/News_Entry_Holder.php');

class News_Manager extends Runmode 
{
	function News_Manager()
	{
		if($GLOBALS['core.runmode']->get_runmode_name() == 'News_Manager')
		{
			$this->base_map[0] = 'action';
			$this->base_map[1] = 'id';
			$this->make_params();
		}
		elseif ($GLOBALS['core.runmode']->get_runmode_name() == 'News_Manager_Entry')
		{
			$this->base_map[0] = 'news_id';
			$this->base_map[1] = 'page_id';
			$this->base_map[2] = 'action';
			$this->base_map[3] = 'id';
		}
		parent::Runmode();
	}
	function process()
	{
		
		if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		{
			$news = new News_Holder($_REQUEST['id']);
		}
		elseif(isset($_REQUEST['hid_id']) && is_numeric($_REQUEST['hid_id']))
		{
			$news = new News_Holder($_REQUEST['hid_id']);
		}
		else 
		{
			$news = new News_Holder();
		}
		
		if(isset($_REQUEST['send']) && !empty($_REQUEST['send']))
		{
			$data = array();
			$data['name'] = $_REQUEST['name'];
			$data['items'] = $_REQUEST['items'];
			$news->set_data($data);
			$news->save();
		}
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{
			if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
			{
				$GLOBALS['core.smarty']->assign('output_array', $news->get_data());
			}
		}
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
		{
			if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
			{
				$news->delete_by_news_id($_REQUEST['id']);
				$news->delete();
			}
		}
		$GLOBALS['core.smarty']->assign('objects', $news->get_all_news());
		return Admin_Header::out('CMS/Page_Runmode/news_manager');
	}
	
	function news_entry()
	{

		if(isset($_REQUEST['news_id']) && is_numeric($_REQUEST['news_id']))
		{
			$news_id = $_REQUEST['news_id'];
		}
		elseif (isset($_REQUEST['hid_news_id']) && is_numeric($_REQUEST['hid_news_id']))
		{
			$news_id = $_REQUEST['hid_news_id'];
		}
		$news_holder = new News_Holder($news_id);
		$news_data = $news_holder->get_data();
		$news_entries = $news_holder->get_entries();
		if(isset($_REQUEST['send']) && !empty($_REQUEST['send']))
		{
			if(isset($_REQUEST['hid_id']) && is_numeric($_REQUEST['hid_id']))
			{
				$entry = new News_Entry_Holder($_REQUEST['hid_id']);
			}
			else 
			{
				$entry = new News_Entry_Holder();
			}
			$data = array();
			$data['name'] = $_REQUEST['name'];
			$data['short'] = $_REQUEST['short'];
			$data['full'] = $_REQUEST['full'];
			$data['adddate'] = $_REQUEST['adddate'];
                        $data['order_id'] = $_REQUEST['order_id'] ? $_REQUEST['order_id'] : 1;
			//$data['addtime'] = $_REQUEST['Time_Hour'].':'.$_REQUEST['Time_Minute'];

                        $newimage = $this->file_save();
                        if ($newimage) {
                            $data['image'] = $newimage;
                        }


			if(isset($_REQUEST['hid_news_id']) && is_numeric($_REQUEST['hid_news_id']))
			{
				$data['news_id'] = $news_id;
			}
			$entry->set_data($data);
			$entry->save();
			
		}
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
		{
			if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
			{
				$news_to_delete = new News_Entry_Holder($_REQUEST['id']);
				$news_to_delete->delete();
			}
		}
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{
			if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
			{
				$news_to_edit = new News_Entry_Holder($_REQUEST['id']);
				$GLOBALS['core.smarty']->assign('news_to_edit', $news_to_edit->get_data());
				//$time = $news_to_edit->get_data('addtime');
				//$time = split(":", $time);
				$GLOBALS['core.smarty']->assign('hid_id', $_REQUEST['id']);
			}
		}
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'publish')
		{
			if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
			{
				$news_to_publish = new News_Entry_Holder($_REQUEST['id']);
				$news_to_publish->set_data(array('publish' => 1));
				$news_to_publish->save();
			}
		}
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'unpublish')
		{
			if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
			{
				$news_to_publish = new News_Entry_Holder($_REQUEST['id']);
				$news_to_publish->set_data(array('publish' => 0));
				$news_to_publish->save();
			}
		}
		if(isset($_REQUEST['page_id']) && is_numeric($_REQUEST['page_id']))
		{
			$news_holder->get_by_page($_REQUEST['page_id'], $news_id);
		}
		else 
		{
			$news_holder->get_by_page(1, $news_id);
		}
		
		$GLOBALS['core.smarty']->assign('hid_news_id', $news_id);
		$GLOBALS['core.smarty']->assign('news_data', $news_data);
		
		//$GLOBALS['core.smarty']->assign('news_entries', $news_entries);
		return Admin_Header::out('CMS/Page_Runmode/news_manager_entry');
	}

        function upload_file($file, $filedirectory)
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

        function file_save()
        {
                $file = null;
                if (isset($_FILES['file']['name']) && $_FILES['file']['error'] != 4)
                {
                    if (isset($_REQUEST['id'])) {
                        $file_to_delete = $GLOBALS['core.sql']->getOne("SELECT image FROM #p#news_module_entry WHERE id = ?",array($_REQUEST['id']));
                        if (!empty($file_to_delete)) {
                            if (file_exists('./upload/'.$file_to_delete)) {
                                unlink('./upload/'.$file_to_delete);
                                unlink('./upload/200_'.$file_to_delete);
                            }
                        }
                    }
                    $filename = $this->upload_file($_FILES['file']['name'],'./upload/');
                    if (move_uploaded_file($_FILES['file']['tmp_name'],'./upload/'.$filename)) {
                        $GLOBALS['core.image']->create_thumb_crop('./upload/'.$filename, './upload/200_'. $filename, 200,  150);
                        $file = $filename;
                    }

                }
                return $file;
        }
}
?>