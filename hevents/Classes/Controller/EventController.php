<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Eric Depta <info@ericdepta.de>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package hevents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Hevents_Controller_EventController extends Tx_Hevents_Controller_AbstractController {
	/**
	 * The session handler
	 * @var Tx_Hevents_Domain_Session_FilterSessionHandler
	 */
	protected $filterHandler = NULL;
	
	/**
	 * eventRepository
	 *
	 * @var Tx_Hevents_Domain_Repository_EventRepository
	 */
	protected $eventRepository;

	/**
	 * injectEventRepository
	 *
	 * @param Tx_Hevents_Domain_Repository_EventRepository $eventRepository
	 * @return void
	 */
	public function injectEventRepository(Tx_Hevents_Domain_Repository_EventRepository $eventRepository) {
		$this->eventRepository = $eventRepository;
	}
	
	/**
	 * cityRepository
	 *
	 * @var Tx_Hevents_Domain_Repository_CityRepository
	 */
	protected $cityRepository;

	/**
	 * injectCityRepository
	 *
	 * @param Tx_Hevents_Domain_Repository_CityRepository $cityRepository
	 * @return void
	 */
	public function injectCityRepository(Tx_Hevents_Domain_Repository_CityRepository $cityRepository) {
		$this->cityRepository = $cityRepository;
	}
	
	/**
	 * categoryRepository
	 *
	 * @var Tx_Hevents_Domain_Repository_CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * injectCategoryRepository
	 *
	 * @param Tx_Hevents_Domain_Repository_CategoryRepository $categoryRepository
	 * @return void
	 */
	public function injectCategoryRepository(Tx_Hevents_Domain_Repository_CategoryRepository $categoryRepository) {
		$this->categoryRepository = $categoryRepository;
	}
	
	public function __construct() {
		parent::__construct();
		$this->filterHandler = t3lib_div::makeInstance('Tx_Hevents_Domain_Session_FilterSessionHandler');
	}
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		//add js
		$this->addJQ();
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/i18n/jquery.ui.datepicker-de.js"></script>'); //lang switch
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>'); //maps
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/hevents.js" ></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/hevents-map.js" ></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/hevents-slider.js" ></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/jquery.bxSlider.min.js" ></script>');
		//$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/jquery.bxSlider.js" ></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/hevents-filter.js" ></script>');

		$arguments = $this->request->getArguments();
		$arguments['action'] = 'list';
		$arguments['controller'] = 'Event';
		
		$this->setFilter($arguments);
		$events = $this->eventRepository->findByFilter();
		$this->eventRepository->clearFilter();
		
		$cities = $this->cityRepository->findAll()->toArray();
		//- empty entry for city box
		$empty = new Tx_Hevents_Domain_Model_City();
		$empty->setTitle(Tx_Extbase_Utility_Localization::translate('basic.none.city', $this->extensionName) );
		$empty->setUid(0);
		array_unshift($cities,$empty);
		
		$categories = $this->categoryRepository->findAll()->toArray();
		$allCats = 'active';
		foreach($categories as &$category){
			if($category->getUid()==(int)$arguments['category']){
				$category->setActive(true);
				$allCats='';
			}
		}
		
		
		//only cats which are in the current events
		/*
		for($i=count($categories)-1; $i>=0; $i--){
			$uid = $categories[$i]->getUid();
			$in = false;
			foreach($events as $event){
				if($uid == $event->getCategory()->getUid()) $in = true;
			}
			if(!$in) unset($categories[$i]);
		}
		*/
		
		$this->view->assign('sliderDummyImage', $this->settings['sliderDummyImage']);
		$this->view->assign('redSlider', $this->settings['redSlider']);
		$this->view->assign('maxPrice', $this->settings['maxPrice']);
		$this->view->assign('events', $events);
		$this->view->assign('allCatsState', $allCats);
		$this->view->assign('pageid', $GLOBALS["TSFE"]->id);
		$this->view->assign('arguments', $arguments);
		$this->view->assign('cities', $cities);
		$this->view->assign('categories', $categories);
	}
	
	/**
	 * action single
	 *
	 * @param Tx_Hevents_Domain_Model_Event $event
	 * @return void
	 */
	public function singleAction(Tx_Hevents_Domain_Model_Event $event) {
		//add js
		$this->addJQ();
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/hevents.js" ></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/hevents-slider.js" ></script>');
		//$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/jquery.bxSlider.min.js" ></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/jquery.bxSlider.js" ></script>');
		
		$today = new DateTime();
		$today->setTime(0,0,0);
		$query = $this->eventRepository->createQuery();
		$this->eventRepository->addFilter($query->greaterThanOrEqual('dates.start', $today->format('U')));
		$this->eventRepository->addFilter($query->equals('categories.uid', $event->getCategory()->getUid()));
		$this->eventRepository->addFilter($query->logicalNot( $query->equals('uid', $event->getUid()) ));
		$events = $this->eventRepository->findByFilter()->toArray();
		shuffle($events);
		$events = array_slice($events, 0, (int)$this->settings['similarCnt']);

		$this->view->assign('sliderDummyImage', $this->settings['sliderDummyImage']);
		$this->view->assign('event', $event);
		$this->view->assign('similarEvents', $events);
	}
	
	protected function sesArcStor($ses_data, &$arguments, $key, $default=''){
		if(!isset($arguments[$key])){
			if(isset($ses_data[$key])){
				$arguments[$key] = $ses_data[$key];
			}else{
				$arguments[$key] = $default;
			}
		}else{
			$this->filterHandler->setToSession($key, $arguments[$key]);
		}
	}
	/**
	 * set repo filter
	 *
	 * @return void
	 */
	protected function setFilter(&$arguments){
		$query = $this->eventRepository->createQuery();
		
		
		$tomorrow = new DateTime();
		$tomorrow->modify('+1 day')->setTime(0,0,0);
		$this->correctDate($arguments, $tomorrow);
		
		$ses_data = $this->filterHandler->restoreFromSession();
		$this->sesArcStor($ses_data, $arguments, 'keyword');
		$this->sesArcStor($ses_data, $arguments, 'city', 0);
		$this->sesArcStor($ses_data, $arguments, 'minprice', 0);
		$this->sesArcStor($ses_data, $arguments, 'maxprice', (int)$this->settings['maxPrice']);
		$this->sesArcStor($ses_data, $arguments, 'startdate', $tomorrow->format('d.m.Y'));
		$this->sesArcStor($ses_data, $arguments, 'enddate', 0);
		$this->sesArcStor($ses_data, $arguments, 'category', 0);
		
		//-- Debug clean session
		//$this->filterHandler->cleanUpSession();
		
		if(!empty($arguments['keyword'])){
			$ec = mysqli_real_escape_string($arguments['keyword']);
			$this->eventRepository->addFilter(
				$query->logicalOr(
					$query->like('title', '%' . $ec . '%'),
					$query->like('description', '%' . $ec . '%'),
					$query->like('location', '%' . $ec . '%')
				)
			);
		}
		
		if($arguments['city']!=0){
			$this->eventRepository->addFilter($query->equals('city.uid', (int)$arguments['city']));
		}
		
		if($arguments['category']!=0){
			$this->eventRepository->addFilter($query->equals('categories.uid', (int)$arguments['category']));
		}
		
		if($arguments['minprice']!=0) $this->eventRepository->addFilter($query->greaterThanOrEqual('price', (int)$arguments['minprice']));
		if($arguments['maxprice']!=(int)$this->settings['maxPrice']) $this->eventRepository->addFilter($query->lessThanOrEqual('price', (int)$arguments['maxprice']));
		#t3lib_utility_Debug::debug($this->argDateToDate($arguments['startdate']));
		if($arguments['startdate']!=0) $this->eventRepository->addFilter($query->greaterThanOrEqual('dates.start', $this->argDateToDate($arguments['startdate'])));
		if($arguments['enddate']!=0) $this->eventRepository->addFilter($query->lessThanOrEqual('dates.end', $this->argDateToDate($arguments['enddate'],false)));
	}
	
	protected function correctDate(&$arguments, $minDate){
		if(isset($arguments['startdate'])){
			$startDate = $this->argDateToDate($arguments['startdate']);
			if($startDate < $minDate){
				$arguments['startdate'] = $minDate->format('d.m.Y');
			}
		}
		
		if(isset($arguments['enddate'])){
			if((int)$arguments['enddate']!=0){
				$endDate = $this->argDateToDate($arguments['enddate']);
				if($endDate < $startDate){
					$arguments['enddate'] = $arguments['startdate'];
				}
			}
		}
		
	}
	
	protected function argDateToDate($date, $day=true){
		$date = DateTime::createFromFormat('d.m.Y', $date);
		if(!$date) return 0;
		if($day){
			$date->setTime(0,0,0);
		}else{
			$date->setTime(23,59,59);
		}
		return $date->format('U');
	}
	
	/**
	 * action archieve
	 *
	 * @return void
	 */
	public function archieveAction() {
		$now = new DateTime();
		$query = $this->eventRepository->createQuery();
		$this->eventRepository->addFilter($query->lessThanOrEqual('dates.start', $now));
		$events = $this->eventRepository->findByFilter();
		
		$this->view->assign('events', $events);
	}
}
?>
