<?php
require_once('Data_Holder.php');
class Header_Image_Holder extends Data_Holder_Simple
{
    function Header_Image_Holder($id = null)
    {
        $key_info = array('key_name' => 'id');
        if(!is_null($id))
        {
                $key_info['key_value'] = $id;
        }
        $this->init('header_image',$key_info);
    }
    function getAll()
    {
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table, array(), 'id');
    }
    function getImagesForSelect()
    {
        $res = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#header_image', array(), 'id');
        $to_ret = array();
        foreach ($res as $value)
        {
            //$to_ret[$value['id']] = $value['title'];
            $to_ret[$value['image']] = $value['title'];
        }
        return $to_ret;
    }

    function getImageById($id)
    {
        return $GLOBALS['core.sql']->getOne("SELECT image FROM #p#header_image WHERE id=?",array($id));
    }
      
    function delete()
    {
        $file = $GLOBALS['core.sql']->getOne("SELECT image FROM #p#".$this->table." WHERE id = ?",array($this->get_key_value()));
        if (!empty($file) && file_exists('./pictures/header/'.$file)) unlink('./pictures/header/'.$file);
        parent::delete();
    }
}
?>