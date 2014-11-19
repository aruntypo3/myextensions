<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Arun Chandran <arun.c@pitsolutions.com>, PIT Solutions Pvt Ltd.
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
 * Test case for class Tx_VstTour_Domain_Model_Vsttour.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage VST Tour Management
 *
 * @author Arun Chandran <arun.c@pitsolutions.com>
 */
class Tx_VstTour_Domain_Model_VsttourTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_VstTour_Domain_Model_Vsttour
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_VstTour_Domain_Model_Vsttour();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	/**
	 * @test
	 */
	public function dummyTestToNotLeaveThisFileEmpty() {
		$this->markTestIncomplete();
	}
	
}
?>