<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Dieter Bunkerd <dieter.bunkerd@typo3-asia.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */
require_once(PATH_tslib . 'class.tslib_pibase.php');
require_once(t3lib_extMgm::extPath('lang', 'lang.php'));

/**
 * Plugin 'Jewellery List' for the 'pfj' extension.
 *
 * @author	Dieter Bunkerd <dieter.bunkerd@typo3-asia.com>
 * @package	TYPO3
 * @subpackage	tx_pfj
 */
class tx_pfj_pi1 extends tslib_pibase {

    var $prefixId = 'tx_pfj_pi1';  // Same as class name
    var $scriptRelPath = 'pi1/class.tx_pfj_pi1.php'; // Path to this script relative to the extension dir.
    var $extKey = 'pfj'; // The extension key.
    var $pi_checkCHash = true;
    var $templateCode;
    var $placeOrder;

    /**
     * Creates an instance of this class
     *
     * @return void
     */
    function __construct() {
        if ($GLOBALS['TSFE']->cHash == '') {
            // Might be USER_INT case
            $piVars = t3lib_div::GParrayMerged($this->prefixId);
            if ($piVars['search']) {
                $this->pi_checkCHash = false;
            }
        }
        $this->placeOrder = $this->pi_getLL('orderplaced');
        parent::tslib_pibase();
    }

    /**
     * Main method of the PlugIn
     *
     * @param	string		$content: The content of the PlugIn
     * @param	array		$conf: The PlugIn Configuration
     * @return	The content that should be displayed on the website
     */
    function main($content, $conf) {
        $this->conf = $conf;
        $this->pi_setPiVarDefaults();
        $this->pi_loadLL();

        // Check environment
        if (!isset($conf['tsIsLoaded'])) {
            return $this->pi_wrapInBaseClass($this->pi_getLL('no_ts_template'));
        }

        // Init
        $this->init();
        $this->addHeaderParts();

        // If there are only two choices AND no flexform is needed, you could use this:
        //		if (t3lib_div::testInt($this->piVars['showUid'])) {
        //			$content = $this->singleView();
        //		}
        //		else {
        //			$content = $this->listView();
        //		}

        switch ((string) $this->fetchConfigurationValue('what_to_display')) {
            case 'singleView':
                $content = $this->singleView();
                break;
            case 'listView':
                $content = $this->listView();
                break;
            case 'catView':
                $content = $this->catView();
                break;
            case 'cartView':
                $content = $this->cartView();
                break;
            case 'stockistView':
                $content = $this->stockistView();
                break;
            case 'stockistSingleView':
                $content = $this->stockistSingleView();
                break;
            case 'orderHistory':
                $content = $this->doGetUserOrder();

                break;

            default:
                return $this->pi_wrapInBaseClass($this->pi_getLL('no_mode_set'));
                break;
        }
        return $this->pi_wrapInBaseClass($content);
    }

    /**
     * Initializes plugin configuration.
     *
     * @return	string	Generated HTML
     */
    protected function init() {
        $this->pi_initPIflexForm();
        // Get values
        $this->conf['templateFile'] = $this->fetchConfigurationValue('templateFile');
        // Set defaults if necessary
        if (!$this->conf['templateFile']) {
            $this->conf['templateFile'] = 'EXT:' . $this->extKey . '/res/tx_pfj_template.html';
        }
        // Load template code
        $this->templateCode = $this->cObj->fileResource($this->conf['templateFile']);
    }

    /**
     * Fetches configuration value given its name. Merges flexform and TS configuration values.
     *
     * @param	string	$param	Configuration value name
     * @return	string	Parameter value
     */
    protected function fetchConfigurationValue($param, $tab = 'sDEF') {
        $value = trim($this->pi_getFFvalue($this->cObj->data['pi_flexform'], $param, $tab));
        return $value ? $value : $this->conf[$param];
    }

