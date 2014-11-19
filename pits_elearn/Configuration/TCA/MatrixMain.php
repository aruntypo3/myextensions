<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$TCA['tx_pitselearn_domain_model_matrix'] = array(
    'ctrl' => $TCA['tx_pitselearn_domain_model_matrix']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title',
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, matrix_question_title ,matrix_question_colname1,matrix_question_colname2,matrix_question_colname3,matrix_question_text , matrix_question_thema  , matrix_question_chapter ,matrix_sponser,matrix_question_img,matrix_question_answer
						,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.main.matrix_question_title',
            'config' => array(
                'type' => 'input',
                'eval' => 'required',
                'size' => 30,
            ),
        ),
        'matrix_question_text' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.main.matrix_question_text',
            'config' => array(
                'type' => 'text',
                'cols' => '40',
                'rows' => '5',
            ),
        ),
        'matrix_question_colname1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.main.matrix_question_colname1',
            'config' => array(
                'type' => 'input',
                'eval' => 'required',
                'size' => 30,
            ),
        ),
        'matrix_question_colname2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.main.matrix_question_colname2',
            'config' => array(
                'type' => 'input',
                'eval' => 'required',
                'size' => 30,
            ),
        ),
        'matrix_question_colname3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.main.matrix_question_colname3',
            'config' => array(
                'type' => 'input',
                'eval' => 'required',
                'size' => 30,
            ),
        ),
        'matrix_question_thema' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.main.matrix_question_thema',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('Select thema', ''),
                ),
                'eval' => 'required',
                'foreign_table' => 'tx_pitselearn_domain_model_thema',
                'foreign_table_where' => 'AND tx_pitselearn_domain_model_thema.pid=###CURRENT_PID### AND tx_pitselearn_domain_model_thema.sys_language_uid= 0 AND tx_pitselearn_domain_model_thema.deleted= 0 AND tx_pitselearn_domain_model_thema.hidden = 0 ',
            ),
        ),
        'matrix_question_chapter' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.main.matrix_question_chapter',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion.select_chapter', ''),
                ),
                'eval' => 'required',
                'foreign_table' => 'tx_pitselearn_domain_model_chapter',
                'foreign_table_where' => 'AND tx_pitselearn_domain_model_chapter.pid=###CURRENT_PID### AND  tx_pitselearn_domain_model_chapter.sys_language_uid = 0 AND tx_pitselearn_domain_model_chapter.thema_id =  ###REC_FIELD_matrix_question_thema### AND tx_pitselearn_domain_model_chapter.deleted= 0 AND tx_pitselearn_domain_model_chapter.hidden = 0 ',
            ),
        ),
        'matrix_sponser' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.main.matrix_sponser',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            ),
        ),
        'matrix_question_point' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.main.matrix_question_point',
            'config' => array(
                'type' => 'input',
                'size' => 30,
        		'eval' => 'int',
				'range' => array( 'lower' => 0, 'upper' => 1 ),
            ),
        ),
        'matrix_question_img' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.main.matrix_question_img',
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
        'matrix_question_answer' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.question',
            "config" => array(
                "type" => "inline",
                "foreign_table" => "tx_pitselearn_domain_model_matrix_question",
                "foreign_field" => "parentid",
                "foreign_table_field" => "parenttable",
                "foreign_label" => "matrix_question_title",
                "maxitems" => 10,
                'appearance' => array(
                ),
            )
        ),
    ),
);
?>