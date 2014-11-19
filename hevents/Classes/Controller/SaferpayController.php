<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Eric Depta <info@ericdepta.de>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package hevents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Hevents_Controller_SaferpayController extends Tx_Hevents_Controller_AbstractController {
	
	/**
	 * action payment
	 *
	 * @param Tx_Hevents_Domain_Model_Payment $payment
	 * @ignorevalidation $payment
	 * @return void
	 */
	public function paymentAction(){
		$a = ($_SERVER['QUERY_STRING']);
		$array=array();
		parse_str($a,$array);
		$DATA = $array['DATA'];
		$SIGNATURE = $array['SIGNATURE'];
		
		urldecode($DATA);
		urldecode($SIGNATURE);
		
		/* the hosting gateway URL to verify pay confirm */
		$gateway = $this->settings['saferpay']['paymentConfirmUrl'];
		$accountid = $this->settings['saferpay']['accountId']; /* saferpay account id */
		/* put it all together */
		$url = "$gateway?DATA=".urlencode($DATA)."&SIGNATURE=".urlencode($SIGNATURE);

		$dataArray = explode( " ", $_GET["DATA"] );
		$responseArray = array();
		foreach ( $dataArray as $key => $value ){
			$splitValues = explode( "=", $value );
			$responseArray[$splitValues[0]] = str_replace( '\"', '', $splitValues[1]);			
		}
		$responseData = array_filter( array_slice( $responseArray, 1 ) );
		$orderIdData = explode( '-', $responseData['ORDERID'] );
		$dateUid = intval( $orderIdData[1] );

		$availseatDetails = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('remainseats', 'tx_hevents_domain_model_date', 'uid='.$dateUid.' AND deleted = 0 AND hidden = 0');
		$bookedSeatDetails = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('amount', 'tx_hevents_domain_model_booking', 'ppref="'.$responseData["ORDERID"].'" AND deleted = 0 AND hidden = 0');
		$availableSeats = intval( $availseatDetails[0]['remainseats'] );
		$bookedSeats = intval( $bookedSeatDetails[0]['amount'] );
		$remainingSeats = intval( $availableSeats - $bookedSeats );
    	$bookedDetails = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'transstatus', 
                                                              'tx_hevents_domain_model_booking', 
                                                              'ppref = "'.$responseData['ORDERID'].'" AND deleted = 0 AND hidden = 0');
		/* verify pay confirm message at hosting server */
		$result = $this->curl( $url );
		if ( substr( $result, 0, 3 ) == "OK:" ){
			$statusMsg = Tx_Extbase_Utility_Localization::translate( 'tx_hevents_domain_model.successtrans', $this->request->getControllerExtensionName() );

			// Update booking data
      	if( empty( $bookedDetails[0]['transstatus'] ) ){
        	$GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_hevents_domain_model_date', 'uid='.intval( $orderIdData[1] ), 
												array('remainseats' => $remainingSeats));
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_hevents_domain_model_booking', 'ppref="'.$responseData['ORDERID'].'"', 
												array('transid' => $responseData['ID'], 'transstatus' => $_GET['status']));
          	//Email to Customer and Admin
          	$this->sendEmail( $responseData['ORDERID'] );	              
      	}
		$finalgateway = $this->settings['saferpay']['paymentCompleteUrl'];
		//Remove Password in live url
		$password = 'XAjc3Kna';
		$attributes = "spPassword=".$password."&ACCOUNTID=".$responseData['ACCOUNTID']."&ID=".urlencode($responseData['ID']);
		$finalurl = $finalgateway."?".$attributes;	
		$paymentComplete = $this->curl( $finalurl );
            	        
		}else if( $_GET['status'] == "failed" ){
			$statusMsg = Tx_Extbase_Utility_Localization::translate( 'tx_hevents_domain_model.failedtrans', $this->request->getControllerExtensionName() ); 
      		$GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_hevents_domain_model_booking', 'ppref="'.$_GET['orderNo'].'"', array('transstatus' => $_GET['status']));
    	}else{
			$statusMsg = Tx_Extbase_Utility_Localization::translate( 'tx_hevents_domain_model.cancelledtrans', $this->request->getControllerExtensionName() ); 
      		$GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_hevents_domain_model_booking', 'ppref="'.$_GET['orderNo'].'"', array('transstatus' => $_GET['status']));
    	}
		$this->view->assign('status', $statusMsg );
	}
	
	// Return Url Content 
	public function curl($url){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	    $data = curl_exec($ch);
	    curl_close($ch);
	    return $data;
	}
  
  // Send Email if transaction is success
  public function sendEmail( $orderID ){
      // Customer Email
      $baseUrl = $GLOBALS['TSFE']->baseUrl;
      $bookedData = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'name, forename, email, event, date', 
                                                              'tx_hevents_domain_model_booking', 
                                                              'ppref = "'.$orderID.'" AND deleted = 0 AND hidden = 0');                                     
      $eventDate =  $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'start, end, eventstarttime, eventendtime', 
                                                              'tx_hevents_domain_model_date', 
                                                              'uid= "'.$bookedData[0]['date'].'" AND deleted = 0 AND hidden = 0');
      $eventData =  $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( '*', 
                                                              'tx_hevents_domain_model_event', 
                                                              'uid= "'.$bookedData[0]['event'].'" AND deleted = 0 AND hidden = 0');                                                                                                              
      
      $separateImg = explode( ',', $eventData[0]['images']);
      
      $custEmailbody .= '<table cellspacing="0" cellpadding="0" border="0">';
      $custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $custEmailbody .= '<tr><td colspan="3">'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.salText", $this->request->getControllerExtensionName() ).'&nbsp;'.ucwords( $bookedData[0]["name"] )." ".ucwords( $bookedData[0]["forename"] ).',</td></tr>';
      $custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $custEmailbody .= '<tr><td colspan="3">'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.custThanksMsg", $this->request->getControllerExtensionName() ).'</td></tr>';
      $custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $custEmailbody .= '<tr><td colspan="3" style="font-size:36px"><b>'.$eventData[0]["title"].'</b></td></tr>';
	  $custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $custEmailbody .= '<tr><td colspan="3"><img src="'.$baseUrl.'uploads/tx_hevents/'.$separateImg[0].'" width="250" /></td></tr>';
 	  $custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $custEmailbody .= '<tr><td colspan="3"><b>'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.evenDescription", $this->request->getControllerExtensionName() ).'</b></td></tr>';
      $custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $custEmailbody .= '<tr><td colspan="3">'.$eventData[0]["description"].'</td></tr>';
      $custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $custEmailbody .= '<tr><td><b>'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.bookedDate", $this->request->getControllerExtensionName() ).'</b></td><td>&nbsp;:&nbsp;</td><td>'.date( "d.m.Y", $eventDate[0]["start"] )." - ".date( "d.m.Y", $eventDate[0]["end"] ).'</td></tr>';
      $custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
	  $custEmailbody .= '<tr><td><b>'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.bookedTime", $this->request->getControllerExtensionName() ).'</b></td><td>&nbsp;:&nbsp;</td><td>'.date( "H:i", $eventDate[0]["eventstarttime"] )." - ".date( "H:i", $eventDate[0]["eventendtime"] ).'</td></tr>';
      $custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      if( !empty( $eventData[0]["locationaddress"] ) ){
	      	$custEmailbody .= '<tr><td style="vertical-align:top;"><b>'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.locationAddress", $this->request->getControllerExtensionName() ).'</b></td><td style="vertical-align:top;">&nbsp;:&nbsp;</td><td>'.$eventData[0]["locationaddress"].'</td></tr>';
	      	$custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      }
      if( !empty( $eventData[0]["provider"] ) ){
	      	$custEmailbody .= '<tr><td style="vertical-align:top;"><b>'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.providerName", $this->request->getControllerExtensionName() ).'</b></td><td style="vertical-align:top;">&nbsp;:&nbsp;</td><td>'.$eventData[0]["provider"].'</td></tr>';
	      	$custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      }
      $custEmailbody .= '<tr><td colspan="3">'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.custAdditionalMsg", $this->request->getControllerExtensionName() ).'</td></tr>';
      $custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $custEmailbody .= '<tr><td colspan="3">'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.greetingsMsg", $this->request->getControllerExtensionName() ).'</td></tr>';
	  $custEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
	  $custEmailbody .= '<tr><td colspan="3"><img src="'.$baseUrl.'fileadmin/templates/img/logo.png" /></td></tr>';
      $custEmailbody .= '</table>';
      
      $custfromEmail = $this->settings['saferpay']['adminEmail'];
      $custfromName = $this->settings['saferpay']['adminName'];
      $custtoEmail = $bookedData[0]['email'];
      $custtoName = ucwords( $bookedData[0]["name"] )." ".ucwords( $bookedData[0]["forename"] );

      $custSubject = sprintf( Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.custSubject", $this->request->getControllerExtensionName() ), $eventData[0]["title"], date( "d.m.Y H:i", $eventDate[0]["start"] )." - ".date( "d.m.Y H:i", $eventDate[0]["end"] ) );
            
      $mail = t3lib_div::makeInstance( 't3lib_mail_message' );
	  $mail->setFrom( array( $custfromEmail => $custfromName ) );
	  $mail->setTo( array( $custtoEmail => $custtoName ) );
	  $mail->setSubject( $custSubject );
	  $mail->setBody( $custEmailbody, 'text/html' );
	  $mail->send();
      
      // Admin Email
      $adminEmailbody .= '<table cellspacing="0" cellpadding="0" border="0">';
      $adminEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $adminEmailbody .= '<tr><td colspan="3">'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.adminThanksMsg", $this->request->getControllerExtensionName() ).'</td></tr>';
      $adminEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $adminEmailbody .= '<tr><td>'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.adminCustName", $this->request->getControllerExtensionName() ).'</td><td>&nbsp;:&nbsp;</td><td>'.ucwords( $bookedData[0]["name"] )." ".ucwords( $bookedData[0]["forename"] ).'</td></tr>';
      $adminEmailbody .= '<tr><td>'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.bookedEvent", $this->request->getControllerExtensionName() ).'</td><td>&nbsp;:&nbsp;</td><td>'.$eventData[0]["title"].'</td></tr>';
      $adminEmailbody .= '<tr><td>'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.bookedDate", $this->request->getControllerExtensionName() ).'</td><td>&nbsp;:&nbsp;</td><td>'.date( "d.m.Y", $eventDate[0]["start"] )." - ".date( "d.m.Y", $eventDate[0]["end"] ).'</td></tr>';
      $adminEmailbody .= '<tr><td>'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.bookedTime", $this->request->getControllerExtensionName() ).'</td><td>&nbsp;:&nbsp;</td><td>'.date( "H:i", $eventDate[0]["eventstarttime"] )." - ".date( "H:i", $eventDate[0]["eventendtime"] ).'</td></tr>';
      $adminEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $adminEmailbody .= '<tr><td colspan="3">'.Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.greetingsMsg", $this->request->getControllerExtensionName() ).'</td></tr>';
      $adminEmailbody .= '<tr><td colspan="3">&nbsp;</td></tr>';
      $adminEmailbody .= '<tr><td colspan="3"><img src="'.$baseUrl.'fileadmin/templates/img/logo.png" /></td></tr>';
      $adminEmailbody .= '</table>';
            
      $adminfromEmail = $bookedData[0]['email'];
      $adminfromName = ucwords( $bookedData[0]["name"] )." ".ucwords( $bookedData[0]["forename"] );
      $admintoEmail = $this->settings['saferpay']['adminEmail'];
      $admintoName = $this->settings['saferpay']['adminName'];
      
      $adminSubject = sprintf( Tx_Extbase_Utility_Localization::translate( "tx_hevents_domain_model_booking.email.adminSubject", $this->request->getControllerExtensionName() ), $eventData[0]["title"], date( "d.m.Y H:i", $eventDate[0]["start"] )." - ".date( "d.m.Y H:i", $eventDate[0]["end"] ) );
            
      $mail = t3lib_div::makeInstance( 't3lib_mail_message' );
	  $mail->setFrom( array( $adminfromEmail => $adminfromName ) );
	  $mail->setTo( array( $admintoEmail => $admintoName ) );
	  $mail->setSubject( $adminSubject );
	  $mail->setBody( $adminEmailbody, 'text/html' );
      return $mail->send();
  }
}
?>