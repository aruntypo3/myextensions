<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Bibusimagegallery',
	'BIBUS Image Gallery V2'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'BIBUS Imge Gallery');

t3lib_extMgm::addLLrefForTCAdescr('tx_bibusimagegallery_domain_model_bibusimagegallery', 'EXT:bibus_imagegallery/Resources/Private/Language/locallang_csh_tx_bibusimagegallery_domain_model_bibusimagegallery.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_bibusimagegallery_domain_model_bibusimagegallery');
$TCA['tx_bibusimagegallery_domain_model_bibusimagegallery'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bibus_imagegallery/Resources/Private/Language/locallang_db.xml:tx_bibusimagegallery_domain_model_bibusimagegallery',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Bibusimagegallery.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bibusimagegallery_domain_model_bibusimagegallery.gif'
	),
);

$pluginSignature = str_replace('_','',$_EXTKEY).'_bibusimagegallery';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');
?>