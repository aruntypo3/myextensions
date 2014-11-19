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
class Tx_Hevents_Domain_Model_Booking extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * amount
	 *
	 * @var integer
	 */
	protected $amount;
	
	/**
	 * price
	 *
	 * @var float
	 */
	protected $price;
	
	/**
	 * ppstatus
	 *
	 * @var integer
	 */
	protected $ppstatus;

	/**
	 * ppref
	 *
	 * @var string
	 */
	protected $ppref;
	
	/**
	 * email
	 *
	 * @var string
	 */
	protected $email;
	
	/**
	 * name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * forename
	 *
	 * @var string
	 */
	protected $forename;

	/**
	 * address
	 *
	 * @var string
	 */
	protected $address;

	/**
	 * zip
	 *
	 * @var string
	 */
	protected $zip;

	/**
	 * city
	 *
	 * @var string
	 */
	protected $city;

	/**
	 * country
	 *
	 * @var string
	 */
	protected $country;

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
	 * lkey
	 *
	 * @var integer
	 */
	protected $lkey;

	/**
	 * event
	 *
	 * @var Tx_Hevents_Domain_Model_Event
	 * @lazy
	 */
	protected $event;

	/**
	 * date
	 *
	 * @var Tx_Hevents_Domain_Model_Date
	 * @lazy
	 */
	protected $date;

	/**
	 * user
	 *
	 * @var Tx_Extbase_Domain_Model_FrontendUser
	 * @lazy
	 */
	protected $user;
	
	/**
	 * delevieraddress
	 *
	 * @var boolean
	 */
	protected $delevieraddress = false;
	
	/**
	 * Returns the amount
	 *
	 * @return integer $amount
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * Sets the amount
	 *
	 * @param integer $amount
	 * @return void
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
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
	 * Returns the ppstatus
	 *
	 * @return string $ppstatus
	 */
	public function getPpstatus() {
		return Tx_Extbase_Utility_Localization::translate('tx_hevents_domain_model_booking.ppstatus.'.$this->ppstatus, 'tx_hevents');
	}
	
	/**
	 * Sets the ppstatus
	 *
	 * @param integer $ppstatus
	 * @return void
	 */
	public function setPpstatus($ppstatus) {
		$this->ppstatus = $ppstatus;
	}

	/**
	 * Returns the ppref
	 *
	 * @return string $ppref
	 */
	public function getPpref() {
		return $this->ppref;
	}

	/**
	 * Sets the ppref
	 *
	 * @param string $ppref
	 * @return void
	 */
	public function setPpref($ppref) {
		$this->ppref = $ppref;
	}

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * Returns the email
	 *
	 * @return string $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets the email
	 *
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns the forename
	 *
	 * @return string $forename
	 */
	public function getForename() {
		return $this->forename;
	}

	/**
	 * Sets the forename
	 *
	 * @param string $forename
	 * @return void
	 */
	public function setForename($forename) {
		$this->forename = $forename;
	}

	/**
	 * Returns the address
	 *
	 * @return string $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets the address
	 *
	 * @param string $address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Returns the zip
	 *
	 * @return string $zip
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * Sets the zip
	 *
	 * @param string $zip
	 * @return void
	 */
	public function setZip($zip) {
		$this->zip = $zip;
	}

	/**
	 * Returns the city
	 *
	 * @return string $city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Sets the city
	 *
	 * @param string $city
	 * @return void
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * Returns the country
	 *
	 * @return string $country
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Sets the country
	 *
	 * @param string $country
	 * @return void
	 */
	public function setCountry($country) {
		$this->country = $country;
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
	 * Returns the lkey
	 *
	 * @return integer $lkey
	 */
	public function getLkey() {
		return $this->lkey;
	}

	/**
	 * Sets the lkey
	 *
	 * @param integer $lkey
	 * @return void
	 */
	public function setLkey($lkey) {
		$this->lkey = $lkey;
	}
	
	
	
	/**
	 * Returns the event
	 *
	 * @return Tx_Hevents_Domain_Model_Event $event
	 */
	public function getEvent() {
		return $this->event;
	}

	/**
	 * Sets the event
	 *
	 * @param Tx_Hevents_Domain_Model_Event $event
	 * @return void
	 */
	public function setEvent(Tx_Hevents_Domain_Model_Event $event) {
		$this->event = $event;
	}

	/**
	 * Returns the date
	 *
	 * @return Tx_Hevents_Domain_Model_Date $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Sets the date
	 *
	 * @param Tx_Hevents_Domain_Model_Date $date
	 * @return void
	 */
	public function setDate(Tx_Hevents_Domain_Model_Date $date) {
		$this->date = $date;
	}

	/**
	 * Returns the user
	 *
	 * @return Tx_Extbase_Domain_Model_FrontendUser $user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the user
	 *
	 * @param Tx_Extbase_Domain_Model_FrontendUser $user
	 * @return void
	 */
	public function setUser(Tx_Extbase_Domain_Model_FrontendUser $user) {
		$this->user = $user;
	}
	
	
	/**
	 * Returns the delevieraddress
	 *
	 * @return boolean $delevieraddress
	 */
	public function getDelevieraddress() {
		return $this->delevieraddress;
	}

	/**
	 * Sets the delevieraddress
	 *
	 * @param boolean $delevieraddress
	 * @return void
	 */
	public function setDelevieraddress($delevieraddress) {
		$this->delevieraddress = $delevieraddress;
	}
}
?>