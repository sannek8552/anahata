<?php
require_once('Data_Holder.php');
class News_Holder extends Data_Holder_Simple 
{
	function News_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('news_module',$key_info);
	}
	function get_all_news()
	{
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#'.$this->table);
	}
	function get_entries()
	{
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#news_module_entry WHERE news_id=? ORDER BY adddate, addtime', array($this->get_key_value()));
	}
	function get_entries_id()
	{
		return $GLOBALS['core.sql']->getAll('SELECT id FROM #p#news_module_entry WHERE news_id=? ORDER BY adddate, addtime', array($this->get_key_value()));
	}
	function get_by_page($page, $news_id, $front = null)
	{
		$GLOBALS['core.list']->custom_init('news_list');
		$GLOBALS['core.list']->set_sql('* FROM #p#news_module_entry');
		$filters = array();
		$filters[] = array('f' => 'news_id', 'v' => $news_id);
		if(isset($front) && $front == 1)
		{
			$filters[] = array('f' => 'publish', 'v' => 1);
		}
		$GLOBALS['core.list']->set_filters($filters);
		$GLOBALS['core.list']->set_param('items_per_page', $this->data['items']);//$GLOBALS['core.sql']->getOne('SELECT items FROM #p#news_module WHERE id=?', array($news_id)));
		$GLOBALS['core.list']->set_param('order_by', array('adddate DESC, addtime DESC'));
		$news = $GLOBALS['core.list']->get_page($page);
		$num_pages = $GLOBALS['core.list']->num_pages();
		//pp($num_pages);
		$GLOBALS['core.smarty'] -> assign('num_pages', $num_pages);

		$GLOBALS['core.smarty']->assign('all_news', $news);
		if(isset($num_pages) && !in_array($page, $num_pages['prepared']))
		{
			$GLOBALS['core.smarty']->assign('page_error', 1);
		}
		else 
		{
			$GLOBALS['core.smarty']->assign('page_error', 0);
		}
		return '';
	}

        function get_for_short_list($news_id)
	{
		$GLOBALS['core.list']->custom_init('news_list');
		$GLOBALS['core.list']->set_sql('* FROM #p#news_module_entry');
		$filters = array();
		$filters[] = array('f' => 'news_id', 'v' => $news_id);
                $filters[] = array('f' => 'publish', 'v' => 1);

		$GLOBALS['core.list']->set_filters($filters);
		$GLOBALS['core.list']->set_param('items_per_page', 3);
		$GLOBALS['core.list']->set_param('order_by', array('adddate DESC, addtime DESC'));
		$news = $GLOBALS['core.list']->get_page(1);

                switch ($news_id) {
                    case 6:
                        $GLOBALS['core.smarty']->assign('seo_url', 'News');
                        break;
                    case 7:
                        $GLOBALS['core.smarty']->assign('seo_url', 'Article');
                        break;
                    case 8:
                        $GLOBALS['core.smarty']->assign('seo_url', 'Campaign');
                        break;
                    default:
                        $GLOBALS['core.smarty']->assign('seo_url', 'News');
                        break;
                }
		$GLOBALS['core.smarty']->assign('all_news', $news);

		return '';
	}

	function delete_by_news_id($news_id)
	{
		$GLOBALS['core.sql']->query('DELETE FROM #p#news_module_entry WHERE news_id='.$news_id);
		return '';
	}
}