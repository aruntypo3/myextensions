<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Arun Chandran <arun.c@pitsolutions.com>, PIT Solutions Pvt Ltd.
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
 * @package vst_tour
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_VstTour_Controller_VsttourController extends Tx_Extbase_MVC_Controller_ActionController {

	protected $vsttourModel;
	protected $fileRepository;
	
	public function __construct() {
		$this->vsttourModel   = new Tx_VstTour_Domain_Model_Vsttour();
		$this->cObj 		  = t3lib_div::makeInstance( 'tslib_cObj' );
		$this->fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
	}
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		
		$GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile(t3lib_extMgm::siteRelPath("vst_tour")."Resources/Public/Js/stickUp.min.js");
		$GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile(t3lib_extMgm::siteRelPath("vst_tour")."Resources/Public/Js/stickUp_script.js");
		$this->cObj  = $this->configurationManager->getContentObject();
		$recordPid 	 = $this->cObj->data['pages'];
		$languageUid = $GLOBALS['TSFE']->sys_language_uid;
		$tourData 	 = $this->vsttourModel->doGetTourDetails( $recordPid, $languageUid, $this->settings['detailPage'] );
		foreach ( $tourData as $tourKey => $tourValue ){
			foreach ( $tourValue['tours'] as $tourKeySingle => $tourValueSingle ){
				$tourData[$tourKey]['tours'][$tourKeySingle]['carousel_images'] = $this->imageFiles( 'tx_tour', 'carousel_images', 
																							 		  $tourValueSingle['tourId']);
			}
		}
		$this->view->assign('vsttours', $tourData);
	}

	/**
	 * action detail
	 *
	 * @return void
	 */
	public function detailAction() {
		
		$GLOBALS['TSFE']->getPageRenderer()->addCssFile(t3lib_extMgm::siteRelPath("vst_tour")."Resources/Public/Css/vst_style.css");
		$args = $this->request->getArguments();
		$languageUid = $GLOBALS['TSFE']->sys_language_uid;
		if( !empty( $args ) ){
			$tourDetail = $this->vsttourModel->doGetTourSingle( $args['uid'], $languageUid );
			foreach ( $tourDetail as $tourKey => $tourInfo  ){
				$partnerData = $this->vsttourModel->doGetPartnerDetails( $tourInfo['uid'] );
				foreach ( $partnerData as $partnerKey => $partnerInfo  ){
					$tourDetail[$tourKey]['partner_images'][$partnerKey]['link'] = $partnerInfo['image_link'];
					$partnerImages[$partnerKey] = $this->imageFiles( 'tx_tour_partners', 'partner_logos', (int) $partnerInfo['uid']);
					foreach ( $partnerImages as $partnerkeySingle => $partnervalueSingle ){
						$tourDetail[$tourKey]['partner_images'][$partnerkeySingle]['image'] = $partnervalueSingle[0];
					}
				}
			}
      		$googleMap['latitude']  = $tourDetail[0]['gps_latitude'];
      		$googleMap['longitude'] = $tourDetail[0]['gps_longitude'];
      		
      		if( $googleMap['latitude'] != "0.000000" && $googleMap['longitude'] != "0.000000" ){
      			$GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile(t3lib_extMgm::siteRelPath("vst_tour")."Resources/Public/Js/googlemapApi.js");
      			$GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile(t3lib_extMgm::siteRelPath("vst_tour")."Resources/Public/Js/google_script.js");
      		}

      		// Assign to template
      		$this->view->assign('googleMap', $googleMap);
			$this->view->assign('tourDetails', $tourDetail);
		}else{
			$flashMsg = Tx_Extbase_Utility_Localization::translate( 'tx_vsttour.noTours', $this->request->getControllerExtensionName(), 
																	$arguments = NULL );
			$this->flashMessageContainer->add( $flashMsg );
			$this-> view-> assign( 'flashMessage', $flashMsg );
		}
	}
  
  	/**
	 * action banner
	 *
	 * @return void
	 */
	public function bannerAction() {
    	$args = $this->request->getArguments();
		$languageUid = $GLOBALS['TSFE']->sys_language_uid;
		if( !empty( $args ) ){
      		$carouselImages = $this->vsttourModel->doGetTourSingle( $args['uid'], $languageUid );
      		foreach ( $carouselImages as $carouselKey => $carouselValue ){
  				$carouselImages[$carouselKey]['carousel_images'] = $this->imageFiles( 'tx_tour', 'carousel_images', $carouselValue['uid']);
		  	}
      		$this->view->assign('carouselImages', $carouselImages[0]);
    	}
  	}
	
	/*
	 * Function to fetch image files from sys_file
	 */
	public function imageFiles( $tableName, $fieldName, $itemId ){

		$fileObjects = $this->fileRepository->findByRelation( $tableName, $fieldName, $itemId);
		$files = array();
		foreach ($fileObjects as $key => $value) {
			$file 			  = array();
			$file['original'] = $value->getOriginalFile()->getProperties();
			$files[$key] 	  = $file['original']['identifier'];
		}
		return $files;
	}
}
?>