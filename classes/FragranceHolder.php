<?php
require_once('Data_Holder.php');
require_once('classes/ProductHolder.php');
class FragranceHolder extends Data_Holder_Simple 
{
	function __construct($id = null)
	{
		$table = 'fragrance';
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
		$res = $this->get_all();
		$GLOBALS['core.smarty']->assign('fragrance_types', $res);
	}
	
	function loadBySeo($seo_url)
	{
		$id = $GLOBALS['core.sql']->getOne("select ".$this->key_info['key_name']." from #p#".$this->table." where seo_url = ?",array($seo_url));
		if (!empty($id)) $this->load($id);
	}
}
?>