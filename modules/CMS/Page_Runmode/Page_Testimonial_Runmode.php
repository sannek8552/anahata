<?php
require_once('classes/CMS/Testimonial_Holder.php');
require_once('classes/CMS/Testimonial_Entry_Holder.php');
class Page_Testimonial_Runmode extends Runmode
{
    function Page_Testimonial_Runmode()
    {
        $this->base_map[0] = 'page_num';
        //$this->base_map[0] = 'seo_page';
        parent::Runmode();
    }
    function process()
    {
        $th = new Testimonial_Holder($_REQUEST['section']);
        $teh = new Testimonial_Entry_Holder();
        $t_data = $th->get_data();

        if(isset($t_data['id']))
        {
            
            if(isset($_REQUEST['all_testimonials']) && $_REQUEST['all_testimonials'] == 1)
            {
                unset($_REQUEST['all_testimonials']);
                //$t_entries = $teh->get_by_section_active($t_data['id']);
                $GLOBALS['app']->init_module('list', 'y');
                $GLOBALS['core.list']->custom_init('my_test_list');
		$GLOBALS['core.list']->set_sql('* FROM #p#testimonial_module_entry');
                if(isset($t_data['items_per_page']) && is_numeric($t_data['items_per_page']))
                {
                    $GLOBALS['core.list']->set_param('items_per_page', $t_data['items_per_page']);
                }
                else
                {
                    $GLOBALS['core.list']->set_param('items_per_page', 10);
                }
                $GLOBALS['core.list']->set_param('order_by', array('order_no'));

		$filters = array();
                $filters['testimonial_id'] = array('f' => 'testimonial_id', 'v' => $t_data['id']);
                $filters['active'] = array('f' => 'active', 'v' => 1);
                $GLOBALS['core.list']->set_filters($filters);

		$page_num = 1;
		if(isset($_REQUEST['page_num']) && is_numeric($_REQUEST['page_num']))
		{
			$page_num = $_REQUEST['page_num'];
		}

		$page = $GLOBALS['core.list']->get_page($page_num);
		$num_pages = $GLOBALS['core.list']->num_pages();


		$GLOBALS['core.smarty']->assign('page', $page);
		$GLOBALS['core.smarty']->assign('num_pages', $num_pages);

                $GLOBALS['core.smarty']->assign('t_data', $t_data);
                return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/Testimonials/testimonial_module.tpl');
               // $GLOBALS['core.smarty']->assign('t_entries', $t_entries);
            }
            else
            {
                $entry = $teh->get_last_testimonial($t_data['id']);
                //$entry['content'] = strip_tags($entry['content']);                
                $entry['content'] = Page_Testimonial_Runmode::format_content($entry['content']);                                    
                $GLOBALS['core.smarty']->assign('entry', $entry);
                $GLOBALS['core.smarty']->assign('t_data', $t_data);

                return $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/Testimonials/testimonial_first.tpl');
            }
            
        }
    }
    function process_ajax()
    {
        if(isset($_REQUEST['q']))
        {
            $_REQUEST = $_REQUEST['q'];
        }
        $teh = new Testimonial_Entry_Holder();
        if(isset($_REQUEST['testimonial_id']) && is_numeric($_REQUEST['testimonial_id']))
        {
            $entry = $teh->get_random_testimonial($_REQUEST['testimonial_id']);
            $output = array();
            if(count($entry) > 0)
            {           
                $entry['content'] = Page_Testimonial_Runmode::format_content($entry['content']);
                $GLOBALS['core.smarty']->assign('entry', $entry);
                $output['html'] = $GLOBALS['core.smarty']->fetch('Common/CMS/Page_Runmode/Testimonials/testimonial_one.tpl');
                $output['success'] = 1;
                $GLOBALS['core.ajax']->put_to_output($output);
            }
        }
    }
    function format_content($content)
    {
        $content = strip_tags($content);
        if(strlen($content) > 190)
        {
            $content = substr($content, 0, 190);
            if($content[189] != ' ')
            {
                for($i = 189; $i > 0; $i --)
                {
                    if($content[$i] == ' ')
                    {
                        $content = substr($content, 0, $i);
                        break;
                    }
                    else
                    {
                        $content = substr($content, 0, $i);
                    }
                }
            }
        }
        return $content.'...';
    }
}
?>