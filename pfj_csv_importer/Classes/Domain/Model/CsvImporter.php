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
class Tx_PfjCsvImporter_Domain_Model_CsvImporter extends Tx_Extbase_DomainObject_AbstractEntity {

    public function parseCsvFile($fileData, $pageId) {

        $query = 'TRUNCATE TABLE tx_pfjcsvimporter_domain_model_csvimporter';
        $GLOBALS['TYPO3_DB']->sql_query($query);
        $mappArray = array(
            'item_number' => 'item_number',
            'item_name' => 'item_name',
            'buy' => 'buy',
            'sell' => 'sell',
            'inventory' => 'inventory',
            'item_pic' => 'item_picture',
            'description' => 'description',
            'custlist_1' => 'custom_list_1',
            'metal' => 'custom_list_2',
            'brand' => 'custom_list_3',
            'stone_details' => 'custom_field_1',
            'show_onsite' => 'custom_field_2',
            'sellingprice' => 'selling_price',
            'quant_break_1'=>'quantity_break_1',
        );
        $insertArray = array();
        foreach ($fileData as $key => $value) {
            foreach ($value as $pin => $data) {
                $searchValue = strtolower(preg_replace('/\s+/', '_', $pin));
                $dbColName = array_search($searchValue, $mappArray);
                if (!empty( $dbColName )) {
                    $insertArray[$key][$dbColName] = $data;
                    $insertArray[$key]['pid'] = $pageId;
                    $insertArray[$key]['tstamp'] = time();
                    $insertArray[$key]['crdate'] = time();
                }
            }
            $this->insertToDatabase($insertArray[$key]);
        }
        //$this->insertToDatabase( $insertArray );
    }

    public function insertToDatabase($insertArray) {


        $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_pfjcsvimporter_domain_model_csvimporter', $insertArray);
    }

    ////EXTA FUNCTIONS
    public function paginate($page, $args, $fileName) {
        $targetpage = "mod.php?M=web_PfjCsvImporterPfjcsvimporter&tx_pfjcsvimporter_web_pfjcsvimporterpfjcsvimporter[show]=" . $fileName . "&tx_pfjcsvimporter_web_pfjcsvimporterpfjcsvimporter[action]=list&tx_pfjcsvimporter_web_pfjcsvimporterpfjcsvimporter[controller]=CsvImporter&tx_pfjcsvimporter_web_pfjcsvimporterpfjcsvimporter[page]=";
        $numberOfResults = $this->getAllDataCount();
        $limit = $resultsPerPage = 200; // page display limit
        $currentPage = $page;
        $stages = 100;
        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil($numberOfResults / $limit);
        $LastPagem1 = $lastpage - 1;
        if ($page && $currentPage != 1) {
            $start = ($page - 1) * $limit;
        } else {
            $start = 1;
            $currentPage = 1;
        }

        $lowerLimit = ( ( $currentPage * $limit ) - $limit ) + 1;
        $upperLimit = $currentPage * $limit;

        if ($currentPage == $lastpage) {
            $upperLimit = $numberOfResults;
        }
        $paginate = '';
        $page = ($page == '') ? 1 : $page;
        if ($lastpage > 1) {
            $paginate .= "<div class='summary'>
                              <div class='paginate'>
                              <p>
                          Displaying results <span>" . $lowerLimit . "</span> to <span>" . $upperLimit . " </span>out of <span>" . $numberOfResults . "</span></p>
                            ";
            if ($page > 1) {
                $paginate.= "<a href='$targetpage$prev'>Previous" . $showUid . "</a>";
            } else {
                $paginate.= "";
            }
            if ($lastpage < 100 + ($stages * 2)) {  // Not enough pages to breaking it up
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $paginate.= "<span class='current'>$counter</span>";
                    } else {
                        $paginate.= "<a href='$targetpage$counter'>$counter</a>";
                    }
                }
            }
            if ($page < $counter - 1) {
                $paginate.= "<a href='$targetpage$next'>Next</a>";
            } else {
                $paginate.= "";
            }
            $paginate.= "<div class='clear'></div></div></div>";
        }
        $retArr['pageNation'] = $paginate;
        $retArr['data'] = $this->getAllData($page, $limit);
        //print_r($retArr);
        return $retArr;
    }

    public function getAllDataCount() {
        $select_fields = 'COUNT(*) AS count';
        $from = 'tx_pfjcsvimporter_domain_model_csvimporter';
        $orderByClause = '';
        $result = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                $select_fields, $from, $whereClause, '', $orderByClause, ''
        );
        return $result['0']['count'];
    }

    public function getAllData($currentPage, $recordPerPage) {
        $startPoint = ($currentPage - 1) * $recordPerPage;
        $limitClause = "$startPoint,$recordPerPage";
        if ($currentPage == NULL && $recordPerPage == NULL) {
            $limitClause = '';
        }
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = TRUE;
        $select_fields = '*';
        $from = 'tx_pfjcsvimporter_domain_model_csvimporter';
        $orderByClause = '';
        $result = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                $select_fields, $from, $whereClause, '', $orderByClause, $limitClause
        );
        return $result;
    }

    public function writeToDatabase() {

        $query = 'TRUNCATE TABLE tx_pfj_items';
        $GLOBALS['TYPO3_DB']->sql_query($query);
        $query = 'INSERT INTO tx_pfj_items (pid,tstamp,crdate,item_number,item_name,buy,sell,inventory,item_pic,description,custlist_1,metal,brand,stone_details,show_onsite,sellingprice,quant_break_1)
                  SELECT pid,tstamp,crdate,item_number,item_name,buy,sell,inventory,item_pic,description,custlist_1,metal,brand,stone_details,show_onsite,sellingprice,quant_break_1
                  FROM tx_pfjcsvimporter_domain_model_csvimporter';
        $GLOBALS['TYPO3_DB']->sql_query($query);

        $query = 'TRUNCATE TABLE tx_pfjcsvimporter_domain_model_csvimporter';
        $GLOBALS['TYPO3_DB']->sql_query($query);
    }

    public function bacupCurrentTable() {

        $randomNumber = rand(1, 10000);
        $backup_file = t3lib_div::getFileAbsFileName('fileadmin/pfj_csv_importer/Backup/') . $randomNumber . 'BackupCsv_' . date('l_jS_\of_F_Y h:i:s_A', time()) . '.csv';

        $fileName = 'http://pfj.com.au/fileadmin/pfj_csv_importer/Backup/BackupCsv_' . $randomNumber . date('l_jS_\of_F_Y h:i:s_A', time()) . '.csv';

        $select_fields = 'item_number,item_name,buy,sell,inventory,item_pic,description,custlist_1,metal,brand,stone_details,show_onsite,sellingprice';
        $from = 'tx_pfj_items_import_check';
        $orderByClause = '';
        $result = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                $select_fields, $from, $whereClause, '', $orderByClause, $limitClause
        );

        $col = array('item_number', 'item_name', 'buy', 'sell', 'inventory', 'item_picture', 'description', 'custom_list_1', 'custom_list_2', 'custom_list_3', 'custom_field_1', 'custom_field_2', 'selling_price');

        $fp = fopen($backup_file, 'w');
        $counter = 0;
        foreach ($result as $fields) {
            if ($counter <= 0) {
                fputcsv($fp, $col);
                $counter++;
            }
            fputcsv($fp, $fields);
        }
        fclose($fp);
        return $backup_file;
    }

}

?>