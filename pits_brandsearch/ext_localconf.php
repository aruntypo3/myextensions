<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pitsbrandsearch',
	array(
		'Brandsearch' => 'list, show, search',
		
	),
	// non-cacheable actions
	array(
		'Brandsearch' => 'list, show, search',
		
	)
);

?>