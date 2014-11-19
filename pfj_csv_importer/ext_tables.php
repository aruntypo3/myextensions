<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'web',	 // Make module a submodule of 'web'
		'pfjcsvimporter',	// Submodule key
		'',						// Position
		array(
			'CsvImporter' => 'list, show,write',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_pfjcsvimporter.xml',
		)
	);

}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'PFJ CSV IMPORTER');

t3lib_extMgm::addLLrefForTCAdescr('tx_pfjcsvimporter_domain_model_csvimporter', 'EXT:pfj_csv_importer/Resources/Private/Language/locallang_csh_tx_pfjcsvimporter_domain_model_csvimporter.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pfjcsvimporter_domain_model_csvimporter');
$TCA['tx_pfjcsvimporter_domain_model_csvimporter'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pfj_csv_importer/Resources/Private/Language/locallang_db.xml:tx_pfjcsvimporter_domain_model_csvimporter',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/CsvImporter.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pfjcsvimporter_domain_model_csvimporter.gif'
	),
);

?>