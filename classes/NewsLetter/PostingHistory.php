<?php
require_once('modules/ActiveRecord.php');
require_once('classes/Listable.php');

class PostingHistory extends ActiveRecord{

	protected $table = "nl_posting_history";

	protected $field_list = array(
		'title',
		'method_id',
  		'mail_id',
                'date_time',
                'type',
                'group_id',
                'contact_id',
                'posting_id',
                'start_time',
                'end_time'
	);


	function __construct($id = null){
		parent::__construct($id);
	}

	
}
?>