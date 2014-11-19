<?php

namespace TYPO3\TntDownloadModule\Domain\Model;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Abin Sabu <abin.s@pitsolutions.com>, PITSolutions Pvt Ltd
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
 * @package tnt_download_module
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class DownloadModule extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    public function doGetCategory($enableFields, $parent) {
        //print_r($GLOBALS['TSFE']->sys_language_uid);
        $lang = $GLOBALS['TSFE']->sys_language_uid;
        $select_fields = 'tx_tntdownloadmodule_domain_model_parentcategory.uid AS parentId,tx_tntdownloadmodule_domain_model_parentcategory.category_title,tx_tntdownloadmodule_domain_model_parentcategory.l10n_parent';
        if ($lang > 0) {
            $select_fields = 'tx_tntdownloadmodule_domain_model_parentcategory.l10n_parent AS parentId,tx_tntdownloadmodule_domain_model_parentcategory.category_title,tx_tntdownloadmodule_domain_model_parentcategory.l10n_parent';
        }
        $from_table = 'tx_tntdownloadmodule_domain_model_parentcategory AS tx_tntdownloadmodule_domain_model_parentcategory';
        $whereClause = " tx_tntdownloadmodule_domain_model_parentcategory.parent = " . $parent . " AND tx_tntdownloadmodule_domain_model_parentcategory.sys_language_uid = " . $lang . $enableFields;
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
        $catInformations = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $whereClause, $groupBy = '', $orderBy = 'tx_tntdownloadmodule_domain_model_parentcategory.sort_order ASC', $limit = '', $uidIndexField = '');
        #echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
        return $catInformations;
    }

    public function doGetDetails($enableFields, $request, $flexSettings = '') {
        $catId = $request['cat_id'];
        $subCatId = $request['subcat_id'];
        $filterText = $request['filterText'];
        $orderBy = '';
        if ($request['sort'] != '') {
            $orderBy = $request['sort'];
        }

        $page = (isset($request['currentPage']) && !empty($request['currentPage'])) ? $request['currentPage'] : 1;
        $per_page = 10;
        if ($flexSettings['paginationPerPage'] != '') {
         $per_page = $flexSettings['paginationPerPage']; //how much records you want to show   
        }
        
        $offset = ($page - 1) * $per_page;
        $limit = $offset . "," . $per_page;
        $whereCond2 = '';
        if ($filterText != '') {
            $whereCond = "tx_tntdownloadmodule_domain_model_downloadmodule.document_title LIKE '%" . $filterText . "%'";
            $whereCond2 = "tx_tntdownloadmodule_domain_model_downloadmodule.document_title LIKE '%" . $filterText . "%' AND ";
        }
        if (empty($catId) && empty($subCatId)) {
            if (!empty($whereCond)) {
                $whereCond .= " AND 1";
            } else {
                $whereCond .= "1";
            }
        } elseif (empty($subCatId)) {
            $category = $this->doGetCategory('', $catId);
            if (!empty($whereCond)) {
                $whereCond .= " AND (FIND_IN_SET('" . $catId . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category)) OR";
                foreach ($category as $key => $value) {
                    $whereCond .= " (FIND_IN_SET('" . $value['parentId'] . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category)) OR";
                }
            } else {
                $whereCond .= " (FIND_IN_SET('" . $catId . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category)) OR";
                foreach ($category as $key => $value) {
                    $whereCond .= " (FIND_IN_SET('" . $value['parentId'] . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category)) OR";
                }
            }
            $whereCond = rtrim($whereCond, 'OR');
        } elseif (!empty($subCatId)) {
            if (!empty($whereCond)) {
                $whereCond .= " AND (FIND_IN_SET('" . $subCatId . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category))";
            } else {
                $whereCond .= "(FIND_IN_SET('" . $subCatId . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category))";
            }
        }

        $lang = $GLOBALS['TSFE']->sys_language_uid;
        //echo $lang;
        $langCond = ' AND tx_tntdownloadmodule_domain_model_downloadmodule.sys_language_uid = 0';
        if( $lang > 0 ){
          $langCond = " AND (tx_tntdownloadmodule_domain_model_downloadmodule.sys_language_uid = ".$lang." OR  tx_tntdownloadmodule_domain_model_downloadmodule.sys_language_uid = 0 )";
        }
        $select_fields = 'tx_tntdownloadmodule_domain_model_downloadmodule.*,sf.*';
        $from_table = 'tx_tntdownloadmodule_domain_model_downloadmodule AS tx_tntdownloadmodule_domain_model_downloadmodule 
                       INNER JOIN sys_file_reference AS sfr  ON tx_tntdownloadmodule_domain_model_downloadmodule.uid = sfr.uid_foreign
                       INNER JOIN sys_file AS sf ON sfr.uid_local = sf.uid';
        $whereClause = $whereCond2 . "sfr.tablenames = 'tx_tntdownloadmodule_domain_model_downloadmodule' AND sfr.fieldname = 'documnet_file_field' AND sfr.deleted=0 AND sfr.hidden = 0 AND tx_tntdownloadmodule_domain_model_downloadmodule.documnet_file_field > 0 AND (" . $whereCond . ")".$langCond.$enableFields;
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
        $catInformations = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $whereClause, $groupBy = 'tx_tntdownloadmodule_domain_model_downloadmodule.uid', $orderBy, $limit, $uidIndexField = '');
        //echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
        //exit();
        $relatedDocumnets = $this->doGetAllDocuments($catInformations, $request, $per_page);

        return $relatedDocumnets;
    }

    public function doGetAllDocuments($singleInformations, $request, $per_page) {

        foreach ($singleInformations as $key => $value) {
            $singleInformations[$key]['isDownloable'] = 0;
            if ($this->userGroupCheck($value)) {
                $singleInformations[$key]['isDownloable'] = 1;
            }
            $singleInformations[$key]['identifier'] = $value['uid'];
            $singleInformations[$key]['size'] = round($value['size'] / 1024);
            $singleInformations[$key]['extension'] = $value['extension'];
            $singleInformations[$key]['document_title'] = $value['document_title'];
        }
        $total_pages = $this->getTotalCount($request);
        $total_pages = ceil($total_pages / $per_page);
        $singleInformation['data'] = $singleInformations;
        $adjacent = 10;
        $singleInformation['pageNation'] = $this->paginate($request['currentPage'], $total_pages, $adjacent);
        //print_r($singleInformation);
        return $singleInformation;
    }

    public function getTotalCount($request) {
        $catId = $request['cat_id'];
        $subCatId = $request['subcat_id'];
        $filterText = $request['filterText'];
        if ($filterText != '') {
            $whereCond = "tx_tntdownloadmodule_domain_model_downloadmodule.document_title LIKE '%" . $filterText . "%'";
            $whereCond2 = "tx_tntdownloadmodule_domain_model_downloadmodule.document_title LIKE '%" . $filterText . "%' AND ";
        }
        if (empty($catId) && empty($subCatId)) {
            if (!empty($whereCond)) {
                $whereCond .= " AND 1";
            } else {
                $whereCond .= "1";
            }
        } elseif (empty($subCatId)) {
            $category = $this->doGetCategory('', $catId);
            if (!empty($whereCond)) {
                $whereCond .= " AND (FIND_IN_SET('" . $catId . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category)) OR";
                foreach ($category as $key => $value) {
                    $whereCond .= " (FIND_IN_SET('" . $value['parentId'] . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category)) OR";
                }
            } else {
                $whereCond .= " (FIND_IN_SET('" . $catId . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category)) OR";
                foreach ($category as $key => $value) {
                    $whereCond .= " (FIND_IN_SET('" . $value['parentId'] . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category)) OR";
                }
            }
            $whereCond = rtrim($whereCond, 'OR');
        } elseif (!empty($subCatId)) {
            if (!empty($whereCond)) {
                $whereCond .= " AND (FIND_IN_SET('" . $subCatId . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category))";
            } else {
                $whereCond .= "(FIND_IN_SET('" . $subCatId . "',tx_tntdownloadmodule_domain_model_downloadmodule.document_category))";
            }
        }

        $lang = $GLOBALS['TSFE']->sys_language_uid;
        $langCond = ' AND tx_tntdownloadmodule_domain_model_downloadmodule.sys_language_uid = 0';
        if( $lang > 0 ){
        	$langCond = " AND (tx_tntdownloadmodule_domain_model_downloadmodule.sys_language_uid = ".$lang." OR  tx_tntdownloadmodule_domain_model_downloadmodule.sys_language_uid = 0 )";
        }
        $select_fields = 'tx_tntdownloadmodule_domain_model_downloadmodule.*,sf.*';
        $from_table = 'tx_tntdownloadmodule_domain_model_downloadmodule AS tx_tntdownloadmodule_domain_model_downloadmodule 
                       INNER JOIN sys_file_reference AS sfr  ON tx_tntdownloadmodule_domain_model_downloadmodule.uid = sfr.uid_foreign
                       INNER JOIN sys_file AS sf ON sfr.uid_local = sf.uid';
        $whereClause = $whereCond2 . " sfr.tablenames = 'tx_tntdownloadmodule_domain_model_downloadmodule' AND sfr.fieldname = 'documnet_file_field' AND sfr.deleted=0 AND sfr.hidden = 0 AND tx_tntdownloadmodule_domain_model_downloadmodule.documnet_file_field > 0 AND (" . $whereCond . ")".$langCond.$enableFields;
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
        $catInformations = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $whereClause, $groupBy = 'tx_tntdownloadmodule_domain_model_downloadmodule.uid', $orderBy = '', $limit = '', $uidIndexField = '');
        #echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
        //exit();
        #echo count($catInformations);
        return count($catInformations);
    }

    public function doGetFile($request) {
        $uid = $request['fileId'];
        $select_fields = '*';
        $from_table = 'sys_file';
        $whereClause = "uid = " . $uid;
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
        $singleFile = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $whereClause, $groupBy = '', $orderBy = '', $limit = '', $uidIndexField = '');
        $path = $_SERVER['DOCUMENT_ROOT'] . "/fileadmin" . $singleFile[0]['identifier'];
        return $path;
    }

    public function paginate($page, $tpages, $adjacents) {
        $prevlabel = "&lsaquo;";
        $nextlabel = "&rsaquo;";
        $out = '<div class="pagination green"> <ul>';
        if ($tpages > 1) {
            // previous label

            if ($page == 1) {
                $out.= "";
            } else {
                $out.= "<li><a href='javascript:void(0);' onclick='load(" . ($page - 1) . ")'>$prevlabel</a></li>";
            }
            // pages

            $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
            $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
            for ($i = $pmin; $i <= $pmax; $i++) {
                if ($i == $page) {
                    $out.= "<li class='current'>$i</li>";
                } else if ($i == 1) {
                    $out.= "<li><a href='javascript:void(0);' onclick='load(1)'>$i</a></li>";
                } else {
                    $out.= "<li><a href='javascript:void(0);' onclick='load(" . $i . ")'>$i</a></li>";
                }
            }

            if ($page < $tpages) {
                $out.= "<li><a href='javascript:void(0);' onclick='load(" . ($page + 1) . ")'>$nextlabel</a></li>";
            } else {
                $out.= "";
            }
            $out.= "</ul></div>";
            return $out;
        }
    }

    public function userGroupCheck($docModule) {

        $loginedUserGroup = explode(',', $GLOBALS['TSFE']->fe_user->user['usergroup']);
        if ($docModule['documnet_user_group'] != '') {
            $moduleAcessGroup = explode(',', $docModule['documnet_user_group']);
            foreach ($loginedUserGroup as $key => $value) {
                if (in_array($value, $moduleAcessGroup)) {
                    return true;
                }
            }
        } else {
            return true;
        }
    }

}

?>