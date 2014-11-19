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
class Tx_PitsBrandsearch_Domain_Model_Brandsearch extends Tx_Extbase_DomainObject_AbstractEntity {
	
	public function getBrandList( $storagePid, $languageUid ) {
		$select_fields = '*';
        $from = 'tx_pitssupplier_domain_model_brands';
        $whereClause = 'pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $orderByClause = 'brand_name';
        $limitClause = '';
        $brandList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
       	return $brandList;
	}
	
	public function getBrandDetail( $uid, $storagePid, $languageUid ) {
		    $select_fields = '*';
        $from = 'tx_pitssupplier_domain_model_brands';
        $whereClause = 'uid='.$uid.' AND pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $orderByClause = '';
        $limitClause = '';
        $brandDetail = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
       	return $brandDetail[0];
	}
	
	public function getInhouseBrands( $whereClause ) {
		    $select_fields = 'uid, brand_name';
        $from = 'tx_pitssupplier_domain_model_brands';
        $orderByClause = '';
        $limitClause = '';
        $inhouseBrandList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $inhouseBrandList;
	}
	
	public function inhouseSupplierList( $brandUid, $storagePid, $languageUid ){
		//$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
		$select_fields = 'uid, supplier_name';
        $from = 'tx_pitssupplier_domain_model_pitssupplier';
        $whereClause = 'FIND_IN_SET( '.$brandUid.', marken ) AND pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $orderByClause = 'supplier_name';
        $limitClause = '';
        $inhouseSupplierList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $inhouseSupplierList;
	}
	
	public function getBrandSearchList( $keyword, $storagePid, $languageUid ) {
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;	
		$select_fields = '*';
        $from = 'tx_pitssupplier_domain_model_brands';
        $whereClause = ''.$keyword.' pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $orderByClause = 'brand_name';
        $limitClause = '';
        $brandSearchList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $brandSearchList;
	}

}
?>