<?php
class PageHolder
{
	var $menu_data = array();
	var $params = array('title' => array('type' => 'text', 'storage' => 'main'),
			'content' => array('type' => 'rich_edit', 'storage' => 'attrib'),
			'page_title' => array('type' => 'text', 'storage' => 'main'), 
			'keywords' => array('type' => 'text','storage' => 'main'),
			'page_description' => array('type' => 'text', 'storage' => 'main'),
			'seo_url' => array('type' => 'text', 'storage' => 'main'),
			'google_priority' => array('type' => 'text', 'storage' => 'main'),
			'template' => array('type' => 'text', 'storage' => 'attrib'),
			'active' => array('type' => 'checkbox', 'storage' => 'main'),
			'published' => array('type' => 'checkbox', 'storage' => 'main'),
                        'access' => array('type' => 'text', 'storage' => 'main'),
                        'header_image' => array('type' => 'text', 'storage' => 'main'),
			);
			
	function PageHolder($id = null)
	{
		if(is_null($id))
		{
			$this->menu_data = array();
		}
		else 
		{
			$menu = $GLOBALS['core.sql']->getRow('SELECT m.*,ma.content,ma.template FROM #p#menu as m INNER JOIN #p#menu_attribute as ma ON m.id=ma.menu_id WHERE m.id=?', $id);
			if(empty($menu))
				PEAR::raiseError('menu not exists', 'menu not exists');
			$this->menu_data = $menu;
		}
	}
	
	function create_by_seo($seo = '')
	{
		if(empty($seo))
		{
			$menu = $GLOBALS['core.sql']->getRow('SELECT m.*,ma.content,ma.template FROM #p#menu as m INNER JOIN #p#menu_attribute as ma ON m.id=ma.menu_id WHERE m.id=?', 1);
			$this->menu_data = $menu;
			return true;
		}
		$menu = $GLOBALS['core.sql']->getRow('SELECT m.*,ma.content,ma.template FROM #p#menu as m INNER JOIN #p#menu_attribute as ma ON m.id=ma.menu_id WHERE m.seo_url=?', $seo);
		if(empty($menu))
			return false;
		$this->menu_data = $menu;
		return true;
	}
	
	function move_down()
	{
		if(isset($this->menu_data['id']) && !empty($this->menu_data['id']))
		{
			$mod = array($this->menu_data['parent_id'],	$order_id = $this->menu_data['order_id']);
			
			$less_row = $GLOBALS['core.sql']->getRow('SELECT * FROM #p#menu WHERE parent_id=? AND order_id>? ORDER BY order_id LIMIT 1',$mod);
			if(!empty($less_row))
			{
				$less_row_obj = new PageHolder($less_row['id']);
				$less_row_obj->menu_data['order_id'] = $this->menu_data['order_id'];
				$this->menu_data['order_id'] = $less_row['order_id'];
				$less_row_obj->save_main_data();
				$this->save_main_data();
			}
		}
	}
	function move_up()
	{
		if(isset($this->menu_data['id']) && !empty($this->menu_data['id']))
		{
			$mod = array($this->menu_data['parent_id'],	$order_id = $this->menu_data['order_id']);
			
			$bigger_row = $GLOBALS['core.sql']->getRow('SELECT * FROM #p#menu WHERE parent_id=? AND order_id<? ORDER BY order_id desc LIMIT 1',$mod);
			if(!empty($bigger_row))
			{
				$bigger_row_obj = new PageHolder($bigger_row['id']);
				$bigger_row_obj->menu_data['order_id'] = $this->menu_data['order_id'];
				$this->menu_data['order_id'] = $bigger_row['order_id'];
				$bigger_row_obj->save_main_data();
				$this->save_main_data();
			}
		}
	}
	
	function publish($status)
	{
		if($status)
			$this->menu_data['published'] = 1;
		else 
			$this->menu_data['published'] = 0;
		$this->save_main_data();
	}
	
	function activate($status)
	{
		if($status)
			$this->menu_data['active'] = 1;
		else 
			$this->menu_data['active'] = 0;
		$this->save_main_data();
	}
	
	function save_main_data()
	{
		$to_save_main = array();
		foreach ($this->params as $key => $value)
		{
			if('main' == $value['storage'])
			{
				$to_save_main[$key] = $this->menu_data[$key];
			}
		}
		//also need to save system order_id
		$to_save_main['order_id'] = $this->menu_data['order_id'];
		//$to_save_main['published'] = $this->menu_data['published'];
		//$to_save_main['active'] = $this->menu_data['active'];
		$to_save_main['parent_id'] = $this->menu_data['parent_id'];
                //pp($this->menu_data);
		$GLOBALS['core.store']->save('menu', $to_save_main, array('key_name' => 'id','key_value' => $this->menu_data['id']));
                $this->make_revision();
	}
	
	function get_data()
	{
		return $this->menu_data;
	}
	
	function set_data($data)
	{
		foreach ($this->params as $key => $value)
		{
			$this->menu_data[$key] = isset($data[$key]) ? $data[$key] : '';
		}
	}
	
