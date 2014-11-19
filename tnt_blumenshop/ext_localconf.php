<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Tntblumenshop',
	array(
		'Blumenshop' => 'list, show, contact, payment',
		
	),
	// non-cacheable actions
	array(
		'Blumenshop' => 'list, show, contact, payment',
		
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Tntblumenshopteaser',
	array(
		'Teaser' => 'teaserView',
		
	),
	// non-cacheable actions
	array(
		'Teaser' => 'teaserView',
		
	)
);

?>