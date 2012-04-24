<?php
class Download extends Runmode 
{
	function Download()
	{
		$this->base_map[0] = 'id';
		parent::Runmode();
	}
	
	function process()
	{
		$id = $_REQUEST['id'];
		$res = $GLOBALS['core.sql']->getRow('SELECT * FROM #p#download_module_entry WHERE id=?',array($id));
		
	 	header("Pragma: ");
                header("Cache-Control: ");
                header("Content-type: " . $res['content_type']);
                header("Content-Disposition: attachment; filename=\"".$res['file']."\";");

                $f = fopen('./upload/' . $res['file'],'r');
                while ($co = fread($f,1024))
                {
                        print $co;
                }
                fclose($f);
	}
}
?>