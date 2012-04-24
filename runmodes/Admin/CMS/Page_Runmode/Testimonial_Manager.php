<?php
require_once('Admin_Header.php');
require_once('classes/CMS/Testimonial_Holder.php');
require_once('classes/CMS/Testimonial_Entry_Holder.php');

class Testimonial_Manager extends Runmode
{
    function Testimonial_Manager()
    {
        if($GLOBALS['core.runmode']->get_runmode_name() == 'Testimonial_Manager')
        {
                $this->base_map[0] = 'action';
                $this->base_map[1] = 'id';
                $this->make_params();
        }
        elseif ($GLOBALS['core.runmode']->get_runmode_name() == 'Testimonial_Manager_Entry')
        {
                $this->base_map[0] = 'testimonial_id';
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
            $th = new Testimonial_Holder($_REQUEST['id']);
        }
        else
        {
            $th = new Testimonial_Holder();
        }

        if(isset($_REQUEST['send']) && !empty($_REQUEST['send']))
        {
            $data = array();
            $data['name'] = $_REQUEST['name'];
            $data['description'] = $_REQUEST['description'];
            $data['items_per_page'] = $_REQUEST['items_per_page'];
            $data['seo_page'] = $_REQUEST['seo_page'];
            $data['timer'] = $_REQUEST['timer'];
            $th->set_data($data);
            $th->save();
        }
        elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
        {
            $GLOBALS['core.smarty']->assign('data', $th->get_data());
        }
        elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
        {                        
            $th->delete();
        }
        $GLOBALS['core.smarty']->assign('testimonials', $th->get_all_testimonial());
        return Admin_Header::out('CMS/Page_Runmode/testimonial_manager');
    }

    function testimonial_entry()
    {
        if(isset($_REQUEST['testimonial_id']) && is_numeric($_REQUEST['testimonial_id']))
        {
            $th = new Testimonial_Holder($_REQUEST['testimonial_id']);               
            if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
            {
                $teh = new Testimonial_Entry_Holder($_REQUEST['id']);
            }
            else
            {
                $teh = new Testimonial_Entry_Holder();
            }

            $t_data = $th->get_data();
            if(isset($_REQUEST['send']) && !empty($_REQUEST['send']))
            {
                $data = array();
                $data['name'] = $_REQUEST['name'];
                $data['content'] = $_REQUEST['content'];
                $data['order_no'] = $_REQUEST['order_no'];
                $data['testimonial_id'] = $_REQUEST['testimonial_id'];
                if(!is_numeric($teh->get_key_value()))
                {
                    $data['active'] = 1;
                }
                $teh->set_data($data);
                $teh->save();
            }
            elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
            {
                $teh->delete();
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
            {
                $GLOBALS['core.smarty']->assign('data', $teh->get_data());
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'activate')
            {
                $teh->set_data(array('active' => 1));
                $teh->save();
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'deactivate')
            {
                $teh->set_data(array('active' => 0));
                $teh->save();

            }
            /*if(isset($_REQUEST['page_id']) && is_numeric($_REQUEST['page_id']))
            {
                $testimonial_holder->get_by_page($_REQUEST['page_id'], $testimonial_id);
            }
            else
            {
                $testimonial_holder->get_by_page(1, $testimonial_id);
            }*/
            if(isset($t_data['id']))
            {
                $t_entries = $teh->get_by_section($t_data['id']);
                //$GLOBALS['core.smarty']->assign('hid_testimonial_id', $testimonial_id);
                $GLOBALS['core.smarty']->assign('testimonial_data', $t_data);
                $GLOBALS['core.smarty']->assign('t_entries', $t_entries);
                return Admin_Header::out('CMS/Page_Runmode/testimonial_manager_entry');
            }
            
        }
    }
}


?>
