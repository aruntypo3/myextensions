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
 ***************************************************************/

/**
 * Test case for class Tx_Hevents_Domain_Model_Event.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Henry Events
 *
 * @author Eric Depta <info@ericdepta.de>
 */
class Tx_Hevents_Domain_Model_EventTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Hevents_Domain_Model_Event
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Hevents_Domain_Model_Event();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getLatitudeReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLatitudeForStringSetsLatitude() { 
		$this->fixture->setLatitude('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLatitude()
		);
	}
	
	/**
	 * @test
	 */
	public function getLongitudeReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLongitudeForStringSetsLongitude() { 
		$this->fixture->setLongitude('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLongitude()
		);
	}
	
	/**
	 * @test
	 */
	public function getLocationReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLocationForStringSetsLocation() { 
		$this->fixture->setLocation('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLocation()
		);
	}
	
	/**
	 * @test
	 */
	public function getPriceReturnsInitialValueForFloat() { 
		$this->assertSame(
			0.0,
			$this->fixture->getPrice()
		);
	}

	/**
	 * @test
	 */
	public function setPriceForFloatSetsPrice() { 
		$this->fixture->setPrice(3.14159265);

		$this->assertSame(
			3.14159265,
			$this->fixture->getPrice()
		);
	}
	
	/**
	 * @test
	 */
	public function getImagesReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setImagesForStringSetsImages() { 
		$this->fixture->setImages('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getImages()
		);
	}
	
	/**
	 * @test
	 */
	public function getCategoriesReturnsInitialValueForObjectStorageContainingTx_Hevents_Domain_Model_Category() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function setCategoriesForObjectStorageContainingTx_Hevents_Domain_Model_CategorySetsCategories() { 
		$category = new Tx_Hevents_Domain_Model_Category();
		$objectStorageHoldingExactlyOneCategories = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneCategories->attach($category);
		$this->fixture->setCategories($objectStorageHoldingExactlyOneCategories);

		$this->assertSame(
			$objectStorageHoldingExactlyOneCategories,
			$this->fixture->getCategories()
		);
	}
	
	/**
	 * @test
	 */
	public function addCategoryToObjectStorageHoldingCategories() {
		$category = new Tx_Hevents_Domain_Model_Category();
		$objectStorageHoldingExactlyOneCategory = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneCategory->attach($category);
		$this->fixture->addCategory($category);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneCategory,
			$this->fixture->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function removeCategoryFromObjectStorageHoldingCategories() {
		$category = new Tx_Hevents_Domain_Model_Category();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($category);
		$localObjectStorage->detach($category);
		$this->fixture->addCategory($category);
		$this->fixture->removeCategory($category);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getCategories()
		);
	}
	
	/**
	 * @test
	 */
	public function getDatesReturnsInitialValueForObjectStorageContainingTx_Hevents_Domain_Model_Date() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getDates()
		);
	}

	/**
	 * @test
	 */
	public function setDatesForObjectStorageContainingTx_Hevents_Domain_Model_DateSetsDates() { 
		$date = new Tx_Hevents_Domain_Model_Date();
		$objectStorageHoldingExactlyOneDates = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneDates->attach($date);
		$this->fixture->setDates($objectStorageHoldingExactlyOneDates);

		$this->assertSame(
			$objectStorageHoldingExactlyOneDates,
			$this->fixture->getDates()
		);
	}
	
	/**
	 * @test
	 */
	public function addDateToObjectStorageHoldingDates() {
		$date = new Tx_Hevents_Domain_Model_Date();
		$objectStorageHoldingExactlyOneDate = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneDate->attach($date);
		$this->fixture->addDate($date);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneDate,
			$this->fixture->getDates()
		);
	}

	/**
	 * @test
	 */
	public function removeDateFromObjectStorageHoldingDates() {
		$date = new Tx_Hevents_Domain_Model_Date();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($date);
		$localObjectStorage->detach($date);
		$this->fixture->addDate($date);
		$this->fixture->removeDate($date);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getDates()
		);
	}
	
	/**
	 * @test
	 */
	public function getCityReturnsInitialValueForObjectStorageContainingTx_Hevents_Domain_Model_City() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getCity()
		);
	}

	/**
	 * @test
	 */
	public function setCityForObjectStorageContainingTx_Hevents_Domain_Model_CitySetsCity() { 
		$city = new Tx_Hevents_Domain_Model_City();
		$objectStorageHoldingExactlyOneCity = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneCity->attach($city);
		$this->fixture->setCity($objectStorageHoldingExactlyOneCity);

		$this->assertSame(
			$objectStorageHoldingExactlyOneCity,
			$this->fixture->getCity()
		);
	}
	
	/**
	 * @test
	 */
	public function addCityToObjectStorageHoldingCity() {
		$city = new Tx_Hevents_Domain_Model_City();
		$objectStorageHoldingExactlyOneCity = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneCity->attach($city);
		$this->fixture->addCity($city);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneCity,
			$this->fixture->getCity()
		);
	}

	/**
	 * @test
	 */
	public function removeCityFromObjectStorageHoldingCity() {
		$city = new Tx_Hevents_Domain_Model_City();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($city);
		$localObjectStorage->detach($city);
		$this->fixture->addCity($city);
		$this->fixture->removeCity($city);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getCity()
		);
	}
	
}
?>