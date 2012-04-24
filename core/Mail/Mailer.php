<?php
require_once('phpmailer/class.phpmailer.php');


class Mailer extends Module 
{
	var $mail_object;
	
	function Mailer($cfg)
	{
		$this->init();
	}
	
	function init()
	{
		$this->mail_object = new phpmailer();
		$this->mail_object->Host = "localhost";
		$this->mail_object->Mailer = "mail";
	}
	
	function run()
	{
		
	}
	
	function addAddress($address, $name = '')
	{
		$this->mail_object->AddAddress($address, $name);
	}
	
	function addCC($address, $name = '')
	{
		$this->mail_object->AddCC($address, $name);
	}
	
	function addBCC($address, $name = '')
	{
		$this->mail_object->AddBCC($address, $name);
	}
	
	function isHTML($bool)
	{
		$this->mail_object->IsHTML($bool);
	}
        function isSMTP($bool)
        {
            $this->mail_object->IsSMTP($bool);
        }
        function setUser($user)
        {
            $this->mail_object->Username = $user;
        }
        function setPassword($password)
        {
            $this->mail_object->Password = $password;
        }
	function setPort($port)
        {
            $this->mail_object->Port = $port;
        }
        function setServer($server)
        {
            $this->mail_object->Host = $server;
        }
	function send()
	{
		//$config = $GLOBALS['core.config']->get_config('mail');
		//$this->setFrom($config['common']['from_email']);
		//$this->setFromName($config['common']['from_name']);
		//$bcc = explode(",",$config['common']['bcc']);
		//if (!empty($bcc))	foreach ($bcc as $adr) $this->addBCC($adr);
		$result = $this->mail_object->Send();
		$this->mail_object->ClearAddresses();
		return $result;
	}
	
	function viewErrorInfo()
	{
		return $this->mail_object->ErrorInfo;
	}
	
	function setBody($body)
	{
		$this->mail_object->Body = $body;
	}
	
	function setFrom($address)
	{
		$this->mail_object->From = $address;
	}
	
	function setSubject($subject)
	{		
		$this->mail_object->Subject = $subject;
	}
	
	function setFromName($name)
	{
		$this->mail_object->FromName = $name;
	}
        
}
?>