<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "pits_job".
 *
 * Auto generated 27-11-2013 06:45
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'TNT Jobs',
	'description' => 'This extension is used to add jobs and listed the jobs in frontend based on the category.',
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
	'_md5_values_when_last_written' => 'a:27:{s:12:"ext_icon.gif";s:4:"978f";s:17:"ext_localconf.php";s:4:"2c7a";s:14:"ext_tables.php";s:4:"8a2f";s:14:"ext_tables.sql";s:4:"a179";s:21:"ExtensionBuilder.json";s:4:"f5fa";s:40:"Classes/Controller/PitsjobController.php";s:4:"9581";s:32:"Classes/Domain/Model/Pitsjob.php";s:4:"3f46";s:43:"Classes/ViewHelpers/SelectBoxViewHelper.php";s:4:"dc15";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"f2b8";s:36:"Configuration/FlexForms/flexform.xml";s:4:"a704";s:29:"Configuration/TCA/Pitsjob.php";s:4:"1656";s:38:"Configuration/TypoScript/constants.txt";s:4:"2943";s:34:"Configuration/TypoScript/setup.txt";s:4:"806e";s:40:"Resources/Private/Language/locallang.xml";s:4:"f7a1";s:76:"Resources/Private/Language/locallang_csh_tx_pitsjob_domain_model_pitsjob.xml";s:4:"e340";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"c533";s:38:"Resources/Private/Layouts/Default.html";s:4:"f3a2";s:50:"Resources/Private/Partials/Pitsjob/Properties.html";s:4:"765b";s:47:"Resources/Private/Templates/Pitsjob/Adform.html";s:4:"e5b1";s:45:"Resources/Private/Templates/Pitsjob/List.html";s:4:"7897";s:48:"Resources/Private/Templates/Pitsjob/Success.html";s:4:"701f";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:58:"Resources/Public/Icons/tx_pitsjob_domain_model_pitsjob.gif";s:4:"1103";s:31:"Resources/Public/Js/validate.js";s:4:"e1f2";s:47:"Tests/Unit/Controller/PitsjobControllerTest.php";s:4:"7da0";s:39:"Tests/Unit/Domain/Model/PitsjobTest.php";s:4:"13f4";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

?>