<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_tntblumenshop_products'] = array(
	'ctrl' => $TCA['tx_tntblumenshop_products']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title,image',
	),
	'feInterface' => $TCA['tx_tntblumenshop_products']['feInterface'],
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'title' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_products.title',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			)
		),
		'image' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_products.image',		
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_tntblumenshop',
				'show_thumbs' => 1,	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'price_1' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_products.price_1',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			)
		),
		'price_2' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_products.price_2',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			)
		),
		'price_3' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_products.price_3',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			)
		),
		'category' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_products.category',		
			'config' => array(
				'type' => 'select',	
				'foreign_table' => 'tx_tntblumenshop_cat',	
				'foreign_table_where' => 'AND tx_tntblumenshop_cat.hidden = 0  AND tx_tntblumenshop_cat.deleted = 0 ORDER BY tx_tntblumenshop_cat.uid',	
				'size' => 5,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),	
	),
	'types' => array(
		'0' => array('showitem' => 'hidden, title, image, price_1, price_2, price_3, category')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_tntblumenshop_cat'] = array(
	'ctrl' => $TCA['tx_tntblumenshop_cat']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title'
	),
	'feInterface' => $TCA['tx_tntblumenshop_cat']['feInterface'],
	'columns' => array(
		'hidden' => array(		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type'    => 'check',
				'default' => '0'
			)
		),
		'title' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_cat.title',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_tntblumenshop_productlog'] = array(
	'ctrl' => $TCA['tx_tntblumenshop_productlog']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,patient_name',
	),
	'feInterface' => $TCA['tx_tntblumenshop_productlog']['feInterface'],
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'patient_name' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.name',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'patient_vorname' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.vorname',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'patient_wohnort' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.wohnort',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'total_price' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.totalprice',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
				'readOnly' => '1',
			)
		),
		'product' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.product',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
				'readOnly' => '1',
			)
		),
		'special_requests' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.special_requests',		
			'config' => array(
				'type' => 'text',
				'cols' => '40',
        		'rows' => '15',	
			)
		),
		'special_comments' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.special_comments',		
			'config' => array(
				'type' => 'text',
				'cols' => '40',
        		'rows' => '15',	
			)
		),
		'transaction_id' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.transaction_id',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
				'readOnly' => '1',
			)
		),
		'reference_number' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.reference_number',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
				'readOnly' => '1',
			)
		),
		'trans_status' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.trans_status',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
				'readOnly' => '1',
			)
		),
		'name' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.contactname',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'vorname' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.contactvorname',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'company' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.company',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'street' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.street',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'zip' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.zip',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'land' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.land',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'phone' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.phone',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'mobile' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.mobile',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'email' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.email',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'ip_address' => array(		
			'exclude' => 0,		
			'label' => 'LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:tx_tntblumenshop_productlog.ip_address',		
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'readOnly' => '1',
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => '--div--;LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:product_info_tab, hidden, patient_name, patient_vorname, patient_wohnort, total_price,
									product, special_requests, special_comments, transaction_id, reference_number, trans_status,
									--div--;LLL:EXT:tnt_blumenshop/Resources/Private/Language/locallang_db.xml:contact_info_tab,name,
									vorname, company, street, zip, land, phone, mobile, email, ip_address')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>