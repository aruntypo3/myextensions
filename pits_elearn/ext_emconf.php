<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "pits_elearn".
 *
 * Auto generated 17-10-2013 15:28
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'TNT E-Learning',
	'description' => 'TNT E-Learning is front-end plug-gin used for e-learning powered by PITS',
	'category' => 'plugin',
	'author' => 'Sivaprasad,Abin',
	'author_email' => 'abin.s@pitsolutions.com,sivaprasad.s@pitsolutions.com',
	'author_company' => 'PITS',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 1,
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
	'_md5_values_when_last_written' => 'a:26:{s:12:"ext_icon.gif";s:4:"978f";s:17:"ext_localconf.php";s:4:"621f";s:14:"ext_tables.php";s:4:"5cee";s:14:"ext_tables.sql";s:4:"ab23";s:21:"ExtensionBuilder.json";s:4:"c074";s:42:"Classes/Controller/ElearningController.php";s:4:"a3b4";s:34:"Classes/Domain/Model/Elearning.php";s:4:"bb76";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"18d5";s:31:"Configuration/TCA/Elearning.php";s:4:"16b3";s:38:"Configuration/TypoScript/constants.txt";s:4:"90cc";s:34:"Configuration/TypoScript/setup.txt";s:4:"c556";s:40:"Resources/Private/Language/locallang.xml";s:4:"f1b7";s:81:"Resources/Private/Language/locallang_csh_tx_pitselearn_domain_model_elearning.xml";s:4:"d165";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"6af1";s:38:"Resources/Private/Layouts/Default.html";s:4:"4685";s:52:"Resources/Private/Partials/Elearning/Properties.html";s:4:"8735";s:47:"Resources/Private/Templates/Elearning/List.html";s:4:"dbd0";s:49:"Resources/Private/Templates/Elearning/Select.html";s:4:"b9df";s:47:"Resources/Private/Templates/Elearning/Show.html";s:4:"af5d";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:63:"Resources/Public/Icons/tx_pitselearn_domain_model_elearning.gif";s:4:"1103";s:30:"Resources/Public/Js/actions.js";s:4:"4250";s:33:"Resources/Public/Js/jquery.min.js";s:4:"08c2";s:49:"Tests/Unit/Controller/ElearningControllerTest.php";s:4:"3394";s:41:"Tests/Unit/Domain/Model/ElearningTest.php";s:4:"10ed";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

?>