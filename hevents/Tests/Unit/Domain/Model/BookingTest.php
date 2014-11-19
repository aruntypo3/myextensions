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
 * Test case for class Tx_Hevents_Domain_Model_Booking.
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
class Tx_Hevents_Domain_Model_BookingTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Hevents_Domain_Model_Booking
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Hevents_Domain_Model_Booking();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getAmountReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getAmount()
		);
	}

	/**
	 * @test
	 */
	public function setAmountForIntegerSetsAmount() { 
		$this->fixture->setAmount(12);

		$this->assertSame(
			12,
			$this->fixture->getAmount()
		);
	}
	
	/**
	 * @test
	 */
	public function getPpstatusReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPpstatusForStringSetsPpstatus() { 
		$this->fixture->setPpstatus('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPpstatus()
		);
	}
	
	/**
	 * @test
	 */
	public function getPprefReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPprefForStringSetsPpref() { 
		$this->fixture->setPpref('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPpref()
		);
	}
	
	/**
	 * @test
	 */
	public function getEventReturnsInitialValueForTx_Hevents_Domain_Model_Event() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getEvent()
		);
	}

	/**
	 * @test
	 */
	public function setEventForTx_Hevents_Domain_Model_EventSetsEvent() { 
		$dummyObject = new Tx_Hevents_Domain_Model_Event();
		$this->fixture->setEvent($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getEvent()
		);
	}
	
	/**
	 * @test
	 */
	public function getDateReturnsInitialValueForTx_Hevents_Domain_Model_Date() { 
		$this->assertEquals(
			NULL,
			$this->fixture->getDate()
		);
	}

	/**
	 * @test
	 */
	public function setDateForTx_Hevents_Domain_Model_DateSetsDate() { 
		$dummyObject = new Tx_Hevents_Domain_Model_Date();
		$this->fixture->setDate($dummyObject);

		$this->assertSame(
			$dummyObject,
			$this->fixture->getDate()
		);
	}
	
	/**
	 * @test
	 */
	public function getUserReturnsInitialValueForTx_Extbase_Domain_Model_FrontendUser() { }

	/**
	 * @test
	 */
	public function setUserForTx_Extbase_Domain_Model_FrontendUserSetsUser() { }
	
}
?>