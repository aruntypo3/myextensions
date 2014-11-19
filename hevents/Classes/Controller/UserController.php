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
class Tx_Hevents_Controller_UserController extends Tx_Hevents_Controller_AbstractController {
	
	
	/**
	 * userRepository
	 *
	 * @var Tx_Hevents_Domain_Repository_UserRepository
	 */
	protected $userRepository;

	/**
	 * injectUserRepository
	 *
	 * @param Tx_Hevents_Domain_Repository_UserRepository $userRepository
	 * @return void
	 */
	public function injectUserRepository(Tx_Hevents_Domain_Repository_UserRepository $userRepository) {
		$this->userRepository = $userRepository;
	}
	
	/**
     * frontendUserGroupRepository
	 *
     * @var Tx_Extbase_Domain_Repository_FrontendUserGroupRepository
     */
    protected $frontendUserGroupRepository;
 
    /**
     * injectFrontendUserGroupRepository
	 *
     * @param Tx_Extbase_Domain_Repository_FrontendUserGroupRepository $frontendUserGroupRepository
	 * @return void
     */
    public function injectFrontendUserGroupRepository(Tx_Extbase_Domain_Repository_FrontendUserGroupRepository $frontendUserGroupRepository) {
        $this->frontendUserGroupRepository = $frontendUserGroupRepository;
    }

	/**
	 * action register
	 *
	 * @param mixxed $arrayuser
	 * @ignorevalidation $arrayuser
	 * @return void
	 */
	public function registerAction($arrayuser=Null) {
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/'.$this->settings['JQueryVerion'].'/jquery.min.js"></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/hevents-booking.js" ></script>');
		
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
		$this->view->assign('user', $arrayuser);
	}
	
	/**
	 * action submit
	 *
	 * @param mixxed $arrayuser
	 * @validate $arrayuser Tx_Hevents_Domain_Validator_ArrayuserValidator
	 * @return void
	 */
	public function submitAction($arrayuser) {
		$user = new Tx_Hevents_Domain_Model_User();
		$now = new DateTime();
		$user->dataFromArray($arrayuser);
		$user->setPid((int)$this->settings['user']['pid']);
		$user->setTxExtbaseType('Tx_Extbase_Domain_Model_FrontendUser');
		if(isset($this->settings['user']['group'])){
			$group = $this->frontendUserGroupRepository->findByUid((int)$this->settings['user']['group']);
			if($group){
				$storage = new Tx_Extbase_Persistence_ObjectStorage();
				$storage->attach($group);
				$user->setUsergroup($storage);
			}
		}
		
		$hash = hash_hmac('md5', $now->format('U').'|'.$arrayuser['email'], $TYPO3_CONF_VARS['SYS']['encryptionKey']);

		$mail = $this->templateView('User/OptinMail.html', array($user));
		$this->mail_typo(
			$user->getEmail(), 
			Tx_Extbase_Utility_Localization::translate('register.mail.subject', $this->extensionName), 
			$this->templateView('User/OptinMail.html', array('user'=>$user,'hash'=>$hash)), 
			$this->settings['user']['register']['mail']['sender'],
			'', 
			'',
			array(), 
			true
		);
		$user->setOptkey($hash);
		$user->setPassword(md5($arrayuser['password']));
		$user->setDisable(true);
		$this->userRepository->add($user);
		
		//EMAIL LINK SCHICKEN
		
		$this->view->assign('user', $user);
	}
	
	
	/**
	 * action edit
	 *
	 * @param Tx_Hevents_Domain_Model_User $user
	 * @ignorevalidation $user
	 * @return void
	 */
	public function editAction(Tx_Hevents_Domain_Model_User $user=Null) {
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/edit_validate.js" ></script>');
		$userLoged = $GLOBALS['TSFE']->fe_user->user;
		if($userLoged){
			if(isset($user)){
				$this->view->assign('user', $user);
			}else{
				$userLoged = $this->userRepository->findByUid($userLoged['uid']);
				$this->view->assign('user', $userLoged);
			}
		}
		$this->view->assign('islogged', (boolean)$userLoged);
	}
	
