<?php
    require_once 'modules/Data_Holder.php';
    class Billing_Country_Holder extends Data_Holder
    {
        function Billing_Country_Holder($id = null)
		{
		    if(is_null($id))
            {
                $this->init('billing_country', array('key_name' => 'id'));
            }
            else
            {
                $this->init('billing_country', array('key_name' => 'id', 'key_value' => $id));
            }
		}

		function getAll()
		{
			return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#billing_country");
		}
		
		function getStates()
		{
			return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#states WHERE country_code=?",array($this->get_data('code')));
		}
    }
?>