<?php
require_once('Data_Holder.php');

class CertificateHolder extends Data_Holder_Simple 
{
	function CertificateHolder($id = null)
	{
		$table = 'certificate';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}
	function get_all()
	{
		return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#" . $this->table,array(), 'id');
	}
	
	function load_lists()
	{
		$certificates = $this->get_all();
		$GLOBALS['core.smarty']->assign('certificates', $certificates);
	}
	
	function loadBySeo($seo)
	{
		$id = $GLOBALS['core.sql']->getOne("select id from #p#" . $this->table . " where seo = ?",array($seo));		
		if (!empty($id)) 
		{
			$this->load($id);
			return true;		
		}
		return false;
	}
	
	function upload_file($file, $filedirectory)
 	{
  		if(!is_null($filedirectory) && is_dir($filedirectory))
  		{
   			$filedirectory = trim($filedirectory, "/");
   			$pathfile = pathinfo($file);
   			$j = 1;
   			while(file_exists($filedirectory.'/'.$file))
   			{
    			$file = $pathfile['filename'].'('.$j.').'.$pathfile['extension'];
    			$j++;
   			}
   			return $file;
  		}
  		else 
  		{
   			exit('dirrectory error');
  		}
 	}
}
?>