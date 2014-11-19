<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "pits_stocklist".
 *
 * Auto generated 16-12-2013 05:53
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'BIBUS Stock List',
	'description' => 'Stock list',
	'category' => 'plugin',
	'author' => 'Siva',
	'author_email' => 'sivaprasad.s@pitsolutions.com',
	'author_company' => 'PIT Solutions Pvt Ltd',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => 'uploads/tx_pits_stocklist',
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
	'_md5_values_when_last_written' => 'a:36:{s:12:"ext_icon.gif";s:4:"978f";s:17:"ext_localconf.php";s:4:"b37b";s:14:"ext_tables.php";s:4:"2c5b";s:14:"ext_tables.sql";s:4:"bb73";s:21:"ExtensionBuilder.json";s:4:"f979";s:52:"Classes/Controller/BIBUSStockListGradeController.php";s:4:"69fe";s:39:"Classes/Domain/Model/BIBUSStockList.php";s:4:"1599";s:44:"Classes/Domain/Model/BIBUSStockListGrade.php";s:4:"6e63";s:47:"Classes/Domain/Model/BIBUSStockListLocation.php";s:4:"34e1";s:51:"Classes/Domain/Model/BIBUSStockListProductShape.php";s:4:"8fce";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"1c09";s:36:"Configuration/TCA/BIBUSStockList.php";s:4:"557f";s:41:"Configuration/TCA/BIBUSStockListGrade.php";s:4:"5e4c";s:44:"Configuration/TCA/BIBUSStockListLocation.php";s:4:"77c1";s:48:"Configuration/TCA/BIBUSStockListProductShape.php";s:4:"280c";s:38:"Configuration/TypoScript/constants.txt";s:4:"75bf";s:34:"Configuration/TypoScript/setup.txt";s:4:"b4bb";s:40:"Resources/Private/Language/locallang.xml";s:4:"026d";s:89:"Resources/Private/Language/locallang_csh_tx_pitsstocklist_domain_model_bibusstocklist.xml";s:4:"00da";s:94:"Resources/Private/Language/locallang_csh_tx_pitsstocklist_domain_model_bibusstocklistgrade.xml";s:4:"73ab";s:97:"Resources/Private/Language/locallang_csh_tx_pitsstocklist_domain_model_bibusstocklistlocation.xml";s:4:"203b";s:101:"Resources/Private/Language/locallang_csh_tx_pitsstocklist_domain_model_bibusstocklistproductshape.xml";s:4:"4962";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"80ed";s:38:"Resources/Private/Layouts/Default.html";s:4:"ddfe";s:57:"Resources/Private/Templates/BIBUSStockListGrade/List.html";s:4:"66a2";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:71:"Resources/Public/Icons/tx_pitsstocklist_domain_model_bibusstocklist.gif";s:4:"1103";s:76:"Resources/Public/Icons/tx_pitsstocklist_domain_model_bibusstocklistgrade.gif";s:4:"1103";s:79:"Resources/Public/Icons/tx_pitsstocklist_domain_model_bibusstocklistlocation.gif";s:4:"1103";s:83:"Resources/Public/Icons/tx_pitsstocklist_domain_model_bibusstocklistproductshape.gif";s:4:"1103";s:59:"Tests/Unit/Controller/BIBUSStockListGradeControllerTest.php";s:4:"b5ee";s:51:"Tests/Unit/Domain/Model/BIBUSStockListGradeTest.php";s:4:"eee5";s:54:"Tests/Unit/Domain/Model/BIBUSStockListLocationTest.php";s:4:"92a0";s:58:"Tests/Unit/Domain/Model/BIBUSStockListProductShapeTest.php";s:4:"62e5";s:46:"Tests/Unit/Domain/Model/BIBUSStockListTest.php";s:4:"7ff1";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

?>