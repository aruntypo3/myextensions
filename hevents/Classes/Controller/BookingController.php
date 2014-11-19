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
class Tx_Hevents_Controller_BookingController extends Tx_Hevents_Controller_AbstractController {
	
	/**
	 * The session handler
	 * @var Tx_Hevents_Domain_Session_EdSessionHandler
	 */
	protected $edHandler;
	
	/**
	 * bookingRepository
	 *
	 * @var Tx_Hevents_Domain_Repository_BookingRepository
	 */
	protected $bookingRepository;

	/**
	 * injectBookingRepository
	 *
	 * @param Tx_Hevents_Domain_Repository_BookingRepository $bookingRepository
	 * @return void
	 */
	public function injectBookingRepository(Tx_Hevents_Domain_Repository_BookingRepository $bookingRepository) {
		$this->bookingRepository = $bookingRepository;
	}
	
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
	 * dateRepository
	 *
	 * @var Tx_Hevents_Domain_Repository_DateRepository
	 */
	protected $dateRepository;

	/**
	 * injectDateRepository
	 *
	 * @param Tx_Hevents_Domain_Repository_DateRepository $dateRepository
	 * @return void
	 */
	public function injectDateRepository(Tx_Hevents_Domain_Repository_DateRepository $dateRepository) {
		$this->dateRepository = $dateRepository;
	}
	
	/**
     * frontendUserRepository
	 *
     * @var Tx_Extbase_Domain_Repository_FrontendUserRepository
     */
    protected $frontendUserRepository;
 
    /**
     * injectFrontendUserRepository
	 *
     * @param Tx_Extbase_Domain_Repository_FrontendUserRepository $frontendUserRepository
	 * @return void
     */
    public function injectFrontendUserRepository(Tx_Extbase_Domain_Repository_FrontendUserRepository $frontendUserRepository) {
        $this->frontendUserRepository = $frontendUserRepository;
    }
	
	public function __construct() {
		parent::__construct();
		$this->edHandler = t3lib_div::makeInstance('Tx_Hevents_Domain_Session_EdSessionHandler');
	}
	
	/**
	 * action problem
	 *
	 * @return void
	 */
	public function problemAction() {
		$this->edHandler->cleanUpSession();
		$this->bookingRepository->cleanUpSession();
	}
	
	/**
	 * action choose
	 *
	 * @param Tx_Hevents_Domain_Model_Event $event
	 * @param Tx_Hevents_Domain_Model_Date $date
	 * @ignorevalidation $event
	 * @ignorevalidation $date
	 * @return void
	 */
	public function chooseAction(Tx_Hevents_Domain_Model_Event $event = Null, Tx_Hevents_Domain_Model_Date $date = Null) {
		if(!$date || !$event) $this->forward('problem');
		
		$this->edHandler->cleanUpSession();
		$this->bookingRepository->cleanUpSession();
		
		$this->edHandler->setToSession('event', $event->getUid());
		$this->edHandler->setToSession('date', $date->getUid());
		
		$user = $GLOBALS['TSFE']->fe_user->user;
		#t3lib_utility_Debug::debug($user);
		
		$this->view->assign('registerPage', $this->settings['registerPid']);
		$this->view->assign('event', $event);
		$this->view->assign('date', $date);
		$this->view->assign('user', $user);
		$this->view->assign('islogged', (boolean)$user);
	}
	
