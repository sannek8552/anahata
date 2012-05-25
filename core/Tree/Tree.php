<?php
class Tree extends Module
{
	function Tree($cfg)
	{
	}
	
	function init()
	{
	}
	
	function run()
	{
	}
	
	var $function_call = array();
	var $additional = '';
	var $tree = array();
        var $fields = array('id','created','updated','parent_id','title','order_id','deleted','page_title','keywords','page_description','seo_url','published','active','google_priority');
	
	function set_callback($callback, $additional)
	{
		$this->function_call = $callback;
		$this->additional = $additional;
	}

	function get_tree($root_id = 0, $to_select = array(), $table_name = 'menu', $id_key = 'id', $parent_id_key = 'parent_id', $order_by = 'order_id', $filters = array())
    {
        $SQL =& $GLOBALS['core.sql'];       
        $p = $GLOBALS['core.store']->prefix;
        //$root_id = '0';
        $sql = "SELECT " . join(',',$to_select) . " FROM ${p}${table_name}";
        $mod = array();
        if(!empty($filters))
        {
        	$sql .= ' WHERE ';
        	$filters_n = array();
        	
        	foreach($filters as $key => $value)
        	{        		
        		$filters_n[] = $key;
        		$mod[] = $value;
        	}
        	
        	$sql .= join(' AND ', $filters_n);
        }
        if($order_by)
        	$sql .= " ORDER BY ${order_by}";
		
        $folders = $SQL->getAll($sql, $mod);

        $temp_folder_tree = array();
        
        $folder_tree = array();
        foreach($to_select as $key => $value)
        {
        	$folder_tree[0][$value] = '';
        }
        
        $folder_tree[0] = array($id_key => '0');

        $zero_add = array();
        
        if(!empty($this->additional) && is_callable($this->function_call))
        {
        	
        	if(is_object($this->function_call[0]))
        	{
        		$folder_tree[0][$this->additional] = call_user_func_array($this->function_call,$folders);//$this->function_call[0]->$this->function_call[1]($folders);
        	}
        	//print '<pre>';
        	//print_r($folder_tree);
        }
        
        foreach($folders as $key => $value)
        {
            $temp_folder_tree[$value[$id_key]] = $value;
        }
        
        foreach($folders as $key => $value)
        {
            $folder_tree[$value[$parent_id_key]]['sub'][$value[$id_key]] = $value;
            
            $folder_tree[$value[$parent_id_key]]['sub_ids'][] = $value[$id_key];
            foreach($to_select as $t_key => $t_value)
            {
            	if($value[$parent_id_key] != 0 && isset($temp_folder_tree[$value[$parent_id_key]]) && isset($temp_folder_tree[$value[$parent_id_key]][$t_value]))
            		$folder_tree[$value[$parent_id_key]][$t_value] = $temp_folder_tree[$value[$parent_id_key]][$t_value];
            }
            if(!empty($this->additional))
            	$folder_tree[$value[$parent_id_key]][$this->additional] = $temp_folder_tree[$value[$parent_id_key]][$this->additional];
            //$folder_tree[$value[$parent_id_key]][$id_key] = $temp_folder_tree[$value[$parent_id_key]][$id_key];
            //$folder_tree[$value['parent_folder_id']]['files'] = $temp_folder_tree[$value['parent_folder_id']]['files'];           
        }
     
        $i = 0;
        while(count($folder_tree) > 1 && $i < 1000)
        {
        	$i++;
            foreach($folder_tree as $key => $value)
            {
            	$flag = 0;

                if ($value['sub_ids'])
                	foreach($value['sub_ids'] as $s_key => $s_value)
                    {
                    	if(isset($folder_tree[$s_value]))
                        {
                        	$flag = 1;
                            break;
                        }
                    }

                    if(!$flag)
                    {
                        foreach($folder_tree as $s_key => $s_value)
                        {
                        	//if we need to attach folder here
                            if(is_array($s_value['sub_ids']) && in_array($key,$s_value['sub_ids']))
                            {
                                $folder_tree[$s_key]['sub'][$key] = $folder_tree[$key];
                                $folder_tree[$s_key]['sub_ids'] = array_merge($folder_tree[$s_key]['sub_ids'],$folder_tree[$key]['sub_ids']);
                            }
                        }

                        unset($folder_tree[$key]);
                    }
           }
        }
        $this->tree = $folder_tree;
        $nodes = array();
        $i = 0;
        while(empty($nodes))
        {
        	$i++;
            foreach($folder_tree as $key => $value)
            {
            	if($root_id == $key)
                {
                	$nodes[$key] = $folder_tree[$key];
                    break;
                }
                elseif(isset($folder_tree[$key]['sub_ids']) && is_array($folder_tree[$key]['sub_ids']) && in_array($root_id,$folder_tree[$key]['sub_ids']))
                {
                	$folder_tree = $value['sub'];
                    break;
                }
            }
            if($i >1000)
            	break;
        }
        
        return $nodes;
    }
    
    function get_place($current_id, $name_path, $id_key)
    {
    	$path = array();
    	$cur_tree = $this->get_tree(1, $this->fields);
    	$found = 0;
    	$i = 0;
    	while($found !=1 && $i < 1000)
    	{
            //pp($cur_tree);
    		$i++;
    		foreach($cur_tree as $key => $value)
    		{
                    
    			if($current_id == $key)
    			{
    				$found = 1;
    				$path[] = array($name_path => $value[$name_path], $id_key => $key, 'seo'=>$value['seo_url']);
    				break;
    			}
    			if(!isset($value['sub_ids']) || !is_array($value['sub_ids']))
    				continue;
    			if(in_array($current_id, $value['sub_ids']))
    			{
    				$cur_tree = $value['sub'];
    				$path[] = array($name_path => $value[$name_path], $id_key => $key, 'seo'=>$value['seo_url']);
    				break;
    			}
    		}
    	}
    	return $path;
    }
}
?>