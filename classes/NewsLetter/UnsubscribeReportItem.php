<?php
require_once('modules/ActiveRecord.php');
require_once('classes/Listable.php');

class UnsubscribeReportItem extends ActiveRecord implements Listable{
	//DEFINE TABLE TO USE
	protected $table = "nl_user";
	protected $addition_sql = "";

	//DEFINE TABLE FILEDS, WITHOUT SYSTEM LIKE id or created
	protected $field_list = array(

	);


	//CUSTOM FIELD, THAT WILL BE USED BY LIST CLASS
	protected $order_by = 'u.unsubscribe_date desc';

	//CUSTOM FILED THAT WILL BE USED BY LIST
	protected $column_defs = array(
                array('key'=>'first_name',  'label'=>'First Name',  'sortable'=>true),
                array('key'=>'last_name',   'label'=>'Last Name',   'sortable'=>true),
                array('key'=>'unsubscribe_date',     'label'=>'Date',        'sortable'=>true),
	);

	protected $meta_class = array(

	);

	//CUSTOM FIELD THAT WILL BE USED BY LIST
	protected $source_fields = array(
		'id',
                'first_name',
                'last_name',
                'unsubscribe_date',
	);
		
	function get_source_fields(){
		return $this->source_fields;
	}

	function get_list_sql(){
		//$sql = "p.* FROM #p#nl_posting AS p ";
                $sql= ' * FROM #p#nl_user ';
		return $sql.$this->addition_sql;
	}

	function get_column_defs(){
		return $this->column_defs;
	}

	function __construct($id = null){
		parent::__construct($id);
	}

        function prepare_filters($filters){
            $to_return = array();
            $to_return['had_read'] = array('f'=>'unsubscribe', 'v'=>'1');
            return  $to_return;
        }
	


}
?>