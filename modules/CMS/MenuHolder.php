<?php
class MenuHolder
{
	var $fields = array('id','created','updated','parent_id','title','order_id','deleted','page_title','keywords','page_description','seo_url','published','active','google_priority');
	function MenuHolder()
	{
		$GLOBALS['core.application']->init_module('tree', true);
	}
	
	function getTree()
	{
		$tree = $GLOBALS['core.cache']->get('menu_tree');
		if($tree !== false)
			return $tree[1];
		$tree = $GLOBALS['core.tree']->get_tree(1, $this->fields,'menu', 'id','parent_id', $order_by = 'order_id',array());
		$GLOBALS['core.cache']->put('menu_tree', $tree);
		$GLOBALS['core.cache']->delete('menu_tree_prepared');
                return $tree[1];
	}
	
	function drop_cache()
	{
		$GLOBALS['core.cache']->delete('menu_tree_prepared');
		$GLOBALS['core.cache']->delete('menu_tree');
	}
	
	function getFrontEnd()
	{
		$ret = $GLOBALS['core.cache']->get('menu_tree_prepared');
		if($ret !== false)
			return $ret;
		$tree = $this->getTree();
                $html_menus = '';
                if(isset($tree['sub']))
                {
                    $html_menus = $tree['sub'];
                    $html_menus = $this->clear_active($html_menus);
                    $html_menus = $this->process_seo($html_menus);
                }
		unset($tree['sub']);
		unset($tree['sub_ids']);
		$html_home_page = $tree;
		
		$ret = array($html_menus, $html_home_page);
		$GLOBALS['core.cache']->put('menu_tree_prepared', $ret);
                return $ret;
	}
	
	function getSiteMap()
	{		
		$tree = $this->getTree();
		$html_menus = $tree['sub'];
		//$html_menus = $this->clear_active($html_menus);
		$html_menus = $this->clear_deactivated($html_menus);
		$html_menus = $this->process_seo($html_menus);
		unset($tree['sub']);
		unset($tree['sub_ids']);
		$html_home_page = $tree;
		$ret = array($html_menus, $html_home_page);
		return $ret;
	}

    function getPages()
    {
        $tree = $GLOBALS['core.cache']->get('menu_tree');
        if($tree !== false)
            return $tree;
        $tree = $GLOBALS['core.tree']->get_tree(1, $this->fields,'menu', 'id','parent_id', $order_by = 'order_id',array());
        return $tree;
    }
	
	function clear_active($menu)
	{
                foreach ($menu as $key => $value)
		{
			if($value['published'] != 1 || $value['active'] != 1)
			{
				unset($menu[$key]);
				continue;
			}
			if(isset($value['sub']) && is_array($value['sub']))
			{
				$menu[$key]['sub'] = $this->clear_active($value['sub']);
				if(empty($menu[$key]['sub']))
				{
					unset($menu[$key]['sub']);
				}
			}
		}
		return $menu;
	}
	
	function clear_deactivated($menu)
	{
		foreach ($menu as $key => $value)
		{
			if($value['active'] != 1)
			{
				unset($menu[$key]);
				continue;
			}
			if(isset($value['sub']) && is_array($value['sub']))
			{
				$menu[$key]['sub'] = $this->clear_deactivated($value['sub']);
				if(empty($menu[$key]['sub']))
				{
					unset($menu[$key]['sub']);
				}
			}
		}
		return $menu;
	}
	
	function process_seo($menu)
	{
		foreach ($menu as $key => $value)
		{
			if(preg_match('/^http/',$value['seo_url']))
			{
				$menu[$key]['direct_link'] = 1;
			}
			if(isset($value['sub']) && is_array($value['sub']))
			{
				$menu[$key]['sub'] = $this->process_seo($value['sub']);
			}
		}
		return $menu;
	}
}
?>