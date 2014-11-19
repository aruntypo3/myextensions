<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_tour_partners'] = array(
		'ctrl' => $TCA['tx_tour_partners']['ctrl'],
		'interface' => array(
				'showRecordFieldList' => 'sys_language_uid, hidden, image_link, partner_logos'
		),
		'feInterface' => $TCA['tx_tour_partners']['feInterface'],
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
								'foreign_table_where' => 'AND tx_tour_partners.pid=###CURRENT_PID### AND tx_tour_partners.sys_language_uid IN (-1,0)',
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
				'image_link' => array(
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour_partners.image_link',
						'exclude' => 1,
						'config' => array(
								'type' => 'input',
								'size' => '30',
								'max' => '256',
								'eval' => 'trim',
								'wizards' => array(
										'_PADDING' => 2,
										'link' => array(
												'type' => 'popup',
												'title' => 'LLL:EXT:cms/locallang_ttc.xml:header_link_formlabel',
												'icon' => 'link_popup.gif',
												'script' => 'browse_links.php?mode=wizard',
												'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
										),
								),
								'softref' => 'typolink',
						),
				),
				'partner_logos' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour_partners.partnerLogo',
						'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('partner_logos', array(
			                'type' => 'inline',
			                'elementBrowserType' => 'file',
			                'appearance' => array(
			                    'createNewRelationLinkTitle' => 'LLL:EXT:vst_tour/Resources/Private/Language/locallang_db.xml:tx_tour.addImage',
			                    'collapseAll' => TRUE,
			                ),
			                'maxitems' => '1',
			                'minitems' => '0',
			            	), $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']),
				),
		),
		'types' => array(
				'0' => array('showitem' => 'hidden;;1;;1-1-1, image_link, partner_logos;;;;2-2-2')
		),
		'palettes' => array(
				'1' => array('showitem' => '')
		)
);
?>