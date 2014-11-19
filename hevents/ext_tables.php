<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Henry Events');

Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY,'Pi1','Henry Events');
Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY,'Pi2','Henry User Bookings');
Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY,'Pi3','Henry Archieve');
Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY,'Pi4','Henry User Register');
Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY,'Pi5','Henry User Edit');
Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY,'Pi6','Henry User Favourits');
Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY,'Pi7','Henry Saferpay');

t3lib_extMgm::addLLrefForTCAdescr('tx_hevents_domain_model_event', 'EXT:hevents/Resources/Private/Language/locallang_csh_tx_hevents_domain_model_event.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_hevents_domain_model_event');
$TCA['tx_hevents_domain_model_event'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_event',
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
		'searchFields' => 'title,description,latitude,longitude,location,price,images,categories,dates,city,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Event.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_hevents_domain_model_event.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_hevents_domain_model_category', 'EXT:hevents/Resources/Private/Language/locallang_csh_tx_hevents_domain_model_category.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_hevents_domain_model_category');
$TCA['tx_hevents_domain_model_category'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_category',
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
		'sortby' => 'sorting',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,description,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Category.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_hevents_domain_model_category.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_hevents_domain_model_date', 'EXT:hevents/Resources/Private/Language/locallang_csh_tx_hevents_domain_model_date.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_hevents_domain_model_date');
$TCA['tx_hevents_domain_model_date'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_date',
		'label' => 'start',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		#'versioningWS' => 2,
		#'versioning_followPages' => TRUE,
		#'origUid' => 't3_origuid',
		#'languageField' => 'sys_language_uid',
		#'transOrigPointerField' => 'l10n_parent',
		#'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'start,end,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Date.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_hevents_domain_model_date.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_hevents_domain_model_booking', 'EXT:hevents/Resources/Private/Language/locallang_csh_tx_hevents_domain_model_booking.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_hevents_domain_model_booking');
$TCA['tx_hevents_domain_model_booking'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_booking',
		'label' => 'event',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		#'versioningWS' => 2,
		#'versioning_followPages' => TRUE,
		#'origUid' => 't3_origuid',
		#'languageField' => 'sys_language_uid',
		#'transOrigPointerField' => 'l10n_parent',
		#'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'amount,ppstatus,ppref,event,date,user,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Booking.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_hevents_domain_model_booking.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_hevents_domain_model_city', 'EXT:hevents/Resources/Private/Language/locallang_csh_tx_hevents_domain_model_city.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_hevents_domain_model_city');
$TCA['tx_hevents_domain_model_city'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_city',
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
		'searchFields' => 'title,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/City.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_hevents_domain_model_city.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_hevents_domain_model_country', 'EXT:hevents/Resources/Private/Language/locallang_csh_tx_hevents_domain_model_country.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_hevents_domain_model_country');
$TCA['tx_hevents_domain_model_country'] = array(
		'ctrl' => array(
				'title'	=> 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_country',
				'label' => 'country',
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
				'searchFields' => 'title,',
				'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Country.php',
				'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_hevents_domain_model_country.gif'
		),
);

/*
t3lib_div::loadTCA('fe_user');
if (!isset($TCA['fe_user']['ctrl']['type'])) {
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$TCA['fe_user']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumns = array();
	$tempColumns[$TCA['fe_user']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user.tx_extbase_type.0','0'),
			),
			'size' => 1,
			'maxitems' => 1,
			'default' => 'Tx_Hevents_User'
		)
	);
	t3lib_extMgm::addTCAcolumns('fe_user', $tempColumns, 1);
}

$TCA['fe_user']['types']['Tx_Hevents_User']['showitem'] = $TCA['fe_user']['types']['Tx_Extbase_Domain_Model_FrontendUser']['showitem'];
$TCA['fe_user']['columns'][$TCA['fe_user']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user','Tx_Hevents_User');
t3lib_extMgm::addToAllTCAtypes('fe_user', $TCA['fe_user']['ctrl']['type'],'','after:hidden');
*/
$tmp_hevents_columns = array(

	'dname' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user.dname',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'dforename' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user.dforename',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'daddress' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user.daddress',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'dzip' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user.dzip',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'dcity' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user.dcity',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'dcountry' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user.dcountry',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'optkey' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user.optkey',
		'config' => array(
			'type' => 'none',
		),
	),
	'opt' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user.opt',
		'config' => array(
			'type' => 'none',
		),
	),
	'favs' => array(
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' => 'LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user.favs',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_hevents_domain_model_event',
			"foreign_table_where" => "AND tx_hevents_domain_model_event.sys_language_uid=0 ORDER BY tx_hevents_domain_model_event.title",
			'MM' => 'tx_hevents_user_event_mm',
			'size' => 10,
			'autoSizeMax' => 30,
			'maxitems' => 9999,
			'multiple' => 0,
			'wizards' => array(
				'_PADDING' => 1,
				'_VERTICAL' => 1,
				/*
				'edit' => array(
					'type' => 'popup',
					'title' => 'Edit',
					'script' => 'wizard_edit.php',
					'icon' => 'edit2.gif',
					'popup_onlyOpenIfSelected' => 1,
					'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
				*/
				'add' => Array(
					'type' => 'script',
					'title' => 'Create new',
					'icon' => 'add.gif',
					'params' => array(
						'table' => 'tx_hevents_domain_model_event',
						'pid' => '###CURRENT_PID###',
						'setValue' => 'prepend'
						),
					'script' => 'wizard_add.php',
				),
			),
		),
	),
);

t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users',$tmp_hevents_columns,1);
t3lib_extMgm::addToAllTCAtypes('fe_users','--div--;Deliver Data, dname, dforename, daddress, dzip, dcity, dcountry');
t3lib_extMgm::addToAllTCAtypes('fe_users','--div--;Opt In, optkey, opt');
t3lib_extMgm::addToAllTCAtypes('fe_users','--div--;Favourits, favs');

/*
t3lib_extMgm::addTCAcolumns('fe_user',$tmp_hevents_columns);

$TCA['fe_user']['columns'][$TCA['fe_user']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:fe_user.tx_extbase_type.Tx_Hevents_User','Tx_Hevents_User');

$TCA['fe_user']['types']['Tx_Hevents_User']['showitem'] = $TCA['fe_user']['types']['Tx_Extbase_Domain_Model_FrontendUser']['showitem'];
$TCA['fe_user']['types']['Tx_Hevents_User']['showitem'] .= ',--div--;LLL:EXT:hevents/Resources/Private/Language/locallang_db.xml:tx_hevents_domain_model_user,';
$TCA['fe_user']['types']['Tx_Hevents_User']['showitem'] .= 'dname, dforename, daddress, dzip, dcity, dcountry';
*/
?>