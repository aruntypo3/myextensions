<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_pitsstocklist_domain_model_bibusstocklist'] = array(
	'ctrl' => $TCA['tx_pitsstocklist_domain_model_bibusstocklist']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title,description,quantity,size,specification,grade ,shape,location,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_pitsstocklist_domain_model_bibusstocklist',
				'foreign_table_where' => 'AND  tx_pitsstocklist_domain_model_bibusstocklist.sys_language_uid IN (-1,0)',
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
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklist.title',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				
			),
		),
			
		'description' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklist.description',
				'config' => array(
						'type' => 'text',
						'rows' => 3,
						'cols' => 20,
		
				),
		),
		'quantity' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklist.quantity',
				'config' => array(
						'type' => 'input',
						'size' => 13,
		
				),
		),
		'grade' => array (
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklist.grade',
				'config' => array (
						'type'     => 'select',
						'foreign_table' => 'tx_pitsstocklist_domain_model_bibusstocklistgrade',
						'foreign_table_where' => 'AND tx_pitsstocklist_domain_model_bibusstocklistgrade.pid=###CURRENT_PID### AND tx_pitsstocklist_domain_model_bibusstocklistgrade.sys_language_uid=###REC_FIELD_sys_language_uid### AND tx_pitsstocklist_domain_model_bibusstocklistgrade.deleted=0 AND tx_pitsstocklist_domain_model_bibusstocklistgrade.hidden=0',
						'size' => 10,
						'minitems' => 0,
						'maxitems' => 2,
				)
		),
		'shape' => array (
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklist.shape',
				'config' => array (
						'type'     => 'select',
						'foreign_table' => 'tx_pitsstocklist_domain_model_bibusstocklistproductshape',
						'foreign_table_where' => 'AND tx_pitsstocklist_domain_model_bibusstocklistproductshape.pid=###CURRENT_PID### AND tx_pitsstocklist_domain_model_bibusstocklistproductshape.sys_language_uid=###REC_FIELD_sys_language_uid### AND tx_pitsstocklist_domain_model_bibusstocklistproductshape.deleted=0 AND tx_pitsstocklist_domain_model_bibusstocklistproductshape.hidden=0',
						'size' => 10,
						'minitems' => 0,
						'maxitems' => 2,
				)
		),
		'size' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklist.size',
				'config' => array(
						'type' => 'input',
						'size' => 13,
		
				),
		),
		'specification' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklist.specification',
				'config' => array(
						'type' => 'input',
						'size' => 13,
		
				),
		),
		'location' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_stocklist/Resources/Private/Language/locallang_db.xml:tx_pitsstocklist_domain_model_bibusstocklist.location',
				'config' => array (
						'type'     => 'select',
						'foreign_table' => 'tx_pitsstocklist_domain_model_bibusstocklistlocation',
						'foreign_table_where' => 'AND tx_pitsstocklist_domain_model_bibusstocklistlocation.pid=###CURRENT_PID### AND tx_pitsstocklist_domain_model_bibusstocklistlocation.sys_language_uid=###REC_FIELD_sys_language_uid### AND tx_pitsstocklist_domain_model_bibusstocklistlocation.deleted=0 AND tx_pitsstocklist_domain_model_bibusstocklistlocation.hidden=0',
						'size' => 10,
						'minitems' => 0,
						'maxitems' => 2,
				)
		),	
	),
);

?>