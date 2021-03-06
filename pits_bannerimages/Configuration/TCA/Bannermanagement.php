<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_pitsbannerimages_domain_model_bannermanagement'] = array(
	'ctrl' => $TCA['tx_pitsbannerimages_domain_model_bannermanagement']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title,
                    image,image_link,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_pitsbannerimages_domain_model_bannermanagement',
				'foreign_table_where' => 'AND tx_pitsbannerimages_domain_model_bannermanagement.pid=###CURRENT_PID### AND tx_pitsbannerimages_domain_model_bannermanagement.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:pits_bannerimages/Resources/Private/Language/locallang_db.xml:tx_pitsbannerimage.title',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',
			),
		),
		'image' => array(		
                       	'exclude' => 0,
			'label' => 'LLL:EXT:pits_bannerimages/Resources/Private/Language/locallang_db.xml:tx_pitsbannerimage.image',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
				'uploadfolder' => 'fileadmin/',
				'show_thumbs' => '1',
				'size' => '3',
				'maxitems' => '200',
				'minitems' => '0',
				'autoSizeMax' => 40,
				),
		),
		'image_link' => array(		
			'label' => 'LLL:EXT:pits_bannerimages/Resources/Private/Language/locallang_db.xml:tx_pitsbannerimage.image_link',		
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
                                    'title' => 'LLL:EXT:cms/locallang_ttc.xml:image_link_formlabel',
                                    'icon' => 'link_popup.gif',
                                    'script' => 'browse_links.php?mode=wizard',
                                    'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
                                ),
                            ),
                            'softref' => 'typolink',
                        ),
		),
	),
);

?>