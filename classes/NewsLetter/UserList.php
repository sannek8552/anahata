<?php
require_once('classes/BaseList.php');
require_once('classes/NewsLetter/UserItem.php');
require_once('classes/NewsLetter/GroupOptions.php');


class UserList extends BaseList{
	protected $list_name = 'user';

	protected $page_size	= 20;
	protected $default_sort	= 'first_name';
	protected $default_dir	= 'ASC';
	protected $holder_class	= 'UserItem';

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

        function post_process(&$page)
        {
		$groups_holder = new UserGroup();
                foreach($page as $key=>$value)
                {
                    $groups = $groups_holder->get_user_groups_string($value['id']);
                    $groups_id = $groups_holder->get_user_groups_id($value['id']);
                    $page[$key]['groups'] = $groups;
                    $page[$key]['groups_id'] = $groups_id;
                }
	}
}
?>