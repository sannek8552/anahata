<?php
require_once('Data_Holder.php');
require_once('classes/ProductHolder.php');

class CategoryHolder extends Data_Holder
{
	var $table_category_product = 'category_product';
	
	function CategoryHolder($id = null)
	{
		$table = 'category';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}

	function loadByUrl($seo_url)
	{
		$id = $GLOBALS['core.sql']->getOne("select ".$this->key_info['key_name']." from #p#".$this->table." where seo_url = ?",array($seo_url));
		if (!empty($id)) $this->load($id);
	}

	function getAll()
	{
		if ($GLOBALS['core.auth.user']->is_member_of('admin')) $result = $GLOBALS['core.sql']->getAll("select * from #p#".$this->table." order by order_id ",array(),$this->key_info['key_name']);
		else $result = $GLOBALS['core.sql']->getAll("select * from #p#".$this->table." where active = ? order by order_id ",array(1),$this->key_info['key_name']);
		return $result;
	}
	
	function getAllForGoogleSitemap()
	{
		$result = $this->getTree();//$GLOBALS['core.sql']->getAll("select * from #p#".$this->table." where active = ? order by order_id ",array(1),$this->key_info['key_name']);
		$result = $this->makeTreePlain($result,array());
		return $result;
	}
	
	function getTops($publish = false)
	{
		//$result = $GLOBALS['core.sql']->getAll("select * from #p#".$this->table." where parent_id = ? order by order_id ",array(0),$this->key_info['key_name']);
		$result = $this->getTree(0, $publish);
		if (!empty($result))
		{
			$ph = new ProductHolder();
			$products = $ph->getAll();
			foreach ($result as $key => $value)
				foreach ($products as $k => $v)
					if (
							($value['id'] == $v['category_id'] && $v['subcategory_picture'] == 1) 
						|| 	(isset($value['sub_ids']) && in_array($v['category_id'], $value['sub_ids']) && $v['subcategory_picture'] == 1))
					{
						$result[$key]['picture'] = $v['picture'];
						$result[$key]['picture_product_id'] = $v['id'];
						break;
					}
					
			
			foreach ($result as $key => $value)
			{
				if ($value['seo_url'] == 'Certificates')
				{
					foreach ($certs as $k => $v)
					if ($v['subcategory_picture'] == 1)
					{
						$result[$key]['picture'] = $v['picture'];
						$result[$key]['picture_product_id'] = $v['id'];
						break;
					}
				}
			}
		}		
		return $result;
	}
	
	function getBottoms($publish = false)
	{
		//new version of function for tree with not limited deep
		$bottoms = array();
		$tree = $this->getTree(0,$publish);
		$tree = $this->processTreeForPaths($tree);//pp($tree);		
		$result = $this->makeTreePlain($tree,array());		
		//-------------------------------------------------------		
		//$result = $GLOBALS['core.sql']->getAll("select * from #p#".$this->table." where parent_id != ? order by order_id ",array(0),$this->key_info['key_name']);
		if (!empty($result))
		{
			$ph = new ProductHolder();
			$products = $ph->getAll();
			foreach ($result as $key => $value)
				foreach ($products as $k => $v)
					if ($value['id'] == $v['category_id'] && $v['subcategory_picture'] == 1)	
					{
						$result[$key]['picture'] = $v['picture'];
						$result[$key]['picture_product_id'] = $v['id'];
					}
		}
		return $result;
	}
	
	function getTree($parent_id = 0, $publish = false)
	{		
		if ($GLOBALS['core.auth.user']->is_member_of('admin')) $filters = array();
		else 
		{
			//filter by access groups
			$groups = $GLOBALS['core.auth.user']->groups;
			$filter_string = " ( access = ? " ;			
			foreach ($groups as $group => $k) $filter_string .= " or access like '%$group%' ";
			$filter_string .= " )";
			$filters = array('active = ?' => 1, $filter_string => '');
			if ($publish) $filters['published = ?'] = 1;
		}
		$result = $GLOBALS['core.tree']->get_tree($parent_id, array('id','parent_id','title','description','order_id','keywords','seo_url','created','updated','page_title','page_description','google_priority','active','published'),$this->table, $this->key_info['key_name'],'parent_id', 'order_id',$filters);
		if (empty($parent_id) && isset($result[$parent_id]['sub'])) return $result[$parent_id]['sub'];
		elseif (isset($result[$parent_id])) return $result[$parent_id];
		else return array();
	}

