<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Tntblumenshop',
	'TNT Blumen Shop'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Tntblumenshopteaser',
	'TNT Blumenshop Teaser'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TNT Blumen Shop');

t3lib_extMgm::addLLrefForTCAdescr('tx_tntblumenshop_domain_model_blumenshop', 'EXT:tnt_blumenshop/Resources/Private/Language/locallang_csh_tx_tntblumenshop_domain_model_blumenshop.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_tntblumenshop_domain_model_blumenshop');

$pluginSignature = str_replace('_','',$_EXTKEY) . '_' . tntblumenshop;
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');

$pluginSignature = str_replace('_','',$_EXTKEY) . '_' . tntblumenshopteaser;
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_teaser.xml');


$TCA['tx_tntblumenshop_products'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_products',
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
		'searchFields' => '',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Blumenshop.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_tntblumenshop_domain_model_blumenshop.gif'
	),
);

$TCA['tx_tntblumenshop_cat'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_cat',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array(		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Blumenshop.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_tntblumenshop_domain_model_blumenshop.gif'
	),
);

$TCA['tx_tntblumenshop_productlog'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog',		
		'label'     => 'name',
		'dividers2tabs'  => true,	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array(		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Blumenshop.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_tntblumenshop_domain_model_blumenshop.gif'
	),
);
?>