<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_pitselearn_domain_model_freetextquestion'] = array(
		'ctrl' => $TCA['tx_pitselearn_domain_model_freetextquestion']['ctrl'],
		'interface' => array(
				'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title',
		),
		'types' => array(
				'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, question_title , question_text , image , answer_text,
						 answer_img,thema_id,chapter_id,sponser_link ,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
								'foreign_table' => 'tx_pitselearn_domain_model_freetextquestion',
								'foreign_table_where' => 'AND tx_pitselearn_domain_model_freetextquestion.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_freetextquestion.sys_language_uid IN (-1,0)',
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
				'question_title' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.question_title',
						'config' => array(
								'type' => 'input',
								'size' => '30',

						),
				),

				'question_text' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.question_text',
						'config' => array(
								'type' => 'text',
								'cols' => '40',
								'rows' => '5',

						),
				),

				'image' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.question_image',
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
				'answer_text' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.answer_text',
						'config' => array(
								'type' => 'text',
								'cols' => '40',
								'rows' => '5',
				
						),
				),
				'answer_img' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.answer_img',
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
				
				'thema_id' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.thema_name',
						'config' => array(
								'type' => 'select',
								'items' => array(
											array('LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.select_thema', 0),
											),
								'foreign_table' => 'tx_pitselearn_domain_model_thema',
								'foreign_table_where' => 'AND tx_pitselearn_domain_model_thema.pid = ###CURRENT_PID### AND tx_pitselearn_domain_model_thema.hidden = 0 
								  						  AND tx_pitselearn_domain_model_thema.deleted = 0 AND tx_pitselearn_domain_model_thema.sys_language_uid IN (-1,0)',

						),
				),
				
								
				'chapter_id' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.chapter_name',
						'config' => array(
								'type' => 'select',
								'items' => array(
											array('LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.select_chapter', 0),
											),
								'foreign_table' => 'tx_pitselearn_domain_model_chapter',
								'foreign_table_where' => 'AND tx_pitselearn_domain_model_chapter.pid = ###CURRENT_PID### AND tx_pitselearn_domain_model_chapter.thema_id = ###REC_FIELD_thema_id### 
														  AND tx_pitselearn_domain_model_chapter.hidden = 0 AND tx_pitselearn_domain_model_chapter.deleted = 0 
														  AND tx_pitselearn_domain_model_chapter.sys_language_uid IN (-1,0)',

						),
				),
				
				
				'sponser_link' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.sponser_link',
						'config' => array(
								'type' => 'input',
								'size' => '30',
				
						),
				),
				'points' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.points',
						'config' => array(
								'type' => 'input',
								'size' => '30',
								'eval' => 'int',
								'range' => array( 'lower' => 0, 'upper' => 1 ),
						),
				),
				
				
				
		),
);

?>