<?php
require_once('classes/BaseList.php');
require_once('classes/NewsLetter/GroupItem.php');

class GroupList extends BaseList{
	protected $list_name = 'group';

	protected $page_size	= 20;
	protected $default_sort	= 'title';
	protected $default_dir	= 'ASC';
	protected $holder_class	= 'GroupItem';

	function __construct(){
		parent::__construct();
	}

	function getAll($filters = array()){
		$filters['deleted'] = 0;
		$filters = $this->holder_instance->prepare_filters($filters);
		$parts = $GLOBALS['core.list']->prepare_filters($filters);
		$sort_field = $this->default_sort;
		return $GLOBALS['core.sql']->getAll(
			'SELECT '.$this->get_sql().
			' WHERE '.$parts['sql_part'].
			' ORDER BY '.$sort_field, 
			$parts['modif']);
	}
}
?>