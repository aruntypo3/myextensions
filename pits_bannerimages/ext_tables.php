<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pitsbannerimages',
	'TNT Banner Management'
);

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'web',	 // Make module a submodule of 'web'
		'pitsbannerimages',	// Submodule key
		'',						// Position
		array(
			'Bannerbackend' => 'list,deleteBanner',
			
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_pitsbannerimages.xml',
		)
	);

}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TNT Banner Management');

t3lib_extMgm::addLLrefForTCAdescr('tx_pitsbannerimages_domain_model_bannermanagement', 'EXT:pits_bannerimages/Resources/Private/Language/locallang_csh_tx_pitsbannerimages_domain_model_bannermanagement.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitsbannerimages_domain_model_bannermanagement');
$TCA['tx_pitsbannerimages_domain_model_bannermanagement'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_bannerimages/Resources/Private/Language/locallang_db.xml:tx_pitsbannerimages_domain_model_bannermanagement',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Bannermanagement.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitsbannerimages_domain_model_bannermanagement.gif'
	),
);

$pluginSignature = str_replace('_','',$_EXTKEY).'_pitsbannerimages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature,'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');

/*
t3lib_extMgm::addLLrefForTCAdescr('tx_pitsbannerimages_domain_model_bannerbackend', 'EXT:pits_bannerimages/Resources/Private/Language/locallang_csh_tx_pitsbannerimages_domain_model_bannerbackend.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitsbannerimages_domain_model_bannerbackend');
$TCA['tx_pitsbannerimages_domain_model_bannerbackend'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_bannerimages/Resources/Private/Language/locallang_db.xml:tx_pitsbannerimages_domain_model_bannerbackend',
		'label' => 'uid',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Bannerbackend.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitsbannerimages_domain_model_bannerbackend.gif'
	),
);
*/
?>