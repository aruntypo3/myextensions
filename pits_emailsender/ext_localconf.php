<?php

if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][$_EXTKEY] = array(
	'extension'        => $_EXTKEY,
	'title'            => 'LLL:EXT:' . $_EXTKEY . '/locallang_db.xml:tx_pits_emailsender.name',
	'description'      => 'LLL:EXT:' . $_EXTKEY . '/locallang_db.xml:tx_pits_emailsender.description',
	'additionalFields' => ''
);


?>
