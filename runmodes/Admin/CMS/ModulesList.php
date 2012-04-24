<?php
require_once('modules/CMS/MenuHolder.php');
class ModulesList extends Runmode 
{
    var $menu_keys = array();
	function ModulesList()
	{
            parent::Runmode();
	}
	
	function process()
	{
            $GLOBALS['core.do_not_parse'] = true;
            $GLOBALS['core.smarty']->assign('module_list', $this->get_list());
            $this->upgrade_popup();
            return $GLOBALS['core.smarty']->fetch('Admin/CMS/modules_list.tpl');
            return '';
	}
        function upgrade_popup()
        {
            $mh = new MenuHolder();
            $menu_list = $mh->getTree();
            $this->make_preffix($menu_list['sub'], '');

            $GLOBALS['core.smarty']->assign('menu_list', $menu_list);
            //$GLOBALS['core.smarty']->assign('menu_keys', $this->menu_keys);
            $main_page = array();
            if(isset($menu_list['title']) && $menu_list['title'] != '')
            {
                $main_page['title'] = $menu_list['title'];
            }
            if(isset($menu_list['seo_url']) && $menu_list['seo_url'] != '')
            {
                $main_page['seo_url'] = $menu_list['seo_url'];
            }
            $GLOBALS['core.smarty']->assign('main_page', $main_page);
        }
	function make_preffix(&$array, $preffix)
        {
            foreach ($array as $key => $value)
            {
                $array[$key]['prefix'] = $preffix.'->'.$value['title'];
                if(isset($value['sub']))
                {
                    
                    //$this->menu_keys[$key]['preffix'] = $preffix.'->'.$value['title'];
                    $this->make_preffix($array[$key]['sub'], $array[$key]['prefix']);
                }
            }                        
        }
	function get_list()
	{
            $modules = array(
                                'contact_module' => array('class' => 'CMS/Contact_Holder.php','class_name' => 'Contact_Holder','name' => 'Contact','entries' => array()),
                                'faq' => array('class' => 'CMS/FAQ_Holder.php','class_name' => 'FAQ_Holder','name' => 'FAQ', 'entries' => array()),
                                'google_map' => array('class' => 'CMS/GoogleMap_Holder.php','class_name' => 'GoogleMap_Holder','name' => 'Google Map','entries' => array()),
                                'before_after' => array('class' => 'CMS/Gallery_Holder.php','class_name'=>'Gallery_Holder','name' => 'Before/After','entries' => array()),
                                'gallery' => array('class' => 'CMS/Gallery_One_Holder.php','class_name' => 'Gallery_One_Holder','name' => 'gallery','entries' => array()),
                                'rss' => array('class' => 'CMS/RSS_Holder.php','class_name' => 'RSS_Holder','name' => 'RSS', 'entries' => array()),
                                'code_manager' => array('class' => 'CMS/Text_Manager_Holder.php','class_name'=>'Text_Manager_Holder','name' => 'Code Manager','entries' => array()),
                                'popup_manager' => array('class' => 'CMS/Popup_Holder.php','class_name' => 'Popup_Holder','name' => 'Popup Page', 'entries' => array()));


            foreach($modules as $key => $value)
            {
                if(isset($value['class']) && !empty($value['class']))
                {
                    require_once($value['class']);
                    $instance = new $value['class_name'];
                    $modules[$key]['entries'] = $instance->get_module_list();
                }
            }
		//pp($modules);
            return $modules;
		
	}
}
?>