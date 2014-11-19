<?php 

$TCA['tx_pitselearn_domain_model_dragdrop_answers'] = array (
		'ctrl' => $TCA['tx_pitselearn_domain_model_dragdrop_answers']['ctrl'],
		'interface' => array (
				'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,starttime,endtime,dragdrop_answers_text,dragdrop_answer_img'
		),
		'feInterface' => $TCA['tx_pitselearn_domain_model_dragdrop_answers']['feInterface'],
		'columns' => array (
				't3ver_label' => array (
						'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
						'config' => array (
								'type' => 'input',
								'size' => '30',
								'max'  => '30',
						)
				),

				'sys_language_uid' => array (
						'exclude' => 1,
						'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
						'config' => array (
								'type'                => 'select',
								'foreign_table'       => 'sys_language',
								'foreign_table_where' => 'ORDER BY sys_language.title',
								'items' => array(
										array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
										array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
								)
						)
				),

				'l10n_parent' => array (
						'displayCond' => 'FIELD:sys_language_uid:>:0',
						'exclude'     => 1,
						'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
						'config'      => array (
								'type'  => 'select',
								'items' => array (
										array('', 0),
								),
								'foreign_table'       => 'tx_pitselearn_domain_model_dragdrop_answers',
								'foreign_table_where' => 'AND tx_pitselearn_domain_model_dragdrop_answers.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_dragdrop_answers.sys_language_uid IN (-1,0)',
						)
				),
				'l10n_diffsource' => array (
						'config' => array (
								'type' => 'passthrough'
						)
				),
				'hidden' => array (
						'exclude' => 1,
						'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
						'config'  => array (
								'type'    => 'check',
								'default' => '0'
						)
				),
				'starttime' => array (
						'exclude' => 1,
						'label'   => 'LLL:EXT:member_rolls/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice_answers.roll_start',
						'config'  => array (
								'type'     => 'input',
								'size'     => '8',
								'max'      => '20',
								'eval'     => 'date',
								'default'  => '0',
								'checkbox' => '0'
						)
				),
				'endtime' => array (
						'exclude' => 1,
						'label'   => 'LLL:EXT:member_rolls/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice_answers.roll_end',
						'config'  => array (
								'type'     => 'input',
								'size'     => '8',
								'max'      => '20',
								'eval'     => 'date',
								'checkbox' => '0',
								'default'  => '0',
								'range'    => array (
										'upper' => mktime(3, 14, 7, 1, 19, 2038),
										'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
								)
						)
				),
				'dragdrop_answers_text' => array (
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_dragdrop.answer_title',
						'config' => array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'dragdrop_answer_img' => array(
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_dragdrop.answer_image',
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
		),
		'types' => array (
				'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, dragdrop_answers_text,dragdrop_answer_img ')
		),
		'palettes' => array (
			#	'1' => array('showitem' => 'starttime, endtime')
		)
);
?>