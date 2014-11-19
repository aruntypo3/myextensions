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
 * @package pits_brandsearch
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PitsBrandsearch_Controller_BrandsearchController extends Tx_Extbase_MVC_Controller_ActionController {

	
	protected $pitsbrandsearchModel;

    public function __construct() {
        $this->pitsbrandsearchModel = new Tx_PitsBrandsearch_Domain_Model_Brandsearch();
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
        $brandSearchList['storagePid'] = $this->contentObj->data['pages'];
        $brandSearchList['pid'] = $GLOBALS['TSFE']->id;
    	$brandSearchList['languageUid'] = $GLOBALS['TSFE']->sys_language_uid;
        $brandSearchList['currentUrl'] = $this->urlPreparation( $brandSearchList['pid'] );
        
    	$brandList = $this->pitsbrandsearchModel->getBrandList( $brandSearchList['storagePid'], $brandSearchList['languageUid'] );
		foreach ( $brandList as $key => $value ) {
    		mb_internal_encoding("UTF-8");
    		$initial = strtoupper( mb_substr ( $value['brand_name'], 0, 1 ) );
    		if( is_numeric( $initial ) ) {
    			$brandSearch['0-9'][] = $value;
    		}else{
    			$brandSearch[$initial][] = $value;
    		}
    	}
    	
    	$brandSearchList['alphabets'] = range('A','Z');
    	$brandSearchList['searchBoxVal'] = Tx_Extbase_Utility_Localization::translate('tx_pitsbrandsearch_domain_model_brandsearch.searchboxVal', 'pitsBrandsearch');   
    		
    	$this->view->assign( 'brandList', $brandSearchList );
    	
    	if( isset( $request['brandUid'] ) || isset( $_GET['brandUid'] ) ) {
	      	$brandUidValue = ( !empty( $request['brandUid'] ) ) ? $request['brandUid'] : $_GET['brandUid'];
	        $this->forward( 'show','Brandsearch','pitsBrandsearch',array('brand_uid'=>$brandUidValue,'direct_Submit'=>1 ) );
        }
       	if( isset( $_POST['keyword'] ) ){
        	$this->view->assign('postKeyword', $_POST['keyword']);
        	$this->searchAction(); 
       	}else{
    	    $this->view->assign('brandSearch', $brandSearch);
        }    
	}

	/**
	 * action show
	 *
	 * @param Tx_PitsBrandsearch_Domain_Model_Brandsearch $brandsearch
	 * @return void
	 */
	public function showAction() {
		$request = $this->request->getArguments();
		$this->contentObj = $this->configurationManager->getContentObject();
		$storagePid = $this->contentObj->data['pages'];
		$brandDetailArray['pid'] = $GLOBALS['TSFE']->id;
		$brandDetailArray['languageUid'] = $GLOBALS['TSFE']->sys_language_uid;
		$brandDetailArray['supplierListPageUrl'] = $this->urlPreparation( $this->settings['flexform']['url'] );
	    $brandSearchList['alphabets'] = range('A','Z');
	    $brandSearchList['currentUrl'] = $this->urlPreparation( $brandDetailArray['pid'] );
	    if( !empty($request['direct_Submit']) ){
	        $brandSearchList['direct_Submit'] = $request['direct_Submit'];
	    } 

		$brandDetail = $this->pitsbrandsearchModel->getBrandDetail( $request['brand_uid'], $storagePid, $brandDetailArray['languageUid'] );
		$last_character = substr( $brandDetail['brand_name'], -1 );
		if ( $last_character == "*" ){
			$brandName = substr( $brandDetail['brand_name'], 0, -1);
			$whereClause = 'brand_name LIKE "'.$brandName.'" OR brand_name LIKE "'.$brandDetail["brand_name"].'" AND pid = '.$storagePid.' AND sys_language_uid = '.$brandDetailArray["languageUid"].' AND deleted = 0 AND hidden = 0';
		}else{
			$whereClause = 'brand_name LIKE "'.$brandDetail["brand_name"].'" OR brand_name LIKE "'.$brandDetail["brand_name"]."*".'" AND pid = '.$storagePid.' AND sys_language_uid = '.$brandDetailArray["languageUid"].' AND deleted = 0 AND hidden = 0';
		}
		$inhouseBrands = $this->pitsbrandsearchModel->getInhouseBrands( $whereClause );
		foreach( $inhouseBrands as $key=>$value ) {
			$inhouseSupplierList = $this->pitsbrandsearchModel->inhouseSupplierList( $value['uid'], $storagePid, $brandDetailArray['languageUid'] );
			$inhouseBrands[$key]['child'] = $inhouseSupplierList;
		}
		$this->view->assign('brandDetails', $brandDetail);
		$this->view->assign('brandList', $brandSearchList);
		$this->view->assign('brandDetail', $brandDetailArray);
		$this->view->assign('inhouseBrands', $inhouseBrands);
		if ( empty($request['direct_Submit']) ) {
			echo $this->view->render();
			exit;
		}
	}
	
	/**
	 * action search
	 *
	 * @param Tx_PitsBrandsearch_Domain_Model_Brandsearch $brandsearch
	 * @return void
	 */
	public function searchAction() {
		$request = $this->request->getArguments();
		$this->contentObj = $this->configurationManager->getContentObject();
		$storagePid = $this->contentObj->data['pages'];
		$brandSearchListArray['pid'] = $GLOBALS['TSFE']->id;
    	$brandSearchListArray['languageUid'] = $GLOBALS['TSFE']->sys_language_uid;
    	$brandSearchListArray['alphabets'] = range('A','Z');
        $brandSearchListArray['currentUrl'] = $this->urlPreparation( $brandSearchListArray['pid'] );
        //$enteredKeyword = ( $_POST['keyword'] != $searchboxLabel ) ? $_POST['keyword'] : '';

		if ( empty($_POST['keyword']) && empty( $_POST['clickVal'] ) ){
			$enteredKeyword = "";
		}else if( empty($_POST['keyword']) && !empty( $_POST['clickVal'] ) ){
			$enteredKeyword = $this->clickValue( $_POST['clickVal'] );
		}else{
			$enteredKeyword = 'brand_name LIKE "%'.$_POST["keyword"].'%" AND';
		}

        $brandSearchList = $this->pitsbrandsearchModel->getBrandSearchList( $enteredKeyword, $storagePid, $brandSearchListArray['languageUid'] );
        
		foreach ( $brandSearchList as $key => $value ) {
    		mb_internal_encoding("UTF-8");
    		$initial = strtoupper( mb_substr ( $value['brand_name'], 0, 1 ) );
    		if( is_numeric( $initial ) ) {
    			$brandSearch['0-9'][] = $value;
    		}else{
    			$brandSearch[$initial][] = $value;
    		}
    	}
    	
		if( empty( $brandSearch ) ){
       		$noResults = Tx_Extbase_Utility_Localization::translate('tx_pitsbrandsearch_domain_model_brandsearch.no_results', 'pitsBrandsearch');
       		$this->flashMessageContainer->add($noResults);
    	}

		$this->view->assign('brandSearch', $brandSearch);
		$this->view->assign('brandList', $brandSearchListArray);
		echo $this->view->render();
		exit;
	/*	if ( empty($_POST['direct_Submit']) ) {
			echo $this->view->render();
			exit;
		}*/
	}
	// Function for processing clicked label
	public function clickValue( $clickLabel ) {
		if( $clickLabel == "all" ){
			$enteredKeyword = "";
		}else if( in_array ( $clickLabel, range('A','Z')) ){
			$enteredKeyword = 'brand_name LIKE "'.$_POST["clickVal"].'%" AND';
		}else if( $clickLabel == "0-9" ) {
			$enteredKeyword = "brand_name regexp '^[0-9]+' AND";
		}
		return $enteredKeyword;
	}

	// To Top Link Generating Action	
	public function urlPreparation( $pageId ){
		$conf = array(
                'parameter' => $pageId,
                'returnLast' => 'url',
    		    ); 
    	return $GLOBALS['TSFE']->baseUrl.$this->contentObj->typoLink('', $conf);
	}

}
?>