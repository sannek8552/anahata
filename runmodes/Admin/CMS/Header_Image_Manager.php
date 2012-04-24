<?php
require_once('Admin_Header.php');
require_once('classes/CMS/Header_Image_Holder.php');

class Header_Image_Manager extends Runmode
{
	function Header_Image_Manager()
	{
		$this->base_map[0] = 'action';
                $this->base_map[1] = 'id';
                $this->make_params();
		parent::Runmode();
	}

	function process()
        {
                //pp($_REQUEST);
                $new_image = true;
                if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
                {
                    $holder = new Header_Image_Holder($_REQUEST['id']);
                    $new_image = false;
                }
                else
                {
                    $holder = new Header_Image_Holder();
                }

                if(isset($_REQUEST['save']) && !empty($_REQUEST['save']))
                {

                    $data = array();
                    $file_info = $this->file_save($new_image);
                    if(!empty($file_info['error']))
                    {
                        $GLOBALS['core.smarty']->assign('data', $_REQUEST);
                        $GLOBALS['core.smarty']->assign('image_error', 1);
                    }
                    else
                    {
                        if(!empty($file_info['image']) && $new_image)
                        {
                            $data['image'] = $file_info['image'];
                        }
                        if(isset($_REQUEST['title']) && !empty($_REQUEST['title']))
                            $data['title'] = $_REQUEST['title'];
                        if(!empty($data))
                        {
                            $holder->set_data($data);
                            $holder->save();
                        }
                    }
                    

                }
                elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
                {
                    $holder->delete();
                }
                elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
                {
                    $GLOBALS['core.smarty']->assign('data', $holder->get_data());
                }
               
                $images = $holder->getAll();
                $GLOBALS['core.smarty']->assign('images', $images);
                return Admin_Header::out('CMS/header_image_manager');
                
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

        function file_save($new_image=true)
        {
                $file = array();
                if (isset($_FILES['file']['name']) && $_FILES['file']['error'] != 4)
                {
                    $type = explode('/',$_FILES['file']['type']);
                    $type = $type[0];
                    if($type!='image')
                        $file['error'] = 1;
                    else
                    {
                        if(!$new_image)
                        {
                            $filename = $GLOBALS['core.sql']->getOne("SELECT image FROM #p#header_image WHERE id = ?",array($_REQUEST['id']));
                            if(!empty($file_to_delete))
                            {
                                if (file_exists('./pictures/header/'.$filename)) unlink('./pictures/header/'.$filename);
                                
                            }
                            //$filename = $file_to_delete;
                        }
                        else $filename = $this->upload_file($_FILES['file']['name'],'./pictures/header/');
                        
                            
                        if (move_uploaded_file($_FILES['file']['tmp_name'],'./pictures/header/'.$filename))
                        {
                                $file['image'] = $filename;
                        }
                    }

                }
                return $file;
        }
}
?>