    function getTreeAdmin()
	{
		$result = $GLOBALS['core.tree']->get_tree(0, array('id','parent_id','title','description','order_id','keywords','seo_url','created','updated','page_title','page_description','google_priority','active','published'),$this->table, $this->key_info['key_name'],'parent_id', 'order_id',array());
		$to_ret['root'] = array('id'=>0,'parent_id'=>0,'title'=>'Root Category');
		if(isset($result[0]['sub'])) $to_ret['sub'] = $result[0]['sub'];
		return $to_ret;
	}
	
	function getChilds()
	{
		$id = $this->get_key_value();
		$childs = array();
		if (!empty($id))
		{
			if ($GLOBALS['core.auth.user']->is_member_of('admin')) $childs = $GLOBALS['core.sql']->getAll('select * from #p#'.$this->table.' where parent_id = ? order by order_id ',array($id),$this->key_info['key_name']);
			else 
			{
				$childs = $GLOBALS['core.sql']->getAll('select * from #p#'.$this->table.' where parent_id = ? and active = ? order by order_id ',array($id,1),$this->key_info['key_name']);
				$current_user_groups = $GLOBALS['core.auth.user']->groups;
				foreach ($childs as $key => $value)
				{
					$give_access = true;
					if (isset($value['access']) && !empty($value['access']))
					{
						$access = explode(",", $value['access']);
						$give_access = false;
						foreach ($access as $group)
						{
							if (isset($current_user_groups[$group]))
								$give_access = true;
						}
					}
					if (!$give_access) unset($childs[$key]);
				}
			}
			$ph = new ProductHolder();
			$products = $ph->getAll();
			//$product_categories = $this->getCategoriesForAllProducts();
			
			foreach ($childs as $key => $value)
			{
				foreach ($products as $k => $v)
				{
					if ($v['category_id'] == $value['id'] && $v['subcategory_picture'] == 1)
					{
						$childs[$key]['picture'] = $v['picture'];
						$childs[$key]['picture_product_id'] = $v['id'];
					}
				}
			}
		}
		return $childs;
	}

        function getPublishedChilds()
	{
		$id = $this->get_key_value();
		$childs = array();
		if (!empty($id))
		{
			if ($GLOBALS['core.auth.user']->is_member_of('admin')) $childs = $GLOBALS['core.sql']->getAll('select * from #p#'.$this->table.' where parent_id = ? order by order_id ',array($id),$this->key_info['key_name']);
			else
			{
				$childs = $GLOBALS['core.sql']->getAll('select * from #p#'.$this->table.' where parent_id = ? and active = ? and published = ? order by order_id ',array($id,1,1),$this->key_info['key_name']);
				$current_user_groups = $GLOBALS['core.auth.user']->groups;
				foreach ($childs as $key => $value)
				{
					$give_access = true;
					if (isset($value['access']) && !empty($value['access']))
					{
						$access = explode(",", $value['access']);
						$give_access = false;
						foreach ($access as $group)
						{
							if (isset($current_user_groups[$group]))
								$give_access = true;
						}
					}
					if (!$give_access) unset($childs[$key]);
				}
			}
			$ph = new ProductHolder();
			$products = $ph->getAll();
			//$product_categories = $this->getCategoriesForAllProducts();

			foreach ($childs as $key => $value)
			{
				foreach ($products as $k => $v)
				{
					if ($v['category_id'] == $value['id'] && $v['subcategory_picture'] == 1)
					{
						$childs[$key]['picture'] = $v['picture'];
						$childs[$key]['picture_product_id'] = $v['id'];
					}
				}
			}
		}
		return $childs;
	}
	
