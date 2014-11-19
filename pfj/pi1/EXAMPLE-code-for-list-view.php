	/**
	 * Shows user list.
	 *
	 * @return	string	Generated HTML
	 */
	protected function listView() {
		// Get list parameters
		$pageSize = t3lib_div::testInt($this->conf['listView.']['pageSize']) ?
						intval($this->conf['listView.']['pageSize']) : 10;
		$page = max(1, intval($this->piVars['page']));

		// Get template for LIST view
		$template = $this->cObj->getSubpart($this->templateCode, '###LIST###');

		// Get plain markers
		$markers = $this->listViewGetHeaderMarkers();

		// Get rows
		$subParts['###LIST_ITEM###'] = $this->listViewGetRows($template, $page, $pageSize);

		// Create pager
		$subParts['###PAGER###'] = $this->listViewGetPager($template, $page, $pageSize);

		// Compile output
		$content = $this->cObj->substituteMarkerArrayCached($template, $markers, $subParts);

		return $content;
	}

	/**
	 * Creates header marker array
	 *
	 * @return	array	Header markers
	 */
	protected function listViewGetHeaderMarkers() {
		// Prepare
		t3lib_div::loadTCA('fe_users');
		$lang = t3lib_div::makeInstance('language');
		/* @var $lang language */
		$lang->init($GLOBALS['TSFE']->lang);

		// Fill some header markers. Here we will use all registered TCA fields plus
		// two date fields to add header markers
		$markers = array(
			'###TEXT_NUMBER###' => $this->pi_getLL('text_number'),
			'###TEXT_CRDATE###' => $this->pi_getLL('field_crdate'),
			'###TEXT_TSTAMP###' => $this->pi_getLL('field_tstamp'),
			'###TEXT_LASTLOGIN###' => $this->pi_getLL('field_lastlogin'),
			'###TEXT_SEARCH###' => $this->pi_getLL('text_search'),
			'###TEXT_SUBMITBTN###' => $this->pi_getLL('text_submitbtn'),
			'###ACTION###' => $this->pi_getPageLink($GLOBALS['TSFE']->id),
			'###SEARCH_TERMS###' => htmlspecialchars($this->piVars['search']),
			'###PID###' => intval($this->conf['usersPid']),
		);

		// Create markers
		foreach (array_keys($GLOBALS['TCA']['fe_users']['columns']) as $field) {
			$str = $this->pi_getLL('field_' . $field);
			if (!$str) {
				$str = $lang->sL($GLOBALS['TCA']['fe_users']['columns'][$field]['label']);
			}
			$markers['###TEXT_' . strtoupper($field) . '###'] = $str;
		}

		// Call hooks
		if (isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$this->extKey]['extraGlobalMarkers'])) {
			foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$this->extKey]['extraGlobalMarkers'] as $userFunc) {
				$params = array(
					'markers' => $markers,
					'pObj' => &$this,
				);
				$markers = t3lib_div::callUserFunction($userFunc, $params, $this);
			}
		}

		return $markers;
	}

	/**
	 * Returns list view rows
	 *
	 * @param string $template	Template to get subsection from
	 * @param int $page	Current page number
	 * @param int $pageSize	Maximum number of items in the list
	 * @return string	Generated HTML
	 */
	protected function listViewGetRows($template, $page, $pageSize) {
		// Get parameters for database call
		$sort = $this->conf['listView.']['sortField'] ? $this->conf['listView.']['sortField'] : 'username ASC';
		$number = ($page - 1)*$pageSize;
		// Prepare all necessary objects and arrays
		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$subTemplate = $this->cObj->getSubpart($template, '###LIST_ITEM###');
		/* @var $cObj tslib_cObj */
		// Get data from database
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'fe_users',
					$this->getListWhere() . $this->cObj->enableFields('fe_users'),
					'', $sort, $number . ',' . $pageSize);
		// Collect data
		$content = '';
		// Must check if we got result. We could get null due to the wrong sort field!
		if (!$res) {
			$GLOBALS['TT']->setTSlogMessage('SQL query for user records in list view has failed in ' .
					$this->prefixId . ' plugin. No users will be shown!', 2);
		}
		else {
			while (false !== ($ar = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
				// Prepare for stdWrap
				$cObj->start($ar, 'fe_users');
				// Loop through fields applying stdWrap
				$subMarkers = array(
					'###NUMBER###' => ++$number,
				);
				foreach ($ar as $field => $value) {
					if (!t3lib_div::inList($this->protectedFields, $field)) {
						$subMarkers['###FIELD_' . strtoupper($field) . '###'] =
							$cObj->stdWrap(htmlspecialchars($value),
									$this->conf['listView.'][$field . '_stdWrap.']);
					}
				}
				// Call hooks
				if (isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$this->extKey]['extraItemMarkers'])) {
					foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$this->extKey]['extraItemMarkers'] as $userFunc) {
						$params = array(
							'markers' => $markers,
							'pObj' => &$this,
						);
						$markers = t3lib_div::callUserFunction($userFunc, $params, $this);
					}
				}
				// Add row to output
				$content .= $this->cObj->substituteMarkerArray($subTemplate, $subMarkers);
			}
			// Free database result
			$GLOBALS['TYPO3_DB']->sql_free_result($res);
		}

		return $content;
	}

	/**
	 * Returns WHERE condition for List view
	 *
	 * @return string	WHERE condition
	 */
	function getListWhere() {
		$where = 'pid=' . intval($this->conf['usersPid']);
		if (($search = trim($this->piVars['search']))) {
			$search = $GLOBALS['TYPO3_DB']->fullQuoteStr($search . '%', 'fe_users');
			$where .= ' AND (username LIKE ' . $search . ' OR name LIKE ' . $search . ')';
		}
		return $where;
	}

	/**
	 * Returns pager
	 *
	 * @param string $template	Template to get subsection from
	 * @param int $page	Current page number
	 * @param int $pageSize	Maximum number of items in the list
	 * @return string	Generated HTML
	 */
	protected function listViewGetPager($template, $page, $pageSize) {
		// Check if we need page at all
		list($row) = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('COUNT(*) AS t',
						'fe_users', $this->getListWhere() .
						$this->cObj->enableFields('fe_users'));
		if ($row['t'] < $pageSize) {
			// Remove pager completely
			return '';
		}

		// Prepare
		$markers = array(
			'###CURRENT_PAGE###' => $page,
		);
		if ($page == 1) {
			// No previous page
			$markers['###LINK_PREV###'] = '';
		}
		else {
			$markers['###LINK_PREV###'] = $this->pi_linkTP_keepPIvars(
					$this->pi_getLL('link_prev'),
					array('page' => $page - 1), true);
		}
		if ($row['t'] <= $page*$pageSize) {
			// No next link
			$markers['###LINK_NEXT###'] = '';
		}
		else {
			$markers['###LINK_NEXT###'] = $this->pi_linkTP_keepPIvars(
					$this->pi_getLL('link_next'),
					array('page' => $page + 1), true);
		}
		$subTemplate = $this->cObj->getSubpart($template, '###PAGER###');
		return $this->cObj->substituteMarkerArray($subTemplate, $markers);
	}
