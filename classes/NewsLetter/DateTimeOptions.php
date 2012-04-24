<?php

class PostingDateTime {
    function posting_update_datetime($posting_id, $date_time){
        $table = "#p#nl_posting";
        $GLOBALS['core.sql']->query("UPDATE $table SET date_time = ? WHERE id = ?",array($date_time,$posting_id));
        
    }
}
?>
