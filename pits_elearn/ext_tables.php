<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pitselearn',
	'TNT E-Learning'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TNT E-Learning');

t3lib_extMgm::addLLrefForTCAdescr('tx_pitselearn_domain_model_thema', 'EXT:pits_elearn/Resources/Private/Language/locallang_csh_tx_pitselearn_domain_model_elearning.xml');

t3lib_extMgm::addLLrefForTCAdescr('tx_pitselearn_domain_model_chapter', 'EXT:pits_elearn/Resources/Private/Language/locallang_csh_tx_pitselearn_domain_model_elearning.xml');

t3lib_extMgm::allowTableOnStandardPages('tx_pitselearn_domain_model_thema');

t3lib_extMgm::allowTableOnStandardPages('tx_pitselearn_domain_model_chapter');

//Tca for thema
$TCA['tx_pitselearn_domain_model_thema'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_thema_name',
		'label' => 'thema_name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'thema_name',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Elearning.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitselearn_domain_model_elearning.gif'
	),
);

//TCA for chapter
$TCA['tx_pitselearn_domain_model_chapter'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_chapter_name',
		'label' => 'chapter_name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'chapter_name',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Elearning.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitselearn_domain_model_elearning.gif'
	),
);
$pluginSignature = str_replace('_','',$_EXTKEY).'_pitselearn';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature,'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');


t3lib_extMgm::addLLrefForTCAdescr('tx_pitselearn_domain_model_freetextquestion', 'Freetext type Questions');
t3lib_extMgm::allowTableOnStandardPages('tx_pitselearn_domain_model_freetextquestion');
$TCA['tx_pitselearn_domain_model_freetextquestion'] = array(
		'ctrl' => array(
				'title'	=> 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_freetextquestion',
				'label' => 'question_title',
				'tstamp' => 'tstamp',
				'crdate' => 'crdate',
				'cruser_id' => 'cruser_id',
				'dividers2tabs' => TRUE,

				'versioningWS' => 2,
				'versioning_followPages' => TRUE,
				'origUid' => 't3_origuid',
				'languageField' => 'sys_language_uid',
				'transOrigPointerField' => 'l10n_parent',
				'transOrigDiffSourceField' => 'l10n_diffsource',
				'delete' => 'deleted',
				'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
				),
				'searchFields' => 'question_title,',
				'requestUpdate' => 'thema_id',
				'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Freetextquestion.php',
				'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitselearn_domain_model_elearning.gif'
		),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_pitselearn_domain_model_multiplechoice', 'EXT:pits_elearn/Resources/Private/Language/locallang_csh_tx_pitselearn_domain_model_multiplechoice.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitselearn_domain_model_multiplechoice');
$TCA['tx_pitselearn_domain_model_multiplechoice'] = array(
		'ctrl' => array(
				'title'	=> 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice',
				'label' => 'multiplechoice_question_title',
				'tstamp' => 'tstamp',
				'crdate' => 'crdate',
				'cruser_id' => 'cruser_id',
				'dividers2tabs' => TRUE,

				'versioningWS' => 2,
				'versioning_followPages' => TRUE,
				'origUid' => 't3_origuid',
				'languageField' => 'sys_language_uid',
				'transOrigPointerField' => 'l10n_parent',
				'transOrigDiffSourceField' => 'l10n_diffsource',
				'delete' => 'deleted',
				'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
				),
				'searchFields' => 'multiplechoice_question_title,',
				'requestUpdate' => 'multiplechoice_question_thema',
				'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/MultipleChoice.php',
				'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitselearn_domain_model_elearning.gif'
		),
);


t3lib_extMgm::allowTableOnStandardPages('tx_pitselearn_domain_model_multiplechoice_answers');
$TCA['tx_pitselearn_domain_model_multiplechoice_answers'] = array (
		'ctrl' => array (
				'title'     => 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_multiplechoice',
				'label'     => 'uid',
				'tstamp'    => 'tstamp',
				'crdate'    => 'crdate',
				'cruser_id' => 'cruser_id',
				'versioningWS' => TRUE,
				'hideTable' => TRUE,
				'default_sortby' => 'ORDER BY crdate',
				'delete' => 'deleted',
				'enablecolumns' => array (
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
				),
				'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/MultipleChoiceAnswers.php',
				'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitselearn_domain_model_elearning.gif'
		),
);


