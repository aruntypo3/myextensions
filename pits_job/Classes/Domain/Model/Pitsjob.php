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
class Tx_PitsJob_Domain_Model_Pitsjob extends Tx_Extbase_DomainObject_AbstractEntity {

	public function listCategory( $storagePid, $languageUid ) {
		$select_fields = 'uid, category_name';
        $from = 'tx_pitsjob_domain_model_jobcategory';
        $whereClause = 'pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $orderByClause = 'category_name';
        $limitClause = '';
        $categoryList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
       	return $categoryList;
	}
	
	public function jobCategory( $uid, $storagePid, $languageUid ) {
		$select_fields = 'category_name';
        $from = 'tx_pitsjob_domain_model_jobcategory';
        $whereClause = 'uid = '.$uid.' AND pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $orderByClause = '';
        $limitClause = '';
        $categoryName = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
       	return $categoryName[0]['category_name'];
	}
	
	public function jobList( $selectedCat, $storagePid, $languageUid ) {
		if( empty( $selectedCat ) ) {
			$whereClause = 'pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND DATE_FORMAT(FROM_UNIXTIME( job_expiredate ), "%Y-%m-%d") >= "'.date("Y-m-d").'" AND deleted = 0 AND hidden = 0';
		}else{
			$whereClause = 'category_id = '.$selectedCat.' AND pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND DATE_FORMAT(FROM_UNIXTIME( job_expiredate ), "%Y-%m-%d") >= "'.date("Y-m-d").'" AND deleted = 0 AND hidden = 0';
		}
		
		$select_fields = '*';
        $from = 'tx_pitsjob_domain_model_pitsjob';
        $orderByClause = 'job_date DESC';
        $limitClause = '';
        $jobListArray = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $jobListArray;
	}
	
	public function jobDetail( $jobId, $storagePid, $languageUid ) {
		$select_fields = '*';
        $from = 'tx_pitsjob_domain_model_pitsjob';
        $whereClause = 'uid = '.$jobId.' AND pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $orderByClause = '';
        $limitClause = '';
        $jobDetailData = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
       	return $jobDetailData[0];
	}
	
	public function jobLatest( $listItemCount, $selectedCatLatest, $storagePid, $languageUid ) {
		if( empty( $selectedCatLatest ) ) {
			$whereClause = 'pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND DATE_FORMAT(FROM_UNIXTIME( job_expiredate ), "%Y-%m-%d") >= "'.date("Y-m-d").'" AND deleted = 0 AND hidden = 0';
		}else{
			$whereClause = 'category_id ='.$selectedCatLatest.' AND pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND DATE_FORMAT(FROM_UNIXTIME( job_expiredate ), "%Y-%m-%d") >= "'.date("Y-m-d").'" AND deleted = 0 AND hidden = 0';
		}
		$select_fields = '*';
        $from = 'tx_pitsjob_domain_model_pitsjob';
        $orderByClause = 'job_date DESC';
        $limitClause = "0, $listItemCount";
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
        $jobLatestData = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $jobLatestData;
	}
}
?>
