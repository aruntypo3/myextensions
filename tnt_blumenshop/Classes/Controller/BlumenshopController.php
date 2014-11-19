<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Arun Chandran <arun@tnt-graphics.ch>, TNT Graphics
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
 * @package tnt_blumenshop
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_TntBlumenshop_Controller_BlumenshopController extends Tx_Extbase_MVC_Controller_ActionController {

	public $tntblumenshopModel;
	
	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		 $this->tntblumenshopModel = new Tx_TntBlumenshop_Domain_Model_Blumenshop();
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		//	Fetch flexform content
		$flexformArray = $this->settings[ 'flexform' ];
		if( $flexformArray[ 'payment_message' ] == 1 ) {
       return $this->insertSuccess();    
		}else{
      $catCheck = ( !empty( $flexformArray[ "cat" ] ) ) ? 'category IN ( '.$flexformArray[ "cat" ].' ) AND' : '';
  		$res = $this->tntblumenshopModel->getProducts( $catCheck );
  		
  		$this->view->assign( 'listimgW', $this->settings[ 'listimgW' ] );
  		$this->view->assign( 'listimgH', $this->settings[ 'listimgH' ] );
  		$this->view->assign( 'flexformArray', $flexformArray );
  		$this->view->assign( 'imageArray', $res );
    }
    
    // Unset session variables
  	$product_info = $GLOBALS["TSFE"]->fe_user->setKey( "ses","product_info", NULL );
  	$contact_info = $GLOBALS["TSFE"]->fe_user->setKey( "ses","contact_info", NULL );
	}

	/**
	 * action show
	 *
	 * @param $products
	 * @return void
	 */
	public function showAction() {
		$pId = $GLOBALS['TSFE']->id;
		$args = $this->request->getArguments();
		$uid = ( !empty( $args[ 'product_uid' ] ) ) ? $args[ 'product_uid' ] : $args[ 'uid' ];
		$res = $this->tntblumenshopModel->getSelectProduct( $uid );
		$flexformArray = $this->settings[ 'flexform' ];
	
		// Retrieve the session variables
		$get_productinfo = $GLOBALS["TSFE"]->fe_user->getKey( "ses","product_info" );
		if ( !empty( $get_productinfo ) ) {
			$this->view->assign( 'ses_username', $get_productinfo[ 'user_name' ] );
			$this->view->assign( 'ses_firstname', $get_productinfo[ 'user_firstname' ] );
			$this->view->assign( 'ses_wohnort', $get_productinfo[ 'user_wohnort' ] );
			$this->view->assign( 'ses_price', $get_productinfo[ 'price' ] );
			$this->view->assign( 'special_request', $get_productinfo[ 'special_request' ] );
			$this->view->assign( 'ses_priceextra', $get_productinfo[ 'priceextra' ] );
			$this->view->assign( 'special_comments', $get_productinfo[ 'special_comments' ] );
		}
		if ( isset( $args[ 'submit' ] ) ) {
			$flag_check = true;
			if ( $args[ 'user_name' ] == "" ) {
				$error_username = Tx_Extbase_Utility_Localization::translate( 'mandatory',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'username_error', $error_username );
				$flag_check = false;															
			}
			if ( $args[ 'user_firstname' ] == "" ) {
				$error_firstname = Tx_Extbase_Utility_Localization::translate( 'mandatory',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'firstname_error', $error_firstname );
				$flag_check = false;															
			}
			if ( $args[ 'price' ] == "" ) {
				$error_price = Tx_Extbase_Utility_Localization::translate( 'price_error',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'price_error', $error_price );
				$flag_check = false;															
			}
			if ( $args[ 'priceextra' ] == "" ) {
				$error_priceextra = Tx_Extbase_Utility_Localization::translate( 'priceextra_error',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'priceextra_error', $error_priceextra );
				$flag_check = false;															
			}	
			$product_info = array();
			$product_info[ 'user_name' ] = $args[ 'user_name' ];
			$product_info[ 'user_firstname' ] = $args[ 'user_firstname' ];
			$product_info[ 'user_wohnort' ] = $args[ 'user_wohnort' ];
			$product_info[ 'price' ] = $args[ 'price' ];
			$product_info[ 'uid' ] = $args[ 'uid' ];
			$product_info[ 'priceextra' ] = $args[ 'priceextra' ];
			$product_info[ 'special_request' ] = $args[ 'special_request' ];
			$product_info[ 'special_comments' ] = $args[ 'special_comments' ];
			$product_info[ 'submit' ] = $args[ 'submit' ];
			$product_info[ 'page_id' ] = $pId;
			$product_info[ 'admin_email' ] = $flexformArray['admin_email'];
			$product_info[ 'from_email' ] = $flexformArray[ 'from_email' ];
			$product_info[ 'extraprice1' ] = $flexformArray[ 'price_extra1' ];
			$product_info[ 'extraprice2' ] = $flexformArray[ 'price_extra2' ];
			
			// Setting of session variables
			$GLOBALS["TSFE"]->fe_user->setKey( "ses","product_info", $product_info );
			$GLOBALS["TSFE"]->fe_user->sesData_change = true;
			$GLOBALS["TSFE"]->fe_user->storeSessionData();
			
			$this->view->assign( 'ses_username', $product_info['user_name'] );
			$this->view->assign( 'ses_firstname', $product_info['user_firstname'] );
			$this->view->assign( 'ses_wohnort', $product_info['user_wohnort'] );
			$this->view->assign( 'ses_price', $product_info['price'] );
			$this->view->assign( 'special_request', $product_info['special_request'] );
			$this->view->assign( 'ses_priceextra', $product_info['priceextra'] );
			$this->view->assign( 'special_comments', $product_info['special_comments'] );
			
			// Redirect to next action
			if ( $flag_check == true ) {
				$this->redirect( 'contact', 'Blumenshop', NULL, array( 'product_uid' => $product_info[ 'uid' ] ) );
			}
		}
	
		$this->view->assign( 'flexformArray', $flexformArray );
		$this->view->assign( 'productArray', $res );
		$this->view->assign( 'detailimgW', $this->settings[ 'detailimgW' ] );
  		$this->view->assign( 'detailimgH', $this->settings[ 'detailimgH' ] );
	}
	
