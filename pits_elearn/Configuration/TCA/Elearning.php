<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_pitselearn_domain_model_thema'] = array(
		'ctrl' => $TCA['tx_pitselearn_domain_model_thema']['ctrl'],
		'interface' => array(
				'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,thema_name',
		),
		'types' => array(
				'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden,thema_name;;1,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
								'foreign_table' => 'tx_pitselearn_domain_model_thema',
								'foreign_table_where' => 'AND tx_pitselearn_domain_model_thema.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_thema.sys_language_uid IN (-1,0)',
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
				'thema_name' => array(
						'l10n_mode' => 'mergeIfNotBlank',
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_thema_name',
						'config' => array(
								'type' => 'input',
								'size' => 20,
								'max' => 120
						),
				),
		),
);

$TCA['tx_pitselearn_domain_model_chapter'] = array(
		'ctrl' => $TCA['tx_pitselearn_domain_model_chapter']['ctrl'],
		'interface' => array(
				'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,chapter_name,thema_id',
		),
		'types' => array(
				'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden,chapter_name,thema_id,partners;;1,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
								'foreign_table' => 'tx_pitselearn_domain_model_chapter',
								'foreign_table_where' => 'AND tx_pitselearn_domain_model_chapter.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_chapter.sys_language_uid IN (-1,0)',
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
				'chapter_name' => array(
						'l10n_mode' => 'mergeIfNotBlank',
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_chapter_name',
						'config' => array(
								'type' => 'input',
								'size' => 30,
								'max' => 120
						),
				),
				'thema_id' => array(
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_thema_name',
						'config' => array(
								'type' => 'select',
								'items' => array(
										array('', 0),
								),
								'foreign_table' => 'tx_pitselearn_domain_model_thema',
								'foreign_table_where' => 'AND tx_pitselearn_domain_model_thema.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_thema.sys_language_uid= 0 AND tx_pitselearn_domain_model_thema.deleted= 0 AND tx_pitselearn_domain_model_thema.hidden = 0 ',
						),
				),
				'partners' => array(
						'exclude' => 1,
						'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
						'config' => array(
								'type' => 'select',
								'size' => 7,
								'maxitems' => 20,
								'foreign_table' => 'tx_pitspartner_domain_model_partner',
								'foreign_table_where' => 'AND tx_pitspartner_domain_model_partner.pid=122 AND tx_pitspartner_domain_model_partner.sys_language_uid IN (-1,0) ORDER BY tx_pitspartner_domain_model_partner.title',
								/* 'foreign_table' => 'tx_pitspartner_domain_model_partner',
								'foreign_table_where' => 'AND tx_pitspartner_domain_model_partner.pid=###CURRENT_PID### AND tx_pitspartner_domain_model_partner.sys_language_uid= 0 AND tx_pitspartner_domain_model_partner.deleted= 0 AND tx_pitspartner_domain_model_partner.hidden = 0 ', */
						),
				),
		),
);

?>