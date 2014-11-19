<?php 

$TCA['tx_pitselearn_domain_model_multiplechoice_answers'] = array (
		'ctrl' => $TCA['tx_pitselearn_domain_model_multiplechoice_answers']['ctrl'],
		'interface' => array (
				'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,starttime,endtime,multiplechoice_answers_title'
		),
		'feInterface' => $TCA['tx_pitselearn_domain_model_multiplechoice_answers']['feInterface'],
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
								'foreign_table'       => 'tx_pitselearn_domain_model_multiplechoice_answers',
								'foreign_table_where' => 'AND tx_pitselearn_domain_model_multiplechoice_answers.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_multiplechoice_answers.sys_language_uid IN (-1,0)',
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
				'multiplechoice_answers_title' => array (
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice.multiplechoice_answers_title',
						'config' => array (
								'type' => 'input',
								'size' => '30',
								'eval' => 'trim',
						)
				),
				'multiplechoice_answers_is_true' => array (
						'exclude' => 0,
						'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice.multiplechoice_answers_is_true',
						'config' => array (
								'type' => 'check',
								'size' => '30',
								'eval' => 'trim',
								
						)
				),
		),
		'types' => array (
				'0' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, multiplechoice_answers_title , multiplechoice_answers_is_true ')
		),
		'palettes' => array (
			#	'1' => array('showitem' => 'starttime, endtime')
		)
);
?>