	function getCategoriesForSelect()
	{
		$tops = $this->getTops();
		$bottoms = $this->getBottoms();
		$to_ret = array();
		
		foreach ($tops as $key => $value)
		{
			$to_ret[$key] = $value['title'];
			foreach ($bottoms as $bkey => $bvalue)
			{
				/*
				if ($bvalue['parent_id'] == $key)
				{
					$to_ret[$bkey] = $value['title'].'/'.$bvalue['title'];
				}
				*/
				$to_ret[$bkey] = $bvalue['_path'];
			}
		}
		return $to_ret;
	}
	
	function getCategoriesForProduct($product_id)
	{
		$categories = $GLOBALS['core.sql']->getAll("select category_id from #p#" . $this->table_category_product . " where product_id = ?", array($product_id),'category_id');		
		$product = new ProductHolder($product_id);
		$category_id = $product->get_data('category_id');
		if (!empty($category_id)) $categories[$category_id] = $category_id;
		return $categories;
	}
	
	function setCategoriesForProduct($product_id, $category_ids)
	{		
		$GLOBALS['core.store']->delete($this->table_category_product, array('key_name' => 'product_id', 'key_value' => $product_id));
		if (!empty($category_ids))
		{
			$data = array();
			foreach ($category_ids as $id)
			{
				$data[] = array('product_id' => $product_id, 'category_id' => $id);
			}
			$GLOBALS['core.store']->fast_insert($this->table_category_product, $data);
		}
	}
	
	function getCategoriesForAllProducts()
	{
		$categories = $GLOBALS['core.sql']->getAll("select * from #p#" . $this->table_category_product, array());
		$ph = new ProductHolder();
		$products = $ph->getAll();
		
		$to_return = array();
		foreach ($categories as $key => $value)
		{
			if (!isset($to_return[$value['product_id']])) $to_return[$value['product_id']] = array();
			$to_return[$value['product_id']][$value['category_id']] = $value;
			if (isset($products[$value['product_id']]) && isset($products[$value['product_id']]['category_id'])
				&& !empty($products[$value['product_id']]['category_id']))
				$to_return[$value['product_id']][$products[$value['product_id']]['category_id']] = array('category_id' => $products[$value['product_id']]['category_id'], 'product_id' => $value['product_id']);
		}
		return $to_return;
	}
	
	function getProductsForCategory($category_id)
	{
		$products = $GLOBALS['core.sql']->getAll("select product_id from #p#" . $this->table_category_product . " where category_id = ?", array($category_id),'product_id');
		$primary_products = $GLOBALS['core.sql']->getAll("select id from #p#product where category_id = ?", array($category_id),'id');
		foreach ($primary_products as $key => $value) $products[$key] = $value;
		return $products;
	}
	
	function getProductsForAllCategories()
	{
		$products = $GLOBALS['core.sql']->getAll("select * from #p#" . $this->table_category_product, array());		
		$ph = new ProductHolder();
		$primary_products = $ph->getAll();		
		$to_return = array();
		foreach ($products as $key => $value)
		{
			if (!isset($to_return[$value['category_id']])) $to_return[$value['category_id']] = array();
			$to_return[$value['category_id']][$value['product_id']] = $value;			
		}
		
		foreach ($primary_products as $k => $v)
		{
			if (!isset($to_return[$v['category_id']])) $to_return[$v['category_id']] = array();
			$to_return[$v['category_id']][$v['id']] = array('category_id' => $v['category_id'],'product_id' => $v['id']);							
		}
		
		return $to_return;
	}
	
