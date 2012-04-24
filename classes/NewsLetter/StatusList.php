<?php

class StatusList {
    function getAll()
    {

	$parent_id = 40;
        return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#dropdown WHERE parent_id = ?",array($parent_id),'id');
        
    }
}
?>
