<?php
require_once('modules/BaseList.php');

class CMSUserList extends BaseList
{
	protected $list_name = 'user_list';

	protected $page_size = 25;
	protected $default_sort = 'login';
	protected $holder_class = 'CMSUser';

	function __construct()
	{
		parent::__construct();
	}
	
	function getAll($department_id = null, $user_id = null, $deleted = 0)
	{
		$filters = array();
		/*if(!empty($department_id))
			$filters['department_id'] = $department_id;
		
		if(!empty($user_id))
			$filters['user_id'] = $user_id;

		if (!$deleted)
			$filters['deleted'] = 0;*/
                
		$filters = $this->holder_instance->prepare_filters($filters);
		$parts = $GLOBALS['core.list']->prepare_filters($filters);
		$sort_field = $this->default_sort;
		return $GLOBALS['core.sql']->getAll('SELECT ' . $this->get_sql() . ' WHERE ' . $parts['sql_part'] . ' ORDER BY ' . $sort_field, $parts['modif']);
	}

	function get_page($start_index = 0, $sort_field = '', $dir = 'asc', $page_size = '', $filters = array())
	{
		if (!$this->holder_instance->have_access('view_section'))
		{
			return array("records" => '');
		}
		else
			return parent::get_page($start_index, $sort_field, $dir, $page_size, $filters);
	}
}
?>