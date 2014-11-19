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
class Tx_TntBlumenshop_Domain_Model_Blumenshop extends Tx_Extbase_DomainObject_AbstractEntity {

	public function getProducts( $catCheck ){
		$select_fields = '*';
        $from = 'tx_tntblumenshop_products';
        $whereClause = "$catCheck deleted = 0 AND hidden = 0";
        $orderByClause = '';
        $limitClause = '';
        $products = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $products;
	}
	
	public function getSelectProduct( $uid ){
		$select_fields = '*';
        $from = 'tx_tntblumenshop_products';
        $whereClause = "uid = ".$uid." AND deleted = 0 AND hidden = 0";
        $orderByClause = '';
        $limitClause = '';
        $products = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $products;
	}
	
	/*
     * doGetTeaserImages
     * 
     */
     public function doGetTeaserImages( $referenceID ){
		$select_fields = '*';
        $from_table = 'sys_file AS sf LEFT JOIN sys_file_reference AS sfr ON sfr.uid_local = sf.uid';
        $whereClause = 'sfr.uid = '.$referenceID.' AND sfr.deleted = 0 AND sfr.hidden = 0';
        $teaserImage = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $whereClause, $groupBy = '', $orderBy = '', $limit = '', $uidIndexField = '');
		return $teaserImage[0]['identifier'];
	 }
}
?>