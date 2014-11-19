<?php

/***************************************************************
 *  Copyright notice
*
*  (c) 2013 Siva <sivaprasad.s@pitsolutions.com>, PIT Solutions Pvt Ltd
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
 * @package pits_stocklist
* @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
*
*/
class Tx_PitsStocklist_Controller_BIBUSStockListGradeController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * action list
	 *
	 * @return void
	 */
	public function stocklistAction() {
		$this->cObj = $this->configurationManager->getContentObject();
		$pid = $this->cObj->data['pages'];
		$pid = 0;
		$styles = '<link rel="stylesheet" type="text/css" href="typo3conf/ext/pits_stocklist/Resources/Public/Styles/styles_stocklist.css" />';
		$this->response->addAdditionalHeaderData($styles);
		$sys_language_uid = $GLOBALS['TSFE']->sys_language_uid;
		$select_fields = '*' ;
		$from_table = 'tx_pitsstocklist_domain_model_bibusstocklistgrade';
		$where_clause = "pid = $pid AND sys_language_uid = $sys_language_uid ".$this->cObj->enableFields( 'tx_pitsstocklist_domain_model_bibusstocklistgrade' ) ;
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
		
		$stockList['grade'] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows 	( 	$select_fields,
				$from_table,
				$where_clause,
				$groupBy = '',
				$orderBy = '',
				$limit = '',
				$uidIndexField = ''
		);
		//echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery ;
		//exit;
		$from_table = '	tx_pitsstocklist_domain_model_bibusstocklistlocation';
		$where_clause = "pid = $pid AND sys_language_uid = $sys_language_uid ".$this->cObj->enableFields( 'tx_pitsstocklist_domain_model_bibusstocklistlocation' ) ;
		$stockList['location'] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows 	( 	$select_fields,
				$from_table,
				$where_clause,
				$groupBy = '',
				$orderBy = '',
				$limit = '',
				$uidIndexField = ''
		);

		$from_table = '	tx_pitsstocklist_domain_model_bibusstocklistproductshape';
		$where_clause = "pid = $pid AND sys_language_uid = $sys_language_uid ".$this->cObj->enableFields( 'tx_pitsstocklist_domain_model_bibusstocklistproductshape' ) ;
		$stockList['shape'] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows 	( 	$select_fields,
				$from_table,
				$where_clause,
				$groupBy = '',
				$orderBy = '',
				$limit = '',
				$uidIndexField = ''
		);

		$stockList['langId'] = $GLOBALS["TSFE"]->sys_language_uid;
		$stockList['baseUrl'] = $GLOBALS["TSFE"]->baseUrl;
		$stockList['page'] = $GLOBALS["TSFE"]->id;
		$this->view->assign( 'StockList' , $stockList );
	}

	public function getresultAction () {
		$request = $this->request->getArguments();
		$sys_language_uid = ( !empty( $_REQUEST['L'] ) ) ?  $_REQUEST['L'] : $GLOBALS['TSFE']->sys_language_uid;
		$this->cObj = $this->configurationManager->getContentObject();
		//$pid = $this->cObj->data['pages'];
		$pid = 0;
		
		$select_fields = 'tx_pitsstocklist_domain_model_bibusstocklist.uid as list_uid  ,
				/*tx_pitsstocklist_domain_model_bibusstocklist.title as list_title,*/
				tx_pitsstocklist_domain_model_bibusstocklist.quantity,
				tx_pitsstocklist_domain_model_bibusstocklist.location,
				tx_pitsstocklist_domain_model_bibusstocklist.description,
				tx_pitsstocklist_domain_model_bibusstocklist.specification,
				tx_pitsstocklist_domain_model_bibusstocklist.size,
				tx_pitsstocklist_domain_model_bibusstocklistgrade.uid as grade_uid,
				tx_pitsstocklist_domain_model_bibusstocklistgrade.title as grade_title,
				tx_pitsstocklist_domain_model_bibusstocklistlocation.uid as location_uid,
				tx_pitsstocklist_domain_model_bibusstocklistlocation.title as location_title,
				tx_pitsstocklist_domain_model_bibusstocklistproductshape.uid as shape_uid,
				tx_pitsstocklist_domain_model_bibusstocklistproductshape.title as shape_title ' ;

		$from_table = 'tx_pitsstocklist_domain_model_bibusstocklist
				INNER JOIN tx_pitsstocklist_domain_model_bibusstocklistgrade ON  ( tx_pitsstocklist_domain_model_bibusstocklist.grade = tx_pitsstocklist_domain_model_bibusstocklistgrade.uid)
				INNER JOIN tx_pitsstocklist_domain_model_bibusstocklistlocation  ON  ( tx_pitsstocklist_domain_model_bibusstocklist.location = tx_pitsstocklist_domain_model_bibusstocklistlocation.uid)
				INNER JOIN tx_pitsstocklist_domain_model_bibusstocklistproductshape  ON  ( tx_pitsstocklist_domain_model_bibusstocklist.shape = tx_pitsstocklist_domain_model_bibusstocklistproductshape.uid)';

		$where_clause = "
		tx_pitsstocklist_domain_model_bibusstocklist.pid = $pid AND
		tx_pitsstocklist_domain_model_bibusstocklistgrade.pid = $pid AND
		tx_pitsstocklist_domain_model_bibusstocklistlocation.pid = $pid AND
		tx_pitsstocklist_domain_model_bibusstocklistproductshape.pid = $pid AND
		tx_pitsstocklist_domain_model_bibusstocklist.sys_language_uid = $sys_language_uid AND
		tx_pitsstocklist_domain_model_bibusstocklistgrade.sys_language_uid = $sys_language_uid AND
		tx_pitsstocklist_domain_model_bibusstocklistlocation.sys_language_uid = $sys_language_uid AND
		tx_pitsstocklist_domain_model_bibusstocklistproductshape.sys_language_uid = $sys_language_uid  ";
		$where_clause .= $this->cObj->enableFields( 'tx_pitsstocklist_domain_model_bibusstocklist' );
		$where_clause .=$this->cObj->enableFields( 'tx_pitsstocklist_domain_model_bibusstocklistgrade' );
		$where_clause .=$this->cObj->enableFields( 'tx_pitsstocklist_domain_model_bibusstocklistlocation' );
		$where_clause .= $this->cObj->enableFields( 'tx_pitsstocklist_domain_model_bibusstocklistproductshape' ) ;
		$where_clause .= !empty( $request['searchtext'] ) ? " AND ( tx_pitsstocklist_domain_model_bibusstocklistgrade.title LIKE '%".$request['searchtext']."%' OR
				tx_pitsstocklist_domain_model_bibusstocklist.specification LIKE '%".$request['searchtext']."%' )" :""; 
		$where_clause .= !empty( $request['grade'] )  ? " AND tx_pitsstocklist_domain_model_bibusstocklist.grade = '".$request['grade']."' " : "";
		$where_clause .= !empty( $request['location'] )  ? " AND tx_pitsstocklist_domain_model_bibusstocklist.location = '".$request['location']."' " : "";
		$where_clause .= !empty( $request['shape'] )  ? " AND tx_pitsstocklist_domain_model_bibusstocklist.shape = '".$request['shape']."' " : "";
		
		
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
		$stockList['response'] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows 	( 	$select_fields,
				$from_table,
				$where_clause,
				$groupBy = '',
				$orderBy = '',
				$limit,
				$uidIndexField = ''
		);
		//echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;exit;
		/* Pagination Start */
		$bibusdocuments['pageLimit'] = 10 ;
		$totalNumberOfRecords = sizeof( $stockList['response'] );
		$currentpage = !empty($request['startfrom']) ? (int) $request['startfrom'] : 1 ;
		//echo $currentPage ;
		$startFrom = ( $currentpage -1 ) * $bibusdocuments['pageLimit'];
		$limit =  $startFrom.','.$bibusdocuments['pageLimit'] ;
		$bibusdocuments['pageLimit'] = 10;
		$totalPages = ceil( $totalNumberOfRecords / $bibusdocuments['pageLimit'] );
		
		//print_r($request;
		$j = 0;
		if( $currentpage >= 5 ){
			$offsetValue = 4;
			$nextLimit = $currentpage + $offsetValue;
			if($nextLimit > $totalPages){
				$nextLimit = $totalPages;
			}
			$initValue = $currentpage-$offsetValue;
			if($currentpage > $offsetValue){
				$initValue = $totalPages - $offsetValue;
			}else{
				$initValue = $currentpage;
			}
			$curTotal = $currentpage + $offsetValue;
			if( $curTotal > $totalPages ){
				$modValue = $curTotal - $totalPages;
				$pagvalue = $currentpage - $modValue;
				$curTotal = $totalPages;
			}else{
				$pagvalue = $currentpage;
			}
			if($pagvalue <= 0){
				$pagvalue = 1;
			}
		}else{
			$pagvalue = 1;
			$curTotal = ( $totalPages < 5) ? $totalPages : 5;
	
		}
	
	
		for ($i = $pagvalue; $i<= $curTotal; $i++) {
				
			$stockList['pages'][$j] = $i;
			if ( $request['startfrom'] == $stockList['pages'][$j] ||  ( $j == 0 && empty( $request['startfrom']) ) ){
				$stockList['pages'][$j] = array( $i ,"font-weight:bold;");
			}else{
				$stockList['pages'][$j] = array( $i , 'font-weight:normal;' );
			}
			
			$j++;
		}
		$stockList['nextpage'] = ( $currentpage < $totalPages ) ? $currentpage+1 : $totalPages ;
		$stockList['previouspage'] = $currentpage <= 1 ? ($currentpage - 1) : 1 ;
		$stockList['currentpage'] = $currentpage ;
		$stockList['lastpage'] = empty($totalPages) ? 1 : $totalPages ;
		$stockList['paginations'] = Tx_Extbase_Utility_Localization::translate('tx_pitsstocklist_domain_model_bibusstocklist.pages', 'pitsStocklist', $arguments=NULL);

		$stockList['paginations'] = sprintf( $stockList['paginations'] ,$currentpage ,$stockList['lastpage'] );
		$stockList['response'] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows 	( 	$select_fields,
				$from_table,
				$where_clause,
				$groupBy = '',
				$orderBy = '',
				$limit,
				$uidIndexField = ''
		);
		
		
		$this->view->assign( 'StockList' , $stockList ); 
		echo $this->view->render( );
		exit;
	}
	
	public function orderprocessAction (){
		$request = $this->request->getArguments();
		foreach ($request['qty'] as $key=>$value){
			$request['items'][$key]['grade'] =  $request['grade'][$key];
			$request['items'][$key]['qty'] =  $value;
			$request['items'][$key]['other'] =  $request['other'][$key];
			$request['items'][$key]['shape'] =  $request['shape'][$key];
			$request['items'][$key]['size'] =  $request['size'][$key];
			$request['items'][$key]['spec'] =  $request['spec'][$key];
			$request['items'][$key]['location'] =  $request['location'][$key];
		}
			
		$request['mail_user'] = 1;
		$this->view->assign( 'StockList' , $request ); 
		$body = $this->view->render( );

		//Mail to user
		$fromEmail = $this->settings['fromEmail'];
		$fromName = Tx_Extbase_Utility_Localization::translate('tx_pitsstocklist_domain_model_bibusstocklist.fromName', 'pitsStocklist', $arguments=NULL); 
		$mail_subject = Tx_Extbase_Utility_Localization::translate('tx_pitsstocklist_domain_model_bibusstocklist.mailSubject', 'pitsStocklist', $arguments=NULL);
		$mailSubject = sprintf( $mail_subject, $request['name'] );
		
		$mail = t3lib_div::makeInstance( 't3lib_mail_message' );
		$mail->setFrom( array( $fromEmail => $fromName ) );
		$mail->setTo( array( $request['email'] => $request['name'] ) );
		$mail->setSubject( $mailSubject );
		$mail->setBody( $body, 'text/html' );
		echo $mail->send();
		
		//Mail to Admin
		$request['mail_user'] = 0;
		$this->view->assign( 'StockList' , $request );
		$body = $this->view->render( );
		
		$mail = t3lib_div::makeInstance( 't3lib_mail_message' );
		$mail->setFrom( array( $request['email'] => $request['name'] ) );
		$mail->setTo( array( $this->settings['adminEmail'] => $this->settings['adminName'] ) );
		$mail->setSubject( $mailSubject );
		$mail->setBody( $body, 'text/html' );
		echo $mail->send();

		exit;
	}

}
?>