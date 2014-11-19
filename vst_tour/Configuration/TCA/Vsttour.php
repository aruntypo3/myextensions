<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_tour_categories'] = array(
		'ctrl' => $TCA['tx_tour_categories']['ctrl'],
		'interface' => array(
				'showRecordFieldList' => 'sys_language_uid, hidden, cat_title'
		),
		'feInterface' => $TCA['tx_tour_categories']['feInterface'],
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
								'foreign_table' => 'tx_tour_categories',
								'foreign_table_where' => 'AND tx_tour_categories.pid=###CURRENT_PID### AND tx_tour_categories.sys_language_uid IN (-1,0)',
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
						'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
						'config'  => array(
								'type'    => 'check',
								'default' => '0'
						)
				),
				'cat_title' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_vsttour_domain_model_cat.title',
						'config' => array(
								'type' => 'input',
								'size' => '30',
						)
				),
		),
		'types' => array(
				'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, hidden;;1;;1-1-1, cat_title;;;;2-2-2')
		),
		'palettes' => array(
				'1' => array('showitem' => '')
		)
);

$TCA['tx_tour'] = array(
		'ctrl' => $TCA['tx_tour']['ctrl'],
		'interface' => array(
				'showRecordFieldList' => 'sys_language_uid, hidden, category_id, tour_id, tour_title, price_before, carousel_images, description, testemonial, youtube_link, gps_latitude, gps_longitude, map, highlights, benefits, contact, partner_images',
		),
		'feInterface' => $TCA['tx_tour']['feInterface'],
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
								'foreign_table' => 'tx_tour',
								'foreign_table_where' => 'AND tx_tour.pid=###CURRENT_PID### AND tx_tour.sys_language_uid IN (-1,0)',
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
				'category_id' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.category_id',
						'config' => array(
								'type' => 'select',
								'items' => array(
										array('LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.select', 0)
								),
								'foreign_table' => 'tx_tour_categories',
								'foreign_table_where' => 'AND tx_tour_categories.hidden = 0 AND tx_tour_categories.deleted = 0 AND tx_tour_categories.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_tour_categories.sort_order',
								'size' => 1,
								'minitems' => 0,
								'maxitems' => 1,
						)
				),
				'tour_id' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.tour_id',
						'config' => Array (
							'type' => 'select',
							'items' => array(
									array('LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.select', 0)
							),
							'size' => 1,    
			            	'minitems' => 0,
							'maxitems' => 1,
							'itemsProcFunc' => "EXT:vst_tour/Configuration/TCAHelpers/user_vsttourtcahelper.php:&user_vsttourtcahelper->user_getTours", 
						)
				),
				'tour_title' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.tour_title',
						'config' => array(
								'type' => 'input',
								'size' => '30',
						)
				),
				'price_before' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.price_before',
						'config' => array(
								'type' => 'input',
								'size' => '30',
						)
				),
				'carousel_images' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.carousel_images',
						'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('carousel_images', array(
			                'type' => 'inline',
			                'elementBrowserType' => 'file',
			                'appearance' => array(
			                    'createNewRelationLinkTitle' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.addImage',
			                    'collapseAll' => TRUE,
			                ),
			                'maxitems' => '9999',
			                'minitems' => '0',
			            	), $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']),
				),
				'description' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.description',
						'config' => array(
							'type' => 'text',
							'cols' => 30,
							'rows' => 5,
							'wizards' => array(
								'_PADDING' => 2,
								'RTE' => array(
									'notNewRecords' => 1,
									'RTEonly' => 1,
									'type' => 'script',
									'title' => 'Full screen Rich Text Editing',
									'icon' => 'wizard_rte2.gif',
									'script' => 'wizard_rte.php',
								),
							),
						),
						'defaultExtras' => 'richtext[*]'
				),
				'testemonial' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.testemonial',
						'config' => array(
							'type' => 'text',
							'cols' => 30,
							'rows' => 5,
							'wizards' => array(
								'_PADDING' => 2,
								'RTE' => array(
									'notNewRecords' => 1,
									'RTEonly' => 1,
									'type' => 'script',
									'title' => 'Full screen Rich Text Editing',
									'icon' => 'wizard_rte2.gif',
									'script' => 'wizard_rte.php',
								),
							),
						),
						'defaultExtras' => 'richtext[*]'
				),
				'youtube_link' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.youtube_link',
						'config' => array(
								'type' => 'input',
								'size' => '30',
						)
				),
				'gps_latitude' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.gps_latitude',
						'config' => array(
								'type' => 'input',
								'size' => 30,
								'max' => 10,
								'eval' => 'trim',
								'checkbox' => 0,
								'default' => '0.00',
						),
				),
				'gps_longitude' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.gps_longitude',
						'config' => array(
								'type' => 'input',
								'size' => 30,
								'max' => 10,
								'eval' => 'trim',
								'checkbox' => 0,
								'default' => '0.00',
						),
				),
				'map' => array(
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.map',
						'config' => array(
								'type' => 'user',
								'userFunc' => 'EXT:vst_tour/Configuration/TCAHelpers/tx_climbingsites_tca_map.php:&tx_ClimbingSites_Tca_Map->render',
								'parameters' => array(
										'latitude' => 'gps_latitude',
										'longitude' => 'gps_longitude',
								),
						),
				),
				'highlights' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.highlights',
						'config' => array(
								'type' => 'text',
								'cols' => 30,
								'rows' => 5,
								'wizards' => array(
										'_PADDING' => 2,
										'RTE' => array(
												'notNewRecords' => 1,
												'RTEonly' => 1,
												'type' => 'script',
												'title' => 'Full screen Rich Text Editing',
												'icon' => 'wizard_rte2.gif',
												'script' => 'wizard_rte.php',
										),
								),
						),
						'defaultExtras' => 'richtext[*]'
				),
				'benefits' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.benefits',
						'config' => array(
							'type' => 'text',
							'cols' => 30,
							'rows' => 5,
							'wizards' => array(
								'_PADDING' => 2,
								'RTE' => array(
									'notNewRecords' => 1,
									'RTEonly' => 1,
									'type' => 'script',
									'title' => 'Full screen Rich Text Editing',
									'icon' => 'wizard_rte2.gif',
									'script' => 'wizard_rte.php',
								),
							),
						),
						'defaultExtras' => 'richtext[*]'
				),
				'contact' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.contact',
						'config' => array(
								'type' => 'text',
								'cols' => 30,
								'rows' => 5,
								'wizards' => array(
										'_PADDING' => 2,
										'RTE' => array(
												'notNewRecords' => 1,
												'RTEonly' => 1,
												'type' => 'script',
												'title' => 'Full screen Rich Text Editing',
												'icon' => 'wizard_rte2.gif',
												'script' => 'wizard_rte.php',
										),
								),
						),
						'defaultExtras' => 'richtext[*]'
				),
				'partner_images' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.partner_images',
						"config" => array(
								"type" => "inline",
								"foreign_table" => "tx_tour_partners",
								"foreign_field" => "parentid",
								"foreign_label" => "image_link",
								"maxitems" => 1000,
								'appearance' => array(
									'collapseAll' => 1,
									'expandSingle' => 1,
								),
						)
				),
		),
		'types' => array(
				'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, hidden, category_id, tour_id, tour_title, price_before, carousel_images, description;;;richtext::rte_transform[flag=rte_disabled|mode=ts_css], testemonial;;;richtext::rte_transform[flag=rte_disabled|mode=ts_css], youtube_link, gps_latitude, gps_longitude, map, highlights;;;richtext::rte_transform[flag=rte_disabled|mode=ts_css], benefits;;;richtext::rte_transform[flag=rte_disabled|mode=ts_css], contact;;;richtext::rte_transform[flag=rte_disabled|mode=ts_css], partner_images')
		),
		'palettes' => array(
				'1' => array('showitem' => '')
		)
);
?>