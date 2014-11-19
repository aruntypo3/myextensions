<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$TCA['tx_pitselearn_domain_model_matrix_question'] = array(
    'ctrl' => $TCA['tx_pitselearn_domain_model_matrix_question']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title',
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, matrix_question_title ,matrix_question_options
						,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access'),
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
                'foreign_table' => 'tx_pitselearn_domain_model_matrix',
                'foreign_table_where' => 'AND tx_pitselearn_domain_model_matrix.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_matrix.sys_language_uid IN (-1,0)',
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
        'matrix_question_title' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.question.matrix_question_title',
            'config' => array(
                'type' => 'input',
                'eval' => 'required',
                'size' => 13,
            ),
        ),
        'matrix_question_options' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.answer',
            "config" => array(
                "type" => "inline",
                "foreign_table" => "tx_pitselearn_domain_model_matrix_answer",
                "foreign_field" => "parentid",
                "foreign_table_field" => "parenttable",
                "foreign_label" => "matrix_answer_title",
                "maxitems" => 10,
                'appearance' => array(
                ),
            )
        ),
    ),
);
?>