<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$TCA['tx_pitselearn_domain_model_dragdrop'] = array(
    'ctrl' => $TCA['tx_pitselearn_domain_model_dragdrop']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title,dragdrop_title,dragdrop_question,dragdrop_sponser_link,dragdrop_points,dragdrop_answer',
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden,dragdrop_title,dragdrop_question,dragdrop_sponser_link,thema_id,chapter_id,dragdrop_answer;;1, title,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
                'foreign_table' => 'tx_pitselearn_domain_model_dragdrop',
                'foreign_table_where' => 'AND tx_pitselearn_domain_model_dragdrop.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_dragdrop.sys_language_uid IN (-1,0)',
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
        'dragdrop_title' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_dragdrop.dragdrop_title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
        'dragdrop_question' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_dragdrop.dragdrop_question',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
        'dragdrop_sponser_link' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_dragdrop.dragdrop_sponser_link',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
        'dragdrop_points' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_dragdrop.dragdrop_points',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'int',
        		'range' => array( 'lower' => 0,'upper' => 1 ),
            )
        ),
        'thema_id' => array(
			'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_thema_name',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_pitselearn_domain_model_thema',
                                'foreign_table_where' => 'AND tx_pitselearn_domain_model_thema.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_thema.sys_language_uid IN (-1,0)',
			),
         ),
        'chapter_id' => array(
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_chapter_name',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_pitselearn_domain_model_chapter',
                                'foreign_table_where' => 'AND tx_pitselearn_domain_model_chapter.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_chapter.sys_language_uid IN (-1,0)
                                                          AND tx_pitselearn_domain_model_chapter.thema_id = ###REC_FIELD_thema_id###',
			),
		),

        'dragdrop_answer' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_dragdrop.dragdrop_answer',
            "config" => array(
                "type" => "inline",
                "foreign_table" => "tx_pitselearn_domain_model_dragdrop_answers",
                "foreign_field" => "parentid",
                "foreign_table_field" => "parenttable",
                "foreign_label" => "dragdrop_answers_text",
                "maxitems" => 10,
                'appearance' => array(
                #'showSynchronizationLink' => 1,
                #'showAllLocalizationLink' => 1,
                #'showPossibleLocalizationRecords' => 1,
                #'showRemovedLocalizationRecords' => 1,
                ),
            /* 'behaviour' => array(
              'localizationMode' => 'select',
              ), */
            )
        ),
    ),
);
?>