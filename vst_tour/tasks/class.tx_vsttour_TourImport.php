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
 * Task 'Scheduler' for the 'vst_tour' extension.
 *
 * @author	 	<arun.c@pitsolutions.com>
 * @package		TYPO3
 * @subpackage	tx_vsttour_import
 */

class tx_vsttour_TourImport extends tx_scheduler_Task {

	public function execute(){
		
		header('Content-Type: text/html; charset=utf-8');
	
		$typo_db          = 'event_VST';
		$typo_db_username = 'vienna';
		$typo_db_password = 'V13nn4!';
		$typo_db_host     = '127.0.0.1';
		
		$conn = mysql_connect ( $typo_db_host , $typo_db_username , $typo_db_password );
		mysql_query( "SET character_set_results=utf8", $conn );
		mb_language( 'uni' );
		mb_internal_encoding( 'UTF-8' );
		mysql_select_db( $typo_db, $conn ) or die( "Unable to select database" );
		mysql_query( "set names 'utf8'", $conn );
		
		$conf = unserialize ( $GLOBALS[ 'TYPO3_CONF_VARS' ][ 'EXT' ][ 'extConf' ][ 'vst_tour' ] );
		$importTables = explode( ',', $conf['import_tables'] );

		if( !empty( $importTables ) ){
			foreach ( $importTables as $key => $table ){
				$result = mysql_query( "SHOW TABLES LIKE '".$table."'" );
				if( mysql_num_rows( $result ) > 0 ){
					$GLOBALS['TYPO3_DB']->exec_TRUNCATEquery( $table );
					$query = mysql_query( "SELECT * FROM $table" );
					$tourRecords = array();
					while ( $row = mysql_fetch_assoc( $query ) ) {
						$insertQuery = 'INSERT INTO '.$table.' ( '.implode( ',', array_keys($row)).' ) VALUES ( "'.implode( '","', array_values($row)).'" );';
						$GLOBALS['TYPO3_DB']->sql_query( $insertQuery );
					}
				}
			}
		}
		mysql_close($conn);
		return true;
    }
}   