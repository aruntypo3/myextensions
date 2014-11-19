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
class Tx_PitsSupplier_Domain_Model_Pitssupplier extends Tx_Extbase_DomainObject_AbstractEntity {
	
	public function getSupplierList ( $storagePid, $languageUid ) {
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;	
		$select_fields = '*';
        $from = 'tx_pitssupplier_domain_model_pitssupplier';
        $whereClause = 'pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $orderByClause = 'supplier_name';
        $limitClause = '';
        $supplierList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
       	return $supplierList;
	}

	// Supplier Detail
	public function getSupplierDetail ( $uid, $storagePid, $languageUid ) {
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;	
		$select_fields = '*';
        $from = 'tx_pitssupplier_domain_model_pitssupplier';
        $whereClause = 'uid='.$uid.' AND pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $orderByClause = '';
        $limitClause = '';
        $supplierDetail = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
       	return $supplierDetail[0];
	}

	public function getSupplierSearchList ( $keyword, $storagePid, $languageUid ) {
		$select_fields = '*';
        $from = 'tx_pitssupplier_domain_model_pitssupplier';
        $whereClause = ''.$keyword.' pid = '.$storagePid.' AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $orderByClause = 'supplier_name';
        $limitClause = '';
        $supplierSearchList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $supplierSearchList;
	}
	
	public function getBrandData ( $brandIds, $languageUid ){
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;	
		$select_fields = '*';
        $from = 'tx_pitssupplier_domain_model_brands';
        $whereClause = 'uid IN ('.$brandIds.') AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $orderByClause = 'brand_name';
        $limitClause = '';
        $brandDataArray = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $brandDataArray;	
	}
}
?>