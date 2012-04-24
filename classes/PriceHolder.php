<?php
require_once('Data_Holder.php');

class PriceHolder extends Data_Holder 
{
	function PriceHolder($id = null)
	{
		$table = 'price';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}
		
	function getByCategory($category_id)
	{
		$result = $GLOBALS['core.sql']->getAll("select * from #p#".$this->table." where type_id = ? order by width desc,height desc ",array($category_id),$this->key_info['key_name']);
		return $result;
	}
	
	function get_min_max($category_id)
	{
		$to_ret = array('min_width' => 0,'min_height' => 0,'max_width' => 0,'max_height' => 0);

		$list = $this->getByCategory($category_id);
		if (!empty($list))
		{
			$mw = 1000000;
			$mh = 1000000;
			$mxw = 0;
			$mxh = 0;
			foreach ($list as $key => $value)
			{
				if ($value['width'] < $mw) $mw = $value['width'];
				if ($value['width'] > $mxw) $mxw = $value['width'];
				if ($value['height'] < $mh) $mh = $value['height'];
				if ($value['height'] > $mxh) $mxh = $value['height'];
			}
			$to_ret = array('min_width' => $mw,'min_height' => $mh,'max_width' => $mxw,'max_height' => $mxh);
		}
		return $to_ret;
	}
}
?>