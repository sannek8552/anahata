<?php

class UserGroup{

	function get_group_users($group_id){
		return $GLOBALS['core.sql']->getAll(
			"SELECT u.* ".
			"FROM #p#nl_user AS u ".
			"INNER JOIN #p#nl_user_group_link AS l ON l.user_id=u.id AND l.group_id=? ".
			"ORDER BY u.first_name, u.last_name ASC ", 
			array($group_id), 'id');
	}

	function get_user_groups($user_id){
		return $GLOBALS['core.sql']->getAll(
			"SELECT g.* ".
			"FROM #p#nl_group AS g ".
			"INNER JOIN #p#nl_user_group_link AS l ON l.group_id=g.id AND l.user_id=? ".
			"ORDER BY g.title ASC ", 
			array($user_id), 'id');
	}
	
	function user_update_groups($user_id, $groups=array()){
		$sql_delete = '';
		$sql_insert = '';
		foreach($groups as $i){
			$sql_delete .= "{$i}, ";
			$sql_insert .= "({$user_id}, {$i}), ";
		}
		$groups = count($groups);
		$sql_delete = substr($sql_delete, 0, -2);
		$sql_insert = substr($sql_insert, 0, -2);
		$GLOBALS['core.sql']->query(
			"DELETE FROM #p#nl_user_group_link ".
			"WHERE user_id=?".
			($groups ? "AND group_id NOT IN({$sql_delete}) " : ''), 
			array($user_id));
		if($groups)
			$GLOBALS['core.sql']->query(
				"INSERT IGNORE INTO #p#nl_user_group_link (user_id, group_id) VALUES {$sql_insert}"
				);
	}
        function get_user_groups_string($user_id){
		$groups = $GLOBALS['core.sql']->getAll(
			"SELECT g.* ".
			"FROM #p#nl_group AS g ".
			"INNER JOIN #p#nl_user_group_link AS l ON l.group_id=g.id AND l.user_id=? ".
			"ORDER BY g.title ASC ",
			array($user_id));
                //pp($groups);exit();
                $res = array();
                foreach($groups as $row)
                {
                    $res[] = $row['title'];
                }
                return join(',',$res);
	}
        function get_user_groups_id($user_id){
		$groups = $GLOBALS['core.sql']->getAll(
			"SELECT g.* ".
			"FROM #p#nl_group AS g ".
			"INNER JOIN #p#nl_user_group_link AS l ON l.group_id=g.id AND l.user_id=? ".
			"ORDER BY g.title ASC ",
			array($user_id));
                //pp($groups);exit();
                $res = array();
                foreach($groups as $row)
                {
                    $res[] = $row['id'];
                }
                return join(',',$res);
	}
}

class PostingGroup{

	function get_group_postings($group_id){
		return $GLOBALS['core.sql']->getAll(
			"SELECT p.* ".
			"FROM #p#nl_posting AS p ".
			"INNER JOIN #p#nl_posting_group_link AS l ON l.posting_id=p.id AND l.group_id=? ".
			"ORDER BY p.title ASC ", 
			array($group_id), 'id');
	}

	function get_posting_groups($posting_id){
		return $GLOBALS['core.sql']->getAll(
			"SELECT g.* ".
			"FROM #p#nl_group AS g ".
			"INNER JOIN #p#nl_posting_group_link AS l ON l.group_id=g.id AND l.posting_id=? ".
			"ORDER BY g.title ASC ", 
			array($posting_id), 'id');
	}
	
	function posting_update_groups($posting_id, $groups=array()){
		$sql_delete = '';
		$sql_insert = '';
		foreach($groups as $i){
			$sql_delete .= "{$i}, ";
			$sql_insert .= "({$posting_id}, {$i}), ";
		}
		$groups = count($groups);
		$sql_delete = substr($sql_delete, 0, -2);
		$sql_insert = substr($sql_insert, 0, -2);
		$GLOBALS['core.sql']->query(
			"DELETE FROM #p#nl_posting_group_link ".
			"WHERE posting_id=?".
			($groups ? "AND group_id NOT IN({$sql_delete}) " : ''), 
			array($posting_id));
		if($groups)
			$GLOBALS['core.sql']->query(
				"INSERT IGNORE INTO #p#nl_posting_group_link (posting_id, group_id) VALUES {$sql_insert}"
				);
	}
        function get_posting_groups_string($posting_id,$return_id = false){
		$groups = $GLOBALS['core.sql']->getAll(
			"SELECT g.* ".
			"FROM #p#nl_group AS g ".
			"INNER JOIN #p#nl_posting_group_link AS l ON l.group_id=g.id AND l.posting_id=? ".
			"ORDER BY g.title ASC ",
			array($posting_id));
                //pp($groups);exit();
                $res = array();
                foreach($groups as $row)
                {
                    if(!$return_id){
                        $res[] = $row['title'];
                    }else{
                        $res[] = $row['id'];
                    }
                }
                return join(',',$res);
	}
}
?>