    /**
     * Shows a list of database entries
     *
     * @param	string		$content: content of the PlugIn
     * @param	array		$conf: PlugIn Configuration
     * @return	HTML list of table entries
     */
    function listView($content, $conf) {
        if (isset($this->piVars['cat'])) {
            $cat = $this->piVars['cat'];
        } else {
            $cat = $this->fetchConfigurationValue('category');
        }
        $pageSize = t3lib_div::testInt($this->conf['listViewPerPage']) ? intval($this->conf['listViewPerPage']) : 10;
        if ((isset($this->piVars['page'])) && ($this->piVars['page'] != '') && ($this->piVars['page'] > 1)) {
            $page = max(1, intval($this->piVars['page']));
        } else {
            $page = 1;
        }
        $page = intval($page);
        if (isset($cat)) {
            //$where = "custlist_1 like '".$cat."%' and deleted=0 and hidden=0 and inactive_item='N' and inactive_item='N' and item_name not like '%cancelled%'";
            //$rst = $GLOBALS['TYPO3_DB']->exec_SELECTquery("*", "tx_pfj_items", "custlist_1 like '".$cat."%' and deleted=0 and hidden=0 and inactive_item='N' and inactive_item='N' and item_name not like '%cancelled%'");
            $where = "custlist_1 like '" . $cat . "%' and deleted = 0 and hidden = 0 and show_onsite LIKE 'yes'";
        } else {
            //$where = $this->fetchConfigurationValue('staticSqlFilter').'item_name not like \'%cancelled%\' and deleted=0 and hidden=0 and inactive_item=\'N\'';
            //$rst = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tx_pfj_items', $this->fetchConfigurationValue('staticSqlFilter').'item_name not like \'%cancelled%\' and deleted=0 and hidden=0 and inactive_item=\'N\'');
            $where = $this->fetchConfigurationValue('staticSqlFilter') . 'deleted = 0 and hidden = 0 and show_onsite LIKE "yes"';
        }
        $rst = $this->prepareSQL($where, $pageSize, $page);
        if ($GLOBALS['TYPO3_DB']->sql_num_rows($rst) > 0) {
            $markers = array();
            $template = $this->cObj->getSubpart($this->templateCode, '###LIST_VIEW###');
            $subParts['###LIST_DATA###'] = $this->getListItem($template, $rst);
            $subParts['###PAGER###'] = $this->getListPage($template, $where, $pageSize, $page);
            $content = $this->cObj->substituteMarkerArrayCached($template, $markers, $subParts);
        } else {
            $template = $this->cObj->getSubpart($this->templateCode, '###LIST_VIEW_NO_RECORD###');
            $content = $this->cObj->substituteMarker($template, '###STRING_RECORD_NOT_FOUND###', $this->pi_getLL('record_not_found'));
        }

        $GLOBALS['TYPO3_DB']->sql_free_result($rst);
        return $content;
    }

// Out put products list
    function getListItem($template, $result) {
        $subTemplate = $this->cObj->getSubpart($template, '###LIST_DATA###');
        $content = '';
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
            $usergroupArray = explode(',', $GLOBALS['TSFE']->fe_user->user['usergroup']);
            $markers['###ITEM_PRICE###'] = (!empty($GLOBALS["TSFE"]->loginUser) && ( in_array($this->conf['stockistsUsergroupId'], $usergroupArray) ) ) ? $this->pi_getLL('pricelabel') . " : " . $row['sellingprice'] : '';
            $pic = $row['item_pic'];
            if ($pic != "" and file_exists("uploads/tx_pfj/$pic")) {
                $source = "uploads/tx_pfj/$pic";
                //$markers['###ITEM_PIC###'] = '<img src="'.$this->imgResize($row['item_pic'],200,200).'" alt="'.$row['item_name'].'" />';
                //$markers['###ITEM_PIC###'] = $this->pi_list_linkSingle('<img src="'.$this->imgResize($row['item_pic'],200,200).'" title="' . $pic . '" alt="'.$row['item_name'].'" />',$row['uid'],1,array(),0,$this->fetchConfigurationValue('singlePid'));
                $markers['###ITEM_PIC###'] = $this->pi_list_linkSingle('<img width="200px" height="200px" src="' . $source . '" title="' . $pic . '" alt="' . $row['item_name'] . '" />', $row['uid'], 1, array(), 0, $this->fetchConfigurationValue('singlePid'));
            } else {
                //$markers['###ITEM_PIC###'] = '<img src="http://www.placehold.it/200x200.png&text=No+Image" />';
                $markers['###ITEM_PIC###'] = $this->pi_list_linkSingle('<img title="NO IMAGE" src="http://www.placehold.it/200x200.png&text=No+Image" />', $row['uid'], 1, array(), 0, $this->fetchConfigurationValue('singlePid'));
            }
            $markers['###ITEM_NUMBER###'] = $row['item_number'];
            $markers['###ITEM_NAME###'] = $row['item_name'];
            $markers['###ITEM_DESCRIPTION###'] = $row['description'];
            $markers['###LINK_DETAIL###'] = $this->pi_list_linkSingle($this->pi_getLL('morelink'), $row['uid'], 1, array(), 0, $this->fetchConfigurationValue('singlePid'));
            $markers['###ADD_CART###'] = (!empty($GLOBALS["TSFE"]->loginUser) && ( in_array($this->conf['stockistsUsergroupId'], $usergroupArray) ) ) ? '<img src="typo3conf/ext/pfj/res/images/addtocart.png" alt="Add to Cart" title="Add to Cart" id="pfjproduct_' . $row['uid'] . '" />' : '';
            $content .= $this->cObj->substituteMarkerArray($subTemplate, $markers);
        }
        return $content;
    }

// Setting SQL before query database
    function prepareSQL($where, $pageSize, $page) {
        $number = ($page - 1) * $pageSize;
        $sort = $this->sortListItem();

        $result = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                '*', 'tx_pfj_items', $where, '', $sort, $number . ',' . $pageSize
        );
        if ($_SERVER['REMOTE_ADDR'] == '121.241.181.73') {
            $result = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                    '*', 'tx_pfj_items_import_check', $where, '', $sort, $number . ',' . $pageSize
            );
        }
        return $result;
    }

// Prepare sort value before query
    function sortListItem() {
        if ((isset($this->piVars['sort'])) && ($this->piVars['sort'] != '')) {
            if ($this->piVars['sorts'] == 'd') {
                $sort = $this->piVars['sort'] . ' DESC';
            } else {
                $sort = $this->piVars['sort'] . ' ASC';
            }
        } else {
            $sort = $this->conf['sortField'] . ' ' . $this->conf['sortType'];
        }
        return $sort;
    }

// Output Pager
    function getListPage($template, $where, $pageSize, $page) {


        list($row) = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                'COUNT(*) AS t', 'tx_pfj_items', $where
        );

        if ($_SERVER['REMOTE_ADDR'] == '121.241.181.73') {
            list($row) = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                    'COUNT(*) AS t', 'tx_pfj_items_import_check', $where
            );
        }

        if ($row['t'] == 0) {
            return '';
        }
        if (($row['t'] < $pageSize) && ($row['t'] != 0)) {
            $markers = array(
                '###CURRENT_PAGE###' => '<span class="currentPage bg-grey">' . $row['t'] . ' ' . $this->pi_getLL('sumresult') . '</span>',
                '###SUM_RESULT###' => '',
                '###FIRST_PAGE###' => '',
                '###LINK_PREV###' => '',
                '###LAST_PAGE###' => '',
                '###LINK_NEXT###' => '',
                '###STEP_NEXT###' => '',
                '###STEP_PREV###' => '',
            );
            $subTemplate = $this->cObj->getSubpart($template, '###PAGER###');
            $subParts['###MORE_PAGES###'] = '';
            $subParts['###LESS_PAGES###'] = '';
            $content = $this->cObj->substituteMarkerArrayCached($subTemplate, $markers, $subParts);
            return $content;
        }
        if ($row['t'] > $pageSize) {
            $lastpage = intval(ceil($row['t'] / $pageSize));
        } else {
            $lastpage = $page;
            $lastpage = intval($lastpage);
        }
        $markers = array(
            '###CURRENT_PAGE###' => '<span class="currentPage">' . $page . '</span>',
            '###SUM_RESULT###' => '<td class="p_center"><span class="currentPage bg-grey">' . number_format($row['t']) . ' ' . $this->pi_getLL('sumresult') . '</span></td>',
        );
        if ($page == 1) {
            $markers['###FIRST_PAGE###'] = '';
            $markers['###LINK_PREV###'] = '';
        } else {
            $markers['###FIRST_PAGE###'] = $this->pi_linkTP_keepPIvars($this->pi_getLL('first_page'), array('page' => 1), true);
            $markers['###LINK_PREV###'] = $this->pi_linkTP_keepPIvars($this->pi_getLL('link_prev'), array('page' => $page - 1), true);
        }
        if ($page == $lastpage) {
            $markers['###LAST_PAGE###'] = '';
        } else {
            $markers['###LAST_PAGE###'] = $this->pi_linkTP_keepPIvars($this->pi_getLL('last_page'), array('page' => $lastpage), true);
        }
        if ($row['t'] <= $page * $pageSize) {
            $markers['###LINK_NEXT###'] = '';
        } else {
            $markers['###LINK_NEXT###'] = $this->pi_linkTP_keepPIvars($this->pi_getLL('link_next'), array('page' => $page + 1), true);
        }
        $markers['###STEP_NEXT###'] = $this->stepNext($pageSize, $page, $lastpage);
        $markers['###STEP_PREV###'] = $this->stepPrev($pageSize, $page, $lastpage);
        $subTemplate = $this->cObj->getSubpart($template, '###PAGER###');
        $subParts['###MORE_PAGES###'] = $this->renderMorePage($subTemplate, $pageSize, $page, $lastpage);
        $subParts['###LESS_PAGES###'] = $this->renderLessPage($subTemplate, $pageSize, $page, $lastpage);
        $content = $this->cObj->substituteMarkerArrayCached($subTemplate, $markers, $subParts);
        return $content;
    }

