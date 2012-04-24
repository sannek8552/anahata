<?php
	require_once('modules/ActiveRecord.php');
	require_once('Listable.php');
	class MediaManager_Record extends ActiveRecord implements Listable
	{
		//this variable should contain all the
		//field that represented by table, without special fields like created, updated and primary key!
		protected $field_list = array('filename','title','caption','description','url','align','size','thumbs','type');

		protected $table = 'cms_media';

		protected $source_fields = array('id','filename','title','caption','description','url','align','size','thumbs','type');

		protected $column_defs = array(
			array('key' => 'id','sortable' => true)
		);
		
		function get_list_sql()
		{
			return "* FROM #p#".$this->table."";
		}

		function get_column_defs()
		{
			return $this->column_defs;
		}

		function get_source_fields()
		{
			return $this->source_fields;
		}

		function prepare_filters($filters)
		{
			$to_return = array('id' => array('f' => 'id','v' => 0,'o' => '<>'));
			
			if (isset($filters['type']) and is_array($filters['type']))
			{
				$to_return['type'] = array('f' => 'type','v' => $filters['type'],'o' => 'IN');
			}
			#pp($to_return);
			return $to_return;
		}
	}
?>