<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_hevents_domain_model_date'] = array(
	'ctrl' => $TCA['tx_hevents_domain_model_date']['ctrl'],
	/*
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, start, end',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, start, end,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	*/
	'interface' => array(
		'showRecordFieldList' => 'hidden, start, eventstarttime, end, eventendtime, totalseats, remainseats',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, start, eventstarttime, end, eventendtime, totalseats, remainseats'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	/*
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
				'foreign_table' => 'tx_hevents_domain_model_date',
				'foreign_table_where' => 'AND tx_hevents_domain_model_date.pid=###CURRENT_PID### AND tx_hevents_domain_model_date.sys_language_uid IN (-1,0)',
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
	*/
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
	/*
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
	*/
		'start' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_date.start',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'date,required',
				'checkbox' => 1,
				'default' => date()
			),
		),
		'eventstarttime' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_time.start',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'time,required',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'end' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_date.end',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'date,required',
				'checkbox' => 1,
				'default' => date()
			),
		),
		'eventendtime' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_time.end',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'time,required',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'totalseats' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_event.avail_seats',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
	  	),
		'remainseats' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_event.remain_seats',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
		        	//'readOnly' => '1',
			),
		),
		'event' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);

?>