// render Pager more page
    function renderMorePage($template, $pageSize, $page, $lastpage) {
        $subTemplate = $this->cObj->getSubpart($template, '###MORE_PAGES###');
        $add_p = intval($this->conf['additionPage']);
        $pageSize = intval($pageSize);
        $page = intval($page);
        $lastpage = intval($lastpage);
        if ($page == $lastpage) {
            return '';
        } elseif ($lastpage < ($page + $add_p)) {
            $i = 0;
            while ($lastpage > ($page + $i)) {
                $i++;
            }
            $max_mp = $page + $i;
        } else {
            $max_mp = $page + $add_p;
        }
        $m_r = range(($page + 1), $max_mp);
        $content = '';
        foreach ($m_r as $key => $more_l) {
            $subMarkers = array(
                '###MORE_PAGE###' => $this->pi_linkTP_keepPIvars($more_l, array('page' => $more_l), true),
            );
            $content .= $this->cObj->substituteMarkerArray($subTemplate, $subMarkers);
        }
        return $content;
    }

// render Pager step next
    function stepNext($pageSize, $page, $lastpage) {
        $add_p = intval($this->conf['additionPage']);
        $pageSize = intval($pageSize);
        $page = intval($page);
        $lastpage = intval($lastpage);
        if (($page == $lastpage) || ($lastpage < ($page + $add_p))) {
            return '';
        } else {
            $max_mp = $page + $add_p;
            return $this->pi_linkTP_keepPIvars($this->pi_getLL('step_next'), array('page' => $max_mp), true);
        }
    }

// render Pager less page
    function renderLessPage($template, $pageSize, $page, $lastpage) {
        $subTemplate = $this->cObj->getSubpart($template, '###LESS_PAGES###');
        $add_p = intval($this->conf['additionPage']);
        $pageSize = intval($pageSize);
        $page = intval($page);
        $lastpage = intval($lastpage);
        if ($page == 1) {
            return '';
        } elseif ($page <= $add_p) {
            $i = 0;
            while (($page - $i) > 1) {
                $i++;
            }
            $min_lp = $page - $i;
        } else {
            $min_lp = $page - $add_p;
        }
        $m_r = range($min_lp, ($page - 1));
        $content = '';
        foreach ($m_r as $key => $less_l) {
            $subMarkers = array(
                '###LESS_PAGE###' => $this->pi_linkTP_keepPIvars($less_l, array('page' => $less_l), true),
            );
            $content .= $this->cObj->substituteMarkerArray($subTemplate, $subMarkers);
        }
        return $content;
    }

