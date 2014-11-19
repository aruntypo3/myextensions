<?php 
class pits_emailsender extends tx_scheduler_Task {

	public function execute() {
		$date  = date('Y-m-d');
		$previous = date('Y-m-d', strtotime('-1 day', strtotime($date)) ) ;
	
		
		
		
		$date  = date('Y-m-d', strtotime(' -1 day'));
		//echo $date; exit;
		//$date = date('Y-m-d', strtotime('-1 day', strtotime($date)) ) ;
		//echo $date; exit;
		
		$where = " DATE_FORMAT ( FROM_UNIXTIME( tx_pitsupdatefeuser_ending ) , '%Y-%m-%d' ) = '".$date."' AND disable = 0 AND deleted =0 " ;
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1 ;
		$data = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows 	( 	  	"*",
				'fe_users',
				$where,
				$groupBy = '',
				$orderBy = '',
				$limit = '',
				$uidIndexField = ''
		);
	
		$fromEmail = "web@cyclinfo.ch";
		$fromName = "Cyclinfo";
		#echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery; exit;
		
		$mail = t3lib_div::makeInstance('t3lib_mail_Message');
		
		$mail->setFrom(array($fromEmail => $fromName));
		foreach (  $data  as $key=> $users ){
			$name = $users['name'];
			$subject  = $GLOBALS['LANG']->sL('LLL:EXT:pits_emailsender/locallang_db.xml:tx_pits_emailsender.emailsubject');
			$emailmessgae  = $GLOBALS['LANG']->sL('LLL:EXT:pits_emailsender/locallang_db.xml:tx_pits_emailsender.emailmessgae');
			$emailmessgae = sprintf( $emailmessgae , $name );
			#echo $emailmessgae; exit;
			$toEmail =  $users['email'];
			$toName =  $users['name'];
			$mail->setTo(array($toEmail => $toName));
			$mail->setSubject($subject);
			$mail->setBody($emailmessgae , 'text/html' );
			$mail->send();
		}
		return true;
	}

}
?>