	function makeTreePlain($tree, $result)
	{
            if (!empty($tree)) {
		foreach ($tree as $key => $value)
		{
			$result[$key] = $value;
			if (isset($value['sub'])) 
			{
				$result = $this->makeTreePlain($value['sub'], $result);
                                if (is_array($result[$key]['sub'])) {
                                    unset($result[$key]['sub']);
                                }
                                if (is_array($result[$key]['sub_ids'])) {
                                    
                                    unset($result[$key]['sub_ids']);			
                                }
					
			}			
		}
            }
            return $result;
	}
	
	function processTreeForPaths($tree, $parent_path_prefix = '')
	{
            if (!empty($tree)) {
		foreach ($tree as $key => $value)
		{
			$tree[$key]['_path'] = $value['title'];
			if (!empty($parent_path_prefix))
				$tree[$key]['_path'] = $parent_path_prefix . "/" . $value['title'];
			if (isset($value['sub']))
				$tree[$key]['sub'] = $this->processTreeForPaths($tree[$key]['sub'], $tree[$key]['_path']);
		}
            }
            return $tree;
	}
	
	function loadCategoriesForSelect()
	{
		$cats = $this->getCategoriesForSelect();
		$GLOBALS['core.smarty']->assign('select_categories', $cats);
		$all_cats = $this->getAll();
		$GLOBALS['core.smarty']->assign('all_categories', $all_cats);
	}
	
	function load_open_cats()
	{
		$childs = $this->getChilds();
		$GLOBALS['core.smarty']->assign('childs',$childs);
		$GLOBALS['core.smarty']->assign('open_parent',$this->get_key_value());
	}
	
    function delete()
    {
        $sub_cats = $GLOBALS['core.sql']->getAll('SELECT id FROM #p#category WHERE parent_id=?', $this->get_key_value());
        foreach ($sub_cats as $key => $value)
        {
                $temp_cat = new CategoryHolder($value['id']);
                $temp_cat->delete();
        }
        parent::delete();
    }

    function save()
    {
        parent::save();
        $this->make_revision();
    }


    function move_up()
	{
                $id = $this->get_key_value();
                $order_id = $this->get_data('order_id');
                $parent_id = $this->get_data('parent_id');
		if(isset($id) && !empty($id))
		{
			$mod = array($parent_id,$order_id);

			$bigger_row = $GLOBALS['core.sql']->getRow('SELECT * FROM #p#category WHERE parent_id=? AND order_id<? ORDER BY order_id desc LIMIT 1',$mod);
			if(!empty($bigger_row))
			{
				$bigger_row_obj = new CategoryHolder($bigger_row['id']);
                                $bigger_row_obj->set_data(array('order_id'=>$order_id));
                                $this->set_data(array('order_id'=>$bigger_row['order_id']));
                                $bigger_row_obj->save();
				$this->save();
			}
		}
	}

    function move_down()
	{
                $id = $this->get_key_value();
                $order_id = $this->get_data('order_id');
                $parent_id = $this->get_data('parent_id');
		if(isset($id) && !empty($id))
		{
			$mod = array($parent_id,$order_id);

			$less_row = $GLOBALS['core.sql']->getRow('SELECT * FROM #p#category WHERE parent_id=? AND order_id>? ORDER BY order_id LIMIT 1',$mod);
			if(!empty($less_row))
			{
				$less_row_obj = new CategoryHolder($less_row['id']);
				$less_row_obj->set_data(array('order_id'=>$order_id));
				$this->set_data(array('order_id'=>$less_row['order_id']));
				$less_row_obj->save();
				$this->save();
			}
		}
	}
	
	function publish()
	{
		$this->set_data(array('published' => 1));
		$this->save();
	}
	
	function unpublish()
	{
		$this->set_data(array('published' => 0));
		$this->save();
	}
	
	function activate()
	{
		$this->set_data(array('active' => 1));
		$this->save();
	}
	
	function deactivate()
	{
		$this->set_data(array('active' => 0));
		$this->save();
	}

