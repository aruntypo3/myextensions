<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pitsbrandsearch',
	'TNT Brand Search'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TNT Brand Search');

t3lib_extMgm::addLLrefForTCAdescr('tx_pitsbrandsearch_domain_model_brandsearch', 'EXT:pits_brandsearch/Resources/Private/Language/locallang_csh_tx_pitsbrandsearch_domain_model_brandsearch.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitsbrandsearch_domain_model_brandsearch');
// TCA for Brands
$TCA['tx_pitssupplier_domain_model_brands'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_name',
		'label' => 'brand_name',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Brandsearch.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitsbrandsearch_domain_model_brandsearch.gif'
	),
);

$pluginSignature = str_replace('_','',$_EXTKEY).'_pitsbrandsearch';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature,'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');

?>
