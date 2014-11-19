<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_pitselearn_domain_model_multiplechoice'] = array(
		'ctrl' => $TCA['tx_pitselearn_domain_model_multiplechoice']['ctrl'],
		'interface' => array(
				'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, multiplechoice_question_title',
		),
		'types' => array(
				'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, multiplechoice_question_title , multiplechoice_question_text , multiplechoice_question_thema , multiplechoice_question_chapter ,multiplechoice_sponser,multiplechoice_question_img, multiplechoice_answer ,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
								'foreign_table' => 'tx_pitselearn_domain_model_multiplechoice',
								'foreign_table_where' => 'AND tx_pitselearn_domain_model_multiplechoice.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_multiplechoice.sys_language_uid IN (-1,0)',
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
				'multiplechoice_question_title' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice.multiplechoice_question_title',
						'config' => array(
								'type' => 'input',
								'size' => 30,
								#'max' => 20,
						),
				),

				'multiplechoice_question_text' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice.multiplechoice_question_text',
						'config' => array(
								'type' => 'text',
								'cols' => '40',
								'rows' => '5',

						),
				),
				'multiplechoice_question_thema' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice.multiplechoice_question_thema',
						'config' => array(
								'type' => 'select',
								'items' => array (
										array('Select thema', ''),
								),
								'foreign_table' => 'tx_pitselearn_domain_model_thema',
								'foreign_table_where' => 'AND tx_pitselearn_domain_model_thema.sys_language_uid= 0 AND tx_pitselearn_domain_model_thema.deleted= 0 AND tx_pitselearn_domain_model_thema.hidden = 0 ',
				
						),
				),
				
				'multiplechoice_question_chapter' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice.multiplechoice_question_chapter',
						'config' => array(
								'type' => 'select',
								'items' => array (
										array('Select thema', ''),
								),
								'foreign_table' => 'tx_pitselearn_domain_model_chapter',
								'foreign_table_where' => 'AND tx_pitselearn_domain_model_chapter.sys_language_uid = 0 AND tx_pitselearn_domain_model_chapter.thema_id =  ###REC_FIELD_multiplechoice_question_thema### AND tx_pitselearn_domain_model_chapter.deleted= 0 AND tx_pitselearn_domain_model_chapter.hidden = 0 ',
				
						),
				),
				'multiplechoice_question_points' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice.multiplechoice_multiplechoice_question_points',
						'config' => array(
								'type' => 'input',
								'size' => '30',
								'eval' => 'int',
								'range' => array( 'lower' => 0, 'upper' => 1 ),
						),
				),
				'multiplechoice_question_img' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.multiplechoice_question_img text',
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
				
				'multiplechoice_sponser' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice.multiplechoice_sponser',
						'config' => array(
								'type' => 'input',
								'size' => '30',

						),
				),
				'multiplechoice_answer' => array (
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice.tx_pitselearn_domain_model_multiplechoice.multiplechoice_multiplechoice_question_answers',
						"config" => array (
								"type" => "inline",
								"foreign_table" => "tx_pitselearn_domain_model_multiplechoice_answers",
								"foreign_field" => "parentid",
								"foreign_table_field" => "parenttable",
								"foreign_label" => "multiplechoice_answers_title",
								"maxitems" => 10,
								'appearance' => array(
										#'showSynchronizationLink' => 1,
										#'showAllLocalizationLink' => 1,
										#'showPossibleLocalizationRecords' => 1,
										#'showRemovedLocalizationRecords' => 1,
								),
								/*'behaviour' => array(
									'localizationMode' => 'select',
								),*/
						)
				),
		),
);





?>