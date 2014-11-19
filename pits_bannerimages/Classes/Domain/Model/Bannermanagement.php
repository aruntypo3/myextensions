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
 * @package pits_bannerimages
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PitsBannerimages_Domain_Model_Bannermanagement extends Tx_Extbase_DomainObject_AbstractEntity {
    
    public function getbannerImages( $randCheck, $selectedUid, $languageUid ) {
        if ( !empty( $randCheck ) ) {
          $orderByClause = 'RAND()';
          $limitClause = '0,1';
        }else{
          $orderByClause = 'FIELD(tx_pitsbannerimages_domain_model_bannermanagement.uid,'.$selectedUid.')';
          $limitClause = '';  
        }
        $select_fields = '*';
        $from = 'tx_pitsbannerimages_domain_model_bannermanagement';
        $whereClause = 'uid IN ('.$selectedUid.') AND sys_language_uid = '.$languageUid.' AND deleted = 0 AND hidden = 0';
        $imageList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $imageList;
    }
    
    public function getCount( $imgName ) {
        $select_fields = '*';
        $from = 'tx_pitsbannerimages_domain_model_bannermanagement';
        $whereClause = 'image = "'.$imgName.'" AND deleted = 0 AND hidden = 0';
        $orderByClause = '';
        $limitClause = '';
        $clickCount = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from, $whereClause, '', $orderByClause, $limitClause);
        return $clickCount;
    }

}
?>
