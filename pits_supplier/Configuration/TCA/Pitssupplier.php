<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_pitssupplier_domain_model_pitssupplier'] = array(
	'ctrl' => $TCA['tx_pitssupplier_domain_model_pitssupplier']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1,
					 supplier_name, address, zip, location, telephone, fax, email, web1, web2, b2b_webshop,
					 marken, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_pitssupplier_domain_model_pitssupplier',
				'foreign_table_where' => 'AND tx_pitssupplier_domain_model_pitssupplier.pid=###CURRENT_PID### AND tx_pitssupplier_domain_model_pitssupplier.sys_language_uid IN (-1,0)',
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
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'supplier_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.supplier_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
			),
		),
		'company_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.company_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'first_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.first_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'last_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.last_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.address',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'country' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.country',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'zip' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.zip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'location' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.location',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'telephone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.telephone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'fax' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.fax',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'web1' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.web1',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'web2' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.web2',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'b2b_webshop' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.b2b_webshop',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'marken' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_supplier/Resources/Private/Language/locallang_db.xml:tx_pitssuppliersearch_domain_model_suppliersearch.marken',		
			'config' => array(
				'type' => 'select',	
				'foreign_table' => 'tx_pitssupplier_domain_model_brands',	
				'foreign_table_where' => 'AND tx_pitssupplier_domain_model_brands.sys_language_uid = ###REC_FIELD_sys_language_uid### AND tx_pitssupplier_domain_model_brands.hidden = 0  AND tx_pitssupplier_domain_model_brands.deleted = 0 ORDER BY tx_pitssupplier_domain_model_brands.brand_name',	
				'size' => 10,    
            	'minitems' => 0,
            	'maxitems' => 20000,
			),
		),
	),
);

?>