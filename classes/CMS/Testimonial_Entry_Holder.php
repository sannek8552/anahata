<?php
require_once('Data_Holder.php');
class Testimonial_Entry_Holder extends Data_Holder_Simple
{
    function Testimonial_Entry_Holder($id = null)
    {
        $key_info = array('key_name' => 'id');
        if(!is_null($id))
        {
                $key_info['key_value'] = $id;
        }
        $this->init('testimonial_module_entry',$key_info);
    }
    function get_all()
    {
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table, array(), 'id');
    }
    function get_by_section($section_id)
    {        
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table.' WHERE testimonial_id = ? ORDER BY order_no', array($section_id), 'id');
    }
    function get_by_section_active($section_id)
    {
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table.' WHERE testimonial_id = ? AND active = 1 ORDER BY order_no', array($section_id), 'id');
    }    
    function get_last_testimonial($section_id)
    {
        return $GLOBALS['core.sql']->getRow('SELECT * FROM #p#'.$this->table.' WHERE testimonial_id = ? AND active = 1 ORDER BY created DESC LIMIT 1', array($section_id));
    }
    function get_random_testimonial($section_id)
    {
        return $GLOBALS['core.sql']->getRow('SELECT * FROM #p#'.$this->table.' WHERE testimonial_id = ? AND active = 1 ORDER BY RAND() LIMIT 1', array($section_id));
    }
}
?>