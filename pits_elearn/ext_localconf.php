<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pitselearn',
	array(
		'Elearning' => 'select,ajaxChapters,detail,showResult,resultRender,themaLink',
		
	),
	// non-cacheable actions
	array(
		'Elearning' => 'select,ajaxChapters,detail,showResult,resultRender,themaLink',
		
	)
);

?>