<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pitssupplier',
	array(
		'Pitssupplier' => 'list, show, search',
		
	),
	// non-cacheable actions
	array(
		'Pitssupplier' => 'list, show, search',
		
	)
);

?>