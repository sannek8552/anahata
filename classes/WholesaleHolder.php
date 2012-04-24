<?php
require_once('Data_Holder.php');
require_once('classes/SettingsHolder.php');

class WholesaleHolder extends Data_Holder_Simple 
{
	function WholesaleHolder($id = null)
	{
		$table = 'wholesale';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}
	
	function getAll()
	{
		return $GLOBALS['core.sql']->getAll("select * from #p#" . $this->table,array(),'id');
	}
	
	function getAllWithCategories()
	{
		$all = $this->getAll();
		$categories = $GLOBALS['core.sql']->getAll("select * from #p#wholesale_category ");
		foreach ($all as $k => $v)
			foreach ($categories as $key => $value)
			{
				if ($value['wholesale_id'] == $v['id'])
				{
					if (!isset($all[$k]['categories'])) $all[$k]['categories'] = array();
					$all[$k]['categories'][$value['category_id']] = $value;
				}
			}
		return $all;	
	}
	
	function addWholesalesForUser($user_id, $wholesales_ids)
	{
		if (!empty($user_id))
		{
			$GLOBALS['core.store']->delete('user_wholesale',array('key_name' => 'user_id', 'key_value' => $user_id));
			if (!empty($wholesales_ids))
			{
				$to_insert = array();
				foreach ($wholesales_ids as $key => $value)
				{
					$tmp = array();
					$tmp['user_id'] = $user_id;
					$tmp['wholesale_id'] = $value;
					$to_insert[] = $tmp;
				}
				
				$GLOBALS['core.store']->fast_insert('user_wholesale', $to_insert);
			}
		}
	}
	
	function deleteWholesalesForUser($user_id)
	{
		$GLOBALS['core.store']->delete('user_wholesale',array('key_name' => 'user_id', 'key_value' => $user_id));
	}
	
	function getWholesalesForUser($user_id)
	{
		return $GLOBALS['core.sql']->getAll("select * from #p#user_wholesale where user_id = ? ",array($user_id),'wholesale_id');
	}
	
	function getAllWholesaleUser()
	{
		$wsu = $GLOBALS['core.sql']->getAll("select * from #p#user_wholesale ");
		$to_ret = array();
		foreach ($wsu as $key => $value)
		{
			if (!isset($to_ret[$value['user_id']])) $to_ret[$value['user_id']] = array();
			$to_ret[$value['user_id']][$value['wholesale_id']] = $value;
		}
		
		return $to_ret;
	}
	
	function getWholesalesCategoriesForUser($user_id)
	{
		$categories = array();
		$wholesales = $GLOBALS['core.sql']->getAll("select * from #p#user_wholesale where user_id = ? ",array($user_id),'wholesale_id');
		$wholesale_data = $this->getAll();
		if (!empty($wholesales))		
		{
			$categories = $GLOBALS['core.sql']->getAll("select * from #p#wholesale_category where wholesale_id in (" . join(",",array_keys($wholesales)) . ") ",array(),'category_id');
			if (!empty($categories))
			{
				foreach ($categories as $key => $value)
				{
					$categories[$key] = $wholesale_data[$value['wholesale_id']];
					$categories[$key]['category_id'] = $key;
				}
			}
		}
		return $categories;
	}
	
	function setCategoriesAndSave($category_ids)
	{
		$id = $this->get_key_value();
		if (!empty($id))
		{
			$GLOBALS['core.store']->delete('wholesale_category',array('key_name' => 'wholesale_id', 'key_value' => $id));
			if (!empty($category_ids))
			{
				$data = array();				
				foreach ($category_ids as $key => $value)
				{
					$data[] = array('wholesale_id' => $id, 'category_id' => $value);					
				}
				
				$GLOBALS['core.store']->fast_insert('wholesale_category', $data);
			}
		}
	}
	
	function get_data($field_name = '')
	{
		if(empty($field_name))
		{
			$data = $this->data;		
			$data['categories'] = array();
			$id = $this->get_key_value();
			if (!empty($id))
			{
				$categories = $GLOBALS['core.sql']->getAll("select * from #p#wholesale_category where wholesale_id = ? ",array($id),'category_id');
				if (!empty($categories)) 
				{
					foreach ($categories as $key => $value)
						$data['categories'][$key] = $value;
				}
			}
			return $data;	
			//return $this->data;
		}
		if(isset($this->data[$field_name]))
			return $this->data[$field_name];
		return null;
	}
	
	function delete()
	{
		if(!isset($this->key_info['key_value']) || empty($this->key_info['key_value']))
			return false;
		$GLOBALS['core.store']->delete($this->table, $this->key_info);
		$GLOBALS['core.store']->delete('wholesale_category', array('key_name' => 'wholesale_id', 'key_value' => $this->key_info['key_value']));
		return 1;
	}
}
?>