t3lib_extMgm::addLLrefForTCAdescr('tx_pitselearn_domain_model_dragdrop', 'EXT:pits_elearn/Resources/Private/Language/locallang_csh_tx_pitselearn_domain_model_dragdrop.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitselearn_domain_model_dragdrop');
$TCA['tx_pitselearn_domain_model_dragdrop'] = array(
		'ctrl' => array(
				'title'	=> 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_dragdrop',
				'label' => 'dragdrop_title',
				'tstamp' => 'tstamp',
				'crdate' => 'crdate',
				'cruser_id' => 'cruser_id',
				'dividers2tabs' => TRUE,

				'versioningWS' => 2,
				'versioning_followPages' => TRUE,
				'origUid' => 't3_origuid',
				'languageField' => 'sys_language_uid',
				'transOrigPointerField' => 'l10n_parent',
				'transOrigDiffSourceField' => 'l10n_diffsource',
				'delete' => 'deleted',
				'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
				),
				'searchFields' => 'dragdrop_title,',
				'requestUpdate' => 'thema_id',
				'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/DragDrop.php',
				'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitselearn_domain_model_elearning.gif'
		),
);

t3lib_extMgm::allowTableOnStandardPages('tx_pitselearn_domain_model_dragdrop_answers');
$TCA['tx_pitselearn_domain_model_dragdrop_answers'] = array (
		'ctrl' => array (
				'title'     => 'TEST',
				'label'     => 'uid',
				'tstamp'    => 'tstamp',
				'crdate'    => 'crdate',
				'cruser_id' => 'cruser_id',
				'versioningWS' => TRUE,
				'hideTable' => TRUE,
				'default_sortby' => 'ORDER BY crdate',
				'delete' => 'deleted',
				'enablecolumns' => array (
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
				),
				'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/DragDropAnswers.php',
				'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitselearn_domain_model_elearning.gif'
		),
);
//matrix
t3lib_extMgm::addLLrefForTCAdescr('tx_pitselearn_domain_model_matrix', 'EXT:pits_elearn/Resources/Private/Language/locallang_csh_tx_pitselearn_domain_model_matrix.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_pitselearn_domain_model_matrix');
$TCA['tx_pitselearn_domain_model_matrix'] = array(
		'ctrl' => array(
				'title'	=> 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.main',
				'label' => 'matrix_question_title',
				'tstamp' => 'tstamp',
				'crdate' => 'crdate',
				'cruser_id' => 'cruser_id',
				'dividers2tabs' => TRUE,

				'versioningWS' => 2,
				'versioning_followPages' => TRUE,
				'origUid' => 't3_origuid',
				'languageField' => 'sys_language_uid',
				'transOrigPointerField' => 'l10n_parent',
				'transOrigDiffSourceField' => 'l10n_diffsource',
				'delete' => 'deleted',
				'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
				),
				'searchFields' => 'matrix_question_title,',
				'requestUpdate' => 'matrix_question_thema',
				'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/MatrixMain.php',
				'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitselearn_domain_model_elearning.gif'
		),
);

t3lib_extMgm::allowTableOnStandardPages('tx_pitselearn_domain_model_matrix_question');
$TCA['tx_pitselearn_domain_model_matrix_question'] = array (
		'ctrl' => array (
				'title'	=> 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.question',
				'label'     => 'uid',
				'tstamp'    => 'tstamp',
				'crdate'    => 'crdate',
				'cruser_id' => 'cruser_id',
				'versioningWS' => TRUE,
				'hideTable' => TRUE,
				'default_sortby' => 'ORDER BY crdate',
				'delete' => 'deleted',
				'enablecolumns' => array (
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
				),
				'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/MatrixQuestions.php',
				'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitselearn_domain_model_elearning.gif'
		),
);

t3lib_extMgm::allowTableOnStandardPages('tx_pitselearn_domain_model_matrix_answer');
$TCA['tx_pitselearn_domain_model_matrix_answer'] = array (
		'ctrl' => array (
				'title'	=> 'LLL:EXT:pits_elearn/Resources/Private/Language/locallang_db.xml:tx_pitselearn_domain_model_matrix.answer',
				'label'     => 'uid',
				'tstamp'    => 'tstamp',
				'crdate'    => 'crdate',
				'cruser_id' => 'cruser_id',
				'versioningWS' => TRUE,
				'hideTable' => TRUE,
				'default_sortby' => 'ORDER BY crdate',
				'delete' => 'deleted',
				'enablecolumns' => array (
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
				),
				'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/MatrixAnswer.php',
				'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitselearn_domain_model_elearning.gif'
		),
);
?>
