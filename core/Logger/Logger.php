<?php
/*

Logger module
Usage: $GLOBALS['core.log']->do_log($message_or_array, $category);

Configuration in application.ini
store = logs	//path where to store log files
accept = core,admin,runmode,class,test	//categories for which we do logs, use all if log all, leave emplty not do log
flush = y	//if do new log file each time when development
max_size = 1048576  //size after which log file will be truncated (bytes)
*/
class Logger extends Module 
{
	var $store = 'logs';
	var $accept = 'all';
	var $accept_arr = array();
	var $pointer = null;
	var $flush = false;
	var $max_size = '1048576';
	
	function Logger($cfg)
	{
		$this->store = $cfg['store'];
		$this->accept = $cfg['accept'];
		$this->accept_arr = explode(',', $this->accept);
		if('y' == $cfg['flush'])
		{
			$this->flush = true;
		}
		$this->max_size = $cfg['max_size'];
	}
	
	function init()
	{
		register_shutdown_function(array(&$this,'close'));
		return true;
	}

	function run()
	{
		return true;
	}
	
	function do_log($what, $category = 'test')
	{
		if('all' != $this->accept && !in_array($category, $this->accept_arr))
		{
			return true;
		}
		
		if(is_null($this->pointer))
		{
			$mode = 'a';
			if($this->flush)
				$mode = 'w';
			else 
			{
				if(file_exists($this->store . '/log.txt') && filesize($this->store . '/log.txt') > $this->max_size)
					$mode = 'w';
			}
			$this->pointer = fopen($this->store . '/log.txt', $mode);
		}
		
		$what = $this->format($what, $category);
		
		fwrite($this->pointer, $what);
	}
	
	function format($message, $category)
	{
		$new_message = "\n----------------------------------\n";
		$new_message .= date("m-d-Y H:i:s") . ' ------- ' . $category . "\n";
		if(is_array($message))
			$new_message .= print_r($message,true);
		else 
			$new_message .= $message;
		return $new_message;
	}
	
	function close()
	{
		if(!is_null($this->pointer))
		{
			fclose($this->pointer);
			$this->pointer = null;
		}
	}
}
?>