<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pitssupplier',
	'TNT Supplier'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TNT Supplier');

t3lib_extMgm::addLLrefForTCAdescr('tx_pitssupplier_domain_model_pitssupplier', 'EXT:pits_supplier/Resources/Private/Language/locallang_csh_tx_pitssupplier_domain_model_pitssupplier.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitssupplier_domain_model_pitssupplier');
// TCA for Suppliers
$TCA['tx_pitssupplier_domain_model_pitssupplier'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.supplier_name',
		'label' => 'supplier_name',
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
		'searchFields' => '',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Pitssupplier.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitssupplier_domain_model_pitssupplier.gif'
	),
);

$pluginSignature = str_replace('_','',$_EXTKEY).'_pitssupplier';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature,'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');

?>