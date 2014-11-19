<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "tnt_download_module".
 *
 * Auto generated 16-05-2014 09:51
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'TNT Download Module',
	'description' => 'TNT Download Module',
	'category' => 'plugin',
	'author' => 'Abin Sabu',
	'author_email' => 'abin.s@pitsolutions.com',
	'author_company' => 'PITSolutions Pvt Ltd',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => '1',
	'createDirs' => 'fileadmin/uploads/downloadmodule',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '1.0.1',
	'constraints' => 
	array (
		'depends' => 
		array (
			'extbase' => '1.3',
			'fluid' => '1.3',
			'typo3' => '4.5-0.0.0',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);

?>