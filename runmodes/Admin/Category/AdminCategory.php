<?php
require_once('Admin_Header.php');
require_once('modules/CMS/MenuHolder.php');
require_once('classes/CMS/Creator/PageHolder.php');
require_once('classes/CategoryHolder.php');

class AdminCategory extends Runmode
{
	var $category_holder = null;
	function AdminCategory()
	{
		$this->category_holder = new CategoryHolder();
		parent::Runmode();
	}

	function process()
	{
		$GLOBALS['core.smarty']->assign('new_interface', 1);
		$tree = $this->category_holder->getTreeAdmin();
                //pp($tree);exit();
		$GLOBALS['core.smarty']->assign('category_tree', json_encode($tree));

		return Admin_Header::out('Category/admin_category');
	}

	function category_creator()
	{
		//$this->categor_holder->drop_cache();

		$action = (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) ? $_REQUEST['action'] : '';
		$category_id = (isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) ? $_REQUEST['category_id'] : 0;

                if(!empty($category_id))
		$category_holder = new CategoryHolder($category_id);

		$out = array();
		if('edit' == $action)
		{
			if(isset($_REQUEST['save']))
			{
                            $errors = $this->validate($_REQUEST);
                            if(empty($errors))
                            {
                                $data = array();
                                $data['title'] = isset($_REQUEST['title'])?$_REQUEST['title']:'';
                                $data['description'] = isset($_REQUEST['description'])?$_REQUEST['description']:'';
                                $data['page_title'] = isset($_REQUEST['page_title'])?$_REQUEST['page_title']:'';
                                $data['page_description'] = isset($_REQUEST['page_description'])?$_REQUEST['page_description']:'';
                                $data['seo_url'] = isset($_REQUEST['seo_url'])?$_REQUEST['seo_url']:'';
                                $data['keywords'] = isset($_REQUEST['keywords'])?$_REQUEST['keywords']:'';
                                $data['google_priority'] = isset($_REQUEST['google_priority'])?$_REQUEST['google_priority']:0.1;
                                $data['access'] = isset($_REQUEST['access'])?$_REQUEST['access']:'';
                                $data['active'] = isset($_REQUEST['active'])?$_REQUEST['active']:0;
                                $data['published'] = isset($_REQUEST['published'])?$_REQUEST['published']:0;
				$category_holder->set_data($data);
				$category_holder->save();
				//$out = $category_holder->get_data();
                                //$out['revisions'] = $category_holder->getRevisionList($page_id);
                            }

			}
			$out = $category_holder->get_data();
                        $out['revisions'] = $category_holder->getRevisionList($category_id);
                        if(!empty($errors))
                            $out['errors'] = $errors;
                        $out['success'] = true;
		}
		elseif ('add' == $action)
                {
			$out['id'] = $category_id;
                        //pp($_REQUEST);
                        if(isset($_REQUEST['save']))
			{
                            $errors = $this->validate($_REQUEST);
                            if(empty($errors))
                            {
                                $data = array();
				$category_holder = new CategoryHolder();
                                $data['title'] = isset($_REQUEST['title'])?$_REQUEST['title']:'';
                                $data['description'] = isset($_REQUEST['description'])?$_REQUEST['description']:'';
                                $data['page_title'] = isset($_REQUEST['page_title'])?$_REQUEST['page_title']:'';
                                $data['page_description'] = isset($_REQUEST['page_description'])?$_REQUEST['page_description']:'';
                                $data['seo_url'] = isset($_REQUEST['seo_url'])?$_REQUEST['seo_url']:'';
                                $data['keywords'] = isset($_REQUEST['keywords'])?$_REQUEST['keywords']:'';
                                $data['google_priority'] = isset($_REQUEST['google_priority'])?$_REQUEST['google_priority']:0.1;
                                $data['access'] = isset($_REQUEST['access'])?$_REQUEST['access']:'';
                                $data['parent_id'] = $category_id;

                                $max = $GLOBALS['core.sql']->getOne('SELECT max(order_id) FROM #p#category WHERE parent_id=?', $category_id);
                                $max = empty($max)?1:($max+1);
                                $data['order_id'] = $max;
                                
				$category_holder->set_data($data);
				$category_holder->save();
                                $data['id'] = $category_holder->get_key_value();
				$out = $data;
                                $out['revisions'] = $category_holder->getRevisionList($category_id);
                            }
                            else
                                $out['errors'] = $errors;
			}
			$out['success'] = true;

		}
		elseif ('move_down' == $action)
		{
			$out['id'] = $category_id;
			$category_holder->move_down();
			$out['success'] = true;
		}
		elseif ('move_up' == $action)
		{
			$out['id'] = $category_id;
			$category_holder->move_up();
			$out['success'] = true;
		}
		elseif ('publish' == $action)
		{
			$out['id'] = $category_id;
			$category_holder->publish();
			$out['success'] = true;
		}
		elseif ('unpublish' == $action)
		{
			$out['id'] = $category_id;
			$category_holder->unpublish();
			$out['success'] = true;
		}
		elseif ('activate' == $action)
		{
			$out['id'] = $category_id;
			$category_holder->activate();
			$out['success'] = true;
		}
		elseif ('deactivate' == $action)
		{
			$out['id'] = $category_id;
			$category_holder->deactivate();
			$out['success'] = true;
		}
		elseif ('delete' == $action)
		{
                        //pp($_REQUEST);
			$out['id'] = $category_id;
			$category_holder->delete();
			$out['success'] = true;
		}
		elseif ('move' == $action)
		{
			$category_holder->move_to($_REQUEST['to']);
			$out['success'] = true;
		}
                elseif ('loadRevision' == $action)
                {
                        $rev_id = (isset($_REQUEST['rev_id']) && !empty($_REQUEST['rev_id'])) ? $_REQUEST['rev_id'] : 0;
                        $out = CategoryHolder::getRevisionById($rev_id);
                }

		$GLOBALS['core.ajax']->put_to_output($out);
	}

        function validate($data)
        {
            $errors = array();

            if(isset($data['seo_url']) && !empty($data['seo_url']))
            {
                $seo = $GLOBALS['core.sql']->getOne("SELECT * FROM #p#category WHERE seo_url=? AND id!=?",array($data['seo_url'],$data['category_id']));
                if(!empty($seo))
                    $errors['seo_url'] = 1;

            }
            return $errors;
        }
}
?>