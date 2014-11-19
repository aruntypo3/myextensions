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
class Tx_Hevents_Domain_Model_User extends Tx_Extbase_Domain_Model_FrontendUser {

	/**
	 * dname
	 *
	 * @var string
	 */
	protected $dname;

	/**
	 * dforename
	 *
	 * @var string
	 */
	protected $dforename;

	/**
	 * daddress
	 *
	 * @var string
	 */
	protected $daddress;

	/**
	 * dzip
	 *
	 * @var string
	 */
	protected $dzip;

	/**
	 * dcity
	 *
	 * @var string
	 */
	protected $dcity;

	/**
	 * dcountry
	 *
	 * @var string
	 */
	protected $dcountry;
	
	/**
	 * optkey
	 *
	 * @var string
	 */
	protected $optkey;
	
	/**
	 * opt
	 *
	 * @var boolean
	 */
	protected $opt = false;
	
	/**
	 * favs
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_Event>
	 * @lazy
	 */
	protected $favs;
	
	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->favs = new Tx_Extbase_Persistence_ObjectStorage();
	}
	
	/**
	 * Returns the dname
	 *
	 * @return string $dname
	 */
	public function getDname() {
		return $this->dname;
	}

	/**
	 * Sets the dname
	 *
	 * @param string $dname
	 * @return void
	 */
	public function setDname($dname) {
		$this->dname = $dname;
	}

	/**
	 * Returns the dforename
	 *
	 * @return string $dforename
	 */
	public function getDforename() {
		return $this->dforename;
	}

	/**
	 * Sets the dforename
	 *
	 * @param string $dforename
	 * @return void
	 */
	public function setDforename($dforename) {
		$this->dforename = $dforename;
	}

	/**
	 * Returns the daddress
	 *
	 * @return string $daddress
	 */
	public function getDaddress() {
		return $this->daddress;
	}

	/**
	 * Sets the daddress
	 *
	 * @param string $daddress
	 * @return void
	 */
	public function setDaddress($daddress) {
		$this->daddress = $daddress;
	}

	/**
	 * Returns the dzip
	 *
	 * @return string $dzip
	 */
	public function getDzip() {
		return $this->dzip;
	}

	/**
	 * Sets the dzip
	 *
	 * @param string $dzip
	 * @return void
	 */
	public function setDzip($dzip) {
		$this->dzip = $dzip;
	}

	/**
	 * Returns the dcity
	 *
	 * @return string $dcity
	 */
	public function getDcity() {
		return $this->dcity;
	}

	/**
	 * Sets the dcity
	 *
	 * @param string $dcity
	 * @return void
	 */
	public function setDcity($dcity) {
		$this->dcity = $dcity;
	}

	/**
	 * Returns the dcountry
	 *
	 * @return string $dcountry
	 */
	public function getDcountry() {
		return $this->dcountry;
	}

	/**
	 * Sets the dcountry
	 *
	 * @param string $dcountry
	 * @return void
	 */
	public function setDcountry($dcountry) {
		$this->dcountry = $dcountry;
	}
	
	
	/**
	 * Returns the optkey
	 *
	 * @return string $optkey
	 */
	public function getOptkey() {
		return $this->optkey;
	}

	/**
	 * Sets the optkey
	 *
	 * @param string $optkey
	 * @return void
	 */
	public function setOptkey($optkey) {
		$this->optkey = $optkey;
	}
	
	/**
	 * Returns the opt
	 *
	 * @return boolean $opt
	 */
	public function getOpt() {
		return $this->opt;
	}

	/**
	 * Sets the opt
	 *
	 * @param string $opt
	 * @return void
	 */
	public function setOpt($opt) {
		$this->opt = $opt;
	}
	
	/**
	 * Sets the date
	 *
	 * @param DateTime $date
	 * @return void
	 */
	public function setTstamp($date){
		$this->tstamp = $date;
	}
	
	/**
	 * Sets the date
	 *
	 * @param boolean $dis
	 * @return void
	 */
	public function setDisable($dis){
		$this->disable = $dis;
	}
	
	/**
	 * Sets the TxExtbaseType
	 *
	 * @param string $type
	 * @return void
	 */
	public function setTxExtbaseType($type){
		$this->txExtbaseType = type;
	}
	
	/**
	 * maps the data
	 *
	 * @param mixxed $user
	 * @return void
	 */
	public function dataFromArray($user){
		$this->password = $user['password'];
		$this->username = $user['email'];
		$this->email = $user['email'];
		$this->lastName = $user['lastName'];
		$this->firstName = $user['firstName'];
		$this->address = $user['address'];
		$this->zip = $user['zip'];
		$this->city = $user['city'];
		$this->country = $user['country'];
		$this->dname = $user['dname'];
		$this->dforename = $user['dforename'];
		$this->daddress = $user['daddress'];
		$this->dzip = $user['dzip'];
		$this->dcity = $user['dcity'];
		$this->dcountry = $user['dcountry'];
	}
	
	
	/**
	 * Adds a Fav
	 *
	 * @param Tx_Hevents_Domain_Model_Event $fav
	 * @return void
	 */
	public function addFav(Tx_Hevents_Domain_Model_Event $fav) {
		$this->favs->attach($fav);
	}

	/**
	 * Removes a Fav
	 *
	 * @param Tx_Hevents_Domain_Model_Event $fav
	 * @return void
	 */
	public function removeFav(Tx_Hevents_Domain_Model_Event $fav) {
		$this->favs->detach($fav);
	}

	/**
	 * Returns the fav
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_Event> $favs
	 */
	 
	public function getFavs() {
		return $this->favs;
	}
	
	/**
	 * Returns the fav
	 *
	 * @param Tx_Hevents_Domain_Model_Event $fav
	 * @return boolean
	 */
	 
	public function hasFavs(Tx_Hevents_Domain_Model_Event $fav) {
		return $this->favs->contains($fav);
	}
	
	/**
	 * Sets the favs
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Hevents_Domain_Model_Event> $favs
	 * @return void
	 */
	public function setFavs(Tx_Extbase_Persistence_ObjectStorage $favs) {
		$this->favs = $favs;
	}
}
?>