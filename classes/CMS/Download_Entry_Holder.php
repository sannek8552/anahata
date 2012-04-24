<?php
require_once('Data_Holder.php');
class Download_Entry_Holder extends Data_Holder_Simple
{
    function Download_Entry_Holder($id = null)
    {
        $key_info = array('key_name' => 'id');
        if(!is_null($id))
        {
                $key_info['key_value'] = $id;
        }
        $this->init('download_module_entry',$key_info);
    }
    function get_all()
    {
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table, array(), 'id');
    }
    function get_by_section($section_id)
    {        
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table.' WHERE section_id = ? ORDER BY order_no', array($section_id), 'id');
    }
    function get_by_section_active($section_id)
    {
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table.' WHERE section_id = ? AND active = 1 ORDER BY order_no', array($section_id), 'id');
    }    
    function delete()
    {
        $file = $GLOBALS['core.sql']->getOne("SELECT file FROM #p#".$this->table." WHERE id = ?",array($this->get_key_value()));
        if (!empty($file) && file_exists('./upload/'.$file)) unlink('./upload/'.$file);
        parent::delete();
    }
}
?>