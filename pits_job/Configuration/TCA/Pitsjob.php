<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_pitsjob_domain_model_pitsjob'] = array(
	'ctrl' => $TCA['tx_pitsjob_domain_model_pitsjob']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden',
	),
	'types' => array(
		'1' => array('showitem' => '--div--;LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:jobDetail_Tab, sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, job_date, job_expiredate, category_id, job_title, short_description, detail_description,
					  contact_info, job_check, webcode,--div--;LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:contactInfo_Tab, name, company, address, zipcode, place, country, phone,
					  email, terms_agree'),
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
				'foreign_table' => 'tx_pitsjob_domain_model_pitsjob',
				'foreign_table_where' => 'AND tx_pitsjob_domain_model_pitsjob.pid=###CURRENT_PID### AND tx_pitsjob_domain_model_pitsjob.sys_language_uid IN (-1,0)',
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
		'job_date' => Array (
			'l10n_mode' => 'mergeIfNotBlank',
			'exclude' => 1,
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_jobDate',
			'config' => Array (
				'type' => 'input',
				'size' => '10',
				'max' => '20',
				'eval' => 'date',
				'default' => 0
			)
		),
    'job_expiredate' => Array (
			'l10n_mode' => 'mergeIfNotBlank',
			'exclude' => 1,
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_jobexpireDate',
			'config' => Array (
				'type' => 'input',
				'size' => '10',
				'max' => '20',
				'eval' => 'date',
				'default' => 0
			)
		),
		'category_id' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_categoryId',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'job_title' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_jobTitle',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'short_description' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_shortText',		
			'config' => array(
				'type' => 'text',
				'cols' => '40',
        		'rows' => '5',
			)
		),
		'detail_description' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_detailText',
		    'defaultExtras' => 'richtext[]',		
			'config' => array(
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					'RTE' => Array(
    					'notNewRecords' => 1,
					    'RTEonly' => 1,
					    'type' => 'script',
					    'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
					    'icon' => 'wizard_rte2.gif',
					    'script' => 'wizard_rte.php',
					),
				),
			),
		),
		'contact_info' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_contactInfo',		
		    'defaultExtras' => 'richtext[]',		
			'config' => array(
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
				"wizards" => Array(
					"_PADDING" => 2,
					'RTE' => Array(
    					'notNewRecords' => 1,
					    'RTEonly' => 1,
					    'type' => 'script',
					    'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
					    'icon' => 'wizard_rte2.gif',
					    'script' => 'wizard_rte.php',
					),
				),
			),
		),
		'job_check' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_jobCheck',		
			'config' => array(
				'type' => 'check',
			)
		),
		'webcode' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_webcode',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'name' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_name',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'company' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_company',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'address' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_address',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'zipcode' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_zipcode',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'place' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_place',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
    'country' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_country',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'phone' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_phone',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'email' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_email',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'web' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_web',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'terms_agree' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:agree_terms',		
			'config' => array(
				'type' => 'check',
			)
		),
	),
);


$TCA['tx_pitsjob_domain_model_jobcategory'] = array(
	'ctrl' => $TCA['tx_pitsjob_domain_model_jobcategory']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, category_name, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_pitsjob_domain_model_jobcategory',
				'foreign_table_where' => 'AND tx_pitsjob_domain_model_jobcategory.pid=###CURRENT_PID### AND tx_pitsjob_domain_model_jobcategory.sys_language_uid IN (-1,0)',
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
		'category_name' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:pits_job/Resources/Private/Language/locallang_db.xml:tx_pitsjob_domain_model_categoryName',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
	),
);
?>