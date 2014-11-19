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
class Tx_Hevents_Domain_Model_Event extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;
	
	/**
	 * duration
	 *
	 * @var string
	 */
	protected $duration;
	
	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;
	
	/**
	 * provider
	 *
	 * @var string
	 */
	protected $provider;
	
	/**
	 * locationaddress
	 *
	 * @var string
	 */
	protected $locationaddress;

	/**
	 * latitude
	 *
	 * @var string
	 */
	protected $latitude;

	/**
	 * longitude
	 *
	 * @var string
	 */
	protected $longitude;

	/**
	 * location
	 *
	 * @var string
	 */
	protected $location;

	/**
	 * price
	 *
	 * @var float
	 */
	protected $price;

	/**
	 * images
	 *
	 * @var string
	 */
	protected $images;

	/**
	 * categories
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_Category>
	 * @lazy
	 */
	protected $categories;

	/**
	 * dates
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_Date>
	 * @lazy
	 */
	protected $dates;

	/**
	 * city
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_City>
	 * @lazy
	 */
	protected $city;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->categories = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->dates = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->city = new Tx_Extbase_Persistence_ObjectStorage();
	}

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
	 * Returns the duration
	 *
	 * @return string $duration
	 */
	public function getDuration() {
		return $this->duration;
	}

	/**
	 * Sets the duration
	 *
	 * @param string $duration
	 * @return void
	 */
	public function setDuration($duration) {
		$this->duration = $duration;
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
	 * Returns the provider
	 *
	 * @return string $provider
	 */
	public function getProvider() {
		return $this->provider;
	}
	
	/**
	 * Sets the provider
	 *
	 * @param string $provider
	 * @return void
	 */
	public function setProvider($provider) {
		$this->provider = $provider;
	}
	
	/**
	 * Returns the locationaddress
	 *
	 * @return string $locationaddress
	 */
	public function getLocationaddress() {
		return $this->locationaddress;
	}
	
	/**
	 * Sets the locationaddress
	 *
	 * @param string $locationaddress
	 * @return void
	 */
	public function setLocationaddress($locationaddress) {
		$this->locationaddress = $locationaddress;
	}
	

	/**
	 * Returns the latitude
	 *
	 * @return string $latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * Sets the latitude
	 *
	 * @param string $latitude
	 * @return void
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	/**
	 * Returns the longitude
	 *
	 * @return string $longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * Sets the longitude
	 *
	 * @param string $longitude
	 * @return void
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	/**
	 * Returns the location
	 *
	 * @return string $location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * Sets the location
	 *
	 * @param string $location
	 * @return void
	 */
	public function setLocation($location) {
		$this->location = $location;
	}

	/**
	 * Returns the price
	 *
	 * @return float $price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * Sets the price
	 *
	 * @param float $price
	 * @return void
	 */
	public function setPrice($price) {
		$this->price = $price;
	}

	/**
	 * Returns the images
	 *
	 * @return array $images
	 */
	public function getImages() {
		if(empty($this->images)) return array();
		$arr = explode(',', $this->images);
		foreach($arr as &$image){
			$image = $GLOBALS['TCA']['tx_hevents_domain_model_event']['columns']['images']['config']['uploadfolder'] . '/' . trim($image);
		}
		return $arr;
	}

	/**
	 * Sets the images
	 *
	 * @param string $images
	 * @return void
	 */
	public function setImages($images) {
		$this->images = $images;
	}

	/**
	 * Adds a Category
	 *
	 * @param Tx_Hevents_Domain_Model_Category $category
	 * @return void
	 */
	public function addCategory(Tx_Hevents_Domain_Model_Category $category) {
		$this->categories->attach($category);
	}

	/**
	 * Removes a Category
	 *
	 * @param Tx_Hevents_Domain_Model_Category $categoryToRemove The Category to be removed
	 * @return void
	 */
	public function removeCategory(Tx_Hevents_Domain_Model_Category $categoryToRemove) {
		$this->categories->detach($categoryToRemove);
	}

	/**
	 * Returns the categories
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_Category> $categories
	 */
	public function getCategories() {
		return $this->categories;
	}
	
	/**
	 * Returns the category
	 *
	 * @return Tx_Hevents_Domain_Model_Category $category
	 */
	public function getCategory() {
		$arr = $this->categories->toArray();
		return $arr[0];
	}

	/**
	 * Sets the categories
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_Category> $categories
	 * @return void
	 */
	public function setCategories(Tx_Extbase_Persistence_ObjectStorage $categories) {
		$this->categories = $categories;
	}

	/**
	 * Adds a Date
	 *
	 * @param Tx_Hevents_Domain_Model_Date $date
	 * @return void
	 */
	public function addDate(Tx_Hevents_Domain_Model_Date $date) {
		$this->dates->attach($date);
	}

	/**
	 * Removes a Date
	 *
	 * @param Tx_Hevents_Domain_Model_Date $dateToRemove The Date to be removed
	 * @return void
	 */
	public function removeDate(Tx_Hevents_Domain_Model_Date $dateToRemove) {
		$this->dates->detach($dateToRemove);
	}

	/**
	 * Returns the dates
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_Date> $dates
	 */
	public function getDates() {
		return $this->dates;
	}

	/**
	 * Sets the dates
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_Date> $dates
	 * @return void
	 */
	public function setDates(Tx_Extbase_Persistence_ObjectStorage $dates) {
		$this->dates = $dates;
	}

	/**
	 * Adds a City
	 *
	 * @param Tx_Hevents_Domain_Model_City $city
	 * @return void
	 */
	public function addCity(Tx_Hevents_Domain_Model_City $city) {
		$this->city->attach($city);
	}

	/**
	 * Removes a City
	 *
	 * @param Tx_Hevents_Domain_Model_City $cityToRemove The City to be removed
	 * @return void
	 */
	public function removeCity(Tx_Hevents_Domain_Model_City $cityToRemove) {
		$this->city->detach($cityToRemove);
	}

	/*
	 * Returns the city
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_City> $city
	 */
	 /*
	public function getCity() {
		return $this->city;
	}
	*/
	
	/**
	 * Returns the city
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_City> $city
	 */
	public function getCity() {
		$arr = $this->city->toArray();
		return $arr[0];
	}

	/**
	 * Sets the city
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_City> $city
	 * @return void
	 */
	public function setCity(Tx_Extbase_Persistence_ObjectStorage $city) {
		$this->city = $city;
	}

}
?>