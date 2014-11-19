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
class Tx_Hevents_Domain_Model_Category extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * active
	 *
	 * @var boolean
	 */
	protected $active=false;
	
	/**
	 * title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;
	
	/**
	 * marker
	 *
	 * @var string
	 */
	protected $marker;
	
	/**
	 * activeicon
	 *
	 * @var string
	 */
	protected $activeicon;
	
	/**
	 * icon
	 *
	 * @var string
	 */
	protected $icon;
	
	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * Returns the marker
	 *
	 * @return string $marker
	 */
	public function getMarker() {
		return $this->marker;
	}
	
	/**
	 * Returns the marker
	 *
	 * @return string $marker
	 */
	public function getMarkerAbs() {
		return empty($this->marker) ? '' : $GLOBALS['TSFE']->tmpl->setup['config.']['baseURL'] . $GLOBALS['TCA']['tx_hevents_domain_model_category']['columns']['marker']['config']['uploadfolder'] . '/' . $this->marker;
	}
	
	/**
	 * Sets the marker
	 *
	 * @param string $marker
	 * @return void
	 */
	public function setMarker($marker) {
		$this->marker = $marker;
	}
	
	
	/**
	 * Returns the icon
	 *
	 * @return string $icon
	 */
	public function getIcon() {
		return empty($this->icon) ? '' : $GLOBALS['TCA']['tx_hevents_domain_model_category']['columns']['icon']['config']['uploadfolder'] . '/' . $this->icon;
	}
	
	/**
	 * Sets the icon
	 *
	 * @param string $icon
	 * @return void
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}
	
	/**
	 * Returns the icon
	 *
	 * @return string $activeicon
	 */
	public function getActiveicon() {
		return empty($this->activeicon) ? '' : $GLOBALS['TCA']['tx_hevents_domain_model_category']['columns']['activeicon']['config']['uploadfolder'] . '/' . $this->activeicon;
	}
	
	/**
	 * Sets the activeicon
	 *
	 * @param string $activeicon
	 * @return void
	 */
	public function setActiveicon($activeicon) {
		$this->activeicon = $activeicon;
	}
	
	/**
	 * get state
	 *
	 * @return string
	 */
	public function getState() {
		return $this->active ? 'active' : '';
	}
	
	/**
	 * set active
	 *
	 * @param boolean $active
	 * @return void
	 */
	public function setActive($active) {
		$this->active = $active;
	}
}
?>