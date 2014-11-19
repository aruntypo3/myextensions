<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "pits_brandsearch".
 *
 * Auto generated 19-11-2013 09:51
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'TNT Brand Search',
	'description' => 'Extension is used to list available brand details in cyclinfo website.',
	'category' => 'plugin',
	'author' => 'Arun Chandran',
	'author_email' => 'arun.c@pitsolutions.com',
	'author_company' => 'PIT Solutions Pvt Ltd.',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.0.0',
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
	'_md5_values_when_last_written' => 'a:28:{s:12:"ext_icon.gif";s:4:"978f";s:17:"ext_localconf.php";s:4:"9724";s:14:"ext_tables.php";s:4:"944a";s:14:"ext_tables.sql";s:4:"8d75";s:21:"ExtensionBuilder.json";s:4:"6083";s:44:"Classes/Controller/BrandsearchController.php";s:4:"449f";s:36:"Classes/Domain/Model/Brandsearch.php";s:4:"a516";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"09e5";s:36:"Configuration/FlexForms/flexform.xml";s:4:"16e1";s:33:"Configuration/TCA/Brandsearch.php";s:4:"511a";s:38:"Configuration/TypoScript/constants.txt";s:4:"666b";s:34:"Configuration/TypoScript/setup.txt";s:4:"7914";s:40:"Resources/Private/Language/locallang.xml";s:4:"6e49";s:88:"Resources/Private/Language/locallang_csh_tx_pitsbrandsearch_domain_model_brandsearch.xml";s:4:"df3d";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"f62b";s:38:"Resources/Private/Layouts/Default.html";s:4:"6961";s:54:"Resources/Private/Partials/Brandsearch/Properties.html";s:4:"befd";s:49:"Resources/Private/Templates/Brandsearch/List.html";s:4:"2e2a";s:51:"Resources/Private/Templates/Brandsearch/Search.html";s:4:"0a9a";s:49:"Resources/Private/Templates/Brandsearch/Show.html";s:4:"85cd";s:33:"Resources/Public/Icons/loader.gif";s:4:"7e99";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:70:"Resources/Public/Icons/tx_pitsbrandsearch_domain_model_brandsearch.gif";s:4:"1103";s:41:"Resources/Public/Js/brandsearch_script.js";s:4:"1a04";s:31:"Resources/Public/Js/scrollTo.js";s:4:"5645";s:51:"Tests/Unit/Controller/BrandsearchControllerTest.php";s:4:"8e5f";s:43:"Tests/Unit/Domain/Model/BrandsearchTest.php";s:4:"5b20";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

?>