// render Pager step prev
    function stepPrev($pageSize, $page, $lastpage) {
        $add_p = intval($this->conf['additionPage']);
        $pageSize = intval($pageSize);
        $page = intval($page);
        $lastpage = intval($lastpage);
        if (($page == 1) || ($page <= $add_p)) {
            return '';
        } else {
            $min_lp = $page - $add_p;
            return $this->pi_linkTP_keepPIvars($this->pi_getLL('step_prev'), array('page' => $min_lp), true);
        }
    }

    /**
     * Display a single item from the database
     *
     * @param	string		$content: The PlugIn content
     * @param	array		$conf: The PlugIn configuration
     * @return	HTML of a single database entry
     */
    function singleView($content, $conf) {
        $rst = $GLOBALS['TYPO3_DB']->exec_SELECTquery("*", "tx_pfj_items", "uid=" . $this->piVars['showUid']);
        if ($GLOBALS['TYPO3_DB']->sql_num_rows($rst) > 0) {
            $markers = array();
            $template = $this->cObj->getSubpart($this->templateCode, '###SINGLE_VIEW###');
            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rst)) {
                //$markers['###STRING_PRICE###'] = $this->pi_getLL('pricelabel');
                $usergroupArray = explode(',', $GLOBALS['TSFE']->fe_user->user['usergroup']);
                $markers['###PRICE_VAL###'] = (!empty($GLOBALS["TSFE"]->loginUser) && ( in_array($this->conf['stockistsUsergroupId'], $usergroupArray) ) ) ? '<div class="item-price"><h2>' . $this->pi_getLL('pricelabel') . '</h2><p>' . $row['sellingprice'] . '</p></div>' : '';
                $markers['###ADD_CART###'] = (!empty($GLOBALS["TSFE"]->loginUser) && ( in_array($this->conf['stockistsUsergroupId'], $usergroupArray) ) ) ? '<div class="single_cart"><h2>' . $this->pi_getLL('cartlabel') . '</h2><span class="addtocart"><img src="typo3conf/ext/pfj/res/images/addtocart.png" alt="Add to Cart" title="Add to Cart" id="pfjproduct_' . $row['uid'] . '" /><span class="totalprice">' . $this->pi_getLL('totallabel') . '</span><span class="totalamt">' . $row['sellingprice'] . '</span></span><p class="order_label">' . $this->pi_getLL('addcartlabel') . '</p></div>' : '';
                $markers['###STRING_DESCRIPTION###'] = $this->pi_getLL('listFieldHeader_description');
                //$markers['###FIELD_ITEM_PRICE###'] = $row['sellingprice'];
                $markers['###FIELD_ITEM_NUMBER###'] = $row['item_number'];
                $markers['###FIELD_ITEM_NAME###'] = $row['item_name'];
                $markers['###FIELD_DESCRIPTION###'] = $row['description'];
                $markers['###STONE_LABEL###'] = $this->pi_getLL('stonelabel');
                $markers['###STONE_NAME###'] = $row['stone_details'];
                $markers['###METAL_LABEL###'] = $this->pi_getLL('metallabel');
                $markers['###METAL_NAME###'] = $row['metal'];
                $markers['###BRAND_LABEL###'] = $this->pi_getLL('brandlabel');
                $markers['###BRAND_NAME###'] = $row['brand'];
                
                //new field added from the csv
                $markers['###STOCK_LABEL###'] = $this->pi_getLL('stocklabel');
                $markers['###STOCK_VALUE###'] = $row['quant_break_1'];
                $markers['###BACKLINK###'] = '<a href="javascript:history.back();">' . $this->pi_getLL('backlink') . '</a>';

                $pic = $row['item_pic'];
                if ($pic != "" and file_exists("uploads/tx_pfj/$pic")) {
                    $source = "uploads/tx_pfj/$pic";
                    //$markers['###SINGLE_IMAGE###'] = '<img src="'.$this->imgResize($row['item_pic'],350,350).'" title="' . $pic . '" alt="'.$row['item_name'].'" />';
                    $markers['###SINGLE_IMAGE###'] = '<img width="350px" height="350px" src="' . $source . '" title="' . $pic . '" alt="' . $row['item_name'] . '" />';
                } else {
                    $markers['###SINGLE_IMAGE###'] = '<img src="http://www.placehold.it/350x350.png&text=No+Image" title="NO IMAGE" />';
                }
            }
            $content = $this->cObj->substituteMarkerArray($template, $markers);
        }

        return $content;
    }

    /**
     * Display a category item from the database
     *
     * @param	string		$content: The PlugIn content
     * @param	array		$conf: The PlugIn configuration
     * @return	HTML of a single database entry
     */
    function catView($content, $conf) {
        $rst = $GLOBALS['TYPO3_DB']->sql_query('select distinct custlist_1 from tx_pfj_items');
        $template = $this->cObj->getSubpart($this->templateCode, '###CAT_VIEW###');
        $markers = array();
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rst)) {
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery("*", "tx_pfj_items", "custlist_1='" . $row['custlist_1'] . "' and deleted=0 and hidden=0 and inactive_item='N' and item_name not like '%cancelled%'");
            $num = $GLOBALS['TYPO3_DB']->sql_num_rows($res);
            $markers['###CAT_TREE###'] .= "<li>";
            $markers['###CAT_TREE###'] .= $this->pi_linkTP_keepPIvars($row['custlist_1'] . "<span class='count'>(" . $num . ")</span>", array('cat' => $row['custlist_1']), 0, 0, $this->fetchConfigurationValue('listPid', 'sSINGLEVIEW'));
            $markers['###CAT_TREE###'] .= "</li>";
        }
        $content .= $this->cObj->substituteMarkerArray($template, $markers);
        $GLOBALS['TYPO3_DB']->sql_free_result($rst);
        $GLOBALS['TYPO3_DB']->sql_free_result($res);
        return $content;
    }

    /**
     * Adds special subpart from template into the page <head> tag.
     *
     * @return	void
     */
    function addHeaderParts() {
        $key = 'EXT:' . $this->extKey . md5($this->templateCode);
        if (!isset($GLOBALS['TSFE']->additionalHeaderData[$key])) {
            $headerParts = $this->cObj->getSubpart($this->templateCode, '###HEADER_PARTS###');
            if ($headerParts) {
                $headerParts = $this->cObj->substituteMarker($headerParts, '###SITE_REL_PATH###', t3lib_extMgm::siteRelPath($this->extKey));
                $GLOBALS['TSFE']->additionalHeaderData[$key] = $headerParts;
            }
        }
    }

    function imgResize($img, $width, $height) {
        $imageConf['file'] = 'uploads/tx_pfj/' . $img;
        $imageConf['file.']['maxH'] = $height;
        $imageConf['file.']['maxW'] = $width;
        $imageConf['file.']['title'] = $img;

        return $thumbnailImage = $this->cObj->IMG_RESOURCE($imageConf);
        //return $imageConf['file'];
    }

    function cartView($template, $conf) {

        session_start();
        $_SESSION['tx_pfj']['adminEmail'] = $this->fetchConfigurationValue('orderEmail');
        $feuid = $GLOBALS['TSFE']->fe_user->user['uid'];
        $cartuidArray = array_unique($_SESSION['tx_pfj']['cartRecords_' . $feuid]);
        $cartUidList = implode(",", $cartuidArray);

        $this->templateCode = $this->cObj->fileResource($this->conf['templateFile']);

        $tabletitle = $this->cObj->getSubpart($this->templateCode, '###CART_TABLETITLE###');
        $markerArray['###CARTVIEW_HEADER###'] = $this->addHeaderParts();
        $markerArray['###ITEM_NAME###'] = $this->pi_getLL('cartitem_name');
        $markerArray['###ITEM_NO###'] = $this->pi_getLL('cartitem_no');
        $markerArray['###ITEM_QTY###'] = $this->pi_getLL('cartitem_qty');
        $markerArray['###ITEM_PRICE###'] = $this->pi_getLL('cartitem_price');
        $tableView = $this->cObj->getSubpart($this->templateCode, '###CART_VIEW###');

        $markerArray['###HEADER###'] = $this->cObj->substituteMarkerArrayCached($tabletitle, $markerArray);

        $cartView = $this->cObj->getSubpart($this->templateCode, '###CART_TABLEVIEW###');
        $no_cartitems = $this->cObj->getSubpart($this->templateCode, '###NO_CART_ITEMS###');

        $submit_buttons = $this->cObj->getSubpart($this->templateCode, '###SUBMIT_BUTTONS###');
        $submitbuttonArray['###UPDATE_CART###'] = $this->pi_getLL('update_cart');
        $submitbuttonArray['###CLEAR_ALL###'] = $this->pi_getLL('clear_all');
        $submitbuttonArray['###CHECK_OUT###'] = $this->pi_getLL('check_out');
        $markerArray['###BUTTONS###'] = $this->cObj->substituteMarkerArrayCached($submit_buttons, $submitbuttonArray);

        $totalrow = $this->cObj->getSubpart($this->templateCode, '###TOTALPRICESUBPART###');

        $markerArray['###NOCART_ITEMS###'] = '';
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tx_pfj_items', 'uid IN ( ' . $cartUidList . ') AND deleted = 0 AND hidden = 0');

        $totalPrice = 0;
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            $markerArray['###PRODUCT_NAME###'] = $row['item_name'];
            $markerArray['###PRODUCT_NO###'] = $row['item_number'];
            $markerArray['###PRODUCT_PRICE###'] = (!empty($_SESSION['tx_pfj']['pricekey_' . $row['uid']]) ) ? $_SESSION['tx_pfj']['pricekey_' . $row['uid']] : $row['sellingprice'];
            $markerArray['###PRODUCT_PRICEHIDDEN###'] = $row['sellingprice'];
            $markerArray['###REMOVE_ITEM###'] = '<img src="typo3conf/ext/pfj/res/images/delete_icon.png" alt="Delete" title="Remove Item" id="product_' . $row['uid'] . '" class="remove_item" />';
            $markerArray['###PRODUCT_ROWID###'] = 'table_' . $row['uid'];
            $markerArray['###QTYVALUE###'] = (!empty($_SESSION['tx_pfj']['qtyKey_' . $row['uid']]) ) ? $_SESSION['tx_pfj']['qtyKey_' . $row['uid']] : '1';
            $markerArray['###QTYID###'] = $row['uid'];
            $markerArray['###PRICEID###'] = $row['uid'];
            $intPrice = str_replace(',', '', trim($row['sellingprice'], "$"));
            $newPriceVal = $intPrice * $markerArray['###QTYVALUE###'];
            $totalprice += $newPriceVal;

            $output_string = array('Itemname' => $row['item_name'], 'price' => $row['sellingprice'], 'uid' => $row['uid']);
            array_push($_SESSION['tx_pfj']['cart_records'], $output_string);

            // Substitute markers and append to result string
            $content .= $this->cObj->substituteMarkerArrayCached($cartView, $markerArray);
        }

        $totalPriceArray['###TOTAL_PRICE###'] = '$' . number_format($totalprice, 2, '.', '');
        $markerArray['###TOTAL_PRICEROW###'] = $this->cObj->substituteMarkerArrayCached($totalrow, $totalPriceArray);

        if (empty($_SESSION['tx_pfj']['cartRecords_' . $feuid])) {
            $noitemArray['###NO_ITEMS###'] = $this->pi_getLL('nocart_items');
            $markerArray['###BUTTONS###'] = '';
            $markerArray['###TOTAL_PRICEROW###'] = '';
            $markerArray['###NOCART_ITEMS###'] = $this->cObj->substituteMarkerArrayCached($no_cartitems, $noitemArray);
        }

        $markerArray['###CONTENT###'] = $content;
        $contentItem .= $this->cObj->substituteMarkerArrayCached($tableView, $markerArray);
        return $contentItem;
    }

    public function checkOutCart($feuid) {
        session_start();
        $totalpriceVal = 0;
        $feuserDetails = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'fe_users', 'uid =' . $feuid . ' AND deleted = 0 AND disable = 0');
        $preview .= "<div class='user_details'><div class='shipping_address'><span><b>Shipping Address</b></span></div>";
        $preview .= "<div><span class='cartpreview_left'>Name:</span><span class='cartpreview_right'><b>" . $feuserDetails[0]['first_name'] . " " . $feuserDetails[0]['last_name'] . "</b></span></div>";
        $preview .= "<div><span class='cartpreview_left'>Address:</span><span class='cartpreview_right'><b>" . $feuserDetails[0]['address'] . "</b></span></div>";
        $preview .= "<div><span class='cartpreview_left'>Telephone:</span><span class='cartpreview_right'><b>" . $feuserDetails[0]['telephone'] . "</b></span></div>";
        $preview .= "<div><span class='cartpreview_left'>Email:</span><span class='cartpreview_right'><b>" . $feuserDetails[0]['email'] . "</b></span></div>";
        $preview .= "<div><span class='cartpreview_left'>City:</span><span class='cartpreview_right'><b>" . $feuserDetails[0]['city'] . "</b></span></div></div>";
        $preview .= "<div class='items_ordered'><div class='ordered_items'><span><b>Ordered Items</b></span></div><br/>";
        $preview .= '<table id="cart_previewtable"><tbody>';
        $preview .= "<tr><th>Item Name</th><th>Item No</th><th>Quantity</th><th>Price</th></tr>";

        $cartuidArray = $_SESSION['tx_pfj']['cartRecords_' . $feuid];
        $cartUidList = implode(",", $cartuidArray);
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid, item_name, item_number', 'tx_pfj_items', 'uid IN ( ' . $cartUidList . ') AND deleted = 0 AND hidden = 0');
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            $preview .= "<tr><td>" . $row['item_name'] . "</td><td>" . $row['item_number'] . "</td><td>" . $_SESSION['tx_pfj']['qtyKey_' . $row['uid']] . "</td><td>" . $_SESSION['tx_pfj']['pricekey_' . $row['uid']] . "</td></tr>";
        }
        $preview .= "<tr><td><b>Total Price</b></td><td></td><td></td><td><b>" . $_SESSION['tx_pfj']['totalPrice'] . "</b></td></tr>";
        $preview .= "</tbody></table>";
        echo $preview;
        exit;
    }

    public function placeOrderItems($feuid) {
        session_start();
        $feuserDetails = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'fe_users', 'uid =' . $feuid . ' AND deleted = 0 AND disable = 0');
        $message .= "<div class='email-logo'><img src='" . t3lib_div::getIndpEnv('TYPO3_SITE_URL') . "fileadmin/templates/images/pfj-logo-header.png' width='400px'/></div>";
        $message .= "<div class='shipping_address'><span><b>Shipping Address</b></span></div><br/>";
        $message .= "<table border='0' style='width:50%;'><tbody>";
        $message .= "<tr><td colspan='4'>Name</td><td colspan='1'>:</td><td colspan='4'><b>" . $feuserDetails[0]['first_name'] . " " . $feuserDetails[0]['last_name'] . "</b></td></tr>";
        $message .= "<tr><td colspan='4'>Address</td><td colspan='1'>:</td><td colspan='4'><b>" . $feuserDetails[0]['address'] . "</b></td></tr>";
        $message .= "<tr><td colspan='4'>Telephone</td><td colspan='1'>:</td><td colspan='4'><b>" . $feuserDetails[0]['telephone'] . "</b></td></tr>";
        $message .= "<tr><td colspan='4'>Email</td><td colspan='1'>:</td><td colspan='4'><b>" . $feuserDetails[0]['email'] . "</b></td></tr>";
        $message .= "<tr><td colspan='4'>City</td><td colspan='1'>:</td><td colspan='4'><b>" . $feuserDetails[0]['city'] . "</b></td></tr>";
        $message .= "</tbody></table><br/>";

        $message .= "<div class='items_ordered'><div class='ordered_items'><span><b>Ordered Items</b></span></div><br/>";
        $message .= "<table border='1' style='width:75%;'><tbody>";
        $message .= "<tr><th colspan='5'>Item Name</th><th colspan='3'>Item No</th><th colspan='2'>Quantity</th><th colspan='2'>Price</th></tr>";
        $cartuidArray = $_SESSION['tx_pfj']['cartRecords_' . $feuid];
        $cartUidList = implode(",", $cartuidArray);
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid, item_name, item_number', 'tx_pfj_items', 'uid IN ( ' . $cartUidList . ') AND deleted = 0 AND hidden = 0');
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            //function will save the user order in the database

            $insert['userId'] = $feuid;
            $insert['crdate'] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
            $insert['productUid'] = $row['uid'];
            $insert['productQuanity'] = $_SESSION['tx_pfj']['qtyKey_' . $row['uid']];
            $insert['productPrice'] = $_SESSION['tx_pfj']['pricekey_' . $row['uid']];
            $this->saveUserOrder($insert);

            $message .= "<tr><td colspan='5'>" . $row['item_name'] . "</td><td colspan='3'>" . $row['item_number'] . "</td><td colspan='2' align='center'>" . $_SESSION['tx_pfj']['qtyKey_' . $row['uid']] . "</td><td colspan='2' align='center'>" . $_SESSION['tx_pfj']['pricekey_' . $row['uid']] . "</td></tr>";
        }
        $message .= "<tr><td colspan='10' align='center'><b>TOTAL</b></td><td colspan='2' align='center'><b>" . $_SESSION['tx_pfj']['totalPrice'] . "</b></td></tr>";
        $message .= "</tbody></table> <br/><br/>";
        $message .= "<b>Comments For The Order:</b>" . $_POST['comment'];

        //$adminEmail = explode(',',$_SESSION['tx_pfj']['adminEmail']);
        $adminEmail = $_SESSION['tx_pfj']['adminEmail'];
        /* $mail = t3lib_div::makeInstance('t3lib_mail_Message');
          $mail->setFrom(array($feuserDetails[0]['email'] => $feuserDetails[0]['first_name']." ".$feuserDetails[0]['last_name']))
          ->setTo('abinsabu@yahoo.com')
          ->setSubject('Stockist Order Details')
          ->setBody($message,'text/html')
          ->send(); */
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $feuserDetails[0]['first_name'] . " " . $feuserDetails[0]['last_name'] . ' <' . $feuserDetails[0]['email'] . '>' . "\r\n";
        //$headers .= 'To:'.$adminEmail[0].''. "\r\n";
        $to = $adminEmail;
        $subject = 'Stockist Order Details';
        mail($to, $subject, $message, $headers);


        session_unset($_SESSION['tx_pfj']);
        $placed = "Your order has been placed successfully !!";
        $placeOrderArray = array($placed, count(session_unset($_SESSION['tx_pfj'])));
        echo json_encode($placeOrderArray);
        exit;
    }

    // Stockist View Function
    public function stockistView($content, $conf) {

        session_start();
        $template = $this->cObj->getSubpart($this->templateCode, '###STOCKIST_VIEW###');
        $pageSize = t3lib_div::testInt($this->conf['listViewPerPage']) ? intval($this->conf['listViewPerPage']) : 10;

        if ((isset($this->piVars['page'])) && ($this->piVars['page'] != '') && ($this->piVars['page'] > 1)) {
            $page = max(1, intval($this->piVars['page']));
        } else {
            $page = 1;
        }
        $page = intval($page);
        #&& !empty($this->piVars['page'])

        if (empty($this->piVars['page'])) {
            $_SESSION['postcode'] = '';
            $_SESSION['suburb_check'] = '';
            $_SESSION['checked'] = '';
        }
        if (!empty($_POST['postcode'])) {
            $_SESSION['postcode'] = $_POST['postcode'];
        }

        if (!empty($_POST['postcode']) && !empty($_POST['include_suburb'])) {
            $_SESSION['suburb_check'] = $_POST['include_suburb'];
            $_SESSION['checked'] = 'checked';
        }

        /* 	  if ( !empty ( $_SESSION['postcode'] ) ) {
          $where = "zip like '".$_SESSION['postcode']."%' and FIND_IN_SET('".$this->conf['stockistsUsergroupId']."', usergroup) and deleted=0 and disable=0";
          }else {
          $where = "FIND_IN_SET('".$this->conf['stockistsUsergroupId']."', usergroup) and deleted=0 and disable=0";
          } */

        if (!empty($_SESSION['postcode']) && empty($_SESSION['suburb_check'])) {
            $where = "zip like '" . $_SESSION['postcode'] . "%' and FIND_IN_SET('" . $this->conf['stockistsUsergroupId'] . "', usergroup) and deleted=0 and disable=0";
        } else if (!empty($_SESSION['postcode']) && !empty($_SESSION['suburb_check'])) {
            $where = "zip BETWEEN '" . ($_SESSION['postcode'] - 10) . "'AND '" . ($_SESSION['postcode'] + 10) . "'";
        } else {
            $where = "FIND_IN_SET('" . $this->conf['stockistsUsergroupId'] . "', usergroup) and deleted=0 and disable=0";
        }



        $rst = $this->prepareStockistSQL($where, $pageSize, $page);
        if ($GLOBALS['TYPO3_DB']->sql_num_rows($rst) > 0) {
            $markers = array();
            $template = $this->cObj->getSubpart($this->templateCode, '###STOCKIST_VIEW###');
            $markers['###SEARCH_ACTION###'] = $GLOBALS['TSFE']->baseUrl . 'index.php?id=' . $GLOBALS['TSFE']->id;
            $markers['###STOCIKST_TITLE###'] = $this->pi_getLL('stockist_title');
            $markers['###SUBURB_LABEL###'] = $this->pi_getLL('suburb_label');
            $markers['###CHECKBOX###'] = '<input type="checkbox" name="include_suburb" value="1" ' . $_SESSION['checked'] . '>';
            $markers['###SEARCH_VAL###'] = (!empty($_SESSION['postcode']) ) ? $_SESSION['postcode'] : '';
            $markers['###STOCKIST_RECORD_NOT_FOUND###'] = '';
            $subParts['###STOCKIST_DATA###'] = $this->getstockistListItem($template, $rst);
            $subParts['###PAGER###'] = $this->getStockistPage($template, $where, $pageSize, $page);
            $content = $this->cObj->substituteMarkerArrayCached($template, $markers, $subParts);
        } else {
            $markers = array();
            $template = $this->cObj->getSubpart($this->templateCode, '###STOCKIST_VIEW###');
            $markers['###SEARCH_ACTION###'] = $GLOBALS['TSFE']->baseUrl . 'index.php?id=' . $GLOBALS['TSFE']->id;
            $markers['###STOCIKST_TITLE###'] = $this->pi_getLL('stockist_title');
            $markers['###SUBURB_LABEL###'] = $this->pi_getLL('suburb_label');
            $markers['###CHECKBOX###'] = '<input type="checkbox" name="include_suburb" value="1" ' . $_SESSION['checked'] . '>';
            $markers['###SEARCH_VAL###'] = (!empty($_SESSION['postcode']) ) ? $_SESSION['postcode'] : '';
            $markers['###STOCKIST_RECORD_NOT_FOUND###'] = $this->pi_getLL('stockist_notfound');
            $subParts['###STOCKIST_DATA###'] = '';
            $subParts['###PAGER###'] = '';
            $content = $this->cObj->substituteMarkerArrayCached($template, $markers, $subParts);
        }
        $GLOBALS['TYPO3_DB']->sql_free_result($rst);
        return $content;
    }

    // Setting SQL before query database
    function prepareStockistSQL($where, $pageSize, $page) {
        $number = ($page - 1) * $pageSize;
        $result = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                '*', 'fe_users', $where, '', '', $number . ',' . $pageSize
        );
        return $result;
    }

    // Out put stockist list
    function getstockistListItem($template, $result) {
        $subTemplate = $this->cObj->getSubpart($template, '###STOCKIST_DATA###');
        $markers['###ITEM_NOTFOUND###'] = '';
        $content = '';
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
            $markers['###COMPANY_NAME###'] = $row['company'];
            $markers['###ADDRESS1###'] = $row['address'];
            $markers['###ADDRESS2###'] = (!empty($row['address_line2']) ) ? $row['address_line2'] : '';
            $markers['###ADDRESS3###'] = (!empty($row['address_line3']) ) ? $row['address_line3'] : '';
            $markers['###CARD_ID###'] = (!empty($row['card_id']) ) ? $this->pi_getLL('stockist_cardId') . " : " . $row['card_id'] : '';
            $markers['###TELEPHONE###'] = (!empty($row['telephone']) ) ? $this->pi_getLL('stockist_phone') . " : " . $row['telephone'] : '';
            $markers['###ZIPCODE###'] = (!empty($row['zip']) ) ? $this->pi_getLL('stockist_zip') . " : " . $row['zip'] : '';
            $markers['###LINK_DETAIL###'] = $this->pi_list_linkSingle($this->pi_getLL('morelink'), $row['uid'], 1, array(), 0, $this->fetchConfigurationValue('singlePid'));
            $content .= $this->cObj->substituteMarkerArray($subTemplate, $markers);
        }
        return $content;
    }

    // Output Pager
    function getStockistPage($template, $where, $pageSize, $page) {
        list($row) = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                'COUNT(*) AS t', 'fe_users', $where
        );
        if ($row['t'] == 0) {
            return '';
        }
        if (($row['t'] < $pageSize) && ($row['t'] != 0)) {
            $markers = array(
                '###CURRENT_PAGE###' => '<span class="currentPage bg-grey">' . $row['t'] . ' ' . $this->pi_getLL('sumresult') . '</span>',
                '###SUM_RESULT###' => '',
                '###FIRST_PAGE###' => '',
                '###LINK_PREV###' => '',
                '###LAST_PAGE###' => '',
                '###LINK_NEXT###' => '',
                '###STEP_NEXT###' => '',
                '###STEP_PREV###' => '',
            );
            $subTemplate = $this->cObj->getSubpart($template, '###PAGER###');
            $subParts['###MORE_PAGES###'] = '';
            $subParts['###LESS_PAGES###'] = '';
            $content = $this->cObj->substituteMarkerArrayCached($subTemplate, $markers, $subParts);
            return $content;
        }
        if ($row['t'] > $pageSize) {
            $lastpage = intval(ceil($row['t'] / $pageSize));
        } else {
            $lastpage = $page;
            $lastpage = intval($lastpage);
        }
        $markers = array(
            '###CURRENT_PAGE###' => '<span class="currentPage">' . $page . '</span>',
            '###SUM_RESULT###' => '<td class="p_center"><span class="currentPage bg-grey">' . number_format($row['t']) . ' ' . $this->pi_getLL('sumresult') . '</span></td>',
        );
        if ($page == 1) {
            $markers['###FIRST_PAGE###'] = '';
            $markers['###LINK_PREV###'] = '';
        } else {
            $markers['###FIRST_PAGE###'] = $this->pi_linkTP_keepPIvars($this->pi_getLL('first_page'), array('page' => 1), true);
            $markers['###LINK_PREV###'] = $this->pi_linkTP_keepPIvars($this->pi_getLL('link_prev'), array('page' => $page - 1), true);
        }
        if ($page == $lastpage) {
            $markers['###LAST_PAGE###'] = '';
        } else {
            $markers['###LAST_PAGE###'] = $this->pi_linkTP_keepPIvars($this->pi_getLL('last_page'), array('page' => $lastpage), true);
        }
        if ($row['t'] <= $page * $pageSize) {
            $markers['###LINK_NEXT###'] = '';
        } else {
            $markers['###LINK_NEXT###'] = $this->pi_linkTP_keepPIvars($this->pi_getLL('link_next'), array('page' => $page + 1), true);
        }
        $markers['###STEP_NEXT###'] = $this->stepNext($pageSize, $page, $lastpage);
        $markers['###STEP_PREV###'] = $this->stepPrev($pageSize, $page, $lastpage);
        $subTemplate = $this->cObj->getSubpart($template, '###PAGER###');
        $subParts['###MORE_PAGES###'] = $this->renderMorePage($subTemplate, $pageSize, $page, $lastpage);
        $subParts['###LESS_PAGES###'] = $this->renderLessPage($subTemplate, $pageSize, $page, $lastpage);
        $content = $this->cObj->substituteMarkerArrayCached($subTemplate, $markers, $subParts);
        return $content;
    }

    //Stockists Single View Function
    public function stockistSingleView($content, $conf) {
        $rst = $GLOBALS['TYPO3_DB']->exec_SELECTquery("*", "fe_users", "uid=" . $this->piVars['showUid']);
        if ($GLOBALS['TYPO3_DB']->sql_num_rows($rst) > 0) {
            $markers = array();
            $template = $this->cObj->getSubpart($this->templateCode, '###STOCKISTS_SINGLE_VIEW###');
            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rst)) {
                $markers['###FIELD_COMPANY_NAME###'] = $row['company'];
                $markers['###ADDRESS1###'] = $row['address'];
                $markers['###ADDRESS2###'] = (!empty($row['address_line2']) ) ? $row['address_line2'] : '';
                $markers['###ADDRESS3###'] = (!empty($row['address_line3']) ) ? $row['address_line3'] : '';
                $markers['###CITY###'] = (!empty($row['city']) ) ? $row['city'] . ',' : '';
                $markers['###ZIPCODE###'] = (!empty($row['zip']) ) ? $row['zip'] : '';
                $markers['###STATE###'] = (!empty($row['zone']) ) ? $row['zone'] . ',' : '';
                $markers['###COUNTRY###'] = (!empty($row['country']) ) ? $row['country'] : '';
                $markers['###PHONE_LABEL###'] = (!empty($row['telephone']) ) ? $this->pi_getLL('single_phone') : '';
                $markers['###PHONE###'] = (!empty($row['telephone']) ) ? $row['telephone'] : '';
                $markers['###FAX_LABEL###'] = (!empty($row['fax']) ) ? $this->pi_getLL('single_fax') : '';
                $markers['###FAX###'] = (!empty($row['fax']) ) ? $row['fax'] : '';
                $markers['###EMAIL_LABEL###'] = (!empty($row['email']) ) ? $this->pi_getLL('single_email') : '';
                $markers['###EMAIL###'] = (!empty($row['email']) ) ? $row['email'] : '';
                $markers['###WEB_LABEL###'] = (!empty($row['www']) ) ? $this->pi_getLL('single_web') : '';
                $markers['###WEB###'] = (!empty($row['www']) ) ? $row['www'] : '';
                $markers['###BACKLINK###'] = '<a href="javascript:history.back();">' . $this->pi_getLL('backlink') . '</a>';
            }

            $markers['###GOOGLE_MAP###'] = '<div id="map-canvas"></div>';

            $content = $this->cObj->substituteMarkerArray($template, $markers);
        }

        return $content;
    }

    public function saveUserOrder($insert) {
        $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_pfj_items_order', $insert);
    }

    public function doGetUserOrder() {

        $feuid = $GLOBALS['TSFE']->fe_user->user['uid'];
        if ($feuid != '') {

            $markerArray['###ORDER_DATE_LIST###'] = $this->doPrepareOrderDates();
            $this->templateCode = $this->cObj->fileResource($this->conf['templateFile']);
            $template = $this->cObj->getSubpart($this->templateCode, '###ORDER_VIEW_LIST###');

            return $content = $this->cObj->substituteMarkerArray($template, $markerArray);
        }
    }

    public function doPrepareOrderDetails($tStamp) {

        $feuid = $GLOBALS['TSFE']->fe_user->user['uid'];
        $select_fields = 'pi.description,pi.item_number,pi.item_name,ot.uid,ot.userId,ot.productUid,ot.productQuanity,ot.productPrice,pi.sellingprice,ot.crdate';
        $from = 'tx_pfj_items_order AS ot LEFT JOIN tx_pfj_items pi ON ot.productUid = pi.uid';
        $whereClause = 'ot.crdate = ' . $tStamp . ' AND ot.userId=' . $feuid;
        $orderByClause = 'ot.crdate DESC';
        $limitClause = '';
        $result = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                $select_fields, $from, $whereClause, '', $orderByClause, $limitClause
        );
        $content = '';
        $totalAmount = 0;
        foreach ($result as $key => $value) {
            $content.= '<tr class="odd">';
            $content.= '<td>' . $value["item_number"] . '</td>';
            $content.= '<td>' . $value["item_name"] . '</td>';
            $content.= '<td>' . $value["productQuanity"] . '</td>';
            $content.= '<td>' . $value["productPrice"] . '</td>';
            $content.= '</tr>';
            $amount = str_replace("$", "", $value["productPrice"]);
            $totalAmount = $totalAmount + $amount;
        }
        $main = '<div class="items-table">
                   <h4>Orderd Items</h4>
                   <table cellpadding="0" cellspacing="0" border="0" class="display" id="orderTable" width="600px">
                        <thead>
                           <tr>
                            <th>Item Name</th>
                            <th>Item No</th>
                            <th>Quantity</th>
                            <th>Price</th>
		          </tr>
	               </thead>
                       <tfoot>
                          <tr>
                            <th>Total Price</th>
                            <th></th>
                            <th></th>
                            <th> $' . $totalAmount . '</th>
                          </tr>
                      </tfoot>
	           <tbody> ' . $content . '</tbody>
                   </table>
	         </div>
		 <div class="spacer"></div>';


        return $main;
    }

    public function doPrepareOrderDates() {

        $feuid = $GLOBALS['TSFE']->fe_user->user['uid'];
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = TRUE;
        $select_fields = 'DISTINCT crdate';
        $from = 'tx_pfj_items_order';
        $whereClause = 'userId=' . $feuid;
        $orderByClause = 'crdate DESC';
        $limitClause = '';
        $result = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                $select_fields, $from, $whereClause, '', $orderByClause, $limitClause
        );
        $content = '<div class="items-table">
                   <h4>Empty History</h4>
                   </div>
		 <div class="spacer"></div>';
        if (!empty($result)) {
            $content = '<ul>';
            foreach ($result as $key => $value) {
                $content.= '<img  id = "arrow_img_' . $value['crdate'] . '" class = "arrow_img" src="typo3conf/ext/pfj/res/images/right.png" width="25px" height="25px"/><li onClick = "getOrderDetails(' . $value['crdate'] . ',this)" class = "orderLink" id ="orderList_' . $value['crdate'] . '"><a href="javascript:void(0);"><h2>' . date("d/m/Y", $value['crdate']) . '</h2></a></li>';
                $content.= '<div class = "orderContent" id = "orderView_' . $value['crdate'] . '" style = "display:none">' . $this->doPrepareOrderDetails($value['crdate']) . '</div>';
            }
            $content .= '</ul>';
        }

        return $content;
    }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pfj/pi1/class.tx_pfj_pi1.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pfj/pi1/class.tx_pfj_pi1.php']);
}
?>
