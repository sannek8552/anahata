<?php
require_once('Common_Header.php');
require_once('classes/CMS/Gallery_One_Holder.php');

class AjaxUpload extends Runmode
{
	function AjaxUpload()
	{
        	parent::Runmode();
	}
	
	function process()
	{
                
            $response['success'] = false;

            if (isset($_FILES['file']['name']) && $_FILES['file']['error'] != 4)
            {
                $filename = $this->upload_file($_FILES['file']['name'],'./upload/');
                if (move_uploaded_file($_FILES['file']['tmp_name'],'./upload/'.$filename)) {
                    $conf = $GLOBALS['core.config']->get_config('templates');
                    $response['success']  = true;
                    $response['filename'] = $conf['common']['domain_name'].$conf['common']['upload'].$filename;
                }

            }

            echo json_encode($response);

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
}

?>