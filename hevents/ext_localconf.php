<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin( 
	$_EXTKEY, 
	'Pi1', 
	array(
		'Event' => 'list, single',
		'Booking' => 'book, choose, submit, pay, done, problem, list',
		'User' => 'removefav, addfav'
	),
	array(
		'Event' => 'list, single',
		'Booking' => 'book, choose, submit, pay, done, list',
		'User' => 'removefav, addfav'
	)
);

Tx_Extbase_Utility_Extension::configurePlugin( 
	$_EXTKEY, 
	'Pi2', 
	array(
		'Booking' => 'list',
		'Event' => 'single',
	),
	array(
		'Booking' => 'list',
		'Event' => 'single',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin( 
	$_EXTKEY, 
	'Pi3', 
	array(
		'Event' => 'archieve, single',
		'User' => 'removefav, addfav',
	),
	array(
		'Event' => 'archieve, single',
		'User' => 'removefav, addfav',
	)
);


Tx_Extbase_Utility_Extension::configurePlugin( 
	$_EXTKEY, 
	'Pi4', 
	array(
		'User' => 'register, submit, optin',
	),
	array(
		'User' => 'register, submit, optin',
	)
);


Tx_Extbase_Utility_Extension::configurePlugin( 
	$_EXTKEY, 
	'Pi5', 
	array(
		'User' => 'edit, submitedit, optin',
	),
	array(
		'User' => 'edit, submitedit, optin',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin( 
	$_EXTKEY, 
	'Pi6', 
	array(
		'User' => 'favourits,removefav, addfav',
	),
	array(
		'User' => 'favourits,removefav, addfav',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin( 
	$_EXTKEY, 
	'Pi7', 
	array(
		'Saferpay' => 'payment',
	),
	array(
		'Saferpay' => 'payment',
	)
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:hevents/Classes/Hooks/Processdata.php:Tx_Hevents_Hooks_Processdata';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['tx_felogin_pi1'] = array('className' => 'ux_tx_felogin_pi1');
?>