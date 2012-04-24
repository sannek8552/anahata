<?php
class Session extends Module 
{
	function Session($cfg)
	{
		
	}
	function init()
	{
		session_set_save_handler(
       		array(& $this, 'open'), 
       		array(& $this, 'close'), 
		array(& $this, 'read'), 
		array(& $this, 'write'), 
		array(& $this, 'destroy'), 
		array(& $this, 'gc'));
	}
	
	function run()
	{	
		session_start();
	}
	
	function open($session_path,$session_name)
	{
	    $dbh =& $GLOBALS['core.sql'];
	    $cfg = $GLOBALS['core.config']->get_config('db_config');
	    $prefix = $cfg['common']['prefix'];
	    $session_config = $GLOBALS['core.config']->get_config('session');
	    $maxlifetime = $session_config['session']['session_timeout'];
	    
	    $query = "delete from ${prefix}session where updated < " . (time()-$maxlifetime);	    
	    $dbh->query($query);
	    return true;
	}

	function close()
	{
	    return(true);
	}
	
	function write($id,$data)
	{
	   	$GLOBALS['core.store']->save_insert('session',array('content' => $data),array('key_name' =>'id','key_value' => $id));
	    return (true);
	}
	
	function destroy($id)
	{   
	    $GLOBALS['core.store']->delete('session',array('key_name' => 'id','key_value' => $id));
	    return (true);
	}

	function gc($maxlifetime)
	{
		return true;
	    /*$cfg = $GLOBALS['core.config'];
	    $cfg = $cfg->get_config('db_config');
	    //$table = $cfg['database']['table'];
	    $session_config = $GLOBALS['core.config']->get_config('session');
	    $maxlifetime = $session_config['session']['maxlifetime'];
	    
	    $GLOBALS['core.sql']->query("delete from #p#session where updated<".(time()-$maxlifetime));
	    return true;*/
	}	
	
	function read($session_id)
	{
	    $dbh =& $GLOBALS['core.sql'];
	    $cfg = $GLOBALS['core.config'];
	    
	    $cfg = $cfg->get_config('db_config');
	    
	    $prefix = $cfg['common']['prefix'];
	    $query = "select content from ${prefix}session where id = ?";
	    return $dbh->getOne($query,array($session_id));
	}
}
?>