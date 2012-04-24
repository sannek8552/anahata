<?php

class SentMailOptions {

        function save_mail($_data, $id = 0)
        {
        	if (!empty($id)) 
        	{
        		$GLOBALS['core.store']->save('nl_sent_mail',$_data, array('key_name'=>'id', 'key_value' => $id));
        		return $id;
        	}
            else 
            {
            	$GLOBALS['core.store']->save('nl_sent_mail',$_data, array('key_name'=>'id'));            
            	return $GLOBALS['core.store']->last_id();
            }
        }
        
        function set_read($_id)
        {
            if (!empty($_id)) 
            {
                $already_read = $GLOBALS['core.sql']->getOne("SELECT had_read FROM #p#nl_sent_mail WHERE id =?",array($_id));
                if (!$already_read) 
                {
                    $GLOBALS['core.store']->save('nl_sent_mail',array('had_read'=>1), array('key_name'=>'id','key_value'=>$_id));
                }
            }
        }

        function get_read_hash($_id)
        {
            $created = $GLOBALS['core.sql']->getOne("SELECT created FROM #p#nl_sent_mail WHERE id =?",array($_id));
            return md5($created.'read');
        }
        
        function delete_mail($id)
        {
        	if (!empty($id))
        	{
        		$GLOBALS['core.store']->delete('nl_sent_mail', array('key_name' => 'id', 'key_value' => $id));
        	}
        }
}
?>
