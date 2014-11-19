<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pitsjob',
	array(
		'Pitsjob' => 'adform, success, list, detail, latest',
		
	),
	// non-cacheable actions
	array(
		'Pitsjob' => 'adform, success, list, detail, latest',
		
	)
);

?>