<?php
require_once('Data_Holder.php');
require_once('modules/CMS/MenuHolder.php');
class SideBox_Holder extends Data_Holder_Simple
{
	function SideBox_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('side_box',$key_info);
	}
	function get_all_sideboxes()
	{
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table.' ORDER BY order_no');
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
                $new_tree[$value['id']] = array('title'=>$value['title'],'seo_url'=>$value['seo_url']);
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
                $cur_title = ($value['parent_id']!=1)?$new_tree[$value['parent_id']]['title'].'/'.$value['title']:$value['title'];
                $new_tree[$value['id']] = array('title'=>$cur_title,'seo_url'=>$value['seo_url']);
                if(isset($value['sub']))
                {
                    $this->additional($value['sub'], $new_tree);
                }
            }

        }
	
}