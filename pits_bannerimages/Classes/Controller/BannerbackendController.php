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
class Tx_PitsBannerimages_Controller_BannerbackendController extends Tx_Extbase_MVC_Controller_ActionController {

    public $pitsbannerbackendModel;

    public function __construct() {
        $this->pitsbannerbackendModel = new Tx_PitsBannerimages_Domain_Model_Bannerbackend();
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {

        $importDataView = $this->pitsbannerbackendModel->getAllItems();
        $pos = strrpos($_SERVER['REQUEST_URI'], "typo3/mod.php?");
        $project = substr($_SERVER['REQUEST_URI'], 0, $pos);
        $urlRef = "http://" . $_SERVER['HTTP_HOST'] . $project;
        $this->view->assign('backendView', $importDataView);
        $this->view->assign('baseUrl', $urlRef);
    }

    /**
     * action deleteBanner
     *
     * @return void
     */
    public function deleteBannerAction() {
        $request = $this->request->getArguments();
        $deleteStatus = $this->pitsbannerbackendModel->deleteBanner($request['banner']);
    }

}

?>