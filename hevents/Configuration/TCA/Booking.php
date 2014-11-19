<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_hevents_domain_model_booking'] = array(
	'ctrl' => $TCA['tx_hevents_domain_model_booking']['ctrl'],
	/*
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, amount, price, ppstatus, ppref, delevieraddress, email, name, forename, address, zip, city, country, dname, dforename, daddress, dzip, dcity, dcountry, event, date, user',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, amount, price, ppstatus, ppref, delevieraddress, email, name, forename, address, zip, city, country, dname, dforename, daddress, dzip, dcity, dcountry, event, date, user,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	*/
	'interface' => array(
		'showRecordFieldList' => 'hidden, amount, price, ppstatus, ppref, email, name, forename, address, zip, city, country, dname, dforename, daddress, dzip, dcity, dcountry, event, date, user, lkey, transid, transstatus',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, amount, price, ppstatus, ppref, email, name, forename, address, zip, city, country, dname, dforename, daddress, dzip, dcity, dcountry, event, date, user, lkey, transid, transstatus,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_hevents_domain_model_booking',
				'foreign_table_where' => 'AND tx_hevents_domain_model_booking.pid=###CURRENT_PID### AND tx_hevents_domain_model_booking.sys_language_uid IN (-1,0)',
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
		'amount' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.amount',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'price' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.price',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2,required'
			),
		),
		'ppstatus' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.ppstatus',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.ppstatus.0', 0),
					array('LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.ppstatus.1', 1),
					array('LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.ppstatus.2', 2),
				),
			),
		),
		'ppref' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.ppref',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'delevieraddress' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.delevieraddress',
			'config' => array(
				'type' => 'check',
			),
		),
		'email'  => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'forename' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.forename',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.address',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'zip' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.zip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'country' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.country',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'dname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.dname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'dforename' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.dforename',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'daddress' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.daddress',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'dzip' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.dzip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'dcity' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.dcity',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'dcountry' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.dcountry',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'lkey' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.lkey',
			'config' => array(
				'type' => 'none',
				'size' => 30,
			),
		),
		'transid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_event.transid',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
		        'readOnly' => '1',
			),
		),
		'transstatus' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_event.transstatus',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
		        'readOnly' => '1',
			),
		),
		'event' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.event',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_hevents_domain_model_event',
				"foreign_table_where" => "AND tx_hevents_domain_model_event.sys_language_uid=0 ORDER BY tx_hevents_domain_model_event.title",
				'minitems' => 0,
				'maxitems' => 1,
				'items' => array (
					array("---",0),
				),
			),
		),
		'date' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.date',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_hevents_domain_model_date',
				'minitems' => 0,
				'maxitems' => 1,
				'items' => array (
					array("---",0),
				),
			),
		),
		'user' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking.user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
				'items' => array (
					array("---",0),
				),
			),
		),
	),
);

?>