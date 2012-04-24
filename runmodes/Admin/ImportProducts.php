<?php
require_once('Admin_Header.php');

class ImportProducts extends Runmode
{
	
	function ImportProducts()
	{
		parent::Runmode();
	}
	
	function process()
	{
		
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			//clean current tables
			$GLOBALS['core.sql']->query('truncate table #p#product');
			$GLOBALS['core.sql']->query('truncate table #p#product_option');
			$GLOBALS['core.sql']->query('truncate table #p#category_product');
			$GLOBALS['core.sql']->query('truncate table #p#brand');
			$GLOBALS['core.sql']->query('ALTER TABLE #p#product CHANGE `id` `id` INT( 11 ) NOT NULL');
			$GLOBALS['core.sql']->query('ALTER TABLE #p#product_option CHANGE `id` `id` INT( 11 ) NOT NULL');			
			
			//get brands
			$brands = $GLOBALS['core.sql']->getAll('SELECT brand FROM biz_products GROUP BY brand order by brand ');
			$new_brands = array();
			foreach ($brands as $key => $value)
			{
				if (!empty($value['brand']))
				{
					$tmp = array();
					$tmp['parent_id'] = 0;
					$tmp['title'] = $value['brand'];
					$tmp['seo_url'] = $this->seo($value['brand']);
					$new_brands[] = $tmp;
				}
			}
			
			$GLOBALS['core.store']->fast_insert('brand', $new_brands);
			$new_brands = $GLOBALS['core.sql']->getAll("select * from #p#brand", array(), 'title');
			
			//get products
			$products = $GLOBALS['core.sql']->getAll("select * from biz_products ",array(), 'product_id');
			
			$groups = array();
			$not_in_group = array();
			foreach ($products as $key => $value)
			{
				if (isset($value['in_group']) && !empty($value['in_group']))
				{
					$group_id = $value['in_group'];
					if (!isset($groups[$group_id])) $groups[$group_id] = array();
					$groups[$group_id][$key] = $value;
				}
				else $not_in_group[$key] = $value;
			}
			
			//get images
			$images = $GLOBALS['core.sql']->getAll("SELECT *
													FROM biz_product_images
													WHERE product_id !=0
													ORDER BY image_priority", array());
			
			$new_images = array();
			foreach ($images as $key => $value)
			{
				if (!isset($new_images[$value['product_id']])) 
				{
					$new_images[$value['product_id']] = $value;
				}
			}
			$images = $new_images;
			
			$new_products = array();
			$new_product_categories = array();
			
			foreach ($not_in_group as $key => $value)
			{
				$temp = array();
				$temp['id']				= $value['product_id'];
				$temp['name'] 			= $value['product_name'];
				$temp['number'] 		= $value['product_code']; 
				$temp['item_code'] 		= $value['product_code']; 
				$temp['category_id'] 	= $value['category_id'];
				$temp['price']			= $value['product_sale_price'];
				$temp['full_description'] 	= $value['description'];
				$temp['weight'] 		= $value['prod_weight'];
				$temp['inactive'] 		= empty($value['active']) ? 1 : 0;
				$temp['created'] 		= $value['product_entered'];
				$temp['order_no']		= $value['sort_order'];
				$temp['brand']			= $value['brand'];
				$temp['brand_id']		= (isset($new_brands[$value['brand']])) ? $new_brands[$value['brand']]['id'] : 0;
				$temp['seo'] 			= $this->seo($value['product_name']);
				$temp['quantity']		= $value['stock'];
				$temp['has_options']	= $value['is_group'];
				$temp['other_info'] 	= serialize($value);				
				if (isset($images[$value['product_id']])) $temp['picture'] = $images[$value['product_id']]['image_file'];
				else $temp['picture']	= '';
				$new_products[] = $temp;
				//$new_product_categories[] = array('product_id' => $value['product_id'], 'category_id' => $value['category_id']);
			}			
			
			//print count($new_products);
			$j = 0;
			$tmp = array();
			$c_tmp = array();
			for($i = 0;$i < count($new_products); $i++)
			{
				$tmp[] = $new_products[$i];
				//$c_tmp[] = $new_product_categories[$i];
				if ($j == 99 || $i == (count($new_products) - 1))
				{					
					$GLOBALS['core.store']->fast_insert('product', $tmp);
					$tmp = array();
					//$GLOBALS['core.store']->fast_insert('category_product', $c_tmp);
					//$c_tmp = array();
					$j = 0;
				}
				$j ++;
			}
			
			//$GLOBALS['core.store']->fast_insert('category_product', $new_products);
			
			
			$new_options = array();
			foreach ($groups as $group)
			{
				foreach ($group as $key => $value)
				{
					$temp = array();
					$temp['id']				= $value['product_id'];
					$temp['product_id']		= $value['in_group'];
					$temp['name'] 			= $value['product_name'];
					$temp['item_code'] 		= $value['product_code']; 					
					$temp['price']			= $value['product_sale_price'];					
					$temp['weight'] 		= $value['prod_weight'];
					$temp['inactive'] 		= empty($value['active']) ? 1 : 0;
					$temp['created'] 		= $value['product_entered'];
					$temp['order_no']		= $value['sort_order'];
					$temp['quantity']		= $value['stock'];
					$temp['other_info'] 	= serialize($value);				
					if (isset($images[$value['product_id']])) $temp['picture'] = $images[$value['product_id']]['image_file'];
					else $temp['picture'] 	= '';
					$new_options[] = $temp;
				}
			}
			
			$j = 0;
			$tmp = array();
			for($i = 0;$i < count($new_options); $i++)
			{
				$tmp[] = $new_options[$i];
				if ($j == 99 || $i == (count($new_options) - 1))
				{					
					$GLOBALS['core.store']->fast_insert('product_option', $tmp);
					$tmp = array();
					$j = 0;
				}
				$j ++;
			}
			
			//prepare database
			$GLOBALS['core.sql']->query('ALTER TABLE #p#product CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT');
			$GLOBALS['core.sql']->query('ALTER TABLE #p#product_option CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT');			
			
		}
		
		
		return Admin_Header::out('import_products');
	}
	
