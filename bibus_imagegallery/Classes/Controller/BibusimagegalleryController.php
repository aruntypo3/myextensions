<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Arun Chandran <arun.c@pitsolutions.com>, PIT Solutions Pvt Ltd
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
 * @package bibus_imagegallery
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_BibusImagegallery_Controller_BibusimagegalleryController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * action list
	 *
	 * @return void
	 */
	public function rendergalleryAction() {
		
		$this->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("tslib_cObj");
		$uid = $this->configurationManager->getContentObject()->data['uid'];
		
		// Method to fetch FAL file referencing.
		$fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
		$fileObjects = $fileRepository->findByRelation('tt_content', 'tx_bibus_imagegallery', $uid);
		
		$files = array();
		foreach ($fileObjects as $key => $value) {
			$file = array();
			$file['reference'] = $value->getReferenceProperties();
        	$file['original'] = $value->getOriginalFile()->getProperties();
        	$files[] = $file;
		}

		foreach ( $files as $dataKey => $dataValue ) {
			$imageObj['img'] = 'IMAGE';
			$imageObj['img.']['file'] = "fileadmin".$dataValue['original']["identifier"];
			$imageObj['img.']['file.']['width'] = $this->settings['thumbWidth'].'m';
			$imageObj['img.']['file.']['height'] = $this->settings['thumbHeight'];
			$image[$dataKey]['resizedImage'] = $this->cObj->IMG_RESOURCE($imageObj['img.']);
			
			$imageObj['img.']['file.']['width'] = $this->settings['lightboxWidth'];
			$imageObj['img.']['file.']['height'] = $this->settings['lightboxHeight'].'m';
			$imageObj['img.']['file.']['maxW']= $this->settings['lightboxWidth'];
			$imageObj['img.']['file.']['maxH']= $this->settings['lightboxHeight'];
			$image[$dataKey]['identifier'] = $this->cObj->IMG_RESOURCE($imageObj['img.']);
			$image[$dataKey]['actTitle'] = ( !empty( $dataValue['reference']['title'] ) ) ? $dataValue['reference']['title'] : $dataValue['original']['title'];
		}

		$viewArray = array();
		$viewArray['baseUrl'] = $GLOBALS['TSFE']->baseUrl;
		$viewArray['sys_images'] = $image;
		$viewArray['thumb_width'] = $this->settings['thumbWidth'];
		$viewArray['thumb_height'] = $this->settings['thumbHeight'];
		$viewArray['imageArraysize'] = sizeof( $image );

		$this->view->assign('bibusGallery', $viewArray);
	}
}
?>