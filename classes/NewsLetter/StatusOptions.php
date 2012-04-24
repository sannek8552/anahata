<?php

class PostingStatus {
    function get_status_postings($status_id){
		return $GLOBALS['core.sql']->getAll(
			"SELECT p.* ".
			"FROM #p#nl_posting AS p ".
			"INNER JOIN #p#nl_posting_status_link AS l ON l.posting_id=p.id AND l.status_id=? ".
			"ORDER BY p.title ASC ",
			array($status_id), 'id');
	}
        
	function get_posting_statuses($posting_id){
		return $GLOBALS['core.sql']->getAll(
			"SELECT d.* ".
			"FROM #p#dropdown AS d ".
			"INNER JOIN #p#nl_posting_status_link AS l ON l.status_id=d.id AND l.posting_id=? ".
			"ORDER BY d.title ASC ",
			array($posting_id), 'id');
	}

	function posting_update_statuses($posting_id, $statuses=array()){
		$sql_delete = '';
		$sql_insert = '';
		foreach($statuses as $i){
			$sql_delete .= "{$i}, ";
			$sql_insert .= "({$posting_id}, {$i}), ";
		}
		$statuses = count($statuses);
		$sql_delete = substr($sql_delete, 0, -2);
		$sql_insert = substr($sql_insert, 0, -2);
		$GLOBALS['core.sql']->query(
			"DELETE FROM #p#nl_posting_status_link ".
			"WHERE posting_id=?".
			($statuses ? "AND status_id NOT IN({$sql_delete}) " : ''),
			array($posting_id));
		if($statuses)
			$GLOBALS['core.sql']->query(
				"INSERT IGNORE INTO #p#nl_posting_status_link (posting_id, status_id) VALUES {$sql_insert}"
				);
	}
        function get_posting_statuses_string($posting_id){
		$statuses = $GLOBALS['core.sql']->getAll(
			"SELECT d.* ".
			"FROM #p#dropdown AS d ".
			"INNER JOIN #p#nl_posting_status_link AS l ON l.status_id=d.id AND l.posting_id=? ".
			"ORDER BY d.title ASC ",
			array($posting_id), 'id');
                //pp($statuses);exit();
                $res = array();
                foreach($statuses as $row)
                {
                    $res[] = $row['title'];
                }
                //pp(join(',',$res));exit();
                return join(',',$res);
	}
}
?>
