<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pitsstocklist',
	'BIBUS Stock List'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'BIBUS Stock List');

t3lib_extMgm::addLLrefForTCAdescr('tx_pitsstocklist_domain_model_bibusstocklistgrade', 'EXT:pits_stocklist/Resources/Private/Language/locallang_csh_tx_pitsstocklist_domain_model_bibusstocklistgrade.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitsstocklist_domain_model_bibusstocklistgrade');
$TCA['tx_pitsstocklist_domain_model_bibusstocklistgrade'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklistgrade',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/BIBUSStockListGrade.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitsstocklist_domain_model_bibusstocklistgrade.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_pitsstocklist_domain_model_bibusstocklistlocation', 'EXT:pits_stocklist/Resources/Private/Language/locallang_csh_tx_pitsstocklist_domain_model_bibusstocklistlocation.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitsstocklist_domain_model_bibusstocklistlocation');
$TCA['tx_pitsstocklist_domain_model_bibusstocklistlocation'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklistlocation',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/BIBUSStockListLocation.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitsstocklist_domain_model_bibusstocklistlocation.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_pitsstocklist_domain_model_bibusstocklistproductshape', 'EXT:pits_stocklist/Resources/Private/Language/locallang_csh_tx_pitsstocklist_domain_model_bibusstocklistproductshape.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitsstocklist_domain_model_bibusstocklistproductshape');
$TCA['tx_pitsstocklist_domain_model_bibusstocklistproductshape'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklistproductshape',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/BIBUSStockListProductShape.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitsstocklist_domain_model_bibusstocklistproductshape.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_pitsstocklist_domain_model_bibusstocklist', 'EXT:pits_stocklist/Resources/Private/Language/locallang_csh_tx_pitsstocklist_domain_model_bibusstocklist.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitsstocklist_domain_model_bibusstocklist');
$TCA['tx_pitsstocklist_domain_model_bibusstocklist'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklist',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/BIBUSStockList.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitsstocklist_domain_model_bibusstocklist.gif'
	),
);

?>