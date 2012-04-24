<?php
require_once('Data_Holder.php');

class SpecialHolder extends Data_Holder 
{
	function SpecialHolder($id = null)
	{
		$table = 'special';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}
	
	function loadByProductId($product_id)
	{
		$id = $GLOBALS['core.sql']->getOne("select id from #p#".$this->table." where object_type = ? and object_id = ?",array('product',$product_id));
		$key_info = array('key_name' => 'id');
		if (!empty($id)) $key_info['key_value'] = $id;
		$this->init($this->table,$key_info);
	}
	
	function getAllProducts()
	{
		$res = $GLOBALS['core.sql']->getAll("select * from #p#".$this->table." where object_type = ? ",array('product'),'object_id');
		return $res;
	}
	
	function getAllCategories()
	{
		$res = $GLOBALS['core.sql']->getAll("select * from #p#".$this->table." where object_type = ? ",array('category'),'object_id');
		return $res;
	}

	function calculateAllSpecials()
	{
		$product_specials = $this->getAllProducts();
		$category_specials = $this->getAllCategories();
		
		require_once('classes/ProductHolder.php');
		$ph = new ProductHolder();
		$products = $ph->getAll();
		
		require_once('classes/CategoryHolder.php');
		$ch = new CategoryHolder();
		$categories = $ch->getAll();
		
		$to_ret = array();
		
		foreach ($products as $key => $value)
		{
			if ($value['inactive'] == 1) continue;
			$data = array();
			if (isset($category_specials[$value['category_id']]))	$data = $category_specials[$value['category_id']];
			elseif (isset($product_specials[$key]))	$data = $product_specials[$key];
			
			if (!empty($data))	
			{
				$to_ret[$key] = $value;								
				$to_ret[$key]['special'] = $this->calculateSpecial($data,$value);
				$to_ret[$key]['special']['old_price'] = $value['price'];
			}
		}
		return $to_ret;
	}
	
	function getSpecialForProduct($product_id,$pdata)
	{
		
		//look for special on all site
		
		
		//look for category special
		$category_special = $this->loadSpecialForCategory($pdata['category_id']);		
		if (!empty($category_special)) $data = $category_special;
		else 
		{
			//look for product special
			$this->loadByProductId($product_id);
			$data = $this->get_data();
		}
		
		if (!empty($data))
		{
			$data = $this->calculateSpecial($data,$pdata);
			/*
			//check for available and expiration dates
			$available = false;
			$expiration = false;
			if (isset($data['available_date']) && !empty($data['available_date']))
			{
				if (time() > $data['available_date']) $available = true;
			}
			else $available = true;
			
			if (isset($data['expiry_date']) && !empty($data['expiry_date']))
			{
				if (time() < $data['expiry_date']) $expiration = true;
			}
			else $expiration = true;
			
			if ($available && $expiration)
			{
				//additional calculations for save off, etc
				$data['new_price'] = $this->recalculatePrice($pdata['price'],$data);
				$data['save_off'] = $this->recalculateSaveOff($pdata['price'],$data);
			}
			*/
		}
		
		return $data;
	}
	
	function calculateSpecial($data,$pdata)
	{
		//check for available and expiration dates
		$available = false;
		$expiration = false;
		if (isset($data['available_date']) && !empty($data['available_date']))
		{
			if (time() > $data['available_date']) $available = true;
		}
		else $available = true;
		
		if (isset($data['expiry_date']) && !empty($data['expiry_date']))
		{
			if (time() < $data['expiry_date']) $expiration = true;
		}
		else $expiration = true;
		
		if ($available && $expiration)
		{
			//additional calculations for save off, etc
			$data['new_price'] = $this->recalculatePrice($pdata['price'],$data);
			$data['save_off'] = $this->recalculateSaveOff($pdata['price'],$data);
		}
		return $data;
	}
	
	function loadSpecialForCategory($category_id)
	{
		$res = $GLOBALS['core.sql']->getRow("select * from #p#".$this->table." where object_type = ? and object_id = ? ",array('category',$category_id));
		return $res;
	}
	
	function recalculatePrice($price,$special)
	{
		$discount = $special['amount'];
		if ($special['type'] == 'percentage')	$price = round($price - ($price*($discount/100)),2);
		else $price = $price - $discount;
		return $price;
	}
	
	function recalculateSaveOff($price,$special)
	{
		$discount = $special['amount'];
		$save_off = array();
		if ($special['type'] == 'percentage')	
		{
			$save_off['percentage'] = $discount;
			$save_off['absolute'] = round($price*$discount/100,2);
		}
		else 
		{
			if ($price != 0) $save_off['percentage'] = round(($discount/$price)*100,2);
			else $save_off['percentage'] = 0;	
			
			$save_off['absolute'] = $discount;
		}
		return $save_off;
	}
	
	function removeOldSpecials($type,$products)
	{
		if (!empty($products))
		{
			$join = join(",",array_values($products));		
			$GLOBALS['core.sql']->query("delete from #p#".$this->table." where object_type = ? and object_id in (".$join.") ",array($type));
			
			if ($type == 'category')
			{
				$ph = new ProductHolder();
				$product_ids = $ph->getIdsByCategories(array_values($products));
				if (!empty($product_ids))
				{
					$this->removeOldSpecials('product',$product_ids);
				}
			}
		}
	}
	
	function fastInsert($data)
	{
		$GLOBALS['core.store']->fast_insert($this->table,$data,array('key_name' => $this->key_info['key_name']));
	}
	
	function specialSave()
 	{
 		$to_ret = array('errors' => array());
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
	 				}	 				
	 				else $to_ret['errors']['type'] = 1;
 			}
 			else $to_ret['errors']['amount'] = 1;
 		}
 		else $to_ret['errors']['amount'] = 1;
 		
 		$to_ret['data'] = $data; 		
 		return $to_ret;
 	}
}