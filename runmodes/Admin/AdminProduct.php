<?php
require_once('Admin_Header.php');
require_once('ProductHolder.php');
require_once('CategoryHolder.php');
require_once('BrandHolder.php');
require_once('DropdownManager.php');
require_once('classes/SettingsHolder.php');

class AdminProduct extends Runmode 
{
	function AdminProduct()
	{
		$this->base_map[0] = 'action';
		$this->base_map[1] = 'id';
		parent::Runmode();
		$GLOBALS['core.smarty']->assign('current_menu', 'Administration');
	}

	function process()
	{
		//pp($_REQUEST);		
		$ph = new ProductHolder();
		if (isset($_REQUEST['action']))
		{
			if ('add' == $_REQUEST['action'])
			{
				$this->load_lists();
				return Admin_Header::out('product/edit_product');
			}
			
			if ('edit' == $_REQUEST['action'])
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					$ph = new ProductHolder($_REQUEST['id']);
					$GLOBALS['core.smarty']->assign('product',$ph->get_data());
					$this->load_lists();
					return Admin_Header::out('product/edit_product');
				}
			}
			
			if ('save' == $_REQUEST['action'])
			{
				$data = $this->process_save();
				$id = null;
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))	$id = $_REQUEST['id'];
				
				if (isset($data['category_ids'])) 
				{
					$category_ids = $data['category_ids'];
					unset($data['category_ids']);					
				}				
				
				$ph = new ProductHolder($id);
				$ph->set_data($data);
				$ph->save();
				$ph->checkStockLimit();
				
				if (isset($category_ids))
				{
					$ch = new CategoryHolder();
					$ch->setCategoriesForProduct($ph->get_key_value(), $category_ids);
				}				
				
				$this->subcategory_picture($data,$ph->get_key_value());
				
				$special_res = $this->special_save($ph->get_key_value());
				if (!empty($special_res['errors']))
				{
					//pp($special_res);
					$GLOBALS['core.smarty']->assign('special_error',$special_res['errors']);
					$GLOBALS['core.smarty']->assign('special_data',$special_res['data']);
					$_REQUEST['id'] = $ph->get_key_value();
					$_REQUEST['action'] = 'edit';
					$_REQUEST['save'] = 1;
					return $this->process();
				}
				
				$this->optionSave($ph->get_key_value());
				
				if ($special_res['delete'] == 1)
				{
					//pp($ph->get_key_value());
					$spech = new SpecialHolder();
					$spech->loadByProductId($ph->get_key_value());
					$spech->delete();
				}
			}
			
			if ('delete' == $_REQUEST['action'])
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					$ph = new ProductHolder($_REQUEST['id']);
					$data = $ph->get_data();
                                        
					if (file_exists('./pictures/'.$data['picture1']))       unlink('./pictures/'.$data['picture1']);
                                        if (file_exists('./pictures/main_'.$data['picture1']))  unlink('./pictures/main_'.$data['picture1']);
                                        if (file_exists('./pictures/thumb_'.$data['picture1'])) unlink('./pictures/thumb_'.$data['picture1']);
                                        if (file_exists('./pictures/block_'.$data['picture1'])) unlink('./pictures/block_'.$data['picture1']);

                                        if (file_exists('./pictures/'.$data['picture2']))       unlink('./pictures/'.$data['picture2']);
                                        if (file_exists('./pictures/main_'.$data['picture2']))  unlink('./pictures/main_'.$data['picture2']);
                                        if (file_exists('./pictures/thumb_'.$data['picture2'])) unlink('./pictures/thumb_'.$data['picture2']);
                                        if (file_exists('./pictures/block_'.$data['picture2'])) unlink('./pictures/block_'.$data['picture2']);

                                        if (file_exists('./pictures/'.$data['picture3']))       unlink('./pictures/'.$data['picture3']);
                                        if (file_exists('./pictures/main_'.$data['picture3']))  unlink('./pictures/main_'.$data['picture3']);
                                        if (file_exists('./pictures/thumb_'.$data['picture3'])) unlink('./pictures/thumb_'.$data['picture3']);
                                        if (file_exists('./pictures/block_'.$data['picture3'])) unlink('./pictures/block_'.$data['picture3']);

                                        if (file_exists('./pictures/'.$data['picture4']))       unlink('./pictures/'.$data['picture4']);
                                        if (file_exists('./pictures/main_'.$data['picture4']))  unlink('./pictures/main_'.$data['picture4']);
                                        if (file_exists('./pictures/thumb_'.$data['picture4'])) unlink('./pictures/thumb_'.$data['picture4']);
                                        if (file_exists('./pictures/block_'.$data['picture4'])) unlink('./pictures/block_'.$data['picture4']);
					$ph->delete();
				}
			}
			
			if ('copy' == $_REQUEST['action'])
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
				{
					$ph = new ProductHolder($_REQUEST['id']);
					$ph->copy();
				}
			}

			if ('page' == $_REQUEST['action'])
			{
				if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))	$page = $_REQUEST['id'];
			}
		}
		
		$GLOBALS['core.list']->custom_init('product_list');
		$GLOBALS['core.list']->set_sql(' * from #p#product ');
		$GLOBALS['core.list']->set_param('items_per_page',10);
		$GLOBALS['core.list']->set_param('order_by',array('order_no', 'created DESC'));
		
		$filters = array();
		$filters = $GLOBALS['core.list']->get_filters();		
		if (isset($_REQUEST['filter']) && !empty($_REQUEST['filter']))
		{
			if (isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id']))
			{
				$ch = new CategoryHolder();
				$category_products = $ch->getProductsForAllCategories();
				$categories = $ch->getTree($_REQUEST['category_id']);
				$cat_ids = array($_REQUEST['category_id']);
				if (isset($categories['sub_ids']) && !empty($categories['sub_ids']))	$cat_ids = array_merge($cat_ids, $categories['sub_ids']);
				
				$products = array();
				foreach ($cat_ids as $cat_id => $v)
				{
					if (isset($category_products[$v]))
					{
						$products = array_merge($products, array_keys($category_products[$v]));
					}
				}
				if (!empty($products))	$filters['category_id'] = array('f' => 'id', 'v' => $products, 'o' => 'in', 'cat_id' => $_REQUEST['category_id']);
				else $filters['category_id'] = array('f' => 'category_id', 'v' => -1, 'cat_id' => $_REQUEST['category_id']);
			}
			elseif (isset($filters['category_id'])) 
			{
				unset($filters['category_id']);
			}
			
			if (isset($_REQUEST['show_inactive']))
			{									
				if ($_REQUEST['show_inactive'] == 2)
				{
					if (isset($filters['show_inactive'])) unset($filters['show_inactive']);
				}
				else
				{
					$filters['show_inactive'] = array('f' => 'inactive', 'v' => $_REQUEST['show_inactive']);
				}
			}
			
			if (isset($_REQUEST['special']) && !empty($_REQUEST['special']))
			{
				$sph = new SpecialHolder();
				$s_products = $sph->getAllProducts();
				$filters['special'] = array('f' => 'id', 'o' => 'in', 'v' => array_keys($s_products));
			}
			elseif (isset($filters['special'])) unset($filters['special']);
			
			if (isset($_REQUEST['search_value']) && !empty($_REQUEST['search_value']))
			{
				$sub = array();
				$sub[] = array('f' => 'name','o' => 'like', 'v' => $_REQUEST['search_value']);
				$product_ids = $GLOBALS['core.sql']->getAll("select product_id from #p#product_option where name like ?",array('%'.$_REQUEST['search_value'].'%'));
				if (!empty($product_ids))
				{
					$values = array();
					foreach ($product_ids as $key => $value) $values[] = $value['product_id'];
					$sub[] = array('f' => 'id', 'o' => 'in', 'v' => array_values($values));
				}
				
				$category_ids =	$GLOBALS['core.sql']->getAll("select id from #p#category where title like ?",array('%'.$_REQUEST['search_value'].'%'));
				$cats_ids = array();
				$ch = new CategoryHolder();
				foreach ($category_ids as $key => $value)
				{
					$categories = $ch->getTree($value['id']);
					$cats_ids = array($value['id']);
					if (isset($categories['sub_ids']) && !empty($categories['sub_ids']))	$cats_ids = array_merge($cats_ids, $categories['sub_ids']);
				}
				
				if (!empty($cats_ids)) $sub[] = array('f' => 'category_id', 'o' => 'in', 'v' => $cats_ids);
				$sub[] = array('f' => 'description','o' => 'like', 'v' => $_REQUEST['search_value']);
				$sub[] = array('f' => 'full_description','o' => 'like', 'v' => $_REQUEST['search_value']);
				$sub[] = array('f' => 'number','o' => 'like', 'v' => $_REQUEST['search_value']);
				$sub['logik'] = 'OR';
				$filters['search_value'] = array('sub' => $sub,'value' => $_REQUEST['search_value']);
			}
			elseif (isset($filters['search_value'])) unset($filters['search_value']);
		}
		
		$GLOBALS['core.list']->set_filters($filters);
		//pp($filters);
		$GLOBALS['core.smarty']->assign('filters',$filters);
		
		if (!isset($page)) $page = 1;
		$products = $GLOBALS['core.list']->get_page($page);
		$info = $GLOBALS['core.list']->num_pages();
		$GLOBALS['core.smarty']->assign('pages_info',$info);
		$GLOBALS['core.smarty']->assign('products',$products);
		
		$this->load_lists();
		
		return Admin_Header::out('product/admin_product');
	}

	function process_save()
	{
		$data = array();
		
		if (isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])) $data['category_id'] = $_REQUEST['category_id'];
		if (isset($_REQUEST['category_ids']))	$data['category_ids'] = $_REQUEST['category_ids'];
		else $data['category_ids'] = array();
		if (isset($_REQUEST['name']) && !empty($_REQUEST['name'])) $data['name'] = $_REQUEST['name'];
		if (isset($_REQUEST['number'])) $data['number'] = $_REQUEST['number'];		
		if (isset($_REQUEST['price']))	$data['price'] = $_REQUEST['price'];
                if (isset($_REQUEST['newprice'])) $data['newprice'] = $_REQUEST['newprice'];
		if (isset($_REQUEST['weight']))	$data['weight'] = $_REQUEST['weight'];
		if (isset($_REQUEST['description']))	$data['description'] = $_REQUEST['description'];
		else $data['description'] = '';
		if (isset($_REQUEST['full_description']))	$data['full_description'] = $_REQUEST['full_description'];
		else $data['full_description'] = '';		
		if (isset($_REQUEST['brand_id'])) $data['brand_id'] = $_REQUEST['brand_id'];
		if (isset($_REQUEST['quantity']) && is_numeric($_REQUEST['quantity'])) $data['quantity'] = $_REQUEST['quantity'];
		if (isset($_REQUEST['inactive']) && !empty($_REQUEST['inactive'])) $data['inactive'] = 1;
		else $data['inactive'] = 0;
		if (isset($_REQUEST['featured']) && !empty($_REQUEST['featured'])) $data['featured'] = 1;
		else $data['featured'] = 0;
		if (isset($_REQUEST['seo'])) $data['seo'] = $_REQUEST['seo']; 
		else $data['seo'] = '';
		if (isset($_REQUEST['keywords'])) $data['keywords'] = $_REQUEST['keywords']; 
		else $data['keywords'] = '';
		if (isset($_REQUEST['page_title'])) $data['page_title'] = $_REQUEST['page_title']; 
		else $data['page_title'] = '';
		if (isset($_REQUEST['page_description'])) $data['page_description'] = $_REQUEST['page_description']; 
		else $data['keywords'] = '';
		//if (isset($_REQUEST['has_options']) && !empty($_REQUEST['has_options'])) $data['has_options'] = 1;
		//else $data['has_options'] = 0;
		
		//$data['not_wholesale'] = (isset($_REQUEST['not_wholesale']) && !empty($_REQUEST['not_wholesale'])) ? 1 : 0;
		//$data['subcategory_picture'] = (isset($_REQUEST['subcategory_picture']) && !empty($_REQUEST['subcategory_picture'])) ? 1 : 0;
		if (isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no'])) $data['order_no'] = $_REQUEST['order_no'];

                $data['house'] = isset($_REQUEST['house']) ? $_REQUEST['house'] : '';
                $data['release_year'] = isset($_REQUEST['release_year']) ? $_REQUEST['release_year'] : '';
                $data['gender'] = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                //$data['m_e_classification'] = isset($_REQUEST['m_e_classification']) ? $_REQUEST['m_e_classification'] : 0;
                $data['top_notes'] = isset($_REQUEST['top_notes']) ? $_REQUEST['top_notes'] : '';
                $data['heart_notes'] = isset($_REQUEST['heart_notes']) ? $_REQUEST['heart_notes'] : '';
                $data['base_notes'] = isset($_REQUEST['base_notes']) ? $_REQUEST['base_notes'] : '';

                //$data['fragrance_id'] = isset($_REQUEST['fragrance']) ? $_REQUEST['fragrance'] : 0;
		


                $main_w  = 300;
                $main_h  = 300;
                $thumb_w = 70;
                $thumb_h = 70;
                $block_w = 120;
                $block_h = 100;

                //Картинка 1
                if (isset($_REQUEST['delete_picture1'])) {
                    $data['picture1'] = '';
                    $ph = new ProductHolder($_REQUEST['id']);
                    $file_to_delete = $ph->get_data('picture1');
                    if (!empty($file_to_delete)) {
                        if (file_exists('./pictures/'.$file_to_delete))       unlink('./pictures/'.$file_to_delete);
                        if (file_exists('./pictures/main_'.$file_to_delete))  unlink('./pictures/main_'.$file_to_delete);
                        if (file_exists('./pictures/thumb_'.$file_to_delete)) unlink('./pictures/thumb_'.$file_to_delete);
                        if (file_exists('./pictures/block_'.$file_to_delete)) unlink('./pictures/block_'.$file_to_delete);
                    }
                }
                elseif (isset($_FILES['picture1']['name']) && $_FILES['picture1']['error'] != 4)
                {
                    if (isset($_REQUEST['id'])) {
                        $ph = new ProductHolder($_REQUEST['id']);
			$file_to_delete = $ph->get_data('picture1');
                        if (!empty($file_to_delete)) {
                            if (file_exists('./pictures/'.$file_to_delete))       unlink('./pictures/'.$file_to_delete);
                            if (file_exists('./pictures/main_'.$file_to_delete))  unlink('./pictures/main_'.$file_to_delete);
                            if (file_exists('./pictures/thumb_'.$file_to_delete)) unlink('./pictures/thumb_'.$file_to_delete);
                            if (file_exists('./pictures/block_'.$file_to_delete)) unlink('./pictures/block_'.$file_to_delete);
                        }
                    }
                    $filename = $this->upload_file($_FILES['picture1']['name'],'./pictures/');
                    if (move_uploaded_file($_FILES['picture1']['tmp_name'],'./pictures/'.$filename)) {
                        $data['picture1'] = $filename;
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/main_'. $filename, $main_w,  $main_h);
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/thumb_'.$filename, $thumb_w, $thumb_h);
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/block_'.$filename, $block_w, $block_h);
                    }
                }

                //Картинка 2
                if (isset($_REQUEST['delete_picture2'])) {
                    $data['picture2'] = '';
                    $ph = new ProductHolder($_REQUEST['id']);
                    $file_to_delete = $ph->get_data('picture2');
                    if (!empty($file_to_delete)) {
                        if (file_exists('./pictures/'.$file_to_delete))       unlink('./pictures/'.$file_to_delete);
                        if (file_exists('./pictures/main_'.$file_to_delete))  unlink('./pictures/main_'.$file_to_delete);
                        if (file_exists('./pictures/thumb_'.$file_to_delete)) unlink('./pictures/thumb_'.$file_to_delete);
                        if (file_exists('./pictures/block_'.$file_to_delete)) unlink('./pictures/block_'.$file_to_delete);
                    }
                }
                elseif (isset($_FILES['picture2']['name']) && $_FILES['picture2']['error'] != 4)
                {
                    if (isset($_REQUEST['id'])) {
                        $ph = new ProductHolder($_REQUEST['id']);
			$file_to_delete = $ph->get_data('picture2');
                        if (!empty($file_to_delete)) {
                            if (file_exists('./pictures/'.$file_to_delete))       unlink('./pictures/'.$file_to_delete);
                            if (file_exists('./pictures/main_'.$file_to_delete))  unlink('./pictures/main_'.$file_to_delete);
                            if (file_exists('./pictures/thumb_'.$file_to_delete)) unlink('./pictures/thumb_'.$file_to_delete);
                            if (file_exists('./pictures/block_'.$file_to_delete)) unlink('./pictures/block_'.$file_to_delete);
                        }
                    }
                    $filename = $this->upload_file($_FILES['picture2']['name'],'./pictures/');
                    if (move_uploaded_file($_FILES['picture2']['tmp_name'],'./pictures/'.$filename)) {
                        $data['picture2'] = $filename;
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/main_'. $filename, $main_w,  $main_h);
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/thumb_'.$filename, $thumb_w, $thumb_h);
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/block_'.$filename, $block_w, $block_h);
                    }
                }

                //Картинка 3
                if (isset($_REQUEST['delete_picture3'])) {
                    $data['picture3'] = '';
                    $ph = new ProductHolder($_REQUEST['id']);
                    $file_to_delete = $ph->get_data('picture3');
                    if (!empty($file_to_delete)) {
                        if (file_exists('./pictures/'.$file_to_delete))       unlink('./pictures/'.$file_to_delete);
                        if (file_exists('./pictures/main_'.$file_to_delete))  unlink('./pictures/main_'.$file_to_delete);
                        if (file_exists('./pictures/thumb_'.$file_to_delete)) unlink('./pictures/thumb_'.$file_to_delete);
                        if (file_exists('./pictures/block_'.$file_to_delete)) unlink('./pictures/block_'.$file_to_delete);
                    }
                }
                elseif (isset($_FILES['picture3']['name']) && $_FILES['picture3']['error'] != 4)
                {
                    if (isset($_REQUEST['id'])) {
                        $ph = new ProductHolder($_REQUEST['id']);
			$file_to_delete = $ph->get_data('picture3');
                        if (!empty($file_to_delete)) {
                            if (file_exists('./pictures/'.$file_to_delete))       unlink('./pictures/'.$file_to_delete);
                            if (file_exists('./pictures/main_'.$file_to_delete))  unlink('./pictures/main_'.$file_to_delete);
                            if (file_exists('./pictures/thumb_'.$file_to_delete)) unlink('./pictures/thumb_'.$file_to_delete);
                            if (file_exists('./pictures/block_'.$file_to_delete)) unlink('./pictures/block_'.$file_to_delete);
                        }
                    }
                    $filename = $this->upload_file($_FILES['picture3']['name'],'./pictures/');
                    if (move_uploaded_file($_FILES['picture3']['tmp_name'],'./pictures/'.$filename)) {
                        $data['picture3'] = $filename;
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/main_'. $filename, $main_w,  $main_h);
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/thumb_'.$filename, $thumb_w, $thumb_h);
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/block_'.$filename, $block_w, $block_h);
                    }
                }

                //Картинка 4
                if (isset($_REQUEST['delete_picture4'])) {
                    $data['picture4'] = '';
                    $ph = new ProductHolder($_REQUEST['id']);
                    $file_to_delete = $ph->get_data('picture4');
                    if (!empty($file_to_delete)) {
                        if (file_exists('./pictures/'.$file_to_delete))       unlink('./pictures/'.$file_to_delete);
                        if (file_exists('./pictures/main_'.$file_to_delete))  unlink('./pictures/main_'.$file_to_delete);
                        if (file_exists('./pictures/thumb_'.$file_to_delete)) unlink('./pictures/thumb_'.$file_to_delete);
                        if (file_exists('./pictures/block_'.$file_to_delete)) unlink('./pictures/block_'.$file_to_delete);
                    }
                }
                elseif (isset($_FILES['picture4']['name']) && $_FILES['picture4']['error'] != 4)
                {
                    if (isset($_REQUEST['id'])) {
                        $ph = new ProductHolder($_REQUEST['id']);
			$file_to_delete = $ph->get_data('picture4');
                        if (!empty($file_to_delete)) {
                            if (file_exists('./pictures/'.$file_to_delete))       unlink('./pictures/'.$file_to_delete);
                            if (file_exists('./pictures/main_'.$file_to_delete))  unlink('./pictures/main_'.$file_to_delete);
                            if (file_exists('./pictures/thumb_'.$file_to_delete)) unlink('./pictures/thumb_'.$file_to_delete);
                            if (file_exists('./pictures/block_'.$file_to_delete)) unlink('./pictures/block_'.$file_to_delete);
                        }
                    }
                    $filename = $this->upload_file($_FILES['picture4']['name'],'./pictures/');
                    if (move_uploaded_file($_FILES['picture4']['tmp_name'],'./pictures/'.$filename)) {
                        $data['picture4'] = $filename;
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/main_'. $filename, $main_w,  $main_h);
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/thumb_'.$filename, $thumb_w, $thumb_h);
                        $GLOBALS['core.image']->create_thumb('./pictures/'.$filename, './pictures/block_'.$filename, $block_w, $block_h);
                    }
                }

		return $data;
	}

	function subcategory_picture($data,$id)
	{
		if (isset($data['subcategory_picture']) && $data['subcategory_picture'] == 1)
		{
			$GLOBALS['core.sql']->query('update #p#product set subcategory_picture = ? where category_id = ? and id != ? ',array(0,$data['category_id'],$id));
		}
	}

	function load_lists()
	{
		$ch = new CategoryHolder();	
		$to_ret = $ch->getCategoriesForSelect();
		$GLOBALS['core.smarty']->assign('categories',$to_ret);
		$category_product = $ch->getCategoriesForAllProducts();
		$GLOBALS['core.smarty']->assign('category_product', $category_product);
		
		$dh = new DropdownManager();
		$types = $dh->get_price_categories();
		$GLOBALS['core.smarty']->assign('price_categories',$types);

                $bh = new BrandHolder();
		$brands = $bh->get_all();
		$GLOBALS['core.smarty']->assign('brands',$brands);
		
	}
	
	function upload_file($file, $filedirectory)
 	{
 		$ph = new ProductHolder();
 		return $ph->upload_file($file, $filedirectory); 
 	}
 	
 	function special_save($id)
 	{
 		$to_ret = array('errors' => array(),'delete' => 0);
 		$data = array();
 		if (isset($_REQUEST['special_amount']) && !empty($_REQUEST['special_amount'])) 			
 		{
 			$data['amount'] = $_REQUEST['special_amount'];
 			if (is_numeric($_REQUEST['special_amount']) && $_REQUEST['special_amount'] > 0)
 			{	 			
	 			if (isset($_REQUEST['special_type']) && !empty($_REQUEST['special_type'])
	 				&& ($_REQUEST['special_type'] == 'price' || $_REQUEST['special_type'] == 'percentage'))
	 				{
	 					$data['type'] = $_REQUEST['special_type'];
	 					$data['object_type'] = 'product';
	 					$data['object_id'] = $id;
	 					
	 					if (	isset($_REQUEST['special_availableDay']) && !empty($_REQUEST['special_availableDay'])
	 						&&	isset($_REQUEST['special_availableMonth']) && !empty($_REQUEST['special_availableMonth'])
	 						&&	isset($_REQUEST['special_availableYear']) && !empty($_REQUEST['special_availableYear']))
	 						{
	 							$data['available_date'] = mktime(23,59,59,$_REQUEST['special_availableMonth'],$_REQUEST['special_availableDay'],$_REQUEST['special_availableYear']);
	 						}
	 						
						if (	isset($_REQUEST['special_expiryDay']) && !empty($_REQUEST['special_expiryDay'])
	 						&&	isset($_REQUEST['special_expiryMonth']) && !empty($_REQUEST['special_expiryMonth'])
	 						&&	isset($_REQUEST['special_expiryYear']) && !empty($_REQUEST['special_expiryYear']))
	 						{
	 							$data['expiry_date'] = mktime(23,59,59,$_REQUEST['special_expiryMonth'],$_REQUEST['special_expiryDay'],$_REQUEST['special_expiryYear']);
	 						}
	 		 						
	 					
	 					$sh = new SpecialHolder();
	 					$sh->loadByProductId($id);
	 					$sh->set_data($data);
	 					$sh->save();
	 				}	 				
	 				else $to_ret['errors']['type'] = 1;
 			}
 			else $to_ret['errors']['amount'] = 1;
 		}
 		elseif (isset($_REQUEST['special_amount']) && empty($_REQUEST['special_amount']))
 		{
 			$to_ret['delete'] = 1;
 		}
 		
 		
 		$to_ret['data'] = $data; 		
 		return $to_ret;
 	}
 	
 	function optionSave($id)
 	{
 		$ph = new ProductHolder($id);
 		
 		if (isset($_REQUEST['has_options']))
		{
			$options = $ph->getOptionsAdm();
			
			foreach ($options as $key => $value)
			{
				if (isset($_REQUEST['option_delete_' . $key]))
				{
                                    //print 'here';
					$ph->deleteOption($key);
				}
				else
				{
                    $data = array();
                    if (isset($_REQUEST['option_name_' . $key])) $data['name'] = $_REQUEST['option_name_' . $key];
                    if (isset($_REQUEST['option_small_name_' . $key])) $data['small_name'] = $_REQUEST['option_small_name_' . $key];
                    if (isset($_REQUEST['option_item_code_' . $key])) $data['item_code'] = $_REQUEST['option_item_code_' . $key];
                    if (isset($_REQUEST['option_price_' . $key])) $data['price'] = $_REQUEST['option_price_' . $key];
                    if (isset($_REQUEST['option_weight_' . $key])) $data['weight'] = $_REQUEST['option_weight_' . $key];
                    if (isset($_REQUEST['option_order_' . $key])) $data['order_no'] = $_REQUEST['option_order_' . $key];
                    if (isset($_REQUEST['option_inactive_' . $key])) $data['inactive'] = 1; else $data['inactive'] = 0;
                    if (isset($_REQUEST['option_quantity_' . $key])) $data['quantity'] = $_REQUEST['option_quantity_' . $key];
                    
                    if (isset($_FILES['option_image_'.$key]) && $_FILES['option_image_'.$key]['error'] == 0)
					{
						$filename = $this->upload_file($_FILES['option_image_'.$key]['name'],'./pictures/');
																
						if (move_uploaded_file($_FILES['option_image_'.$key]['tmp_name'],'./pictures/'.$filename))
						{
							$sh = new SettingsHolder();
							$settings = $sh->getSettings();											
							$GLOBALS['core.image']->create_thumb_width('./pictures/'.$filename,'./pictures/180_'.$filename,180,null,hexdec($settings['option_color']));
							copy('./pictures/'.$filename,'./pictures/full_'.$filename);
							
							if (!empty($settings))
							{
								$GLOBALS['core.image']->create_thumb('./pictures/'.$filename,'./pictures/'.$filename,$settings['option_width'],$settings['option_height'],null,hexdec($settings['option_color']));
								$GLOBALS['core.image']->create_thumb('./pictures/full_'.$filename,'./pictures/large_'.$filename,$settings['option_tip_width'],$settings['option_tip_height'],null,hexdec($settings['option_tip_color']));
							}
							
							
                            $oh = new OptionHolder($key);
                            $picture = $oh->get_data('picture');
                            if (!empty($picture))
                            {
                                if (file_exists('./pictures/'.$picture)) unlink('./pictures/'.$picture);
                                if (file_exists('./pictures/180_'.$picture)) unlink('./pictures/180_'.$picture);
                                if (file_exists('./pictures/large_'.$picture)) unlink('./pictures/large_'.$picture);
                                if (file_exists('./pictures/full_'.$picture)) unlink('./pictures/full_'.$picture);
                            }
							$data['picture'] = $filename;
						}
					}
                    
                    
                    $ph->saveOption($data,$key);
				}
			}
			
			if (isset($_REQUEST['row_num']) && !empty($_REQUEST['row_num']))
			{
                        for($i = 1; $i <= $_REQUEST['row_num']; $i++)
                        {
                            $data = array();
                            if (isset($_REQUEST['add_option_name_'.$i]) && !empty($_REQUEST['add_option_name_'.$i]))  $data['name'] = $_REQUEST['add_option_name_'.$i];
                            if (isset($_REQUEST['add_option_small_name_'.$i]) && !empty($_REQUEST['add_option_small_name_'.$i]))  $data['small_name'] = $_REQUEST['add_option_small_name_'.$i];
                            if (isset($_REQUEST['add_option_item_code_'.$i])) $data['item_code'] = $_REQUEST['add_option_item_code_'.$i];
                            if (isset($_REQUEST['add_option_price_'.$i])) $data['price'] = $_REQUEST['add_option_price_'.$i];
                            if (isset($_REQUEST['add_option_weight_'.$i])) $data['weight'] = $_REQUEST['add_option_weight_'.$i];
                            if (isset($_REQUEST['add_option_quantity_'.$i])) $data['quantity'] = $_REQUEST['add_option_quantity_'.$i];
                            if (isset($_REQUEST['add_option_order_'.$i])) $data['order_no'] = $_REQUEST['add_option_order_'.$i];                                                                        

                            if (isset($data['name']))
                            {
                                    if (isset($_REQUEST['add_option_inactive_'.$i])) $data['inactive'] = 1; else $data['inactive'] = 0;
                                    
                                    if (isset($_FILES['add_option_image_'.$i]) && $_FILES['add_option_image_'.$i]['error'] == 0)
									{
										$filename = $this->upload_file($_FILES['add_option_image_'.$i]['name'],'./pictures/');
																				
										if (move_uploaded_file($_FILES['add_option_image_'.$i]['tmp_name'],'./pictures/'.$filename))
										{
											$sh = new SettingsHolder();
											$settings = $sh->getSettings();											
											$GLOBALS['core.image']->create_thumb_width('./pictures/'.$filename,'./pictures/180_'.$filename,180,null,hexdec($settings['option_color']));
											copy('./pictures/'.$filename,'./pictures/full_'.$filename);
											
											if (!empty($settings))
											{
												$GLOBALS['core.image']->create_thumb('./pictures/'.$filename,'./pictures/'.$filename,$settings['option_width'],$settings['option_height'],null,hexdec($settings['option_color']));
												$GLOBALS['core.image']->create_thumb('./pictures/full_'.$filename,'./pictures/large_'.$filename,$settings['option_tip_width'],$settings['option_tip_height'],null,hexdec($settings['option_tip_color']));
											}
											$data['picture'] = $filename;
										}
									}
                                    $ph->addOption($data);
                            }
                        }
			}
		}
		else 
		{
			//need to remove options from database
		}
 	}
 	
 	function strToHex($string)
	{
		/*
    	$arr = explode("x",$string);
    	$hex = 0;
    	for($i = strlen($arr[1]); $i >= 0; $i--)
    	{
    		$hex += base_convert($arr[1][$i],16,2);
    	}
    	$hex = base_convert($hex,2,16);
    	*/
		//$hex = base_convert($string,16,2);
		//$hex = base_convert($hex,2,16);
		
    	//return $hex;
    	
	}
}
?>