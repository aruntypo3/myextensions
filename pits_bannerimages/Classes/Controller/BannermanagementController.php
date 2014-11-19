<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Arun Chandran <arun.c@pitsolutions.com>, PIT Solutions Pvt Ltd.
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
 * ************************************************************* */

/**
 *
 *
 * @package pits_bannerimages
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PitsBannerimages_Controller_BannermanagementController extends Tx_Extbase_MVC_Controller_ActionController {

    public $pitsbannerimageModel;
    public $pageId;
    public $languageUid;

    public function __construct() {
        $this->pitsbannerimageModel = new Tx_PitsBannerimages_Domain_Model_Bannermanagement();
        $this->languageUid = $GLOBALS['TSFE']->sys_language_uid;
        $this->pageId = $GLOBALS['TSFE']->id;
        $this->baseUrl = $GLOBALS['TSFE']->baseUrl;
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        $this->contentObj = $this->configurationManager->getContentObject();
        $bannerImage['storagePid'] = $this->contentObj->data['pages'];
        $bannerImage['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $bannerImage['languageUid'] = $this->languageUid;
        $bannerImage['pageId'] = $this->pageId;
        $bannerImage['baseUrl'] = $this->baseUrl;
        $randCheck = $this->settings['show_random'];
        if (!empty($this->settings['image_position'])) {
            $imagePosition = $this->settings['image_position'];
            switch ($imagePosition) {
                case 'first_column':
                    $this->view->setTemplatePathAndFilename(t3lib_extMgm::siteRelPath('pits_bannerimages') . 'Resources/Private/Templates/Bannermanagement/List_first_column.html');
                    $bannerImage['width'] = (!empty($this->settings['image_width'])) ? $this->settings['image_width'] : 468;
                    break;
                case 'second_column':
                    $this->view->setTemplatePathAndFilename(t3lib_extMgm::siteRelPath('pits_bannerimages') . 'Resources/Private/Templates/Bannermanagement/List_second_column.html');
                    $bannerImage['width'] = (!empty($this->settings['image_width'])) ? $this->settings['image_width'] : 300;
                    break;
                case 'third_column':
                    $this->view->setTemplatePathAndFilename(t3lib_extMgm::siteRelPath('pits_bannerimages') . 'Resources/Private/Templates/Bannermanagement/List.html');
                    $bannerImage['width'] = (!empty($this->settings['image_width'])) ? $this->settings['image_width'] : 160;
                    break;
                case 'top_banner':
                    $this->view->setTemplatePathAndFilename(t3lib_extMgm::siteRelPath('pits_bannerimages') . 'Resources/Private/Templates/Bannermanagement/List_top_banner.html');
                    $bannerImage['width'] = (!empty($this->settings['image_width'])) ? $this->settings['image_width'] : 727;
                    break;
            }
        }
        $selectImageArray = $this->pitsbannerimageModel->getbannerImages($randCheck, $this->settings['flexform']['selected_images'], $this->languageUid);

        // print_r( $selectImageArray);
        foreach ($selectImageArray as $key => $value) {
                $filename = $GLOBALS['TSFE']->baseUrl . '/fileadmin/' . $value['image'];
                $selectImageArray[$key]['isGif'] = 0;
                if (exif_imagetype($filename) == IMAGETYPE_GIF) {
                   $selectImageArray[$key]['isGif'] = 1;
                } 
            if (!empty($value['image_link'])) {
                $selectImageArray[$key]['urlStatus'] = (!is_numeric($value['image_link']) ) ? 1 : 0;
            }
        }
        $this->view->assign('imageDetails', $bannerImage);
        $this->view->assign('imageArray', $selectImageArray);
    }

    /**
     * action show
     *
     * @param Tx_PitsBannerimages_Domain_Model_Bannermanagement $bannermanagement
     * @return void
     */
    public function showAction() {
        $request = $this->request->getArguments();

        //$imgclickArray['image_id'] = $request['image_id'];
        //$imgclickArray['title'] = $request['title'];
        //$imgclickArray['image'] = '/fileadmin/' . $request['image'];
        $imgclickArray['sys_language_uid'] = $this->languageUid;
        $imgclickArray['count'] = 1;

        $imgCount = $this->pitsbannerimageModel->getCount( $request['image'] );
        
        if (empty($imgCount)) {
            $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_pitsbannerimages_domain_model_bannermanagement', $imgclickArray);
        }
        else {
            $updateQuery = "UPDATE tx_pitsbannerimages_domain_model_bannermanagement SET count=count+1 WHERE image = '".$request['image']."'";
            $GLOBALS['TYPO3_DB']->sql_query($updateQuery);
        }
        exit;
    }

}

?>
