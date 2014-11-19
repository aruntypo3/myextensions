<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Trent Smith
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
 * @package pfj_csv_importer
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PfjCsvImporter_Controller_CsvImporterController extends Tx_Extbase_MVC_Controller_ActionController {

    public $uploadfilename;
    public $uploadfile;

    public function __construct() {
        ini_set("memory_limit", -1);
        $this->csvImporterModel = new Tx_PfjCsvImporter_Domain_Model_CsvImporter();
        $this->csvParserModel = new Tx_PfjCsvImporter_Domain_Model_CsvParser();
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        $this->view->assign('extensionPathCss', "../" . t3lib_extMgm::siteRelPath('pfj_csv_importer') . 'Resources/Public/css/');
        $args = $this->request->getArguments();
        if (!empty($_FILES)) {
            $this->uploadfilename = $_FILES['tx_pfjcsvimporter_web_pfjcsvimporterpfjcsvimporter']['name']['import']['up_file'];
            $this->uploadfile = t3lib_div::upload_to_tempfile($_FILES['tx_pfjcsvimporter_web_pfjcsvimporterpfjcsvimporter']['tmp_name']['import']['up_file']);
            $newFile = t3lib_div::getFileAbsFileName('fileadmin/pfj_csv_importer/archive/') . 'Archive_' . time() . '_' . $this->uploadfilename;
            t3lib_div::upload_copy_move($this->uploadfile, $newFile);
            if (!empty($this->uploadfile)) {
                $this->csvParserModel->sort_by = 'title';
                $this->csvParserModel->offset = 1;
                //$this->csvParserModel->limit = 10;
                $this->csvParserModel->auto($newFile);       
                $csvData = $this->csvParserModel->data;
                $pageId = (int) t3lib_div::_GP('id');
                $this->csvImporterModel->parseCsvFile($csvData, $pageId);
            }
        }
        $showUid = $args['page'];
        if (empty($args)) {
            $showUid = 1;
        }
        $content = $this->csvImporterModel->paginate($showUid, $args, $this->uploadfilename);
        $this->view->assign('csvImporters', $content);
        $this->view->assign('backUpcsvFile', $backUpFile);
        if (empty($this->uploadfilename)) {
            $this->view->assign('csvFile', $args['show']);
        }
    }

    /**
     * action show
     *
     * @param Tx_PfjCsvImporter_Domain_Model_CsvImporter $csvImporter
     * @return void
     */
    public function showAction(Tx_PfjCsvImporter_Domain_Model_CsvImporter $csvImporter) {
        $this->view->assign('csvImporter', $csvImporter);
    }

    /**
     * action write
     *
     * @param Tx_PfjCsvImporter_Domain_Model_CsvImporter $csvImporter
     * @return void
     */
    public function writeAction() {
        $this->view->assign('extensionPathCss', "../" . t3lib_extMgm::siteRelPath('pfj_csv_importer') . 'Resources/Public/css/');
        $args = $this->request->getArguments();
        
        $backUpFile = $this->csvImporterModel->bacupCurrentTable();
        if (!empty($args['backup']) && $args['backup'] == 1) {
            $path_parts = pathinfo($backUpFile);
            //$fileName = $path_parts['filename'].'.csv';
            if (file_exists($backUpFile)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/CSV');
                header('Content-Disposition: attachment; filename=' . basename('databaseBackup.csv'));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($backUpFile));
                readfile($backUpFile);
                exit;
            }
        }else{
            $this->csvImporterModel->writeToDatabase();
            
        }
    }

}

?>