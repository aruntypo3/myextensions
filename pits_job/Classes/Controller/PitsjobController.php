<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Arun Chandran <arun.c@pitsolutions.com>, PIT Solutions Pvt Ltd.
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
 * @package pits_job
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PitsJob_Controller_PitsjobController extends Tx_Extbase_MVC_Controller_ActionController {

	
	public $pitsjobModel;
	public $pageId;
	public $languageUid;

    public function __construct() {
        $this->pitsjobModel = new Tx_PitsJob_Domain_Model_Pitsjob();
        $this->pageId = $GLOBALS['TSFE']->id;
        $this->languageUid = $GLOBALS['TSFE']->sys_language_uid;
    }
	
	/**
	 * action adform
	 *
	 * @return void
	 */
	public function adformAction() {

		$this->contentObj = $this->configurationManager->getContentObject();
		$storagePid = $this->contentObj->data['pages'];
		$categoryListData = $this->pitsjobModel->listCategory( $storagePid, $this->languageUid );

		$submitValues = $this->request->getArguments();
		if ( isset( $submitValues[ 'submit' ] ) ) {
			$flag_check = true;
			if ( $submitValues[ 'job_title' ] == "" ) {
				$error_title =  Tx_Extbase_Utility_Localization::translate('mandatory', 'pitsJob');
				$this->view->assign( 'title_error', $error_title );
				$flag_check = false;						
			}

			if ( $submitValues[ 'category' ] == 0 ) {
				$error_text =  Tx_Extbase_Utility_Localization::translate('category_mandatory', 'pitsJob');
				$this->view->assign( 'cat_mandatory', $error_text );
				$flag_check = false;						
			}
			
			if ( $submitValues[ 'contact_name' ] == "" ) {
				$error_title =  Tx_Extbase_Utility_Localization::translate('mandatory', 'pitsJob');
				$this->view->assign( 'name_title_error', $error_title );
				$flag_check = false;						
			}
			
			if ( $submitValues[ 'email' ] == "" ) {
				$error_contactemail = Tx_Extbase_Utility_Localization::translate('mandatory', 'pitsJob');
				$this->view->assign( 'contact_email_error', $error_contactemail );
				$flag_check = false;															
			}else if ( ( $submitValues[ 'email' ] != "" ) && ( !filter_var ( $submitValues[ 'email' ], FILTER_VALIDATE_EMAIL ) ) ) {
				$error_contactemail = Tx_Extbase_Utility_Localization::translate('invalid_mail', 'pitsJob');
				$this->view->assign( 'contact_email_error', $error_contactemail );
				$flag_check = false;												
			}
			
			if ( ( $submitValues[ 'telephone' ] != "" ) && ( !preg_match ( '/^[+ 0-9 ]+$/', $submitValues[ 'telephone' ] ) ) ) {
				$error_contactmobile = Tx_Extbase_Utility_Localization::translate('invalid_phone', 'pitsJob');
				$this->view->assign( 'contact_mobile_error', $error_contactmobile );
				$flag_check = false;													
			}
			
			// Setting of session variables
			$GLOBALS["TSFE"]->fe_user->setKey( "ses","submit_values", $submitValues );
			$GLOBALS["TSFE"]->fe_user->sesData_change = true;
			$GLOBALS["TSFE"]->fe_user->storeSessionData();
			
			$this->view->assign( 'ses_Submitval', $submitValues );
			
			// Redirect to next action
			if ( $flag_check == true ) {
					$this->forward( 'success' );
			}
	    }
	    $this->view->assign('categorylist', $categoryListData);
	}
	
	/**
	 * action success
	 *
	 * @param Tx_PitsJob_Domain_Model_Pitsjob $pitsjob
	 * @return void
	 */
	public function successAction() {
		$submitValues = $this->request->getArguments();
		$this->contentObj = $this->configurationManager->getContentObject();
		$storagePid = $this->contentObj->data['pages'];
		
		//Array to be inserted
		$insertArray = array();
		$insertArray[ 'pid' ] = ( !empty ( $storagePid ) ) ? $storagePid : $this->pageId;
		$insertArray[ 'job_date' ] = strtotime(date('d-m-Y'));
		$insertArray[ 'category_id' ] = $submitValues[ 'category' ];
		$insertArray[ 'job_title' ] = $submitValues[ 'job_title' ];
		$insertArray[ 'hidden' ] = 1;
		$insertArray[ 'short_description' ] = $submitValues[ 'short_text' ];
		$insertArray[ 'detail_description' ] = $submitValues['detail_text'];
		$insertArray[ 'contact_info' ] = $submitValues[ 'contact_info' ];
		$insertArray[ 'job_check' ] = $submitValues[ 'chiffre' ];
		$insertArray[ 'name' ] = $submitValues[ 'contact_name' ];
		$insertArray[ 'company' ] = $submitValues[ 'firma_name' ];
		$insertArray[ 'address' ] = $submitValues[ 'address' ];
		$insertArray[ 'zipcode' ] = $submitValues[ 'zipcode' ];
		$insertArray[ 'place' ] = $submitValues[ 'ort' ];
    	$insertArray[ 'country' ] = $submitValues[ 'country' ];
		$insertArray[ 'phone' ] = $submitValues[ 'telephone' ];
		$insertArray[ 'email' ] = $submitValues[ 'email' ];
		$insertArray[ 'web' ] = $submitValues[ 'web' ];
		$insertArray[ 'terms_agree' ] = $submitValues[ 'agree_terms' ];
		$insertArray[ 'tstamp' ] = time();
		
		$choose_categoryName = $this->pitsjobModel->jobCategory( $insertArray[ 'category_id' ], $storagePid, $this->languageUid );
		//Email Message Prepartion
		$mail_subject_text = Tx_Extbase_Utility_Localization::translate('mail_subject', 'pitsJob');
		$mail_subject = sprintf($mail_subject_text, $choose_categoryName, $insertArray[ 'job_title' ]);
		$adminEmail = explode(",", $this->settings['adminEmail'] );
		
		$message = '<html><body>';
		$message .= '<table cellpadding="3">';
		$message .= "<tr><td colspan = 3>".Tx_Extbase_Utility_Localization::translate('salutation_text', 'pitsJob')."</td></tr>";
		$message .= "<tr><td colspan = 3>".Tx_Extbase_Utility_Localization::translate('mail_text1', 'pitsJob')."</td></tr>";
		$message .= "<tr><td></td><td></td></tr>";
		
		$message .= "<tr><th style='text-align:left;'><strong>". Tx_Extbase_Utility_Localization::translate( 'mailjobinfo', 'pitsJob') ."</strong></th></tr>";
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('job_category', 'pitsJob')."</td>
						 <td>".$choose_categoryName."</td></tr>";
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('job_title', 'pitsJob')."</td>
						 <td>".$insertArray[ 'job_title' ]."</td></tr>";
		if ( !empty( $insertArray[ 'short_description' ] ) ){
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('short_text', 'pitsJob')."</td>
						 <td>".$insertArray[ 'short_description' ]."</td></tr>";
		}
		if ( !empty( $insertArray[ 'detail_description' ] ) ){
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('detail_text', 'pitsJob')."</td>
						 <td>".$insertArray[ 'detail_description' ]."</td></tr>";
		}
		if ( !empty( $insertArray[ 'contact_info' ] ) ){
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('contact_info', 'pitsJob')."</td>
						 <td>".$insertArray[ 'contact_info' ]."</td></tr>";
		}
		if ( !empty( $insertArray[ 'job_check' ] ) ){
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'chiffre', 'pitsJob' ) .":</td>
							 <td>" . Tx_Extbase_Utility_Localization::translate( 'chiffre_yes', 'pitsJob' ) . "</td></tr>";
		}else {
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'chiffre', 'pitsJob' ) .":</td>
							 <td>" . Tx_Extbase_Utility_Localization::translate( 'chiffre_no', 'pitsJob' ) . "</td></tr>";
		}
		$message .= "<tr><td></td><td></td></tr>";
		$message .= "<tr><td></td><td></td></tr>";
		$message .= "<tr><th style='text-align:left;'><strong>". Tx_Extbase_Utility_Localization::translate( 'mailcontactinfo', 'pitsJob') ."</strong></th></tr>";
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('contact_name', 'pitsJob')."</td>
						 <td>".$insertArray[ 'name' ]."</td></tr>";
		if ( !empty( $insertArray[ 'company' ] ) ){
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('firma_name', 'pitsJob')."</td>
						 <td>".$insertArray[ 'company' ]."</td></tr>";
		}
		if ( !empty( $insertArray[ 'address' ] ) ){
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('address', 'pitsJob')."</td>
						 <td>".$insertArray[ 'address' ]."</td></tr>";
		}
		if ( !empty( $insertArray[ 'zipcode' ] ) ){
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('zipcode', 'pitsJob')."</td>
						 <td>".$insertArray[ 'zipcode' ]."</td></tr>";
		}
		if ( !empty( $insertArray[ 'place' ] ) ){
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('ort', 'pitsJob')."</td>
						 <td>".$insertArray[ 'place' ]."</td></tr>";
		}
    if ( !empty( $insertArray[ 'country' ] ) ){
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('country', 'pitsJob')."</td>
						 <td>".$insertArray[ 'country' ]."</td></tr>";
		}
		if ( !empty( $insertArray[ 'phone' ] ) ){
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('telephone', 'pitsJob')."</td>
						 <td>".$insertArray[ 'phone' ]."</td></tr>";
		}
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('email', 'pitsJob')."</td>
						 <td>".$insertArray[ 'email' ]."</td></tr>";
		if ( !empty( $insertArray[ 'web' ] ) ){
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('web', 'pitsJob')."</td>
						 <td>".$insertArray[ 'web' ]."</td></tr>";
		}
		if ( !empty( $insertArray[ 'terms_agree' ] ) ){
		$message .= "<tr><td>".Tx_Extbase_Utility_Localization::translate('agree_terms', 'pitsJob')."</td>
						 <td>".Tx_Extbase_Utility_Localization::translate( 'chiffre_yes', 'pitsJob' )."</td></tr>";
		}
		
		$message .= "</table>";
		$message .= "</body></html>";

		$mail = t3lib_div::makeInstance('t3lib_mail_Message');
		if( !empty ( $insertArray ) ){
			$mail->setFrom( $insertArray[ 'email' ] )
			 	 ->setTo( $adminEmail )
			 	 ->setSubject($mail_subject)
		     	 ->setBody($message,'text/html')
		     	 ->send();
			
		   $resInsert = $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'tx_pitsjob_domain_model_pitsjob', $insertArray );
		   // Unset session variables
		   $product_info = $GLOBALS["TSFE"]->fe_user->setKey( "ses","submit_values", array() );
		}
		//$userMsg = Tx_Extbase_Utility_Localization::translate('usermsg_text', 'pitsJob');
		//$this->view->assign('user_msg', $userMsg);
	}

	/**
	 * action list
	 *
	 * @param Tx_PitsJob_Domain_Model_Pitsjob $pitsjob
	 * @return void
	 */
	public function listAction() {
		
		$this->contentObj = $this->configurationManager->getContentObject();
		$storagePid = $this->contentObj->data['pages'];
		$selectedCat = $this->settings['categorySelect'];
		$detailPid = $this->settings['detailPage'];
		$list['currentUrl'] = $this->urlPreparation( $detailPid );
		$list['categoryName'] = $this->pitsjobModel->jobCategory( $selectedCat, $storagePid, $this->languageUid );

		$jobListView = $this->pitsjobModel->jobList( $selectedCat, $storagePid, $this->languageUid );
		if( !empty( $jobListView ) ){
				$this->view->assign('jobListArray', $jobListView);
		}else{
				$noResults = Tx_Extbase_Utility_Localization::translate('no_items', 'pitsJob');
       			$this->flashMessageContainer->add($noResults);
		}
		$this->view->assign('listData', $list);
	}
	
	/**
	 * action detail
	 *
	 * @param Tx_PitsJob_Domain_Model_Pitsjob $pitsjob
	 * @return void
	 */
	public function detailAction() {
		$submitJobData = $this->request->getArguments();
		$this->contentObj = $this->configurationManager->getContentObject();
		$storagePid = $this->contentObj->data['pages'];
 		$jobDetailView = $this->pitsjobModel->jobDetail( $submitJobData['jobId'], $storagePid, $this->languageUid );
 		$categoryName = $this->pitsjobModel->jobCategory( $submitJobData['catId'], $storagePid, $this->languageUid );
		$this->view->assign('jobDetail', $jobDetailView);
		$this->view->assign('categoryName', $categoryName);
	}
	
	/**
	 * action latest
	 *
	 * @param Tx_PitsJob_Domain_Model_Pitsjob $pitsjob
	 * @return void
	 */
	public function latestAction() {
		
                $latestViewTemplate = $this->settings['latestViewTemplate'];
                if ( !empty( $latestViewTemplate ) && file_exists( $latestViewTemplate ) ) {
                     $this->view->setTemplatePathAndFilename( $latestViewTemplate );
                }
                $this->contentObj = $this->configurationManager->getContentObject();
		$storagePid = $this->contentObj->data['pages'];
		$detailPid = $this->settings['detailPage'];
		$alljobsPid = $this->settings['alljobsPage'];
		$adformPid = $this->settings['adformPage'];
		$listItemCount = (!empty ($this->settings['latestJobItems'])) ? $this->settings['latestJobItems'] : 5;
		$selectedCatLatest = $this->settings['categorySelect'];
	
		$latest['detailUrl'] = $this->urlPreparation( $detailPid );
		$latest['alljobUrl'] = $this->urlPreparation( $alljobsPid );
		$latest['adformUrl'] = $this->urlPreparation( $adformPid );
                
		$jobLatestView = $this->pitsjobModel->jobLatest( $listItemCount, $selectedCatLatest, $storagePid, $this->languageUid );
		if( !empty( $jobLatestView ) ){
			$this->view->assign('jobLatestArray', $jobLatestView);
		}else{
			$noResults = Tx_Extbase_Utility_Localization::translate('no_items', 'pitsJob');
       			$this->flashMessageContainer->add($noResults);
		}
		$this->view->assign('latestData', $latest);
	}
	
	/**
	 * action urlPreparation
	 *
	 * @param Tx_PitsJob_Domain_Model_Pitsjob $pitsjob
	 * @return void
	 */
	public function urlPreparation( $pageId ){
		$conf = array(
                'parameter' => $pageId,
                'returnLast' => 'url',
    		    ); 
    	return $GLOBALS['TSFE']->baseUrl.$this->contentObj->typoLink('', $conf);
	}
}
?>
