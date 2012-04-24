<?php
require_once('modules/ActiveRecord.php');
require_once('classes/Listable.php');

class ReadReportItem extends ActiveRecord implements Listable{
	//DEFINE TABLE TO USE
	protected $table = "nl_sent_mail";
	protected $addition_sql = "";

	//DEFINE TABLE FILEDS, WITHOUT SYSTEM LIKE id or created
	protected $field_list = array(

	);


	//CUSTOM FIELD, THAT WILL BE USED BY LIST CLASS
	protected $order_by = 'r.updated';

	//CUSTOM FILED THAT WILL BE USED BY LIST
	protected $column_defs = array(
				array('key'=>'posting_title',  	'label'=>'Posting',     'sortable'=>true),
				array('key'=>'email',       	'label'=>'E-mail',      'sortable'=>true),
	            array('key'=>'first_name',  	'label'=>'First Name',  'sortable'=>true),
	            array('key'=>'last_name',   	'label'=>'Last Name',   'sortable'=>true),
	            array('key'=>'updated',     	'label'=>'Date',        'sortable'=>true),
                    array('key'=>'read_number',     	'label'=>'Read Number',        'sortable'=>true),
	);

	protected $meta_class = array(

	);

	//CUSTOM FIELD THAT WILL BE USED BY LIST
	protected $source_fields = array(
		'id',
		'email',
                'first_name',
                'last_name',
                'updated',
                'posting_title',
                'read_number'
	);
		
	function get_source_fields(){
		return $this->source_fields;
	}

	function get_list_sql(){
		//$sql = "p.* FROM #p#nl_posting AS p ";
		
                $sql= ' sm.* , u.email, u.first_name, u.last_name , sum(sm.had_read) as read_number, np.title as posting_title '.
                        'FROM `#p#nl_sent_mail` sm '.
                        'INNER JOIN `#p#nl_user` u ON sm.user_id = u.id '.
                        'INNER JOIN #p#nl_posting as np on sm.posting_id = np.id ';
        
		/*
                $sql= ' r.* , sum(r.had_read) as read_number, np.title as posting_title FROM ( '.
                        'SELECT sm.* , u.email, u.first_name, u.last_name '.
                        'FROM `#p#nl_sent_mail` sm '.
                        'LEFT OUTER JOIN `#p#nl_user` u ON sm.user_id = u.id '.
                        'UNION '.
                        'SELECT sm .* , c.email, null,null '.
                        'FROM `#p#nl_sent_mail` sm '.
                        'LEFT OUTER JOIN  `#p#contact_module_entry` c ON sm.contact_entry_id = c.id '.
                      ') r
                      LEFT OUTER JOIN #p#nl_posting as np on r.posting_id = np.id ';
		*/                      
		return $sql.$this->addition_sql;
	}

        function prepare_group_by()
        {
            $group_by = ' sm.posting_id, sm.user_id ';
            return $group_by;
        }

	function get_column_defs(){
		return $this->column_defs;
	}

	function __construct($id = null){
		parent::__construct($id);
	}

        function prepare_filters($filters){
            $to_return = array();
            $to_return['had_read'] = array('f'=>'had_read', 'v'=>'1');
            $to_return['email_not_null'] = array('f'=>'email', 'v'=>NULL, 'o'=>'IS NOT');
            return  $to_return;
        }
	


}
?>