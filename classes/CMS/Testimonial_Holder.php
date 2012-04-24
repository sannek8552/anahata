<?php
require_once('Data_Holder.php');
class Testimonial_Holder extends Data_Holder_Simple
{
    function Testimonial_Holder($id = null)
    {
        $key_info = array('key_name' => 'id');
        if(!is_null($id))
        {
                $key_info['key_value'] = $id;
        }
        $this->init('testimonial_module',$key_info);
    }
    function get_all_testimonial()
    {
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#testimonial_module');
    }
    function delete()
    {
        parent::delete();
        $GLOBALS['core.sql']->query('DELETE FROM #p#testimonial_module_entry WHERE testimonial_id = ?', array($this->get_key_value()));
    }
    /*function get_entries()
    {
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#testimonial_module_entry WHERE testimonial_id=? ORDER BY order_no', array($this->get_key_value()));
    }
    function get_entries_id()
    {
        return $GLOBALS['core.sql']->getAll('SELECT id FROM #p#testimonial_module_entry WHERE testimonial_id=?', array($this->get_key_value()));
    }*/
    /*function get_by_page($page, $testimonial_id, $front = null)
    {
        $GLOBALS['core.list']->custom_init('testimonial_list');
        $GLOBALS['core.list']->set_sql('* FROM #p#testimonial_module_entry');
        $filters = array();
        $filters[] = array('f' => 'testimonial_id', 'v' => $testimonial_id);
        /*if(isset($front) && $front == 1)
        {
                $filters[] = array('f' => 'publish', 'v' => 1);
        }*/
   /*     $GLOBALS['core.list']->set_filters($filters);
        $GLOBALS['core.list']->set_param('items_per_page', $this->data['items']);//$GLOBALS['core.sql']->getOne('SELECT items FROM #p#news_module WHERE id=?', array($news_id)));
        $GLOBALS['core.list']->set_param('order_by', array('order_no'));
        $testimonial = $GLOBALS['core.list']->get_page($page);
        $num_pages = $GLOBALS['core.list']->num_pages();
        //pp($num_pages);
        $GLOBALS['core.smarty'] -> assign('num_pages', $num_pages);
        $GLOBALS['core.smarty']->assign('all_testimonial', $testimonial);
        if(isset($num_pages) && !in_array($page, $num_pages['prepared']))
        {
            $GLOBALS['core.smarty']->assign('page_error', 1);
        }
        else
        {
            $GLOBALS['core.smarty']->assign('page_error', 0);
        }
    }*/
    
}
?>