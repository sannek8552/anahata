<?php
class PostingContact {
    function get_contact_postings($contact_id){
		return $GLOBALS['core.sql']->getAll(
			"SELECT p.* ".
			"FROM #p#nl_posting AS p ".
			"INNER JOIN #p#nl_posting_contact_link AS l ON l.posting_id=p.id AND l.contact_id=? ".
			"ORDER BY p.title ASC ",
			array($contact_id), 'id');
	}
        
	function get_posting_contacts($posting_id){
		return $GLOBALS['core.sql']->getAll(
			"SELECT c.* ".
			"FROM #p#contact_module AS c ".
			"INNER JOIN #p#nl_posting_contact_link AS l ON l.contact_id=c.id AND l.posting_id=? ".
			"ORDER BY c.subject ASC ",
			array($posting_id), 'id');
	}

	function posting_update_contacts($posting_id, $contacts=array()){
		$sql_delete = '';
		$sql_insert = '';
		foreach($contacts as $i){
			$sql_delete .= "{$i}, ";
			$sql_insert .= "({$posting_id}, {$i}), ";
		}
		$contacts = count($contacts);
		$sql_delete = substr($sql_delete, 0, -2);
		$sql_insert = substr($sql_insert, 0, -2);
		$GLOBALS['core.sql']->query(
			"DELETE FROM #p#nl_posting_contact_link ".
			"WHERE posting_id=?".
			($contacts ? "AND contact_id NOT IN({$sql_delete}) " : ''),
			array($posting_id));
		if($contacts)
			$GLOBALS['core.sql']->query(
				"INSERT IGNORE INTO #p#nl_posting_contact_link (posting_id, contact_id) VALUES {$sql_insert}"
				);
	}
        function get_posting_contacts_string($posting_id,$return_id = false){
		$contacts = $GLOBALS['core.sql']->getAll(
			"SELECT c.* ".
			"FROM #p#contact_module AS c ".
			"INNER JOIN #p#nl_posting_contact_link AS l ON l.contact_id=c.id AND l.posting_id=? ".
			"ORDER BY c.subject ASC ",
			array($posting_id), 'id');
                //pp($groups);exit();
                $res = array();
                foreach($contacts as $row)
                {
                    if(!$return_id){
                        $res[] = $row['subject'];
                    }else{
                        $res[] = $row['id'];
                    }
                }
                return join(',',$res);
	}
}
?>
