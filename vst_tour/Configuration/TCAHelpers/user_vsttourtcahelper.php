<?php 

class user_vsttourtcahelper{
	
	public function user_getTours( $params ){

		$select_fields = 'ID, BEZ';
		$from_table = 'touren';
		$where_clause = '';
		$groupBy = '';
		$orderBy = 'ID';

	  	$tourenData = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( $select_fields, $from_table, $where_clause, $groupBy, $orderBy );

		foreach( $tourenData as $tourenDataList ){
			if( !empty( $tourenDataList[ 'ID' ] ) && !empty( $tourenDataList['BEZ'] ) ){
				$params[ 'items' ][] = array( $tourenDataList[ 'BEZ' ], $tourenDataList['ID'] );
			}
		}
	}
}
?>