<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2014  <arun.c@pitsolutions.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http_://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Task 'Scheduler' for the 'pits_stocklist' extension.
 *
 * @author	 	<arun.c@pitsolutions.com>
 * @package		TYPO3
 * @subpackage	tx_pits_stocklist
 */
require_once PATH_site.'typo3conf/ext/pits_stocklist/Configuration/PHPExcel/Classes/PHPExcel.php';

class tx_pits_stocklist extends tx_scheduler_Task {

	public function execute(){

		// Initialize directory path
    	$dirPath = PATH_site.'fileadmin/editors/countries/bmcn/stocklist';
    	if ( is_dir( $dirPath ) && is_writeable( $dirPath ) ){
        	$xls_files = glob( $dirPath.'/*.xls' );
        	
        	if ( !empty( $xls_files ) ) {
        	
        		// Tructate tables before import
        		$GLOBALS['TYPO3_DB']->exec_TRUNCATEquery( 'tx_pitsstocklist_domain_model_bibusstocklist' );
       			$GLOBALS['TYPO3_DB']->exec_TRUNCATEquery( 'tx_pitsstocklist_domain_model_bibusstocklistgrade' );
    			$GLOBALS['TYPO3_DB']->exec_TRUNCATEquery( 'tx_pitsstocklist_domain_model_bibusstocklistlocation' );
    			$GLOBALS['TYPO3_DB']->exec_TRUNCATEquery( 'tx_pitsstocklist_domain_model_bibusstocklistproducts' );
    			$GLOBALS['TYPO3_DB']->exec_TRUNCATEquery( 'tx_pitsstocklist_domain_model_bibusstocklistproductshape' );
        	
        		$objReader = new PHPExcel_Reader_Excel5();
        		$objReader->setReadDataOnly(true);

        		$i = 0;
	        	foreach ( $xls_files as $singleFile ) {

		        	$objPHPExcel = $objReader->load(  $singleFile );
		        	$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		        	
		        	$array_data = array();
					foreach($rowIterator as $row){
					    $cellIterator = $row->getCellIterator();
					    $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
					    if(1 == $row->getRowIndex ()) continue;//skip first row
					    $rowIndex = $row->getRowIndex();
  
					    foreach ($cellIterator as $cell) {
					       switch ( $cell->getColumn() ){
					       		case 'A' : $array_data[$rowIndex]['A'] = $cell->getCalculatedValue();
					       				   break;
					       		case 'B' : $array_data[$rowIndex]['B'] = $cell->getCalculatedValue();
					       				   break;
					       		case 'C' : $array_data[$rowIndex]['C'] = $cell->getCalculatedValue();
					       				   break;
					       		case 'D' : $array_data[$rowIndex]['D'] = $cell->getCalculatedValue();
					       				   break;
					       		case 'E' : $array_data[$rowIndex]['E'] = $cell->getCalculatedValue();
					       				   break;
					       		case 'F' : $array_data[$rowIndex]['F'] = $cell->getCalculatedValue();
					       				   break;
					       		case 'G' : $array_data[$rowIndex]['G'] = $cell->getCalculatedValue();
					       				   break;
					       		case 'H' : $array_data[$rowIndex]['H'] = $cell->getCalculatedValue();
					       				   break;
					       		case 'I' : $array_data[$rowIndex]['I'] = $cell->getCalculatedValue();
					       				   break;		   		   		   		   		   		   		   		   
					       } 
					    }
					}
					$dataArray[$i] = $array_data;
					$i++;
	        	}

	        	// Iterate excel data
	        	foreach ( $dataArray as $key => $value ){
	        		foreach ( $value as $data ){
						
	        			// Initialize sys_language_uid based on type
	        			$syslangUid = ( $data["A"] == '1' ) ? '26' : '0'; 
	        			// Check the location data already exists in db, else insert
	        			
	        			$location = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'title', 'tx_pitsstocklist_domain_model_bibusstocklistlocation',
	        												'title = "'.$data[F].'" AND sys_language_uid = "'.$syslangUid.'" AND deleted = 0 AND hidden = 0' );
	        			
	        			if( empty( $location ) ){
	        				$GLOBALS['TYPO3_DB']->exec_INSERTquery( 'tx_pitsstocklist_domain_model_bibusstocklistlocation', array( 'title' => $data[F], 'sys_language_uid' => $syslangUid ) );
	           			}
	        			
	        			// Check the grade data already exists in db, else insert
	        			$grade = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'title', 'tx_pitsstocklist_domain_model_bibusstocklistgrade',
	        												'title = "'.$data[D].'" AND sys_language_uid = "'.$syslangUid.'" AND deleted = 0 AND hidden = 0' );
	        			if( empty( $grade ) ){
	        				$GLOBALS['TYPO3_DB']->exec_INSERTquery( 'tx_pitsstocklist_domain_model_bibusstocklistgrade', array( 'title' => $data[D], 'sys_language_uid' => $syslangUid ) );
	        			}
	        			
	        			// Check the shape data already exists in db, else insert
	        			$shape = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'title', 'tx_pitsstocklist_domain_model_bibusstocklistproductshape',
	        												'title = "'.$data[C].'" AND sys_language_uid = "'.$syslangUid.'" AND deleted = 0 AND hidden = 0' );
	        			if( empty( $shape ) ){
	        			
	        				$GLOBALS['TYPO3_DB']->exec_INSERTquery( 'tx_pitsstocklist_domain_model_bibusstocklistproductshape', array( 'title' => $data[C], 'sys_language_uid' => $syslangUid ) );
	        			}
	        			
	        			// Check the products data already exists in db, else insert
	        			$products = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'title', 'tx_pitsstocklist_domain_model_bibusstocklistproducts',
	        												'title = "'.$data[B].'" AND sys_language_uid = "'.$syslangUid.'" AND deleted = 0 AND hidden = 0' );
	        			if( empty( $products ) ){
	        				$GLOBALS['TYPO3_DB']->exec_INSERTquery( 'tx_pitsstocklist_domain_model_bibusstocklistproducts', array( 'title' => $data[B], 'sys_language_uid' => $syslangUid ) );
	        			}

	        			// Get uids from location, grade, shape and products tables
	        			$locationUid = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'uid', 'tx_pitsstocklist_domain_model_bibusstocklistlocation',
	        												'title = "'.$data[F].'" AND sys_language_uid = "'.$syslangUid.'" AND deleted = 0 AND hidden = 0' );
	        			$gradeUid = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'uid', 'tx_pitsstocklist_domain_model_bibusstocklistgrade',
	        												'title = "'.$data[D].'" AND sys_language_uid = "'.$syslangUid.'" AND deleted = 0 AND hidden = 0' );
	        			$shapeUid = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'uid', 'tx_pitsstocklist_domain_model_bibusstocklistproductshape',
	        												'title = "'.$data[C].'" AND sys_language_uid = "'.$syslangUid.'" AND deleted = 0 AND hidden = 0' );
	        			$productsUid = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'uid', 'tx_pitsstocklist_domain_model_bibusstocklistproducts',
	        												'title = "'.$data[B].'" AND sys_language_uid = "'.$syslangUid.'" AND deleted = 0 AND hidden = 0' );   

	        			//Insert Array
	        			$insertArray = array();
	        			$insertArray['type'] = $data["A"];
	        			$insertArray['description'] = $data["I"];
	        			$insertArray['specification'] = $data["E"];
	        			$insertArray['quantity'] = $data["H"];
	        			$insertArray['products'] = $productsUid[0]['uid'];
	        			$insertArray['grade'] = $gradeUid[0]['uid'];
	        			$insertArray['shape'] = $shapeUid[0]['uid'];
	        			$insertArray['size'] = $data["G"];
	        			$insertArray['location'] = $locationUid[0]['uid'];
	        			$insertArray['deleted'] = 0;
	        			$insertArray['hidden'] = 0;
	        			$insertArray['tstamp'] = time();
	        			$insertArray['sys_language_uid'] = $syslangUid;
	        			
	        			//Insert Stocklist Data
	        			$GLOBALS['TYPO3_DB']->exec_INSERTquery( 'tx_pitsstocklist_domain_model_bibusstocklist', $insertArray );
	        		}
	        	}
        	}
    	}
    	return true; 
    }
}   