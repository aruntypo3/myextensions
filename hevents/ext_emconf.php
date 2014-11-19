<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "hevents".
 *
 * Auto generated 12-08-2013 13:30
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Henry Events',
	'description' => 'Event Booking Tool',
	'category' => 'plugin',
	'author' => 'Eric Depta',
	'author_email' => 'info@ericdepta.de',
	'author_company' => '',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => 'fe_users',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '1.0.0',
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
	'_md5_values_when_last_written' => 'a:99:{s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"ff49";s:14:"ext_tables.php";s:4:"21e4";s:14:"ext_tables.sql";s:4:"c41b";s:24:"ext_typoscript_setup.txt";s:4:"219e";s:21:"ExtensionBuilder.json";s:4:"1895";s:41:"Classes/Controller/AbstractController.php";s:4:"0abb";s:40:"Classes/Controller/BookingController.php";s:4:"15c4";s:38:"Classes/Controller/EventController.php";s:4:"2440";s:37:"Classes/Controller/UserController.php";s:4:"5a9d";s:32:"Classes/Domain/Model/Booking.php";s:4:"6209";s:33:"Classes/Domain/Model/Category.php";s:4:"3ae4";s:29:"Classes/Domain/Model/City.php";s:4:"cd4c";s:29:"Classes/Domain/Model/Date.php";s:4:"06b6";s:30:"Classes/Domain/Model/Event.php";s:4:"6b21";s:29:"Classes/Domain/Model/User.php";s:4:"2838";s:47:"Classes/Domain/Repository/BookingRepository.php";s:4:"9397";s:48:"Classes/Domain/Repository/CategoryRepository.php";s:4:"1bff";s:44:"Classes/Domain/Repository/CityRepository.php";s:4:"34c9";s:44:"Classes/Domain/Repository/DateRepository.php";s:4:"8a1b";s:45:"Classes/Domain/Repository/EventRepository.php";s:4:"1885";s:44:"Classes/Domain/Repository/UserRepository.php";s:4:"7121";s:48:"Classes/Domain/Session/BookingSessionHandler.php";s:4:"79ee";s:43:"Classes/Domain/Session/EdSessionHandler.php";s:4:"54ac";s:47:"Classes/Domain/Session/FilterSessionHandler.php";s:4:"8b80";s:47:"Classes/Domain/Validator/ArrayuserValidator.php";s:4:"6509";s:45:"Classes/Domain/Validator/BookingValidator.php";s:4:"ab34";s:42:"Classes/Domain/Validator/UserValidator.php";s:4:"773e";s:29:"Classes/Hooks/Processdata.php";s:4:"ccad";s:43:"Classes/ViewHelpers/IsfavuserViewHelper.php";s:4:"9716";s:49:"Classes/ViewHelpers/Form/DatepickerViewHelper.php";s:4:"03e1";s:49:"Classes/ViewHelpers/Form/RangeslideViewHelper.php";s:4:"e610";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"1106";s:29:"Configuration/TCA/Booking.php";s:4:"a777";s:30:"Configuration/TCA/Category.php";s:4:"f73f";s:26:"Configuration/TCA/City.php";s:4:"16d9";s:26:"Configuration/TCA/Date.php";s:4:"0869";s:27:"Configuration/TCA/Event.php";s:4:"4c1a";s:26:"Configuration/TCA/User.php";s:4:"a0fd";s:38:"Configuration/TypoScript/constants.txt";s:4:"4886";s:34:"Configuration/TypoScript/setup.txt";s:4:"cf6e";s:40:"Resources/Private/Language/locallang.xml";s:4:"39eb";s:52:"Resources/Private/Language/locallang_csh_fe_user.xml";s:4:"6304";s:76:"Resources/Private/Language/locallang_csh_tx_hevents_domain_model_booking.xml";s:4:"0a24";s:77:"Resources/Private/Language/locallang_csh_tx_hevents_domain_model_category.xml";s:4:"95e9";s:73:"Resources/Private/Language/locallang_csh_tx_hevents_domain_model_city.xml";s:4:"49cb";s:73:"Resources/Private/Language/locallang_csh_tx_hevents_domain_model_date.xml";s:4:"62b8";s:74:"Resources/Private/Language/locallang_csh_tx_hevents_domain_model_event.xml";s:4:"5ea4";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"c0b4";s:38:"Resources/Private/Layouts/Default.html";s:4:"4833";s:41:"Resources/Private/Partials/AddButton.html";s:4:"0e33";s:42:"Resources/Private/Partials/FirstImage.html";s:4:"c782";s:42:"Resources/Private/Partials/FormErrors.html";s:4:"9e6e";s:45:"Resources/Private/Templates/Booking/Book.html";s:4:"c884";s:47:"Resources/Private/Templates/Booking/Choose.html";s:4:"4c8b";s:45:"Resources/Private/Templates/Booking/Done.html";s:4:"093c";s:45:"Resources/Private/Templates/Booking/List.html";s:4:"398b";s:44:"Resources/Private/Templates/Booking/Pay.html";s:4:"2ca5";s:48:"Resources/Private/Templates/Booking/Problem.html";s:4:"a9df";s:47:"Resources/Private/Templates/Booking/Submit.html";s:4:"8b52";s:47:"Resources/Private/Templates/Event/Archieve.html";s:4:"e72e";s:43:"Resources/Private/Templates/Event/List.html";s:4:"6f6f";s:45:"Resources/Private/Templates/Event/Single.html";s:4:"f356";s:42:"Resources/Private/Templates/User/Edit.html";s:4:"cded";s:46:"Resources/Private/Templates/User/Favcount.html";s:4:"0c44";s:47:"Resources/Private/Templates/User/Favourits.html";s:4:"79ab";s:43:"Resources/Private/Templates/User/Optin.html";s:4:"a374";s:47:"Resources/Private/Templates/User/OptinMail.html";s:4:"5d37";s:46:"Resources/Private/Templates/User/Register.html";s:4:"dc6f";s:44:"Resources/Private/Templates/User/Submit.html";s:4:"1780";s:29:"Resources/Public/Css/main.css";s:4:"0842";s:30:"Resources/Public/Icons/fav.png";s:4:"ef4d";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:58:"Resources/Public/Icons/tx_hevents_domain_model_booking.gif";s:4:"905a";s:59:"Resources/Public/Icons/tx_hevents_domain_model_category.gif";s:4:"905a";s:55:"Resources/Public/Icons/tx_hevents_domain_model_city.gif";s:4:"905a";s:55:"Resources/Public/Icons/tx_hevents_domain_model_date.gif";s:4:"905a";s:56:"Resources/Public/Icons/tx_hevents_domain_model_event.gif";s:4:"1103";s:32:"Resources/Public/Icons/unFav.png";s:4:"00e5";s:29:"Resources/Public/Img/Date.png";s:4:"b400";s:38:"Resources/Public/Js/hevents-booking.js";s:4:"8858";s:37:"Resources/Public/Js/hevents-filter.js";s:4:"71fc";s:34:"Resources/Public/Js/hevents-map.js";s:4:"3177";s:37:"Resources/Public/Js/hevents-slider.js";s:4:"fbf4";s:30:"Resources/Public/Js/hevents.js";s:4:"24c2";s:38:"Resources/Public/Js/jquery.bxSlider.js";s:4:"beda";s:42:"Resources/Public/Js/jquery.bxSlider.min.js";s:4:"86c4";s:40:"Resources/Public/Js/jquery.easing.1.3.js";s:4:"6516";s:47:"Tests/Unit/Controller/BookingControllerTest.php";s:4:"cd81";s:48:"Tests/Unit/Controller/CategoryControllerTest.php";s:4:"6e32";s:44:"Tests/Unit/Controller/CityControllerTest.php";s:4:"36b3";s:44:"Tests/Unit/Controller/DateControllerTest.php";s:4:"71f6";s:45:"Tests/Unit/Controller/EventControllerTest.php";s:4:"ee98";s:39:"Tests/Unit/Domain/Model/BookingTest.php";s:4:"af1e";s:40:"Tests/Unit/Domain/Model/CategoryTest.php";s:4:"ef89";s:36:"Tests/Unit/Domain/Model/CityTest.php";s:4:"7062";s:36:"Tests/Unit/Domain/Model/DateTest.php";s:4:"0e9f";s:37:"Tests/Unit/Domain/Model/EventTest.php";s:4:"231b";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

?>