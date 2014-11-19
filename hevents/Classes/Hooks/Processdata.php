<?php
class Tx_Hevents_Hooks_Processdata {
	protected $sender = 'info@ericdepta.de';
	protected $subject_lang = array(
		0=>'Booking Status',
		1=>'Status Ihrer Buchung',
	);
	protected $status_lang = array(
		0=>array(
			0=>'progress',
			1=>'dispatch',
			2=>'canceled',
		),
		1=>array(
			0=>'progress de',
			1=>'dispatch de',
			2=>'canceled de',
		),
	);
	
	
	function processDatamap_preProcessFieldArray(&$fieldArray, $table, $id, &$pObj) {
		if($table=='tx_hevents_domain_model_booking'){
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*','tx_hevents_domain_model_booking','uid='.$id); 
			while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
				if($row['ppstatus'] != $fieldArray['ppstatus']){
					$res2 = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*','tx_hevents_domain_model_event','uid='.$fieldArray['event']);
					while($row2 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res2)){
						$event = $row2;
						$res3 = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*','tx_hevents_domain_model_event','l10n_parent='.$fieldArray['event'].' AND sys_language_uid='.$row['lkey']);
						while($row3 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res3)){
							$event = $row3;
						}
						break;
					}
					
					$this->mail_typo(
						$fieldArray['email'], 
						$this->subject_lang[(int)$row['lkey']], 
						$this->message($fieldArray, $event, (int)$row['lkey']), 
						$this->sender
					);
				}
			} 
		}
	}
	
	protected function mail_typo($to, $subject, $message, $from, $cc='', $bcc='',$attachments=array()){
		$mail = t3lib_div::makeInstance('t3lib_mail_Message');
		$mail->setFrom(array($from));
		$mail->setTo(array($to));
		$mail->setSubject($subject);
		$mail->setBody($message);
		if(!empty($cc)){
			$ccs = explode(',', $cc);
			foreach($ccs as $c){
				$mail->addCc(trim($c));
			}
		}
		if(!empty($bcc)){
			$bccs = explode(',', $bcc);
			foreach($bccs as $bc){
				$mail->addBcc(trim($bc));
			}
		}
		
		foreach($attachments as $attachment){
			if(is_file($attachment)){
				$attachment = Swift_Attachment::fromPath($attachment);
				$mail->attach($attachment);
			}
		}
		$mail->send();
	}
	
	/*
		Mailteste Hier
	*/
	protected function message($fieldArray, $event, $lang){
		switch($lang){
			case 1:
				return 'Dein Status von event '.$event['title'].' ist '.$this->status_lang[$lang][$fieldArray['ppstatus']];
			default:
				return 'Your Status on event '.$event['title'].' is '.$this->status_lang[$lang][$fieldArray['ppstatus']];
		}
	}
	
}
?>