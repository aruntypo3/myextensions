<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_pitssupplier_domain_model_brands'] = array(
	'ctrl' => $TCA['tx_pitssupplier_domain_model_brands']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1,
					 brand_name, brand_firma, brand_address, brand_zipcode, brand_location, brand_telephone,
					 brand_fax, brand_email, brand_web, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_pitssupplier_domain_model_brands',
				'foreign_table_where' => 'AND tx_pitssupplier_domain_model_brands.pid=###CURRENT_PID### AND tx_pitssupplier_domain_model_brands.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			),
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'brand_name' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_name',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
				'eval' => 'trim,required',
			),
		),
		'brand_firma' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_firma',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),
		'brand_firstname' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_firstname',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),
		'brand_lastname' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_lastname',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),
		'brand_address' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_address',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),
		'brand_land' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_land',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),
		'brand_zipcode' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_zipcode',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),
		'brand_location' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_location',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),
		'brand_telephone' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_telephone',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),
		'brand_fax' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_fax',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),
		'brand_email' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_email',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),
		'brand_web' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_brandsearch/Resources/Private/Language/locallang_db.xml:tx_pitsbrandsearch_domain_model_brandsearch.brand_web',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),         
	),
);

?>
