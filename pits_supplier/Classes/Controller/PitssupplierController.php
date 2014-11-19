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
 * @package pits_supplier
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PitsSupplier_Controller_PitssupplierController extends Tx_Extbase_MVC_Controller_ActionController {

	
	protected $pitssupplierModel;

    public function __construct() {
        $this->pitssupplierModel = new Tx_PitsSupplier_Domain_Model_Pitssupplier();
    }
	
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
			if( !empty( $this->settings['scrollToJs'] ) ){
				$this->response->addAdditionalHeaderData('<script type="text/javascript" src="'.$this->settings["scrollToJs"].'"></script>');	
			}
			$request = $this->request->getArguments();
        	$this->contentObj = $this->configurationManager->getContentObject();
    		$supplierListArray['storagePid'] = $this->contentObj->data['pages'];
    		$supplierListArray['pid'] = $GLOBALS['TSFE']->id;
    		$supplierListArray['languageUid'] = $GLOBALS['TSFE']->sys_language_uid;
            $supplierListArray['currentUrl'] = $this->topLink( $supplierListArray['pid'] );
    		
    		$supplierList = $this->pitssupplierModel->getSupplierList( $supplierListArray['storagePid'], $supplierListArray['languageUid'] );
    		foreach ($supplierList as $key => $value ) {
    			mb_internal_encoding("UTF-8");
    			$initial = strtoupper( mb_substr ( $value['supplier_name'], 0, 1 ) );
    			if( is_numeric( $initial ) ) {
    				$supplierSearch['0-9'][] = $value;
    			}else{
    				$supplierSearch[$initial][] = $value;
    			}
    		}
    		$supplierListArray['alphabets'] = range('A','Z');   
        	$supplierListArray['searchBoxVal'] = Tx_Extbase_Utility_Localization::translate('tx_pitssupplier_domain_model_pitssupplier.searchboxVal', 'pitsSupplier');
    		$this->view->assign('supplierList', $supplierListArray);
	 	if( isset( $request['supplierUid'] ) || isset( $_GET['supplierUid'] ) ) {
	        	$supplierUidValue = ( !empty( $request['supplierUid'] ) ) ? $request['supplierUid'] : $_GET['supplierUid'];
	                $this->forward('show','Pitssupplier','pitsSupplier',array('supplier_uid'=>$supplierUidValue,'direct_Submit'=>1 ));
        	}
       		if( isset( $_POST['keyword'] ) ){
            		$this->view->assign('postKeyword', $_POST['keyword']);
            		return $this->searchAction(); 
       	 	}else{
    		    $this->view->assign('supplierSearch', $supplierSearch);
        	}       
}

	/**
	 * action show
	 *
	 * @param Tx_PitsSupplier_Domain_Model_Pitssupplier $pitssupplier
	 * @return void
	 */
	public function showAction() {

		$request = $this->request->getArguments();
		$this->contentObj = $this->configurationManager->getContentObject();
		$storagePid = $this->contentObj->data['pages'];
		$supplierDetailArray['pid'] = $GLOBALS['TSFE']->id;
		$supplierDetailArray['languageUid'] = $GLOBALS['TSFE']->sys_language_uid;
	    $supplierListArray['alphabets'] = range('A','Z');
	    $supplierListArray['currentUrl'] = $this->topLink( $supplierDetailArray['pid'] );
	    if( !empty($request['direct_Submit']) ){
	        $supplierListArray['direct_Submit'] = $request['direct_Submit'];
	    } 

		$supplierDetail = $this->pitssupplierModel->getSupplierDetail( $request['supplier_uid'], $storagePid, $supplierDetailArray['languageUid'] );
		$brandData = $this->pitssupplierModel->getBrandData( $supplierDetail['marken'], $supplierDetailArray['languageUid'] ); 

		$brandList = "";
 		foreach ( $brandData as $key=>$value ) {
     		$conf = array(
                'parameter' => $this->settings['flexform']['url'],
                'additionalParams' => '&tx_pitsbrandsearch_pitsbrandsearch[brandUid]='.$value["uid"],
                'returnLast' => 'url',
            ); 
      		$targetLinkToBrand = $GLOBALS['TSFE']->baseUrl . $this->contentObj->typoLink('', $conf);
 			$brandList .= '<a href="'.$targetLinkToBrand.'">'.$value['brand_name'].'</a>, ';
 		}
 		$brandDataList = rtrim( $brandList, ', ' );
    	$this->view->assign('supplierList', $supplierListArray);
		$this->view->assign('supplierDetails', $supplierDetail);
		$this->view->assign('supplierDetail', $supplierDetailArray);
		$this->view->assign('brandDatas', $brandDataList);
		if ( empty($request['direct_Submit']) ) {
			echo $this->view->render();
			exit;
		}
	}
	
	/**
	 * action search
	 *
	 * @param Tx_PitsSupplier_Domain_Model_Pitssupplier $pitssupplier
	 * @return void
	 */
	public function searchAction() {

		$request = $this->request->getArguments();
		$this->contentObj = $this->configurationManager->getContentObject();
		$storagePid = $this->contentObj->data['pages'];
		$supplierListArray['pid'] = $GLOBALS['TSFE']->id;
		$supplierListArray['languageUid'] = $GLOBALS['TSFE']->sys_language_uid;
    	$supplierListArray['alphabets'] = range('A','Z');
		$supplierListArray['currentUrl'] = $this->topLink( $supplierListArray['pid'] );

		if ( empty($_POST['keyword']) && empty( $_POST['clickVal'] ) ){
			$enteredKeyword = "";
		}else if( empty($_POST['keyword']) && !empty( $_POST['clickVal'] ) ) {
			$enteredKeyword = $this->clickValue( $_POST['clickVal'] );
		}else{
			$enteredKeyword = 'supplier_name LIKE "%'.$_POST["keyword"].'%" AND';
		}

		$supplierSearchList = $this->pitssupplierModel->getSupplierSearchList( $enteredKeyword, $storagePid, $supplierListArray['languageUid'] );
    
		foreach ($supplierSearchList as $key => $value ) {
				mb_internal_encoding("UTF-8");
				$initial = strtoupper( mb_substr ( $value['supplier_name'], 0, 1 ) );
				if( is_numeric( $initial ) ) {
					$supplierSearch['0-9'][] = $value;
				}else{
					$supplierSearch[$initial][] = $value;
				}
		}
		
	 	if( empty($supplierSearch) ){
       			$noResults = Tx_Extbase_Utility_Localization::translate('tx_pitssupplier_domain_model_pitssupplier.no_results', 'pitsSupplier');
       			$this->flashMessageContainer->add($noResults);
    	}
		$this->view->assign('supplierSearch', $supplierSearch);
		$this->view->assign('supplierList', $supplierListArray);
		echo $this->view->render();
		exit;
	/*	if ( empty($_POST['direct_Submit']) ) {
			echo $this->view->render();
			exit;
		}*/
	}
	
	public function clickValue( $clickLabel ) {
		if( $clickLabel == "all" ){
			$enteredKeyword = "";
		}else if( in_array ( $clickLabel, range('A','Z')) ){
			$enteredKeyword = 'supplier_name LIKE "'.$_POST["clickVal"].'%" AND';
		}else if( $clickLabel == "0-9" ) {
			$enteredKeyword = "supplier_name regexp '^[0-9]+' AND";
		}
		return $enteredKeyword;
	}

	
	// To Top Link Generating Action
	public function topLink( $pageUid ) {
		$conf = array(
                'parameter' => $pageUid,
                'returnLast' => 'url',
            ); 
    return $GLOBALS['TSFE']->baseUrl . $this->contentObj->typoLink('', $conf);
	}
}
?>