	/**
	 * action book
	 *
	 * @param Tx_Hevents_Domain_Model_Booking $booking
	 * @return void
	 */
	public function bookAction(Tx_Hevents_Domain_Model_Booking $booking = NULL) {
		
		$this->getEventDateSes($event, $date);
		
		$this->addJQ();
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/hevents-booking.js" ></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/book_validate.js" ></script>');
		
		$user = $GLOBALS['TSFE']->fe_user->user;
		
		if(!$booking){
			if(!($booking = $this->bookingRepository->findBySession())){
				//prefill by user data
				$booking = new Tx_Hevents_Domain_Model_Booking();
				if($user){
					$booking->setName($user['last_name']);
					$booking->setForename($user['first_name']);
					$booking->setZip($user['zip']);
					$booking->setCity($user['city']);
					$booking->setAddress($user['address']);
					$booking->setCountry($user['country']);
					$booking->setDname($user['dname']);
					$booking->setDforename($user['dforename']);
					$booking->setDzip($user['dzip']);
					$booking->setDcity($user['dcity']);
					$booking->setDaddress($user['daddress']);
					$booking->setDcountry($user['dcountry']);
					if( !empty( $user['email'] ) ){
						$booking->setEmail($user['email']);
					}else{
						$booking->setEmail($user['username']);
					}
				}
				$booking->setAmount(1);
			}
		}
		
		// Get Country List
		$langUid = $GLOBALS['TSFE']->sys_language_uid;
		$select  = 'uid, country';
		$from    = 'tx_hevents_domain_model_country';
		$where   = 'sys_language_uid = 0 AND deleted = 0 AND hidden = 0';
		$groupBy = '';
		$orderBy = 'country';
		$limit   = '';
		
		$countryList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( $select, $from, $where, $groupBy, $orderBy, $limit );
		
		$i = 0;
		$countryData = array();
		$countryData[''] = Tx_Extbase_Utility_Localization::translate( 'tx_hevents_domain_model_event.selectCountry', $this->request->getControllerExtensionName(), $arguments = NULL );
		foreach ( $countryList as $countryId => $countryValue ) {
			if( $langUid > 0 ){
				$select  = 'uid, country';
				$from    = 'tx_hevents_domain_model_country';
				$where   = 'sys_language_uid = "'.$langUid.'" AND l10n_parent = "'.$countryValue["uid"].'" AND deleted = 0 AND hidden = 0';
				$groupBy = '';
				$orderBy = 'country';
				$limit   = '';
				
				$countryTransList = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( $select, $from, $where, $groupBy, $orderBy, $limit );
			}
			if( sizeof( $countryTransList[0] ) > 0 ){
				$optionKey = $countryTransList[0]['country'];
				$countryData[$optionKey] .= $countryTransList[0]['country'];
			}else{
				$optionKey = $countryValue['country'];
				$countryData[$optionKey] .= $countryValue['country'];
			}
			$i++;
		}

		$this->view->assign('countrylist', $countryData);
		$this->view->assign('event', $event);
		$this->view->assign('date', $date);
		$this->view->assign('booking', $booking);
	}
	
	protected function getEventDateSes(&$event, &$date){
		$ed_ses = $this->edHandler->restoreFromSession();
		if(isset($ed_ses['event']) && isset($ed_ses['date'])){
			$event = $this->eventRepository->findByUid((int)$ed_ses['event']);
			$date = $this->dateRepository->findByUid((int)$ed_ses['date']);
			if(!$date || !$event) $this->forward('problem');
		}else{
			$eventData = $this->request->getArguments();
			$event = $this->eventRepository->findByUid((int)$eventData['event']);
			$date = $this->dateRepository->findByUid((int)$eventData['date']);
			if(!$date || !$event) $this->forward('problem');
		}
	}
	

