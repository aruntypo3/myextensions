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
class Tx_Hevents_Domain_Model_Date extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * start
	 *
	 * @var DateTime
	 * @validate NotEmpty
	 */
	protected $start;

	/**
	 * end
	 *
	 * @var DateTime
	 * @validate NotEmpty
	 */
	protected $end;
	
	/**
	 * eventstarttime
	 *
	 * @var DateTime
	 * @validate NotEmpty
	 */
	protected $eventstarttime;
	
	/**
	 * eventendtime
	 *
	 * @var DateTime
	 * @validate NotEmpty
	 */
	protected $eventendtime;
	
	/**
	 * remainseats
	 *
	 * @var integer
	 * @validate NotEmpty   
	 */
	protected $remainseats;
	
	/**
	 * Returns the start
	 *
	 * @return DateTime $start
	 */
	public function getStart() {
		return $this->start;
	}

	/**
	 * Sets the start
	 *
	 * @param DateTime $start
	 * @return void
	 */
	public function setStart($start) {
		$this->start = $start;
	}

	/**
	 * Returns the end
	 *
	 * @return DateTime $end
	 */
	public function getEnd() {
		return $this->end;
	}

	/**
	 * Sets the end
	 *
	 * @param DateTime $end
	 * @return void
	 */
	public function setEnd($end) {
		$this->end = $end;
	}
	
	/**
	 * Returns the eventstarttime
	 *
	 * @return DateTime $eventstarttime
	 */
	public function getEventstarttime() {
		return $this->eventstarttime;
	}
	
	/**
	 * Sets the eventstarttime
	 *
	 * @param DateTime $eventstarttime
	 * @return void
	 */
	public function setEventstarttime($eventstarttime) {
		$this->eventstarttime = $eventstarttime;
	}
	
	/**
	 * Returns the eventendtime
	 *
	 * @return DateTime $eventendtime
	 */
	public function getEventendtime() {
		return $this->eventendtime;
	}
	
	/**
	 * Sets the eventendtime
	 *
	 * @param DateTime $eventendtime
	 * @return void
	 */
	public function setEventendtime($eventendtime) {
		$this->eventendtime = $eventendtime;
	}
	
	/**
	 * Returns the remainseats
	 *
	 * @return integer $remainseats
	 */
	public function getRemainseats() {
		return $this->remainseats;
	}

	/**
	 * Sets the remainseats
	 *
	 * @param integer $remainseats
	 * @return void
	 */
	public function setRemainseats($remainseats) {
		$this->remainseats = $remainseats;
	}

	public function getIsBookable(){
		$now = new DateTime();
		return $this->start > $now;
	}
}
?>