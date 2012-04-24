<?php
require_once('Data_Holder.php');
require_once('classes/ProductHolder.php');
class CrossSellHolder extends Data_Holder_Simple 
{
	function CrossSellHolder($id = null)
	{
		$table = 'cross_sell';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}
	function getAll()
	{
		return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#" . $this->table,array(), 'id');
	}
	
	function getAllCrossSells()
	{
		$all = $this->getAll();
		$to_ret = array();
		foreach ($all as $key => $value)
		{
			if (!isset($to_ret[$value['product_id']])) $to_ret[$value['product_id']] = array();
			$to_ret[$value['product_id']][$value['cross_product_id']] = $value;
		}
		return $to_ret;
	}
	
	function getProductCrossSells($product_id)
	{
		$cross_sells = $GLOBALS['core.sql']->getAll("select * from #p#" . $this->table . " where product_id = ?",array($product_id));		
		$ph = new ProductHolder();
		$products = $ph->getAllActive();
		foreach ($cross_sells as $key => $value)
		{
			if (!isset($products[$value['cross_product_id']])) unset($cross_sells[$key]);
		}		
		return $cross_sells;
	}
	
	function getProductsCrossSells($produdct_ids)
	{
		$cross_sells = array();
		if (!empty($produdct_ids))	$cross_sells = $GLOBALS['core.sql']->getAll("select * from #p#" . $this->table . " where product_id in (" . join(",", $produdct_ids) . ") ",array());
		return $cross_sells;
	}
	
	function deleteCrossSells($product_id)
	{
		if (!empty($product_id))
			$GLOBALS['core.store']->delete($this->table,array('key_name' => 'product_id', 'key_value' => $product_id));
	}
	
	function batchDeleteCrossSells($product_ids)
	{
		if (!empty($product_ids))
			$GLOBALS['core.sql']->query('delete from #p#'. $this->table . ' where product_id in ( ' . join(",", $product_ids) . ') ');
	}
	
	function addCrossSells($product_id, $cross_ids)
	{
		$data = array();
		if (!empty($cross_ids))
		{
			foreach ($cross_ids as $cid)
			{
				if ($product_id != $cid)
				{
					$tmp = array();
					$tmp['product_id'] = $product_id;
					$tmp['cross_product_id'] = $cid;
					$data[] = $tmp;
				}
			}
			$GLOBALS['core.store']->fast_insert($this->table,$data);
		}
	}
	
	function batchAddCrossSells($product_ids, $cross_ids)
	{
		$data = array();
		if (!empty($product_ids) && !empty($cross_ids))
		{
		    foreach ($product_ids as $pid)
		    {
		    	foreach ($cross_ids as $cid)
		    	{
		    		if ($pid != $cid)
		    		{
			    		$tmp = array();
			    		$tmp['product_id'] = $pid;
			    		$tmp['cross_product_id'] = $cid;
			    		$data[] = $tmp;
		    		}
		    	}
		    }
		    $GLOBALS['core.store']->fast_insert($this->table,$data);
		}
	}
}
?>