    function move_to($to)
	{
		if(!isset($to))
			return false;
                if(!empty($to))
                {
                    $to_cat = new CategoryHolder($to);
                    $max_order = $GLOBALS['core.sql']->getOne('SELECT max(order_id) FROM #p#category WHERE parent_id=?',$to_cat->get_data('id'));
                    if(empty($max_order))
                            $max_order = 0;
                    $max_order++;
                    $this->set_data(array('order_id' => $max_order));
                    $this->set_data(array('parent_id' => $to_cat->get_data('id')));
                }
                else
                {
                    $max_order = $GLOBALS['core.sql']->getOne('SELECT max(order_id) FROM #p#category WHERE parent_id=?',0);
                    if(empty($max_order))
                            $max_order = 0;
                    $max_order++;
                    $this->set_data(array('order_id' => $max_order));
                    $this->set_data(array('parent_id' => 0));
                }
		
		$this->save();
	}

    function make_revision()
    {
            $rev_table = "category_revision";
            $rev_data = $this->get_data();
            $rev_data['record_id'] = $this->get_key_value();
            unset($rev_data['updated']);
            unset($rev_data['created']);
            unset($rev_data['id']);
            //$rev_data['record_id'] = $this->get_data('id');
            $GLOBALS['core.store']->save($rev_table, $rev_data, array('key_name' => 'id'));
    }

    function getRevisionList($record_id)
    {
        $res = $GLOBALS['core.sql']->getAll("SELECT id,created FROM #p#category_revision WHERE record_id=? ORDER BY created DESC LIMIT 10",array($record_id));
        foreach ($res as $key => $value)
        {
            $res[$key]['created'] = date("d/m/Y h:i A", $res[$key]['created']);
        }
        return $res;
    }
    function getRevisionById($rev_id)
    {
        $res = $GLOBALS['core.sql']->getRow("SELECT * FROM #p#category_revision WHERE id=?",array($rev_id));
        //$cr_id = $GLOBALS['core.sql']->getOne("SELECT login FROM #p#user WHERE user_id=?",array($res['created_user_id']));
        //$up_id = $GLOBALS['core.sql']->getOne("SELECT login FROM #p#user WHERE user_id=?",array($res['updated_user_id']));
        //$res['created_user_id'] = !empty($cr_id)?$cr_id:'';
        //$res['updated_user_id'] = !empty($up_id)?$up_id:'';
        $res['created'] = date("d/m/Y h:i A", $res['created']);
        $res['updated'] = date("d/m/Y h:i A", $res['updated']);
        return $res;
    }

    function getCategoriesForHeader()
    {
        $cur_user_groups = $GLOBALS['core.auth.user']->groups;
        
        if ($GLOBALS['core.auth.user']->is_member_of('admin'))        
        	$result = $GLOBALS['core.tree']->get_tree(0, array('id','parent_id','title','description','order_id','keywords','seo_url','created','updated','page_title','page_description','google_priority','access'),$this->table, $this->key_info['key_name'],'parent_id', 'order_id',array());
        else 
        {        	
        	$result = $GLOBALS['core.tree']->get_tree(0, array('id','parent_id','title','description','order_id','keywords','seo_url','created','updated','page_title','page_description','google_priority','access'),$this->table, $this->key_info['key_name'],'parent_id', 'order_id',array('active = ?' => 1, 'published = ?' => 1));
        }
        $tree = $result[0]['sub'];
        
        $tree = $this->processCategoryTree($tree, $cur_user_groups);

        /*
        $new_tree = array();
        
        foreach($tree as $key=>$value)
        {
            $cur_path = "[$key]";
            $new_tree[$value['id']] = "[$key]";

            if(isset($value['access']) && !empty($value['access']))
            {
                //pp($cur_user_groups);
                $groups = explode(',',$value['access']);
                $have_access = false;
                foreach($groups as $g_value)
                {
                    if(isset($cur_user_groups[trim($g_value)]))
                    {
                        
                        $have_access = true;
                        break;
                    }
                }
                if(!$have_access)
                {
                    //pp('$tree'.$cur_path);
                    eval("unset(\$tree$cur_path);");
                    //pp($tree[10063]);exit();
                    continue;
                }
            }
            
            
            if(isset($value['sub']))
            {
                
               $this->getCategoriesForHeader_sub($value['sub'], $new_tree, $tree);
                
            }
        }
		*/
        //pp($new_tree);
        //pp($tree);
        //exit();
        return $tree;
    }
    
