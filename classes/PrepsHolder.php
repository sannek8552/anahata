<?php
require_once('Data_Holder.php');

class PrepsHolder extends Data_Holder
{
	function __construct($id = null)
	{
		$table = 'preps';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}

        function get_all() {
            return $GLOBALS['core.sql']->getAll("select * from #p#".$this->table, array(), $this->key_info['key_name']);
        }
		
        function delete() {
            $id = $this->get_key_value();
            if ($id) {
                $file_to_delete = $GLOBALS['core.sql']->getOne("SELECT photo FROM #p#preps WHERE id = ?",array($id));
                if (!empty($file_to_delete)) {
                    if (file_exists('./upload/'.$file_to_delete)) {
                        unlink('./upload/'.$file_to_delete);
                        unlink('./upload/thumb_'.$file_to_delete);
                    }
                }
            }
            parent::delete();
        }
}
?>