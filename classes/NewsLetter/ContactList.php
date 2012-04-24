<?php

class ContactList {
    function GetAll()
    {
	return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#contact_module");
    }
}
?>
