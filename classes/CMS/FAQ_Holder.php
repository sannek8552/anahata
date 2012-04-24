<?php
require_once('Data_Holder.php');
class FAQ_Holder extends Data_Holder_Simple 
{
	function FAQ_Holder($id = null)
	{
            $key_info = array('key_name' => 'id');
            if(!is_null($id))
            {
                $key_info['key_value'] = $id;
            }
            $this->init('faq_module',$key_info);
	}
	
	function get_module_list()
	{
            $to_ret = array();
            $res = $this->get_all();
            foreach ($res as $key => $value)
            {
                $to_ret[] = array('code'=> '[faq_module?section=' . $value['id'] . ']','description' => $value['name']);

            }
            return $to_ret;
	}
	
	function get_all()
	{
            return $GLOBALS['core.sql']->getAll('SELECT f.name,f.user_questions,f.id,f.created,f.updated, count(e.id) as enties_num FROM #p#faq_module as f LEFT OUTER JOIN #p#faq_module_entry as e ON f.id=e.faq_id GROUP BY f.name,f.id,f.created,f.updated ORDER BY id',array(),'id');
	}
	
	function add_entries($entries)
	{
            $ids = array();
            foreach($entries as $key => $value)
            {
                if(isset($value['id']))
                {
                    $ids[] = $value['id'];
                }
            }
            $GLOBALS['core.store']->delete('faq_module_entry',array('key_name' => 'faq_id','key_value' => $this->get_key_value()));
            if(count($ids) > 0)
            {
                $GLOBALS['core.sql']->query('DELETE FROM #p#faq_module_mass_entry WHERE faq_entry_id NOT IN ('.join(',',$ids).')');
            }
            foreach ($entries as $key => $value)
            {
                $mass_entries = array();
                if(isset($value['id']) && is_numeric($value['id']))
                {
                    $mass_entries = $GLOBALS['core.sql']->getAll('SELECT * FROM #p#faq_module_mass_entry WHERE faq_entry_id = ?', array($value['id']), 'id');
                }
                $GLOBALS['core.store']->save('faq_module_entry',array('faq_id' => $this->get_key_value(),'title' => $value['title'],'content' => $value['content']),array('key_name' => 'id'));
                if(count($mass_entries) > 0)
                {
                    $last_id = $GLOBALS['core.sql']->last_id();
                    foreach ($mass_entries as $k => $v)
                    {
                        $GLOBALS['core.store']->save('faq_module_mass_entry', array('faq_entry_id' => $last_id), array('key_name' => 'id', 'key_value' => $k));
                    }
                }
            }
	}
	
	function delete()
	{
            $entries = $this->get_entries();
            $ids = array();
            foreach($entries as $key => $value)
            {
                $ids[] = $value['id'];
            }
            if(count($ids) > 0)
            {
                $GLOBALS['core.sql']->query('DELETE FROM #p#faq_module_mass_entry WHERE faq_entry_id IN ('.join(',', $ids).')');
            }
            $GLOBALS['core.store']->delete('faq_module_entry',array('key_name' => 'faq_id','key_value' => $this->get_key_value()));
            parent::delete();
	}
	
	function get_entries()
	{
            return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#faq_module_entry WHERE faq_id=? ORDER BY id',array($this->get_key_value()));
	}
	
}
?>