	function move_to($to)
	{
		if(!isset($to) || empty($to))
			return false;
		$to_page = new PageHolder($to);
		$max_order = $GLOBALS['core.sql']->getOne('SELECT max(order_id) FROM #p#menu WHERE parent_id=?',$to_page->menu_data['id']);
		if(empty($max_order))
			$max_order = 0;
		$max_order++;
		$this->menu_data['order_id'] = $max_order;
		$this->menu_data['parent_id'] = $to_page->menu_data['id'];
		$this->save_main_data();
	}
	
	function delete()
	{
		if(isset($this->menu_data['id']) && !empty($this->menu_data['id']))
		{
			if($this->menu_data['id'] != 1)
			{
				$sub_menus = $GLOBALS['core.sql']->getAll('SELECT id FROM #p#menu WHERE parent_id=?', $this->menu_data['id']);
				foreach ($sub_menus as $key => $value)
				{
					$temp_menu = new PageHolder($value['id']);
					$temp_menu->delete();
				}
				$this->real_delete();
			}
		}
	}
	
	function real_delete()
	{
		if(isset($this->menu_data['id']) && !empty($this->menu_data['id']))
		{
			if($this->menu_data['id'] != 1)
			{
				$GLOBALS['core.store']->delete('menu',array('key_name' => 'id', 'key_value' => $this->menu_data['id']));
				$GLOBALS['core.store']->delete('menu_attribute', array('key_name' => 'menu_id', 'key_value' => $this->menu_data['id']));
			}
		}
	}
	
	function set_parent($parent_id)
	{
		$this->menu_data['parent_id'] = $parent_id;
	}
	
	function save()
	{
		$to_save_main = array();
		$to_save_main_attrib = array();
		foreach ($this->params as $key => $value)
		{
			if('main' == $value['storage'])
			{
				$to_save_main[$key] = $this->menu_data[$key];
			}
			elseif ('attrib' == $value['storage'])
			{
				$to_save_main_attrib[$key] = $this->menu_data[$key];
			}
		}
                $to_save_main['updated_user_id'] = $GLOBALS['core.auth.user']->uid;
		if(isset($this->menu_data['id']) && !empty($this->menu_data['id']))
		{	
			//we are saving existing page
                        $GLOBALS['core.store']->save('menu', $to_save_main, array('key_name' => 'id', 'key_value' => $this->menu_data['id']));
			$GLOBALS['core.store']->save('menu_attribute', $to_save_main_attrib, array('key_name' => 'menu_id', 'key_value' => $this->menu_data['id']));
                        
		}
		else 
		{
                        $to_save_main['created_user_id'] = $GLOBALS['core.auth.user']->uid;
			// we are adding new page for use
			$to_save_main['parent_id'] = $this->menu_data['parent_id'];
			//need to set order_id
			$max = $GLOBALS['core.sql']->getOne('SELECT max(order_id) FROM #p#menu WHERE parent_id=?', $this->menu_data['parent_id']);
			if(empty($max))
				$max = 1;
			else 
				$max = $max + 1;
			$to_save_main['order_id'] = $max;
			$to_save_main['active'] = 1;
			$GLOBALS['core.store']->save('menu', $to_save_main, array('key_name' => 'id'));
			$to_save_main_attrib['menu_id'] = $GLOBALS['core.sql']->last_id();
			$GLOBALS['core.store']->save('menu_attribute', $to_save_main_attrib, array('key_name' => 'id'));
			$this->menu_data['id'] = $to_save_main_attrib['menu_id'];
			$this->menu_data['order_id'] = $max;
			$this->menu_data['active'] = 1;
			$this->menu_data['published'] = 0;
                        $this->menu_data['created_user_id'] = $GLOBALS['core.auth.user']->uid;
                        $this->menu_data['updated_user_id'] = $GLOBALS['core.auth.user']->uid;
                        
		}
                $this->make_revision();
	}

        function make_revision()
        {
                $rev_table = "menu_revision";
                $rev_data = $this->menu_data;
                unset($rev_data['updated']);
                unset($rev_data['created']);
                unset($rev_data['deleted']);
                unset($rev_data['id']);
                $rev_data['record_id'] = $this->menu_data['id'];
                $GLOBALS['core.store']->save($rev_table, $rev_data, array('key_name' => 'id'));
        }

        function getRevisionList($record_id)
        {
            $res = $GLOBALS['core.sql']->getAll("SELECT id,created FROM #p#menu_revision WHERE record_id=? ORDER BY created DESC LIMIT 10",array($record_id));
            foreach ($res as $key => $value) 
            {
                $res[$key]['created'] = date("d/m/Y h:i A", $res[$key]['created']);
            }
            return $res;
        }
        function getRevisionById($rev_id)
        {
            $res = $GLOBALS['core.sql']->getRow("SELECT * FROM #p#menu_revision WHERE id=?",array($rev_id));
            $cr_id = $GLOBALS['core.sql']->getOne("SELECT login FROM #p#user WHERE user_id=?",array($res['created_user_id']));
            $up_id = $GLOBALS['core.sql']->getOne("SELECT login FROM #p#user WHERE user_id=?",array($res['updated_user_id']));
            $res['created_user_id'] = !empty($cr_id)?$cr_id:'';
            $res['updated_user_id'] = !empty($up_id)?$up_id:'';
            $res['created'] = date("d/m/Y h:i A", $res['created']);
            $res['updated'] = date("d/m/Y h:i A", $res['updated']);
            return $res;
        }
} 
?>