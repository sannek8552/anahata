<?php
require_once('modules/ActiveRecord.php');
require_once('classes/Listable.php');

class MailItem extends ActiveRecord implements Listable{
	//DEFINE TABLE TO USE
	protected $table = "nl_email";
	protected $addition_sql = "";

	//DEFINE TABLE FILEDS, WITHOUT SYSTEM LIKE id or created
	protected $field_list = array(
		'created',
		'updated',
		'title',
		'subject',
		'html',
		'plain',
        'campaign_settings'
	);

	//DEFINE VALIDATION SCHEMA, THAT IS CUSTOM, NOT REQUIRED
	protected $field_validation = array(		
	);
	
	protected $do_not_escape_html = array('html','campaign_settings'); 

	//CUSTOM FIELD, THAT WILL BE USED BY LIST CLASS
	protected $order_by = 'title asc';

	//CUSTOM FILED THAT WILL BE USED BY LIST
	protected $column_defs = array(
		array('key'=>'title', 'label'=>'Title', 'sortable'=>true),
		array('key'=>'edit', 'label'=>'Last edited', 'sortable'=>true),
		array('key'=>'functions', 'label'=>'Functions', 'sortable'=>false, 'field'=>'id', 'formatter'=>'nlmail.function_formatter'),
	);

	protected $meta_class = array(
//		'country' => array('class' => 'Location','field' => 'title','f_key' => 'country_id'),
	);

	//CUSTOM FIELD THAT WILL BE USED BY LIST
	protected $source_fields = array(
		'id',
		'title',
		'edit',
	);
		
	function get_source_fields(){
		return $this->source_fields;
	}

	function get_list_sql(){
		$sql = "m.*, IFNULL(m.updated, m.created) AS 'edit' ".
			"FROM #p#nl_email AS m ";
		
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

		$to_return['deleted'] = array('f'=>'m.deleted', 'v'=>'0');
		
		if(isset($filters['title']) && !empty($filters['title']))
			$to_return['title'] = array('f'=>'m.title', 'v'=>$filters['title'], 'o'=>'LIKE');

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
}
?>