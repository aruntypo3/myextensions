<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'Bibusimagegallery',
	array(
		'Bibusimagegallery' => 'rendergallery',
		
	),
	// non-cacheable actions
	array(
		'Bibusimagegallery' => 'rendergallery',
		
	)
);

?>
