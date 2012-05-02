<?php

$response['success'] = false;

if (isset($_FILES['file']['name']) && $_FILES['file']['error'] != 4)
{
    $filename = upload_file($_FILES['file']['name'],'./upload/');
    if (move_uploaded_file($_FILES['file']['tmp_name'],'./upload/'.$filename)) {
        $response['success']  = true;
        $response['filename'] = $filename;
    }

}

echo json_encode($response);

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


?>