/**
	 * action contact
	 *
	 * @param $products
	 * @return void
	 */
	public function contactAction() {
		
		$productInfo = $GLOBALS["TSFE"]->fe_user->getKey( "ses","product_info" );
		$flexformArray = $this->settings[ 'flexform' ];
		$get_args = $this->request->getArguments();
		$priceExtra = ( $productInfo[ 'priceextra' ] == 1 ) ? 0 : $productInfo[ 'priceextra' ];
		$totalAmount_float = floatval( $productInfo[ 'price' ] ) + floatval( $priceExtra ) + floatval( $this->settings[ 'fixedPrice' ] );
		$totalAmount = number_format($totalAmount_float,2,"."," ");
		$selectArray = array( "VIS" => "VISA", "ECA" => "MasterCard", "PFC" => "Swiss PostFinance - PostFinance Card" );
		$res = $this->tntblumenshopModel->getSelectProduct( $productInfo['uid'] );
				
		// Retrieve the session variables
		$get_contactinfo = $GLOBALS["TSFE"]->fe_user->getKey( "ses","contact_info" );
		if ( !empty( $get_contactinfo ) ) {
			$this->view->assign( 'ses_contactname', $get_contactinfo[ 'contact_name' ] );
			$this->view->assign( 'ses_contactfirstname', $get_contactinfo[ 'contact_firstname' ] );
			$this->view->assign( 'ses_contactfirma', $get_contactinfo[ 'contact_firma' ] );
			$this->view->assign( 'contact_strasse', $get_contactinfo[ 'contact_strasse' ] );
			$this->view->assign( 'contact_ort1', $get_contactinfo[ 'contact_ort1' ] );
			$this->view->assign( 'contact_ort2', $get_contactinfo[ 'contact_ort2' ] );
			$this->view->assign( 'ses_paymentOptions', $get_contactinfo[ 'paymentOptions' ] );
			$this->view->assign( 'contact_telefon', $get_contactinfo[ 'contact_telefon' ] );
			$this->view->assign( 'contact_mobile', $get_contactinfo[ 'contact_mobile' ] );
			$this->view->assign( 'contact_email', $get_contactinfo[ 'contact_email' ] );
			$this->view->assign( 'ses_doccheck', $get_contactinfo[ 'doc_check' ] );
		}
		if ( isset( $get_args[ 'submit' ] ) ) {
			$error_check = true;
			if ( $get_args[ 'contact_name' ] == "" ) {
				$error_contactusername = Tx_Extbase_Utility_Localization::translate( 'mandatory',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'contact_name_error', $error_contactusername );
				$error_check = false;															
			}
			if ( $get_args[ 'contact_firstname' ] == "" ) {
				$error_contactfirstname = Tx_Extbase_Utility_Localization::translate( 'mandatory',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'contact_firstname_error', $error_contactfirstname );
				$error_check = false;															
			}
			if ( $get_args[ 'contact_strasse' ] == "" ) {
				$error_contactstrasse = Tx_Extbase_Utility_Localization::translate( 'mandatory',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'contact_strasse_error', $error_contactstrasse );
				$error_check = false;															
			}
			if ( $get_args[ 'contact_ort1' ] == "" ) {
				$error_contactort1 = Tx_Extbase_Utility_Localization::translate( 'mandatory',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'contact_ort_error', $error_contactort1 );
				$error_check = false;															
			} else if ( $get_args[ 'contact_ort2' ] == "" ) {
				$error_contactort2 = Tx_Extbase_Utility_Localization::translate( 'mandatory',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'contact_ort_error', $error_contactort2 );
				$error_check = false;															
			}
			if ( $_POST[ 'paymentoptions' ] == "" ) {
				$error_paymentOptions = Tx_Extbase_Utility_Localization::translate( 'select_card_error',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'payment_method_error', $error_paymentOptions );
				$error_check = false;															
			}
			if ( $get_args[ 'contact_telefon' ] == "" ) {
				$error_contacttelefon = Tx_Extbase_Utility_Localization::translate( 'mandatory',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'contact_telefon_error', $error_contacttelefon );
				$error_check = false;																
			} else if ( ( $get_args[ 'contact_telefon' ] != "" ) && ( !preg_match( '/^[+ 0-9 ]+$/', $get_args[ 'contact_telefon' ] ) ) ) {
				$error_contacttelefon = Tx_Extbase_Utility_Localization::translate( 'invalid_phone',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'contact_telefon_error', $error_contacttelefon );
				$error_check = false;													
			}
			if ( ( $get_args[ 'contact_mobile' ] != "" ) && ( !preg_match ( '/^[+ 0-9 ]+$/', $get_args[ 'contact_mobile' ] ) ) ) {
				$error_contactmobile = Tx_Extbase_Utility_Localization::translate( 'invalid_phone',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'contact_mobile_error', $error_contactmobile );
				$error_check = false;													
			}
			if ( $get_args[ 'contact_email' ] == "" ) {
				$error_contactemail = Tx_Extbase_Utility_Localization::translate( 'mandatory',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'contact_email_error', $error_contactemail );
				$error_check = false;															
			}else if ( ( $get_args[ 'contact_email' ] != "" ) && ( !filter_var ( $get_args[ 'contact_email' ], FILTER_VALIDATE_EMAIL ) ) ) {
				$error_contactemail = Tx_Extbase_Utility_Localization::translate( 'invalid_email',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL );
				$this->view->assign( 'contact_email_error', $error_contactemail );
				$error_check = false;												
			}

			$contact_info = array();
			$contact_info[ 'contact_name' ] = $get_args[ 'contact_name' ];
			$contact_info[ 'contact_firstname' ] = $get_args[ 'contact_firstname' ];
			$contact_info[ 'contact_firma' ] = $get_args[ 'contact_firma' ];
			$contact_info[ 'contact_strasse' ] = $get_args[ 'contact_strasse' ];
			$contact_info[ 'contact_ort1' ] = $get_args[ 'contact_ort1' ];
			$contact_info[ 'contact_ort2' ] = $get_args[ 'contact_ort2' ];
			$contact_info[ 'paymentOptions' ] = $_POST[ 'paymentoptions' ];
			$contact_info[ 'contact_telefon' ] = $get_args[ 'contact_telefon' ];
			$contact_info[ 'contact_mobile' ] = $get_args[ 'contact_mobile' ];
			$contact_info[ 'contact_email' ] = $get_args[ 'contact_email' ];
			$contact_info[ 'total_price' ] = $totalAmount;
			$contact_info[ 'fixed_price' ] = number_format($this->settings[ 'fixedPrice' ],2,"."," ");
			$contact_info[ 'ip_address' ] = $_SERVER[ 'REMOTE_ADDR' ];
			$contact_info[ 'doc_check' ] = $get_args[ 'doc_check' ];
			$contact_info[ 'useragentMobileCheck' ] = $this->detectMobile();
			
			// Setting of session variables
			$GLOBALS["TSFE"]->fe_user->setKey( "ses","contact_info", $contact_info );
			$GLOBALS["TSFE"]->fe_user->sesData_change = true;
			$GLOBALS["TSFE"]->fe_user->storeSessionData();

			$this->view->assign( 'ses_contactname', $contact_info[ 'contact_name' ] );
			$this->view->assign( 'ses_contactfirstname', $contact_info[ 'contact_firstname' ] );
			$this->view->assign( 'ses_contactfirma', $contact_info[ 'contact_firma' ] );
			$this->view->assign( 'contact_strasse', $contact_info[ 'contact_strasse' ] );
			$this->view->assign( 'contact_ort1', $contact_info[ 'contact_ort1' ] );
			$this->view->assign( 'contact_ort2', $contact_info[ 'contact_ort2' ] );
			$this->view->assign( 'ses_paymentOptions', $contact_info[ 'paymentOptions' ] );
			$this->view->assign( 'contact_telefon', $contact_info[ 'contact_telefon' ] );
			$this->view->assign( 'contact_mobile', $contact_info[ 'contact_mobile' ] );
			$this->view->assign( 'contact_email', $contact_info[ 'contact_email' ] );
			
			// Redirect to next action
			if ( $error_check == true ) {
				$this->redirect( 'payment', 'Blumenshop', NULL, array( 'product_uid' => $productInfo['uid'] ) );
			}
		}

		$this->view->assign( 'flexformArray', $flexformArray );
		$this->view->assign( 'ses_nameInfo', $productInfo[ 'user_name' ] );
		$this->view->assign( 'ses_vornameInfo', $productInfo[ 'user_firstname' ] );
		$this->view->assign( 'ses_wohnortInfo', $productInfo[ 'user_wohnort' ] );
		$this->view->assign( 'ses_priceInfo', $productInfo[ 'price' ] );
		$this->view->assign( 'paymentOptions', $selectArray );
		$this->view->assign( 'ses_priceextraInfo', number_format( $priceExtra, 2, ".", "" ) );
		$this->view->assign( 'ses_specialrequestInfo', $productInfo[ 'special_request' ] );
		$this->view->assign( 'ses_specialcommentsInfo', $productInfo[ 'special_comments' ] );
		$this->view->assign( 'fixedPrice', number_format($this->settings[ 'fixedPrice' ],2,"."," ") );
		$this->view->assign( 'totalAmt', $totalAmount );
		$this->view->assign( 'timestampJS', time() );
		$this->view->assign( 'productinfoContact', $res );
		$this->view->assign( 'detailimgW', $this->settings[ 'detailimgW' ] );
  		$this->view->assign( 'detailimgH', $this->settings[ 'detailimgH' ] );
	}
	
	/**
	 * action payment
	 *
	 * @param $products
	 * @return void
	 */
	public function paymentAction() {
		$flexformArray = $this->settings['flexform'];
		$refNum = time();
		$get_paymentcontactinfo = $GLOBALS["TSFE"]->fe_user->getKey( "ses","contact_info" );
		$totalAmt = bcmul ( $get_paymentcontactinfo[ 'total_price' ], 100 );
		$this->view->assign( 'totalprice', $totalAmt );
		$this->view->assign( 'refno', $refNum );
		$this->view->assign( 'currency', $this->settings[ 'currency' ] );
		$this->view->assign( 'paymenyOption', $get_paymentcontactinfo[ 'paymentOptions' ] );
		$this->view->assign( 'useragentMobileCheck', $get_paymentcontactinfo[ 'useragentMobileCheck' ] );
		$this->view->assign( 'flexformArray', $flexformArray );
	}
	
	/**
	 * action insertSuccess
	 *
	 * @param $products
	 * @return array
	 */
	public function insertSuccess() {

		$insert_productinfo = $GLOBALS["TSFE"]->fe_user->getKey( "ses","product_info" );
		$insert_contactinfo = $GLOBALS["TSFE"]->fe_user->getKey( "ses","contact_info" );
		$conf = unserialize ( $GLOBALS[ 'TYPO3_CONF_VARS' ][ 'EXT' ][ 'extConf' ][ 'tnt_blumenshop' ] );
		$totalAmount = number_format($_POST[ 'amount' ] / 100,2,"."," ");
		$priceExtra = ( $insert_productinfo[ 'priceextra' ] == 1 ) ? 0 : $insert_productinfo[ 'priceextra' ];
		
		$insertArray = array();
		$insertArray[ 'pid' ] = ( !empty ( $conf[ 'storage_id' ] ) ) ? $conf[ 'storage_id' ] : $insert_productinfo['page_id'];
		$insertArray[ 'tstamp' ] = time();
		$insertArray[ 'patient_name' ] = $insert_productinfo[ 'user_name' ];
		$insertArray[ 'patient_vorname' ] = $insert_productinfo[ 'user_firstname' ];
		$insertArray[ 'patient_wohnort' ] = $insert_productinfo[ 'user_wohnort' ];
		$insertArray[ 'total_price' ] = $totalAmount;
		$insertArray[ 'product' ] = $insert_productinfo[ 'uid' ];
		$insertArray[ 'special_requests' ] = $insert_productinfo[ 'special_request' ];
		$insertArray[ 'special_comments' ] = $insert_productinfo[ 'special_comments' ];
		$insertArray[ 'transaction_id' ] = $_POST[ 'uppTransactionId' ];
		$insertArray[ 'reference_number' ] = $_POST[ 'refno' ];
		$insertArray[ 'name' ] = $insert_contactinfo[ 'contact_name' ];
		$insertArray[ 'vorname' ] = $insert_contactinfo[ 'contact_firstname' ];
		$insertArray[ 'company' ] = $insert_contactinfo[ 'contact_firma' ];
		$insertArray[ 'street' ] = $insert_contactinfo[ 'contact_strasse' ];
		$insertArray[ 'zip' ] = $insert_contactinfo[ 'contact_ort1' ];
		$insertArray[ 'land' ] = $insert_contactinfo[ 'contact_ort2' ];
		$insertArray[ 'phone' ] = $insert_contactinfo[ 'contact_telefon' ];
		$insertArray[ 'mobile' ] = $insert_contactinfo[ 'contact_mobile' ];
		$insertArray[ 'email' ] = $insert_contactinfo[ 'contact_email' ];
		$insertArray[ 'ip_address' ] = $insert_contactinfo[ 'ip_address' ];
		$insertArray[ 'trans_status' ] = $_POST[ 'status' ];
		$insertArray[ 'document_check' ] = ( !empty( $insert_contactinfo[ 'doc_check' ] ) ) ? $insert_contactinfo[ 'doc_check' ] : 0;

    if( !empty ( $insertArray[ 'trans_status' ] ) && !empty( $insertArray[ 'email' ] ) ) {
		      $res_product_title = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('title','tx_tntblumenshop_products','uid = '.$insertArray[ 'product' ]);
          $productTitle = $res_product_title[0]['title'];
    }else{
          $productTitle = $insertArray[ 'product' ]; 
    }      
		
		// Email Subject
		$mail_subject = Tx_Extbase_Utility_Localization::translate( 'mail_subject',
																	$this->request->getControllerExtensionName(),
																	$arguments=NULL )." ".$insertArray[ 'vorname' ]." ".$insertArray[ 'name' ];
		// Email message body													
		$message = '<html><body>';
		$message .= '<table cellpadding="3">';
		$message .= "<tr><th style='text-align:left;'><strong>". Tx_Extbase_Utility_Localization::translate( 'mail_productinfo',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) ."</strong></th></tr>";
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'mail_patientname',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'patient_name' ] . "</td></tr>";
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'mail_patientvorname',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'patient_vorname' ] . "</td></tr>";
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'mail_patientwohnort',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'patient_wohnort' ] . "</td></tr>";										
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'mail_amount',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" .$productTitle." (".Tx_Extbase_Utility_Localization::translate( 'mail_cat_amounttext',
												$this->request->getControllerExtensionName(),$arguments=NULL )." ".$insert_productinfo[ 'price' ].")"."</td></tr>";
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'special_request',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'special_requests' ] . "</td></tr>";
		
		if ( $priceExtra == $insert_productinfo[ 'extraprice1' ] ) {										
		
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'price_extramap',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . Tx_Extbase_Utility_Localization::translate( 'price_250',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) . "</td></tr>";												
		}else if ( $priceExtra == $insert_productinfo[ 'extraprice2' ] ) {
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'price_extramap',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . Tx_Extbase_Utility_Localization::translate( 'price_500',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) . "</td></tr>";
		}else {
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'price_extramap',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . Tx_Extbase_Utility_Localization::translate( 'price_0',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) . "</td></tr>";
		}
		
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'mail_textcart',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'special_comments' ] . "</td></tr>";
		
		$message .= "<tr><td></td><td></td></tr>";
		$message .= "<tr><td></td><td></td></tr>";
		$message .= "<tr><th style='text-align:left;'><strong>". Tx_Extbase_Utility_Localization::translate( 'mail_contactinfo',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) ."</strong></th></tr>";
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'contact_name',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'name' ] . "</td></tr>";
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'contact_firstname',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'vorname' ] . "</td></tr>";
		if ( !empty( $insertArray[ 'company' ] ) ){
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'contact_firma',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'company' ] . "</td></tr>";
		}										
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'contact_strasse',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'street' ] . "</td></tr>";
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'contact_ort',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'zip' ]." ". "/"." ". $insertArray[ 'land' ] . "</td></tr>";
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'contact_telefon',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'phone' ] . "</td></tr>";
		if ( !empty( $insertArray[ 'mobile' ] ) ){										
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'contact_mobile',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'mobile' ] . "</td></tr>";
		}
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'contact_email',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . $insertArray[ 'email' ] . "</td></tr>";
		if ( $insert_contactinfo['paymentOptions'] == "VIS" ){										
				$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'payment_method',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>". Tx_Extbase_Utility_Localization::translate( 'visa',
																			$this->request->getControllerExtensionName(),
																			$arguments=NULL ) ."</td></tr>";
		}else if( $insert_contactinfo['paymentOptions'] == "ECA" ){
				$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'payment_method',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>". Tx_Extbase_Utility_Localization::translate( 'master',
																			$this->request->getControllerExtensionName(),
																			$arguments=NULL ) ."</td></tr>";
		}else {
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'payment_method',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>". Tx_Extbase_Utility_Localization::translate( 'swisspostfinance',
																			$this->request->getControllerExtensionName(),
																			$arguments=NULL ) ."</td></tr>";
		}
		$message .= "<tr><td></td><td></td></tr>";
		$message .= "<tr><td></td><td></td></tr>";
		$message .= "<tr><th style='text-align:left;'><strong>". Tx_Extbase_Utility_Localization::translate( 'mail_pricedetails',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) ."</strong></th></tr>";
		
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'mail_price1',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>". Tx_Extbase_Utility_Localization::translate( 'labelprice',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) ." ". $insert_productinfo[ 'price' ] . "</td></tr>";
		
		if ( $priceExtra == $insert_productinfo[ 'extraprice1' ] ) {											
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'price_250',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>". Tx_Extbase_Utility_Localization::translate( 'labelprice',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) ." ". number_format($priceExtra,2,"."," ") . "</td></tr>";
		}else if ( $priceExtra == $insert_productinfo[ 'extraprice2' ] ){
			
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'price_500',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>". Tx_Extbase_Utility_Localization::translate( 'labelprice',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) ." ". number_format($priceExtra,2,"."," ") . "</td></tr>";
		}else {
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'price_0',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>". Tx_Extbase_Utility_Localization::translate( 'labelprice',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) ." ". number_format($priceExtra,2,"."," ") . "</td></tr>";
		}
		
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'mail_price3',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>". Tx_Extbase_Utility_Localization::translate( 'labelprice',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) ." ". number_format($insert_contactinfo[ 'fixed_price' ],2,"."," ") . "</td></tr>";
		$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'mail_price4',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td><b>". Tx_Extbase_Utility_Localization::translate( 'labelprice',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) ." ". $insertArray[ 'total_price' ] . "</b></td></tr>";

		$message .= "<tr><td></td><td></td></tr>";
		$message .= "<tr><td></td><td></td></tr>";
		
		if ( !empty( $insertArray[ 'document_check' ] ) ){
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'check_document',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . Tx_Extbase_Utility_Localization::translate( 'doc_yes',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) . "</td></tr>";
		}else {
			$message .= "<tr><td>". Tx_Extbase_Utility_Localization::translate( 'check_document',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) .":</td><td>" . Tx_Extbase_Utility_Localization::translate( 'doc_no',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ) . "</td></tr>";
		}
		
		$message .= "<tr><td></td><td></td></tr>";
		$message .= "<tr><td></td><td></td></tr>";
		$message .= "</table>";
		$message .= '<table cellpadding="3">';
		$message .= "<tr><td colspan=5>". Tx_Extbase_Utility_Localization::translate( 'static_mailtext',
												$this->request->getControllerExtensionName(),
												$arguments=NULL ). "</td></tr>";
																															
		$message .= "</table>";
		$message .= "</body></html>";

		// Insert all the above parameters to db & Send email to the admin after completion of transaction
		if( !empty ( $insertArray[ 'trans_status' ] ) && !empty( $insertArray[ 'email' ] ) ) {

      // Insert into DB
      $resInsert = $GLOBALS['TYPO3_DB']->exec_INSERTquery( 'tx_tntblumenshop_productlog', $insertArray );    
      
      // Send Email
      if( $insertArray[ 'trans_status' ] == "success" ) {
  			$admin_emails = explode(",", $insert_productinfo['admin_email'] );
  			$from_email = $insert_productinfo['from_email'];
  
  			$mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
  			$mail->setFrom( $from_email )
  				   ->setTo( $insertArray[ 'email' ] )
  				   ->setBcc( $admin_emails )	
  				   ->setSubject( $mail_subject )
  			     ->setBody( $message, 'text/html' )
  			     ->send();
		  }
		}

		// Unset session variables
		$product_info = $GLOBALS["TSFE"]->fe_user->setKey( "ses","product_info", NULL );
		$contact_info = $GLOBALS["TSFE"]->fe_user->setKey( "ses","contact_info", NULL );
    
    return;
	}
	
	/**
	 * action detectMobile
	 *
	 * @return void
	 */
	public function detectMobile(){
		$userAgent = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('HTTP_USER_AGENT');
		$mobileCheck = ( preg_match( '/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $userAgent ) ) ? 1 : 0;
   		return $mobileCheck;    
	}
}
?>