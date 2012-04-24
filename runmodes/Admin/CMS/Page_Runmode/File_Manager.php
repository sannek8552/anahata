<?php
require_once('Admin_Header.php');

class File_Manager extends Runmode 
{
	function File_Manager()
	{
		parent::Runmode();
		$GLOBALS['core.smarty']->assign('current_sub', 'File Manager');
		$GLOBALS['core.smarty']->assign('current_menu','Modules');
	}
	
	function process()
	{
		$conf = $GLOBALS['core.config']->get_config('file_storage');
		$path = $conf['common']['path'];
		$i_path = $path;
		
		if(isset($_REQUEST['change_path']) && !empty($_REQUEST['change_path']))
		{
			$_REQUEST['change_path'] = str_replace('.','',$_REQUEST['change_path']);
			if(substr($_REQUEST['change_path'],-1) == '/')
			{
				$_REQUEST['change_path'] = substr($_REQUEST['change_path'],0,strlen($_REQUEST['change_path']) - 1);
			}
			$path .= $_REQUEST['change_path'] . '/';
		}
		
		if(isset($_REQUEST['save_folder']) && !empty($_REQUEST['save_folder']))
		{
			if(!isset($_REQUEST['edit_from']))
			{
				$_REQUEST['new_folder'] = str_replace('.','',$_REQUEST['new_folder']);
			}
			//if()
			$_REQUEST['new_folder'] = str_replace('/','',$_REQUEST['new_folder']);
			
			$to_create = $_REQUEST['new_folder'];
			$to_check = $path . $to_create;
			if(is_dir($to_check))
			{
				$GLOBALS['core.smarty']->assign('folder_exists', 1);
			}
			else 
			{
				if(isset($_REQUEST['edit_from']))
				{
					$_REQUEST['edit_from'] = str_replace('/','',$_REQUEST['edit_from']);
					if(!is_file($path . $_REQUEST['edit_from']))
						$_REQUEST['edit_from'] = str_replace('.','',$_REQUEST['edit_from']);
				}
				if(isset($_REQUEST['edit_from']) && !empty($_REQUEST['edit_from']))
				{
					rename($path . $_REQUEST['edit_from'],$to_check);
				}
				else 
				{
					mkdir($to_check);
					chmod($to_check,0777);
				}
			}
		}
		elseif (isset($_REQUEST['save_file']) && !empty($_REQUEST['save_file']))
		{
                    $file_name = File_Manager::upload_filename($_FILES['new_file']['name'], $path);

                    if(isset($_FILES['new_file']) && $_FILES['new_file']['size'] > 0)
                    {
                        if(move_uploaded_file($_FILES['new_file']['tmp_name'], $path . $file_name))
                        {
                            if( isset($_FILES['new_file']['type']) && ($_FILES['new_file']['type'] == 'image/jpeg' || $_FILES['new_file']['type'] == 'image/png' || $_FILES['new_file']['type'] == 'image/gif'))
                            {
                                if(isset($_REQUEST['thumb_type']) && $_REQUEST['thumb_type'] == 'width')
                                {
                                    $GLOBALS['core.image']->create_thumb_width($path.$file_name, $path.$_REQUEST['width'].'_width_'.$file_name, $_REQUEST['width'], null, $color=0x000000);
                                }
                                elseif(isset($_REQUEST['thumb_type']) && $_REQUEST['thumb_type'] == 'height_width')
                                {
                                    $GLOBALS['core.image']->create_thumb($path.$file_name, $path.$_REQUEST['width'].'_width_height'.$file_name, $_REQUEST['width'], $_REQUEST['height'], null, $color=0x000000);
                                }
                                elseif(isset($_REQUEST['thumb_type']) && $_REQUEST['thumb_type'] == 'crop')
                                {
                                    $GLOBALS['core.image']->create_thumb_crop($path.$file_name, $path.$_REQUEST['width'].'_width_height'.$file_name, $_REQUEST['width'], $_REQUEST['height'], null);
                                }
                            }
                        }
                    }
		}
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
		{
			
                    $item = $_REQUEST['action_item'];

                    $to_check = $path . $item;
                    if(is_file($to_check))
                    {
                        unlink($to_check);
                    }
                    if(is_dir($to_check) && !empty($item))
                    {
                        $this->remove_dir($to_check);
                    }
		}
		elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && !empty($_REQUEST['action_item']))
		{
                    if(is_file($path . $_REQUEST['action_item']))
                    {
                        $GLOBALS['core.smarty']->assign('edit_from_file', 1);
                    }
                    $GLOBALS['core.smarty']->assign('edit_from', $_REQUEST['action_item']);
		}
		
		$dir = opendir($path);
		$dirs = array();
		$files = array();
		
		while (($file = readdir($dir)) !== false)
		{
			if($file == '.' || $file == '..')
				continue;
			if(is_dir($path . $file))
			{
				$dirs[] = $file;
			}
			else 
			{
				$files[] = $file;
			}
		}
		//pp($dirs);
		closedir($dir);
		sort($dirs);
		sort($files);
	
		$cur_path = str_replace($i_path, '', $path);
		//print $i_path . ' ' . print  $path;
		$cur_split = explode('/',$cur_path);
		//print $cur_path;
		//pp($cur_split);
		array_pop($cur_split);
		//pp($cur_split);
		$path_split = array();
		$temp = '';
		foreach ($cur_split as $key => $value)
		{
			$temp .= $value . '/';
			$path_split[] = array('name' => $value, 'link' => $temp);
		}
		//temp now contain path to file
		$GLOBALS['core.smarty']->assign('cur_path_split', $path_split);
		
		$link = $conf['common']['link'];
		$link .= $temp;
		$GLOBALS['core.smarty']->assign('prefix', $link);
		
		
		$GLOBALS['core.smarty']->assign('cur_path', $cur_path);
		$GLOBALS['core.smarty']->assign('dirs', $dirs);
		$GLOBALS['core.smarty']->assign('files', $files);
		return Admin_Header::out('CMS/Page_Runmode/file_manager');
	}
	
	function remove_dir($path)
	{
		$dir = opendir($path);
		while (($file = readdir($dir)) !== false)
		{
			if($file == '.' || $file == '..')
			{
				continue;
			}
			if(is_file($path . '/' . $file))
			{
				unlink($path . '/' . $file);
			}
			else 
			{
				$this->remove_dir($path . '/' . $file);
			}
		}
		rmdir($path);
	}
        function upload_filename($file, $filedirectory)
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
                //move_uploaded_file($_FILES['tmp_name'], $filedirectory.$file);
                return $file;
            }
            else
            {
                exit();
            }

        }
}
?>