    function processCategoryTree($tree, $cur_user_groups)
    {
    	$new_tree = array();
        
        foreach($tree as $key=>$value)
        {
            $cur_path = "[$key]";
            $new_tree[$value['id']] = "[$key]";

            if(isset($value['access']) && !empty($value['access']))
            {
                //pp($cur_user_groups);
                $groups = explode(',',$value['access']);
                $have_access = false;
                foreach($groups as $g_value)
                {
                    if(isset($cur_user_groups[trim($g_value)]))
                    {
                        $have_access = true;
                        break;
                    }
                }
                if(!$have_access)
                {                    
                    eval("unset(\$tree$cur_path);");                 
                    continue;
                }
            }          
                    
            if(isset($value['sub']))
            {
                
               $this->getCategoriesForHeader_sub($value['sub'], $new_tree, $tree, $cur_user_groups);
                
            }
        }
        return $tree;
    }

    function getCategoriesForHeader_sub($sub,&$new_tree, &$tree, $cur_user_groups = array())
    {
    	if (empty($cur_user_groups))	$cur_user_groups = $GLOBALS['core.auth.user']->groups;
        //pp($sub);
        $cur_path = '';
        foreach($sub as $key=>$value)
        {
           // pp($new_tree);
            $cur_path = $new_tree[$value['parent_id']]."['sub']"."[$key]";
            $new_tree[$value['id']] = $cur_path;
            
            if(isset($value['access']) && !empty($value['access']))
            {
                //pp($cur_user_groups);
                $groups = explode(',',$value['access']);
                $have_access = false;
                foreach($groups as $g_value)
                {
                    if(isset($cur_user_groups[trim($g_value)]))
                    {

                        $have_access = true;
                        break;
                    }
                }
                if(!$have_access)
                {
                    //pp('$tree'.$cur_path);
                    eval("unset(\$tree$cur_path);");
                    //pp($tree[10063]);exit();
                    continue;
                }
            }
            
            if(isset($value['sub']))
            {
                //pp($value);
                $this->getCategoriesForHeader_sub($value['sub'], $new_tree, $tree, $cur_user_groups);
            }
            
        }
    }

    function getPagesForSelect()
    {
        //$mh = new MenuHolder();
        $tr = $mh->getTree();
        $tree[] = $tr;
        //pp($tree);

        $new_tree = array();
        $cur_title = '';
        foreach($tree as $value)
        {
            $new_tree[$value['id']] = $value['title'];
            if(isset($value['sub']))
            {
                foreach($value['sub'] as $value_sub)
                {
                    $this->additional($value['sub'], $new_tree);
                }
            }
        }
        return $new_tree;
        //pp($new_tree);
    }

    function additional($sub,&$new_tree)
    {
        $cur_title = '';
        foreach($sub as $value)
        {
            $cur_title = ($value['parent_id']!=1)?$new_tree[$value['parent_id']].'/'.$value['title']:$value['title'];
            $new_tree[$value['id']] = $cur_title;
            if(isset($value['sub']))
            {
                $this->additional($value['sub'], $new_tree);
            }
        }
    }
    
    function checkAccess()
    {
    	$access = $this->get_data('access');
		$has_access = true;
		if (!empty($access) && !$GLOBALS['core.auth.user']->is_member_of('admin'))
		{
			$has_access = false;
			$access_groups = explode(",", $access);
			foreach ($access_groups as $access_group)
			{
				if (isset($GLOBALS['core.auth.user']->groups[$access_group])) $has_access = true;
			}
		}
		return $has_access;
    }
    
}
?>