	/**
	 * action submitedit
	 *
	 * @param Tx_Hevents_Domain_Model_User $user
	 * @ignorevalidation $user
	 * @return void
	 */
	public function submiteditAction(Tx_Hevents_Domain_Model_User $user) {
		//$this->userRepository->update($user);
		$updateArray = array();
		$updateArray['email'] = $user->getEmail();
		$updateArray['username'] = $user->getEmail();
		$updateArray['last_name'] = $user->getLastName();
		$updateArray['first_name'] = $user->getFirstName();
		$updateArray['address'] = $user->getAddress();
		$updateArray['zip'] = $user->getZip();
		$updateArray['city'] = $user->getCity();
		$updateArray['country'] = $user->getCountry();
		
		$updateArray['dname'] = $user->getDname();
		$updateArray['dforename'] = $user->getDforename();
		$updateArray['daddress'] = $user->getDaddress();
		$updateArray['dzip'] = $user->getDzip();
		$updateArray['dcity'] = $user->getDcity();
		$updateArray['dcountry'] = $user->getDcountry();
		
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users','uid="'.$user->getUid().'"', $updateArray);
		echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
		//print_r( $updateArray );exit;
		
		$this->redirect('edit');
	}
	
	/**
	 * action optin
	 *
	 * @param string hash
	 * @return void
	 */
	public function optinAction($hash='') {
		if(empty($hash)) $this->view->assign('error', true);
		$user = $this->userRepository->findByHash($hash);
		if($user){
			$user->setDisable(false);
			$user->setOpt(true);
			$this->userRepository->update($user);
			$this->view->assign('user', $user);
		}else{
			$this->view->assign('error', true);
		}
		
	}
	
	/**
	 * action addfav
	 *
	 * @param Tx_Hevents_Domain_Model_Event $event
	 * @param boolean $archive
	 * @return void
	 */
	public function addfavAction(Tx_Hevents_Domain_Model_Event $event, $archive=false) {
		$userLoged = $GLOBALS['TSFE']->fe_user->user;
		if($userLoged){
			//$userLoged = $this->userRepository->findByUid($userLoged['uid']);
			//$userLoged->addFav($event);
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'favs', 'fe_users', 'uid='.$userLoged['uid'] );
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery( 'fe_users', 'uid='.$userLoged['uid'], array( 'favs' => intval($res[0]['favs'])+1 ) );
			$GLOBALS['TYPO3_DB']->exec_INSERTquery( 'tx_hevents_user_event_mm', array('uid_local' => $userLoged['uid'], 'uid_foreign' => $event->getUid()));
		}
		
		if($archive){
			$this->forward('archieve','Event');
		}else{
			$this->forward('list','Event');
		}
	}
	
	/**
	 * action removefav
	 *
	 * @param Tx_Hevents_Domain_Model_Event $event
	 * @param boolean $favs
	 * @param boolean $archive
	 * @return void
	 */
	public function removefavAction(Tx_Hevents_Domain_Model_Event $event, $favs=false, $archive=false) {
		$userLoged = $GLOBALS['TSFE']->fe_user->user;
		if($userLoged){
			//$userLoged = $this->userRepository->findByUid($userLoged['uid']);
			//$userLoged->removeFav($event);
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'favs', 'fe_users', 'uid='.$userLoged['uid'] );
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery( 'fe_users', 'uid='.$userLoged['uid'], array( 'favs' => intval($res[0]['favs'])-1 ) );
			$GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_hevents_user_event_mm', 'uid_local="'.$userLoged['uid'].'" AND uid_foreign ="'.$event->getUid().'"');
		}
		
		if($favs){
			$this->forward('favourits');
		}else if($archive){
			$this->forward('archieve','Event');
		}else{
			$this->forward('list','Event');
		}
	}
	
	/**
	 * action favourits
	 *
	 * @return void
	 */
	public function favouritsAction() {
		$userLoged = $GLOBALS['TSFE']->fe_user->user;
		if($userLoged){
			$userLoged = $this->userRepository->findByUid($userLoged['uid']);
			$this->view->assign('user', $userLoged);
			$this->view->assign('sliderDummyImage', $this->settings['sliderDummyImage']);
		}
		$this->view->assign('islogged', (boolean)$userLoged);
	}
}
?>