	/**
	 * action submit
	 *
	 * @param Tx_Hevents_Domain_Model_Booking $booking
	 * @dontvalidate $booking
	 * @return void
	 */
	public function submitAction(Tx_Hevents_Domain_Model_Booking $booking) {
		$requestArray = $this->request->getArguments();
		if( $booking ){
			$this->bookingRepository->writeToSession($booking);
		}else{
			$this->bookingRepository->writeToSession($requestArray['booking']);
		}
		$this->view->assign('booking', $requestArray['booking']);
		$this->view->assign('event', $requestArray['event']);
		$this->view->assign('date', $requestArray['date']);
	}
	
	
	/**
	 * action pay
	 *
	 * @return void
	 */
	public function payAction() {
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/OpenSaferpayScript.js" ></script>');
		$this->cObj = t3lib_div::makeInstance('tslib_cObj');
		
		$booking = $this->bookingRepository->findBySession();
		if( !$booking ) $this->forward('problem');
		
		$this->getEventDateSes($event, $date);

		$now = new DateTime();
		$booking->setEvent($event);
		$booking->setDate($date);
		$booking->setPrice(round($event->getPrice()*$booking->getAmount(),2));
		$booking->setPpref($event->getUid().'-'.$date->getUid().'-'.$now->format('U'));
		$booking->setLkey((int)$GLOBALS['TSFE']->sys_language_content);

		$user = $GLOBALS['TSFE']->fe_user->user;
		if($user){
			$user = $this->frontendUserRepository->findByUid($user['uid']);
			if($user) $booking->setUser($user);
		}
		
		$insertArray = array();
		$insertArray['amount'] = $booking->getAmount();
		$insertArray['email'] = $booking->getEmail();
		$insertArray['name'] = $booking->getName();
		$insertArray['forename'] = $booking->getForename();
		$insertArray['address'] = $booking->getAddress();
		$insertArray['zip'] = $booking->getZip();
		$insertArray['city'] = $booking->getCity();
		$insertArray['country'] = $booking->getCountry();
		$insertArray['dname'] = ( $booking->getDname() == false ) ? $booking->getName() : $booking->getDname();
		$insertArray['dforename'] = ( $booking->getDforename() == false ) ? $booking->getForename() : $booking->getDforename();
		$insertArray['daddress'] = ( $booking->getDaddress() == false ) ? $booking->getAddress() : $booking->getDaddress();
		$insertArray['dzip'] = ( $booking->getDzip() == false ) ? $booking->getZip() : $booking->getDzip();
		$insertArray['dcity'] = ( $booking->getDcity() == false ) ? $booking->getCity() : $booking->getDcity();
		$insertArray['dcountry'] = ( $booking->getDcountry() == false ) ? $booking->getCountry() : $booking->getDcountry();
		$insertArray['ppref'] = $event->getUid().'-'.$date->getUid().'-'.$now->format('U');
		$insertArray['price'] = round($event->getPrice()*$booking->getAmount(),2);
		$insertArray['date'] = $date->getUid();
		$insertArray['event'] = $event->getUid();
		$insertArray['lkey'] = (int)$GLOBALS['TSFE']->sys_language_content;
		$insertArray['tstamp'] = time();
		$insertArray['crdate'] = time();
		$insertArray['pid'] = $event->getPid();
		$insertArray['user'] = ( $user ) ? $user->getUid() : 0;
		
		$GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_hevents_domain_model_booking', $insertArray);
	
		//$this->bookingRepository->addBooking($booking);
		
		$this->edHandler->cleanUpSession();
		$this->bookingRepository->cleanUpSession();
		
		$this->view->assign('booking', $booking);
		$this->view->assign('event', $event);
		$this->view->assign('date', $date);
		
		//Saferpay Processing
	  	$gateway = $this->settings['saferpay']['url'];
		$accountid = $this->settings['saferpay']['accountId']; /* saferpay account id */
		$seatDetail = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('avail_seats, remain_seats', 
															   'tx_hevents_domain_model_date', 
															   'uid='.$date->getUid());
		$availableSeats = $seatDetail[0]['avail_seats'];
		$orderid = ($event->getUid().'-'.$date->getUid().'-'.$now->format('U')); /* use your own order or basket identifier */
		$amount = ($event->getPrice()*$booking->getAmount())*100;
		$currency = "CHF";
		$description = urlencode("\"Test Purchase - saferpay\"");

		$successconf = array(
		  'parameter' => $this->settings['saferpay']['responsePid'],
		  'additionalParams' => '&orderNo='.$orderid.'&status=success&L='.$GLOBALS['TSFE']->sys_language_uid,
		  'useCashHash' => true,
		  'forceAbsoluteUrl' => true,
		  'returnLast' => 'url',
		);
		
		$failconf = array(
		  'parameter' => $this->settings['saferpay']['responsePid'],
		  'additionalParams' => '&orderNo='.$orderid.'&status=failed&L='.$GLOBALS['TSFE']->sys_language_uid,
		  'useCashHash' => true,
		  'forceAbsoluteUrl' => true,
		  'returnLast' => 'url',
		);
		
		$cancelconf = array(
		  'parameter' => $this->settings['saferpay']['responsePid'],
		  'additionalParams' => '&orderNo='.$orderid.'&status=cancelled&L='.$GLOBALS['TSFE']->sys_language_uid,
		  'useCashHash' => true,
		  'forceAbsoluteUrl' => true,
		  'returnLast' => 'url',
		);

		$successlink = urlencode( $this->cObj->typoLink('', $successconf) );
		$faillink = urlencode( $this->cObj->typoLink('', $failconf) );
		$backlink = urlencode( $this->cObj->typoLink('', $cancelconf) );

		$attributes = "ACCOUNTID=$accountid&AMOUNT=$amount&CURRENCY=$currency&ORDERID=$orderid&DESCRIPTION=$description&SUCCESSLINK=$successlink&FAILLINK=$faillink&BACKLINK=$backlink";
		$url = $gateway."?".$attributes;

		$payinit_url = $this->curl( $url );

	  	$saferpayAmount = ($event->getPrice()*$booking->getAmount())*100;
		$this->view->assign('saferpayamount', $saferpayAmount );
		$this->view->assign('saferpayUrl', $payinit_url);
		$this->view->assign('dateUid', $date->getUid());
	
	}
  
  // Return Url Content 
  public function curl($url){
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
     $data = curl_exec($ch);
     curl_close($ch);
     return $data;
  }

	//depress error message if validation goes wrong
	protected function getErrorFlashMessage() {
		return '';
	}
	
	/**
	 * action pay
	 *
	 * @return void
	 */
	public function listAction() {
		$user = $GLOBALS['TSFE']->fe_user->user;
		if($user){
			$bookings = $this->bookingRepository->findByUser($user['uid']);
			
			$this->view->assign('bookings', $bookings);
			$this->view->assign('user', $user);
		}
		$this->view->assign('islogged', (boolean)$user);
	}
}
?>