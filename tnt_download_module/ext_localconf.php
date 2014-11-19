<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TYPO3.' . $_EXTKEY,
	'Tntdownloadmodule',
	array(
		'DownloadModule' => 'list, show,file,permalink',
		
	),
	// non-cacheable actions
	array(
		'DownloadModule' => 'list, show,file,permalink',
		
	)
);

?>