	function easy_import()
	{
		print 'start';
		$products = $GLOBALS['core.sql']->getAll("select * from biz_products ",array(), 'product_id');
		foreach ($products as $key => $value)
		{
			$GLOBALS['core.sql']->query('update #p#product set category_id = ? where id = ?',array($value['category_id'],$key));
		}
		print 'finish';
	}
	
	function seo_import()
	{
		print 'start<br />';
		$products = $GLOBALS['core.sql']->getAll("select * from code_product ",array(), 'id');
		$seo = array();
		foreach ($products as $key => $value)
		{
			if (in_array($value['seo'], array_keys($seo)))
			{				
				$GLOBALS['core.sql']->query('update #p#product set seo = ? where id = ?',array($value['seo'] . "-" . $seo[$value['seo']],$key));
				$seo[$value['seo']] ++;
			}
			else $seo[$value['seo']] = 1;
		}
		
		print 'finish';
	}
	
	function small_import()
	{
		print 'start<br />';
		$options = $GLOBALS['core.sql']->getAll("select * from code_product_option ",array(), 'id');
		$biz_products = $GLOBALS['core.sql']->getAll("select * from biz_products ",array(), 'product_id');
		
		
		foreach ($options as $key => $value)
		{
			if (isset($biz_products[$key]) && isset($biz_products[$key]['product_small_name']))
			{
				$GLOBALS['core.store']->save('product_option', array('small_name' => $biz_products[$key]['product_small_name']), array('key_name' => 'id', 'key_value' => $key));
			}
		}
		
		print 'finish';
	}
	
	function seo($seo)
	{
			$seo = preg_replace("/\s/",'-',$seo);
            $seo = preg_replace("/\&/",'and',$seo);			
			$seo = preg_replace("/([^a-z|A-Z|\d|\-])/",'', $seo);
			return $seo;			
	}
}

?>