<?php
require_once('Data_Holder.php');
require_once('classes/SettingsHolder.php');

class ReviewHolder extends Data_Holder_Simple 
{
	function ReviewHolder($id = null)
	{
		$table = 'product_review';
		$key_info = array('key_name' => 'id');
		if (!is_null($id)) $key_info['key_value'] = $id;
		$this->init($table,$key_info);
	}
	function getAll($approved = 1)
	{
		$order = " ORDER BY created desc ";
		if (empty($approved)) return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#" . $this->table . $order,array(), 'id');
		return $GLOBALS['core.sql']->getAll("SELECT * FROM #p#" . $this->table . " WHERE approved = ? " . $order,array($approved), 'id');
	}	
	
	function getForProduct($product_id)
	{
		return $GLOBALS['core.sql']->getAll("SELECT * from #p#" . $this->table . " WHERE approved = ? and product_id = ? ORDER BY created DESC ",array(1,$product_id));
	}
	
	function sendNotification()
	{
		$sh = new SettingsHolder();
		$settings = $sh->getSettings();
		
		$data = $this->get_data();
		$GLOBALS['core.smarty']->assign('data', $data);
		$body = $GLOBALS['core.smarty']->fetch('Emails/review_notification.tpl');
		
		$GLOBALS['core.application']->init_module('mailer_module', true);
		$GLOBALS['core.mail']->init();
		$GLOBALS['core.mail']->addAddress($settings['review_admin_email']);
		$GLOBALS['core.mail']->setSubject($settings['review_admin_subject']);
		$GLOBALS['core.mail']->isHTML(true);
		$GLOBALS['core.mail']->setBody($body);
		$GLOBALS['core.mail']->send();
	}
	function approveReviews($array)
	{
		$id_array = join(",",$array);
		return $GLOBALS['core.sql']->query("UPDATE #p#product_review SET approved = '1' WHERE id in($id_array)");
		
	}
	function unapproveReviews($array)
	{
		$id_array = join(",",$array);
		return $GLOBALS['core.sql']->query("UPDATE #p#product_review SET approved = '0' WHERE id in($id_array)");
	}
	function deleteReviews($array)
	{
		$id_array = join(",",$array);
		return $GLOBALS['core.sql']->query("DELETE FROM #p#product_review WHERE id in($id_array)");
	}
	
}
?>