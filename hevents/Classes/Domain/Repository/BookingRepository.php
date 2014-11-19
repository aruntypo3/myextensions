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
class Tx_Hevents_Domain_Repository_BookingRepository extends Tx_Extbase_Persistence_Repository {
	/**
	 * The session handler
	 * @var Tx_Hevents_Domain_Session_BookingSessionHandler
	 * @inject
	 */
	protected $sessionHandler = NULL;
 
	public function __construct() {
		//parent::__construct();
		// get an instance of the session handler
		$this->sessionHandler = t3lib_div::makeInstance('Tx_Hevents_Domain_Session_BookingSessionHandler');
	}
	
	/**
	 * Returns the object stored in the user�s PHP session
	 * @return Tx_Hevents_Domain_Model_Booking the stored Object
	 */
	public function findBySession() {
		return $this->sessionHandler->restoreFromSession();
	}
 
	/**
	 * Writes the object into the PHP session
	 * @return	Tx_Hevents_Domain_Repository_BookingRepository this
	 */
	public function writeToSession(Tx_Hevents_Domain_Model_Booking $object) {
		$this->sessionHandler->writeToSession($object);
		return $this;
	}
 
	/**
	 * Cleans up the session: removes the stored object from the PHP session
	 * @return	Tx_Hevents_Domain_Repository_BookingRepository this
	 */
	public function cleanUpSession() {
		$this->sessionHandler->cleanUpSession();
		return $this;
	}
	
	/**
	 * 
	 * @return Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findByUser($uid, $order='asc'){
		$query = $this->createQuery();
		$ordering = ($order=='asc') ? array('date.start' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING) : array('date.start' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING);
		return $query
			->matching(
				$query->equals('user.uid', $uid)
			)
			->setOrderings($ordering)
			->execute();
	}
}
?>