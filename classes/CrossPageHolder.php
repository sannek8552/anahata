<?php
require_once('Data_Holder.php');
//require_once('classes/ProductHolder.php');
require_once('modules/CMS/MenuHolder.php');
class CrossPageHolder extends Data_Holder_Simple
{
	function CrossPageHolder($id = null)
	{
		$table = 'cross_page';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}
	function getAll()
	{
		return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#" . $this->table. " ORDER BY id ASC",array(), 'id');
	}
	
	function getAllCrossPages()
	{
		$all = $this->getAll();
		$to_ret = array();
		foreach ($all as $key => $value)
		{
			if (!isset($to_ret[$value['page_id']])) $to_ret[$value['page_id']] = array();
			$to_ret[$value['page_id']][$value['cross_page_id']] = $value;
		}
		return $to_ret;
                
	}
	
	
	function batchDeleteCrossPages($page_ids)
	{
		if (!empty($page_ids))
			$GLOBALS['core.sql']->query('delete from #p#'. $this->table . ' where page_id in ( ' . join(",", $page_ids) . ') ');
	}
	
	
	function batchAddCrossPages($page_ids, $cross_ids)
	{
		$data = array();
		if (!empty($page_ids) && !empty($cross_ids))
		{
		    foreach ($page_ids as $pid)
		    {
		    	foreach ($cross_ids as $cid)
		    	{
		    		//if ($pid != $cid)
		    		//{
			    		$tmp = array();
			    		$tmp['page_id'] = $pid;
			    		$tmp['cross_page_id'] = $cid;
			    		$data[] = $tmp;
		    		//}
		    	}
		    }
		    $GLOBALS['core.store']->fast_insert($this->table,$data);
		}
	}

        function getPagesForSelect()
        {
            $mh = new MenuHolder();
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
       
}
?>