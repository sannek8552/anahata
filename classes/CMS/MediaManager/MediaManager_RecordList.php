<?php
	require_once('modules/BaseList.php');
	require_once('classes/CMS/MediaManager/MediaManager_Record.php');
	
	class MediaManager_RecordList extends BaseList 
	{
		protected $holder_class = 'MediaManager_Record';
		protected $default_sort = 'id';
	}
?>