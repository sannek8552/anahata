<?php
require_once('Data_Holder.php');
class Download_Holder extends Data_Holder_Simple
{
    function Download_Holder($id = null)
    {
        $key_info = array('key_name' => 'id');
        if(!is_null($id))
        {
                $key_info['key_value'] = $id;
        }
        $this->init('download_module',$key_info);
    }
    function getAll()
    {
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#download_module');
    }
    function delete()
    {
        $files = $GLOBALS['core.sql']->getAll("SELECT file FROM #p#download_module_entry WHERE section_id = ?",array($this->get_key_value()));
        foreach($files as $value)
            if (!empty($value['file']) && file_exists('./upload/'.$value['file'])) unlink('./upload/'.$value['file']);
        $GLOBALS['core.sql']->query("DELETE FROM #p#download_module_entry WHERE section_id = ?",array($this->get_key_value()));
        parent::delete();
    }
   
    
}
?>