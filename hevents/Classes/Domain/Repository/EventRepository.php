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
class Tx_Hevents_Domain_Repository_EventRepository extends Tx_Extbase_Persistence_Repository {
	protected $defaultOrderings = array(
		'title' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING
	);
	
	/**
	 * filter 
	 *
	 * @var array
	 */
	protected $filter = array();
	
	public function findByFilter(){
		$query = $this->createQuery();
	
		if(count($this->filter)>0){
			$query->matching($query->logicalAnd($this->filter));
		}
		
		return $query
			  ->setOrderings($this->defaultOrderings)
			  ->execute();
	}
	
	/**
	 * add filter logic
	 *
	 * @param Tx_Extbase_Persistence_QOM_ConstraintInterface $filter
	 * @return void
	 */
	public function addFilter(Tx_Extbase_Persistence_QOM_ConstraintInterface $filter){
		$this->filter []= $filter;
	}
	
	/**
	 * clear filter logic
	 *
	 * @return void
	 */
	public function clearFilter(){
		$this->filter = array();
	}
}
?>