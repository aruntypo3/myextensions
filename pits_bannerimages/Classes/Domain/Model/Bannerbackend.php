<?php

/* * *************************************************************
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
 * ************************************************************* */

/**
 *
 *
 * @package pits_bannerimages
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PitsBannerimages_Domain_Model_Bannerbackend extends Tx_Extbase_DomainObject_AbstractEntity {

    public function getAllItems() {
        $select_fields = '*';
        $from = 'tx_pitsbannerimages_domain_model_bannermanagement';
        /* ADDED BY ABIN */
        $whereClause = " deleted = 0 AND hidden = 0 ";
        /* ADDED BY ABIN */
        $orderByClause = '';
        $limitClause = '';
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
        $allItems = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $allItems;
    }
	/*
    public function getTotalClick($imageId, $ipAddress) {
        $select_fields = 'SUM(count) as clickCount';
        $from = 'tx_pitsbannerimages_domain_model_bannerbackend';
        // ADDED BY ABIN 
        $whereClause = 'deleted = 0 AND hidden = 0 AND image_id = "' . $imageId . '" AND ip_address = "' . $ipAddress . '"';
         // ADDED BY ABIN 
        $orderByClause = '';
        $limitClause = '';
        $imgclickCount = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $imgclickCount[0]['clickCount'];
    }
	*/
    public function deleteBanner($bannerId) {
        /* ADDED BY ABIN */
        $fields_values['deleted'] = 1;
        $table = "tx_pitsbannerimages_domain_model_bannermanagement";
        $where = "uid = " . $bannerId;
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields = '');
        /* ADDED BY ABIN */
    }

}

?>