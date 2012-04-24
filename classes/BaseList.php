<?php
class BaseList
{
	protected $list_name;
	protected $page_size;
	protected $holder_class;
	protected $holder_instance = null;

	function __construct()
	{
		$GLOBALS['core.application']->init_module('list', true);
		if(!empty($this->holder_class))
		{
			$this->holder_instance = new $this->holder_class;
		}
	}

	function get_column_defs()
	{
		$defs = $this->holder_instance->get_column_defs();
		$defs = json_encode($defs);
		$defs = preg_replace('/(formatter":)"(.*?)"/', '$1$2', $defs);
		$defs = preg_replace('/(editor":)"(.*?)"/', '$1$2', $defs);
		return $defs;
	}

	function get_source_fields()
	{
		return json_encode($this->holder_instance->get_source_fields());
	}

	function get_sql()
	{
		return $this->holder_instance->get_list_sql();
	}

	function getAll()
	{
		
		$sort_field = $this->default_sort;
//		$sort_dir = isset($this->default_dir) ? $this->default_dir : '';
		$data = $GLOBALS['core.sql']->getAll('SELECT ' . $this->get_sql() . ' ORDER BY ' . $sort_field);
		return $data;
	}
	
	function get_page($start_index = 0, $sort_field = '', $dir = 'asc', $page_size = '', $filters = array(), $group_by = false)
	{
		$filters = $this->holder_instance->prepare_filters($filters);

		//first we check if page size is numberic
		if(empty($page_size))
		{
			$page_size = $this->page_size;
		}

		if(!is_numeric($page_size))
		{
			PEAR::raiseError('page size should be numeric','page size should be numeric');
		}
		$page_size = abs((int)$page_size);

		if(!is_numeric($start_index))
		{
			PEAR::raiseError('start index should be numeric', 'start index should be numeric');
		}
		$start_index = abs((int)$start_index);

		if(!in_array($dir,array('asc','desc')))
		{
			PEAR::raiseError('iccorect direction', 'incorrect direction');
		}
		//need to check sort field
		if(empty($sort_field))
		{
			$sort_field = $this->default_sort;
		}

		$flag_sort = false;
		$defs = $this->holder_instance->get_column_defs();
		foreach ($defs as $key => $value)
		{
			if(!isset($value['sortable']))
				$value['sortable'] = false;
			if($value['sortable'] && $value['key'] == $sort_field)
			{
				//we found match for sort field, so can use it
				$flag_sort = true;
			}
		}
		if(!$flag_sort)
		{
			PEAR::raiseError('incorrect field ' . $sort_field, 'incorrect sort field');
		}
		//need to calculate page
		$page_num = floor($start_index / $page_size) + 1;

		$GLOBALS['core.list']->custom_init($this->list_name);
		$GLOBALS['core.list']->set_filters($filters);
		$GLOBALS['core.list']->set_param('items_per_page', $page_size);
		$GLOBALS['core.list']->set_sql($this->get_sql());
        if ($group_by) 
        {
        	$GLOBALS['core.list']->set_param('group_by',$group_by);
        }
		$GLOBALS['core.list']->set_param('order_by',array($sort_field .' ' . $dir));

		$page = $GLOBALS['core.list']->get_page($page_num);
		//print $GLOBALS['core.sql.last_query'];exit();
		$page_info = $GLOBALS['core.list']->num_pages();
		
		$this->post_process($page);
		
		$to_return = array('records' => $page);
		$to_return['totalRecords'] = $page_info['items'];
		$to_return['pageSize'] = $page_size;
		$to_return['startIndex'] = $start_index;
		$to_return['recordsReturned'] = count($page);

		return $to_return;
	} 
	
	protected function post_process(&$page)
	{
		
	}
	
	function get_filters()
	{
		$GLOBALS['core.list']->custom_init($this->list_name);
		return $GLOBALS['core.list']->get_filters();
	}
}
?>