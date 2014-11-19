<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pitsjob',
	'TNT Jobs'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TNT Jobs');

t3lib_extMgm::addLLrefForTCAdescr('tx_pitsjob_domain_model_pitsjob', 'EXT:pits_job/Resources/Private/Language/locallang_csh_tx_pitsjob_domain_model_pitsjob.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitsjob_domain_model_pitsjob');
$TCA['tx_pitsjob_domain_model_pitsjob'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_pitsjob',
		'label' => 'job_title',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Pitsjob.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitsjob_domain_model_pitsjob.gif'
	),
);

$TCA['tx_pitsjob_domain_model_jobcategory'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_jobcategory',
		'label' => 'category_name',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Pitsjob.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitsjob_domain_model_pitsjob.gif'
	),
);

$pluginSignature = str_replace('_','',$_EXTKEY).'_pitsjob';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature,'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');


//Extend tt_news tca for webcode field
$tempColsArray = array(
	 'webcode' => array(      
            'exclude' => 0,      
            'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tt_news.webcode',      
            'config' => array(
                'type' => 'input',  
                'size' => '30',
            )
    ),
);

t3lib_div::loadTCA('tt_news');
t3lib_extMgm::addTCAcolumns('tt_news',$tempColsArray);
t3lib_extMgm::addToAllTCATypes('tt_news','webcode','','after:bodytext');
?>