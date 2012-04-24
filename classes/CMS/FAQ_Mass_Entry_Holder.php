<?php
require_once('Data_Holder.php');

class FAQ_Mass_Entry_Holder extends Data_Holder_Simple
{
    function FAQ_Mass_Entry_Holder($id = null)
    {
        $key_info = array('key_name' => 'id');
        if(!is_null($id))
        {
            $key_info['key_value'] = $id;
        }
        $this->init('faq_module_mass_entry', $key_info);
    }
    function get_all()
    {
        return $GLOBALS['core.sql']->getAll('SELECT * FROM #p#faq_module_mass_entry', array(), 'id');
    }
    function group_by_entries($faq_id)
    {
        $mass_entries = $GLOBALS['core.sql']->getAll('SELECT #p#faq_module_mass_entry.*, #p#faq_module_mass_entry.id as entry_id, #p#faq_module_entry.faq_id FROM #p#faq_module_mass_entry INNER JOIN #p#faq_module_entry ON #p#faq_module_entry.id = #p#faq_module_mass_entry.faq_entry_id WHERE #p#faq_module_entry.faq_id = ?', array($faq_id), 'id');
        $group_entries = array();
        foreach ($mass_entries as $key => $value)
        {
            $group_entries[$value['faq_entry_id']][$value['id']] = $value;
        }
        return $group_entries;
    }
    function count_mass_entries()
    {
        $mass_entries = $GLOBALS['core.sql']->getAll('SELECT #p#faq_module.id as faq, COUNT(*) as count, #p#faq_module_entry.faq_id FROM #p#faq_module_mass_entry INNER JOIN #p#faq_module_entry ON #p#faq_module_entry.id = #p#faq_module_mass_entry.faq_entry_id INNER JOIN #p#faq_module on #p#faq_module.id = #p#faq_module_entry.faq_id GROUP BY #p#faq_module.id', array(), 'faq');
        return $mass_entries;
    }
}

?>
