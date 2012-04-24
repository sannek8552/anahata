<?php
class FileCache extends Module 
{
	var $cache_path = './cache/';
	function FileCache($cfg)
	{
		
	}
	
	function init()
	{
		
	}
	
	function run()
	{
		
	}
	
	function get($key)
	{
		if(!file_exists($this->cache_path . $key))
			return false;
		return unserialize(file_get_contents($this->cache_path . $key));	
	}
	
	function put($key, $data)
	{
		//place data to cache
		$f = fopen($this->cache_path . $key,"w");
		flock($f, LOCK_EX);
		fwrite($f, serialize($data));
		fclose($f);
	}
	
	function delete($key)
	{
		if(file_exists($this->cache_path . $key))
			unlink($this->cache_path . $key);
	}
}
?>