<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Vsttour',
	'VST Tour Management'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'VST Tour Management');

$pluginSignature = str_replace( '_','',$_EXTKEY ).'_'.vsttour;
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue( $pluginSignature,'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml' );

t3lib_extMgm::addLLrefForTCAdescr('tx_tour_categories', 'EXT:vst_tour/Resources/Private/Language/locallang_csh_tx_vsttour_domain_model_vsttour.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_tour_categories');

$TCA['tx_tour_categories'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_vsttour_domain_model_vsttour',
		'label'     => 'cat_title',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sort_order',
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
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Vsttour.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vsttour_domain_model_vsttour.gif'
	),
);

$TCA['tx_tour'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour',
		'label' => 'tour_title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sort_order',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Vsttour.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vsttour_domain_model_vsttour.gif'
	),
);

$TCA['tx_tour_partners'] = array(
		'ctrl' => array(
				'title'	=> 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour_partners',
				'label' => 'uid',
				'tstamp' => 'tstamp',
				'crdate' => 'crdate',
				'cruser_id' => 'cruser_id',
				'sortby' => 'sort_order',
				'dividers2tabs' => TRUE,
				'versioningWS' => 2,
				'hideTable' => TRUE,
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
				'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/VsttourPartners.php',
				'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_vsttour_domain_model_vsttour.gif'
		),
);
?>