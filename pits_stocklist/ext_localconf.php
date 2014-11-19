<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'Pitsstocklist',
	array(
		'BIBUSStockListGrade' => 'stocklist,getresult,orderprocess',
	),
	// non-cacheable actions
	array(
		'BIBUSStockListGrade' => 'stocklist,getresult,orderprocess',
	)
);

$TYPO3_CONF_VARS['SC_OPTIONS']['scheduler']['tasks']['tx_pits_stocklist'] = array(
    'extension' => $_EXTKEY,
    'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklist.scheduler_name',
    'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklist.scheduler_description',
);

?>
