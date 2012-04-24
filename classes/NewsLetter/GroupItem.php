<?php
require_once('modules/ActiveRecord.php');
require_once('classes/Listable.php');

class GroupItem extends ActiveRecord implements Listable{
	//DEFINE TABLE TO USE
	protected $table = "nl_group";
	protected $addition_sql = "";

	//DEFINE TABLE FILEDS, WITHOUT SYSTEM LIKE id or created
	protected $field_list = array(
		'title',
            'contact_id',
	);

	//DEFINE VALIDATION SCHEMA, THAT IS CUSTOM, NOT REQUIRED
	protected $field_validation = array(		
	);

	//CUSTOM FIELD, THAT WILL BE USED BY LIST CLASS
	protected $order_by = 'title asc';

	//CUSTOM FILED THAT WILL BE USED BY LIST
	protected $column_defs = array(
		array('key'=>'title', 'label'=>'Title', 'sortable'=>true),
		array('key' => 'id', 'label' => 'Group Id', 'sortable' => true),
		array('key'=>'users', 'label'=>'Users', 'sortable'=>true),
		array('key'=>'functions', 'label'=>'Functions', 'sortable'=>false, 'field'=>'id', 'formatter'=>'nlgroup.function_formatter'),
	);

	protected $meta_class = array(
//		'country' => array('class' => 'Location','field' => 'title','f_key' => 'country_id'),
	);

	//CUSTOM FIELD THAT WILL BE USED BY LIST
	protected $source_fields = array(
		'id',
		'title',
		'users',
	);
		
	function get_source_fields(){
		return $this->source_fields;
	}

	function get_list_sql(){
		$sql = "g.*, IFNULL(l.users, 0) AS users ".
			"FROM #p#nl_group AS g ".
			"LEFT JOIN (SELECT group_id, count(*) AS users FROM #p#nl_user_group_link GROUP BY group_id) AS l ON l.group_id=g.id ";
		
		return $sql.$this->addition_sql;
	}

	function get_column_defs(){
		return $this->column_defs;
	}

	function __construct($id = null){
		parent::__construct($id);
	}

	function validate(&$data){
		//need to validate data for broker
		$GLOBALS['core.application']->init_module('validator_module', true);
		foreach ($this->field_validation as $key => $value){
			if(!isset($data[$key]))
				$data[$key] = '';
			$GLOBALS['core.validator']->add($key, $data[$key], '', $value);
		}
		$err = $GLOBALS['core.validator']->check();	
		return $err;
	}

	function prepare_filters($filters){
		$to_return = array();
		
		$to_return['deleted'] = array('f'=>'g.deleted', 'v'=>'0');
		
		if(isset($filters['title']) && !empty($filters['title']))
			$to_return['title'] = array('f'=>'g.title', 'v'=>$filters['title'], 'o'=>'LIKE');

		if(isset($filters['user']) && $filters['group']>0){
			$this->addition_sql .= "INNER JOIN #p#nl_user_group_link AS l ON l.group_id=g.id ";
			$to_return['user'] = array('f'=>'l.user_id', 'v'=>$filters['user']);
		}
		
		return $to_return;
	}
	
	function get_data($name = null){
		$data = parent::get_data($name);
		//if($name=='price') $data = number_format($data, 2, '.', ' ');
		return $data;
	}

	function set_data($data){
		return parent::set_data($data);
	}
	
	function get_title_id_group(){
		return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#nl_group WHERE deleted=0 ', array(), 'title');
	}
}
?>