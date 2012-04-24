<?php
require_once('Data_Holder.php');
class Product_Tops_Holder extends Data_Holder_Simple
{
	function Product_Tops_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('tops_module', $key_info);
	}

        function get_count()
        {
            return $GLOBALS['core.sql']->getOne('SELECT count FROM #p#'.$this->table);
        }
        function get_All()
	{
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table);
        }

        
	function get_All_Tops()
	{
		$data = $GLOBALS['core.sql']->getAll('SELECT cart_info FROM #p#payment');
                $data_temp = array();
                $data_new = array();
                foreach($data as $row)
                {
                    if(!empty($row['cart_info']))
                        $data_temp[] = unserialize($row['cart_info']);
                }

                foreach($data_temp as $row)
                {
                   foreach($row as $row2)
                   $data_new[] = $row2;
                }

                foreach($data_new as $key=>$row)
                {
                    $quantity = 0;
                    if(isset($row['options']))
                    {

                        foreach($row['options'] as $option)
                            $quantity += $option;
                        $data_new[$key]['quantity'] = $quantity;
                    }
                }
                
                /*Creating an array of Tops*/
                $tops = array();
                foreach($data_new as $row)
                {
                    if (!isset($tops[$row['product_id']])) $tops[$row['product_id']] = 0;
                    $tops[$row['product_id']] += $row['quantity'];
                }
                return $tops;
	}
        
	
	
	
}
?>