<?php
require_once('Admin_Header.php');
require_once('classes/CMS/Download_Holder.php');
require_once('classes/CMS/Download_Entry_Holder.php');

class Download_Manager extends Runmode
{
    function Download_Manager()
    {
        if($GLOBALS['core.runmode']->get_runmode_name() == 'Download_Manager')
        {
                $this->base_map[0] = 'action';
                $this->base_map[1] = 'id';
                $this->make_params();
        }
        elseif ($GLOBALS['core.runmode']->get_runmode_name() == 'Download_Manager_Entry')
        {
                $this->base_map[0] = 'section_id';
                //$this->base_map[1] = 'page_id';
                $this->base_map[1] = 'action';
                $this->base_map[2] = 'id';
                $this->make_params();
        }
        parent::Runmode();
    }
    function process()
    {
        if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
        {
            $dh = new Download_Holder($_REQUEST['id']);
        }
        else
        {
            $dh = new Download_Holder();
        }

        if(isset($_REQUEST['send']) && !empty($_REQUEST['send']))
        {
            $data = array();
            $data['name'] = $_REQUEST['name'];
            $data['public'] = isset($_REQUEST['public'])?1:0;
            $dh->set_data($data);
            $dh->save();
        }
        elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
        {
            $GLOBALS['core.smarty']->assign('data', $dh->get_data());
        }
        elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
        {                        
            $dh->delete();
        }
        $GLOBALS['core.smarty']->assign('sections', $dh->getAll());
        return Admin_Header::out('CMS/Page_Runmode/download_manager');
    }

    function download_entry()
    {
        if(isset($_REQUEST['section_id']) && is_numeric($_REQUEST['section_id']))
        {
            $dh = new Download_Holder($_REQUEST['section_id']);
            if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
            {
                $deh = new Download_Entry_Holder($_REQUEST['id']);
            }
            else
            {
                $deh = new Download_Entry_Holder();
            }

            $d_data = $dh->get_data();
            if(isset($_REQUEST['send']) && !empty($_REQUEST['send']))
            {

                $data = array();
                $file_info = $this->file_save();
                if(!empty($file_info))
                {
                    $data['file'] = $file_info['file'];
                    $data['content_type'] = $file_info['type'];
                }
                $data['description'] = $_REQUEST['description'];
                $data['order_no'] = $_REQUEST['order_no'];
                $data['section_id'] = $_REQUEST['section_id'];

                if(!empty($file_info) || !empty($data['description']))
                {
                    $deh->set_data($data);
                    $deh->save();
                }

            }
            elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
            {
                $deh->delete();
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
            {
                $GLOBALS['core.smarty']->assign('data', $deh->get_data());
            }


            if(isset($d_data['id']))
            {
                $d_entries = $deh->get_by_section($d_data['id']);
                //$GLOBALS['core.smarty']->assign('hid_testimonial_id', $testimonial_id);
                $GLOBALS['core.smarty']->assign('section_data', $d_data);
                $GLOBALS['core.smarty']->assign('d_entries', $d_entries);
                return Admin_Header::out('CMS/Page_Runmode/download_manager_entry');
            }
            
        }
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
            $file = array();
            if (isset($_FILES['file']['name']) && $_FILES['file']['error'] != 4)
            {
                if(isset($_REQUEST['id']))
                {
                    $file_to_delete = $GLOBALS['core.sql']->getOne("SELECT file FROM #p#download_module_entry WHERE id = ?",array($_REQUEST['id']));
                    if(!empty($file_to_delete))
                    {
                        if (file_exists('./upload/'.$file_to_delete)) unlink('./upload/'.$file_to_delete);
                    }
                }
                $filename = $this->upload_file($_FILES['file']['name'],'./upload/');
                if (move_uploaded_file($_FILES['file']['tmp_name'],'./upload/'.$filename))
                {
                        $file['file'] = $filename;
                        $file['type'] = $_FILES['file']['type'];
                }
                
            }
            return $file;
    }


}


?>
