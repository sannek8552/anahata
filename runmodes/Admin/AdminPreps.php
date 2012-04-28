<?php
require_once('Admin_Header.php');
require_once('PrepsHolder.php');

class AdminPreps extends Runmode
{
	function __construct()
	{
                $this->base_map[0] = 'action';
                $this->base_map[1] = 'id';

		parent::Runmode();
	}

	function process()
	{


		if (isset($_REQUEST['action'])) {

                    switch ($_REQUEST['action']) {

                        case 'save':
                            if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
                                $ph = new PrepsHolder($_REQUEST['id']);
                            } else {
                                $ph = new PrepsHolder();
                            }
                            

                            $data = array();
                            $data['fio'] = $_REQUEST['fio'];
                            $data['bio'] = $_REQUEST['bio'];

                            $newimage = $this->file_save();
                            if ($newimage) {
                                $data['photo'] = $newimage;
                            }

                            $ph->set_data($data);
                            $ph->save();
                            break;

                        case 'delete':
                            if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
                                $ph = new PrepsHolder($_REQUEST['id']);
                                $ph->delete();
                            }
                            break;

                        case 'edit':
                            if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
                                    $ph = new PrepsHolder($_REQUEST['id']);
                                    $GLOBALS['core.smarty']->assign('data', $ph->get_data());
                            }
                            break;
                    }
                } else {
                    $ph = new PrepsHolder();
                }

		$preps = $ph->get_all();

		$GLOBALS['core.smarty']->assign('preps', $preps);

		return Admin_Header::out('preps');
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
                        $file_to_delete = $GLOBALS['core.sql']->getOne("SELECT photo FROM #p#preps WHERE id = ?",array($_REQUEST['id']));
                        if (!empty($file_to_delete)) {
                            if (file_exists('./upload/'.$file_to_delete)) {
                                unlink('./upload/'.$file_to_delete);
                                unlink('./upload/thumb_'.$file_to_delete);
                            }
                        }
                    }
                    $filename = $this->upload_file($_FILES['file']['name'],'./upload/');
                    if (move_uploaded_file($_FILES['file']['tmp_name'],'./upload/'.$filename)) {
                        $GLOBALS['core.image']->create_thumb_crop('./upload/'.$filename, './upload/thumb_'. $filename, 200,  150);
                        $file = $filename;
                    }

                }
                return $file;
        }
}
?>