<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "pfj_csv_importer".
 *
 * Auto generated 02-03-2014 21:21
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'PFJ CSV IMPORTER',
	'description' => 'Import CSV files to the data base',
	'category' => 'module',
	'author' => 'Trent Smith',
	'author_email' => '',
	'author_company' => '',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.0.1',
	'constraints' => array(
		'depends' => array(
			'extbase' => '1.3',
			'fluid' => '1.3',
			'typo3' => '4.5-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:23:{s:12:"ext_icon.gif";s:4:"e922";s:14:"ext_tables.php";s:4:"76d1";s:14:"ext_tables.sql";s:4:"7976";s:21:"ExtensionBuilder.json";s:4:"e9da";s:44:"Classes/Controller/CsvImporterController.php";s:4:"4937";s:36:"Classes/Domain/Model/CsvImporter.php";s:4:"bf52";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"1497";s:33:"Configuration/TCA/CsvImporter.php";s:4:"3fa2";s:38:"Configuration/TypoScript/constants.txt";s:4:"8e0a";s:34:"Configuration/TypoScript/setup.txt";s:4:"e602";s:46:"Resources/Private/Backend/Layouts/Default.html";s:4:"5784";s:62:"Resources/Private/Backend/Partials/CsvImporter/Properties.html";s:4:"1c5b";s:57:"Resources/Private/Backend/Templates/CsvImporter/List.html";s:4:"78cc";s:57:"Resources/Private/Backend/Templates/CsvImporter/Show.html";s:4:"83d8";s:40:"Resources/Private/Language/locallang.xml";s:4:"81a5";s:87:"Resources/Private/Language/locallang_csh_tx_pfjcsvimporter_domain_model_csvimporter.xml";s:4:"bac7";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"adeb";s:55:"Resources/Private/Language/locallang_pfjcsvimporter.xml";s:4:"ba6d";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:69:"Resources/Public/Icons/tx_pfjcsvimporter_domain_model_csvimporter.gif";s:4:"1103";s:51:"Tests/Unit/Controller/CsvImporterControllerTest.php";s:4:"9b45";s:43:"Tests/Unit/Domain/Model/CsvImporterTest.php";s:4:"1a33";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

?>