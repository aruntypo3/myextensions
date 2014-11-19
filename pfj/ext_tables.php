<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_pfj_items'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:pfj/locallang_db.xml:tx_pfj_items',		
		'label'     => 'item_name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'starttime' => 'starttime',	
			'endtime' => 'endtime',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_pfj_items.gif',
	),
);

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';

t3lib_extMgm::addPlugin(array(
	'LLL:EXT:pfj/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

t3lib_extMgm::addStaticFile($_EXTKEY,'pi1/static/','Jewellery List');

//Manually added to initialize Flexforms
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_pi1', 'FILE:EXT:' . $_EXTKEY . '/pi1/flexform_ds.xml');
//Manually added END

if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_pfj_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_pfj_pi1_wizicon.php';
}

// fe_users modified
$tempColsArray = array(
        'card_id' => array(       
            'exclude' => 0,       
            'label' => 'LLL:EXT:pfj/locallang_db.xml:fe_users.card_id',       
            'config' => array(
                'type' => 'input',   
                'size' => '30',
            )
        ),
        'babylinks' => array(       
            'exclude' => 0,       
            'label' => 'LLL:EXT:pfj/locallang_db.xml:fe_users.babylinks',       
            'config' => array(
                'type' => 'input',   
                'size' => '30',
            )
        ),
        'luvlets' => array(       
            'exclude' => 0,       
            'label' => 'LLL:EXT:pfj/locallang_db.xml:fe_users.luvlets',       
            'config' => array(
                'type' => 'input',   
                'size' => '30',
            )
        ),
        'address_line2' => array(       
            'exclude' => 0,       
            'label' => 'LLL:EXT:pfj/locallang_db.xml:fe_users.address_line2',       
            'config' => array(
                'type' => 'input',   
                'size' => '30',
            )
        ),
        'address_line3' => array(       
            'exclude' => 0,       
            'label' => 'LLL:EXT:pfj/locallang_db.xml:fe_users.address_line3',       
            'config' => array(
                'type' => 'input',   
                'size' => '30',
            )
        ),
);

t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users',$tempColsArray);
$TCA['fe_users']['feInterface']['fe_admin_fieldList'].=',card_id,babylinks,luvlets,address_line2,address_line3';
$TCA['fe_users']['ctrl']['label']='company';
t3lib_extMgm::addToAllTCATypes('fe_users','--div--;LLL:EXT:pfj/locallang_db.xml:fe_users.stockistsData,card_id;;;;1-1-1,babylinks,luvlets');
t3lib_extMgm::addToAllTCATypes('fe_users','address_line2','','after:address');
t3lib_extMgm::addToAllTCATypes('fe_users','address_line3','','after:address_line2');
?>