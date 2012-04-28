<?php
require_once('Data_Holder.php');
class News_Entry_Holder extends Data_Holder_Simple 
{
	function News_Entry_Holder($id = null)
	{
		$key_info = array('key_name' => 'id');
		if(!is_null($id))
		{
			$key_info['key_value'] = $id;
		}
		$this->init('news_module_entry',$key_info);
	}

        function delete() {
            $id = $this->get_key_value();
            if ($id) {
                $file_to_delete = $GLOBALS['core.sql']->getOne("SELECT image FROM #p#news_module_entry WHERE id = ?",array($id));
                if (!empty($file_to_delete)) {
                    if (file_exists('./upload/'.$file_to_delete)) {
                        unlink('./upload/'.$file_to_delete);
                        unlink('./upload/200_'.$file_to_delete);
                    }
                }
            }
            parent::delete();
        }
}
?>