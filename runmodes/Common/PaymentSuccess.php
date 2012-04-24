<?php
require_once('classes/PaymentHolder.php');

class PaymentSuccess extends Runmode 
{
	function PaymentSuccess()
	{
		//$this->base_map[0] = 'type';
		//$this->base_map[1] = 'code';
		parent::Runmode();
	}

	function process()
	{
		//pp($_REQUEST);		
		if (isset($_REQUEST['request_id']) && !empty($_REQUEST['request_id']))
		{
			$code = $_REQUEST['request_id'];
		}
		if (isset($_REQUEST['id']) && !empty($_REQUEST['id']))
		{
			$code = $_REQUEST['id'];
		}
		if (isset($code))
		{
			$ph = new PaymentHolder();
			$ph->loadByCode($code);
			
			$data = $ph->get_data();
			if (isset($data['type']) && !empty($data['type']))
			{
				if ('speaker_first' == $data['type'] || 'speaker_sr_first' == $data['type'])
				{
					require_once('runmodes/Common/SpeakerRegistration.php');
					$sr = new SpeakerRegistration();					
					$sr->finish_registration($ph);
				}
				if ('member_each' == $data['type'])
				{
					require_once('runmodes/Member/MemberLDR.php');
					$ml = new MemberLDR();
					return $ml->finish_ldr($ph);
				}
				if ('member_reg' == $data['type'])
				{
					require_once('runmodes/Member/MemberRegistration.php');
					$mr = new MemberRegistration();
					return $mr->finish_registration($ph);
				}
				
				if ('organization_each' == $data['type'])
				{
					require_once('runmodes/Organization/OrganizationLDR.php');
					$ml = new OrganizationLDR();
					return $ml->finish_ldr($ph);
				}
				
				if ('speaker_ldr_second' == $data['type'])
				{
					require_once('runmodes/Speaker/MySpeeches.php');
					$ms = new MySpeeches();
					return $ms->finishSpeech($ph);
				}
				if ('speaker_ldr_first' == $data['type'])
				{
					require_once('runmodes/Speaker/SpeakerLDR.php');
					$ms = new SpeakerLDR();
					return $ms->finish_ldr($ph);
				}
				
				if ('speaker_sr_ldr_second' == $data['type'])
				{
					require_once('runmodes/Speaker/MySpeeches.php');
					$ms = new MySpeeches();
					return $ms->finishSpeech($ph);
				}
				if ('speaker_sr_ldr_first' == $data['type'])
				{
					require_once('runmodes/Speaker/SpeakerLDR.php');
					$ms = new SpeakerLDR();
					return $ms->finish_ldr($ph);
				}				
			}
		}
		return '';
	}
}
?>