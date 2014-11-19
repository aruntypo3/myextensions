<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Arun Chandran <arun.c@pitsolutions.com>, PIT Solutions Pvt Ltd.
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
 * @package vst_tour
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_VstTour_Domain_Model_Vsttour extends Tx_Extbase_DomainObject_AbstractEntity {

   /*
	* Get all tour categories
	*/
	public function doGetTourDetails( $storagePid, $languageUid, $detailPage ){
		$select = ( $languageUid == 0 ) ? 'tx_tour_categories.uid AS catUid, tx_tour_categories.cat_title, tx_tour.*, touren.BEZ' :
				   'tx_tour_categories.uid AS catUid, tx_tour_categories.cat_title, tx_tour.*, touren.BEZ_E';
		$from = 'tx_tour_categories LEFT JOIN tx_tour ON tx_tour_categories.uid = tx_tour.category_id LEFT JOIN touren
				ON tx_tour.tour_id = touren.ID';
		$where = 'tx_tour_categories.sys_language_uid = "'.$languageUid.'" AND tx_tour.sys_language_uid = "'.$languageUid.'" 
				  AND tx_tour_categories.pid = "'.$storagePid.'" AND tx_tour_categories.deleted = 0 AND tx_tour_categories.hidden = 0
				  AND tx_tour.deleted = 0 AND tx_tour.hidden = 0';
		$groupBy = '';
		$orderBy = 'tx_tour_categories.sort_order, tx_tour.sort_order';
		$limit = '';

		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
		$tourList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( $select, $from, $where, $groupBy, $orderBy, $limit );
 
		$i = 0;
		$tourDetails = array();
		foreach ( $tourList as $tourKey => $tourData ) {
			$indexKey = $tourData['catUid'];
     		$tourDetails[$indexKey]['category'] = $tourData['cat_title'];
     		$tourDetails[$indexKey]['currentUrl'] = t3lib_div::getIndpEnv( 'TYPO3_REQUEST_URL' );
     		$tourDetails[$indexKey]['categoryId'] = str_replace( ' ', '_', strtolower( $tourData['cat_title'] ) );
			$tourDetails[$indexKey]['tours'][$i]['catId'] = $tourData['catUid'];
			$tourDetails[$indexKey]['tours'][$i]['tourId'] = $tourData['uid'];
			$tourDetails[$indexKey]['tours'][$i]['tourTitle'] = ( $languageUid == 0 ) ? $tourData['BEZ'] : $tourData['BEZ_E'];
			if( empty( $tourDetails[$indexKey]['tours'][$i]['tourTitle'] ) &&  $languageUid > 0 ){
				$tourDetails[$indexKey]['tours'][$i]['tourTitle'] = $tourData['BEZ'];
			}
			$tourDetails[$indexKey]['tours'][$i]['price_before'] = number_format( (float)$tourData['price_before'], 2, ',', '' );
			$tourDetails[$indexKey]['tours'][$i]['description'] = $tourData['description'];
			$tourDetails[$indexKey]['tours'][$i]['detailPage'] = $detailPage;
/* 			$tourDetails[$indexKey]['tours'][$i]['testemonial'] = $tourData['testemonial'];
			$tourDetails[$indexKey]['tours'][$i]['youtube_link'] = $tourData['youtube_link'];
			$tourDetails[$indexKey]['tours'][$i]['gps_latitude'] = $tourData['gps_latitude'];
			$tourDetails[$indexKey]['tours'][$i]['gps_longitude'] = $tourData['gps_longitude'];
			$tourDetails[$indexKey]['tours'][$i]['highlights'] = $tourData['highlights'];
			$tourDetails[$indexKey]['tours'][$i]['benefits'] = $tourData['benefits']; */
			$tourDetails[$indexKey]['tours'][$i]['contact'] = $tourData['contact'];
			
			$i++;
		}
		return $tourDetails;
	}
	
	/*
	 * Get all tour partner details
	*/
	public function doGetPartnerDetails( $tourId ){
		$select  = 'uid, image_link, parentid';
		$from    = 'tx_tour_partners';
		$where   = 'parentid = "'.$tourId.'" AND deleted = 0 AND hidden = 0';
		$groupBy = '';
		$orderBy = 'sort_order';
		$limit   = '';
	
		$partnerList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( $select, $from, $where, $groupBy, $orderBy, $limit );
		
		foreach ( $partnerList as $key => $value ) {
			$partnerDetails[$key]['uid'] = $value['uid'];
			$partnerDetails[$key]['image_link'] = $value['image_link'];
			$partnerDetails[$key]['parentid'] = $value['parentid'];
		}
		return $partnerDetails; 
	}
	
	/*
	 * Get all single tour data
	*/
	public function doGetTourSingle( $tourId, $languageUid ){
		$select	 = ( $languageUid == 0 ) ? 'tx_tour_categories.uid AS catUid, tx_tour_categories.cat_title, tx_tour.*, touren.BEZ' :
				   'tx_tour_categories.uid AS catUid, tx_tour_categories.cat_title, tx_tour.*, touren.BEZ_E';
		$from    = 'tx_tour_categories LEFT JOIN tx_tour ON tx_tour_categories.uid = tx_tour.category_id LEFT JOIN touren
				   ON tx_tour.tour_id = touren.ID';
		$where   = 'tx_tour.uid= "'.$tourId.'" AND tx_tour.sys_language_uid = "'.$languageUid.'" AND tx_tour.deleted = 0 AND tx_tour.hidden = 0';
		$groupBy = '';
		$orderBy = 'tx_tour.sort_order';
		$limit   = '';
	
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
		$tourSingle = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( $select, $from, $where, $groupBy, $orderBy, $limit );
		//echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;

		$i = 0;
		$tourSingleDetails = array();
		foreach ( $tourSingle as $tourSingleKey => $tourSingleData ) {
      $youtubePattern = preg_match( '/youtu\.be/i', $tourSingleData['youtube_link'] ) || preg_match( '/youtube\.com\/watch/i', $tourSingleData['youtube_link'] ) || preg_match( '/youtube\.com\/embed/i', $tourSingleData['youtube_link'] );
      $tourSingleDetails[$i]['category'] = $tourSingleData['cat_title'];
			$tourSingleDetails[$i]['uid'] = $tourSingleData['uid'];
			$tourSingleDetails[$i]['tourTitle'] = ( $languageUid == 0 ) ? $tourSingleData['BEZ'] : $tourSingleData['BEZ_E'];
			if( empty( $tourSingleDetails[$i]['tourTitle'] ) &&  $languageUid > 0 ){
				$tourSingleDetails[$i]['tourTitle'] = $tourSingleData['BEZ'];
			}
			$tourSingleDetails[$i]['price_before'] = number_format( (float)$tourSingleData['price_before'], 2, ',', '' );
			$tourSingleDetails[$i]['description'] = $tourSingleData['description'];
			$tourSingleDetails[$i]['testemonial'] = $tourSingleData['testemonial'];
			$tourSingleDetails[$i]['youtube_link'] = ( $youtubePattern ) ? $tourSingleData['youtube_link'] : '';
			$tourSingleDetails[$i]['gps_latitude'] = $tourSingleData['gps_latitude'];
			$tourSingleDetails[$i]['gps_longitude'] = $tourSingleData['gps_longitude'];
			$tourSingleDetails[$i]['highlights'] = $tourSingleData['highlights'];
			$tourSingleDetails[$i]['benefits'] = $tourSingleData['benefits'];
			$tourSingleDetails[$i]['contact'] = $tourSingleData['contact'];
				
			$i++;
		}
		return $tourSingleDetails; 
	}
}
?>