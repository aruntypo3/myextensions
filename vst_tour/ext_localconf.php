<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Vsttour',
	array(
		'Vsttour' => 'list, detail, banner',
		
	),
	// non-cacheable actions
	array(
		'Vsttour' => 'list, detail, banner',
	)
);

//Register scheduler
$TYPO3_CONF_VARS['SC_OPTIONS']['scheduler']['tasks']['tx_vsttour_TourImport'] = array(
	'extension' => $_EXTKEY,
	'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xml:tx_vsttour.scheduler_name',
	'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xml:tx_vsttour.scheduler_description',
);

?>