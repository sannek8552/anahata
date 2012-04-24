<?php
require_once('Admin_Header.php');
require_once('modules/CMS/MenuHolder.php');
require_once('classes/CMS/Creator/PageHolder.php');
require_once ('classes/CMS/Header_Image_Holder.php');

class AdminMenuNew extends Runmode 
{
	var $menu_holder = null;
	function AdminMenuNew()
	{
		$this->menu_holder = new MenuHolder();
		parent::Runmode();
	}
	
	function process()
	{
		$GLOBALS['core.smarty']->assign('new_interface', 1);
		$tree = $this->menu_holder->getTree();
		//pp($tree);
		$GLOBALS['core.smarty']->assign('menu_tree', json_encode($tree));
		$GLOBALS['core.smarty']->assign('templates', $this->scan_templates());
                $GLOBALS['core.smarty']->assign('header_images', Header_Image_Holder::getImagesForSelect());
		
		return Admin_Header::out('CMS/admin_menu_new');
	}
	
	
	function scan_templates()
	{
		$templates = array();
    	if ($dh = opendir('./templates/Headers')) 
    	{
        	while (($file = readdir($dh)) !== false) 
        	{
            	//echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
            	if('.' != $file && '..' != $file)
            	{
            		$temp = pathinfo($file);
            		if(isset($temp['extension']))
            		{
                            if('tpl' == $temp['extension']) $templates[] = $temp['filename'];
            		}
            	}
        	}
        	closedir($dh);
    	}
    	sort($templates);
    	return $templates;
	}
	
	function page_creator()
	{
		$this->menu_holder->drop_cache();
		
		$action = (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) ? $_REQUEST['action'] : '';
		$page_id = (isset($_REQUEST['page_id']) && !empty($_REQUEST['page_id'])) ? $_REQUEST['page_id'] : 0;
		//pp($_REQUEST);
                //pp($page_id);
                if(!empty($page_id))
		$page_holder = new PageHolder($page_id);
		$errors = array();
		$out = array();
                //$GLOBALS['core.smarty']->assign('revisions',$page_holder->getRevisionList($page_id));
                switch ($action)
                {
                case 'edit':
                            if(isset($_REQUEST['save']))
                            {
                                    $errors = $this->validate($_REQUEST);
                                    if(empty($errors))
                                    {
                                        $page_holder->set_data($_REQUEST);
                                        $page_holder->save();
                                        $out = $page_holder->get_data();
                                        $out['revisions'] = $page_holder->getRevisionList($page_id);
                                    }


                            }
                            $out = $page_holder->get_data();
                            $out['created']=!empty($out['created'])?date('d/m/Y h:i A',$out['created']):'';
                            $out['updated']=!empty($out['updated'])?date('d/m/Y h:i A',$out['updated']):'';
                            $created_user = $GLOBALS['core.sql']->getOne("SELECT login FROM #p#user WHERE user_id=?",array($out['created_user_id']));
                            $updated_user = $GLOBALS['core.sql']->getOne("SELECT login FROM #p#user WHERE user_id=?",array($out['updated_user_id']));
                            $out['header_images'] = Header_Image_Holder::getImagesForSelect();
                            $out['created_user_id']=!empty($created_user)?$created_user:'';
                            $out['updated_user_id']=!empty($updated_user)?$updated_user:'';
                            $out['revisions'] = $page_holder->getRevisionList($page_id);
                            if(!empty($errors))
                            $out['errors'] = $errors;
                            $out['success'] = true;
                            break;
                case 'add':
                            $out['id'] = $page_id;
                            if(isset($_REQUEST['save']))
                            {
                                $errors = $this->validate($_REQUEST);
                                if(empty($errors))
                                {
                                    $add_page = new PageHolder();
                                    $add_page->set_data($_REQUEST);
                                    $add_page->set_parent($page_id);
                                    $add_page->save();
                                    $out = $add_page->get_data();
                                    $out['created']=!empty($out['created'])?date('d/m/Y h:i A',$out['created']):'';
                                    $out['updated']=!empty($out['updated'])?date('d/m/Y h:i A',$out['updated']):'';
                                    $created_user = $GLOBALS['core.sql']->getOne("SELECT login FROM #p#user WHERE user_id=?",array($out['created_user_id']));
                                    $updated_user = $GLOBALS['core.sql']->getOne("SELECT login FROM #p#user WHERE user_id=?",array($out['updated_user_id']));
                                    $out['header_images'] = Header_Image_Holder::getImagesForSelect();
                                    $out['created_user_id']=!empty($created_user)?$created_user:'';
                                    $out['updated_user_id']=!empty($updated_user)?$updated_user:'';
                                    $out['revisions'] = $page_holder->getRevisionList($page_id);
                                }
                                else
                                    $out['errors'] = $errors;
                            }

                            $out['success'] = true;
                            break;
                case 'move_down':
                            $out['id'] = $page_id;
                            $page_holder->move_down();
                            $out['success'] = true;
                            break;
                case 'move_up':
                            $out['id'] = $page_id;
                            $page_holder->move_up();
                            $out['success'] = true;
                            break;
                case 'publish':
                            $out['id'] = $page_id;
                            $page_holder->publish(true);
                            $out['success'] = true;
                            break;
                case 'unpublish':
                            $out['id'] = $page_id;
                            $page_holder->publish(false);
                            $out['success'] = true;
                            break;
                case 'activate':
                            $out['id'] = $page_id;
                            $page_holder->activate(true);
                            $out['success'] = true;
                            break;
                case 'deactivate':
                            $out['id'] = $page_id;
                            $page_holder->activate(false);
                            $out['success'] = true;
                            break;
                case 'delete':
                            if($page_id != 1)
                            {
                                    $out['id'] = $page_id;
                                    $page_holder->delete();
                            }
                            $out['success'] = true;
                            break;
                case 'move':
                            $page_holder->move_to($_REQUEST['to']);
                            $out['success'] = true;
                            break;
                case 'loadRevision':
                            $rev_id = (isset($_REQUEST['rev_id']) && !empty($_REQUEST['rev_id'])) ? $_REQUEST['rev_id'] : 0;
                            $out = PageHolder::getRevisionById($rev_id);
                            break;
		}
		
		$GLOBALS['core.ajax']->put_to_output($out);
	}

        function validate($data)
        {
            $errors = array();
            
            if(isset($data['seo_url']) && !empty($data['seo_url']))
            {
                $seo = $GLOBALS['core.sql']->getOne("SELECT * FROM #p#menu WHERE seo_url=? AND id!=?",array($data['seo_url'],$data['page_id']));
                if(!empty($seo))
                    $errors['seo_url'] = 1;
                
            }
            return $errors;
        }
}
?>