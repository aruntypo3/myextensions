<?php
class Tx_Hevents_Domain_Session_FilterSessionHandler extends Tx_Hevents_Domain_Session_BookingSessionHandler {
	
	protected $name = 'tx_hevents_filter';
	
	/**
	 * Returns the object stored in the user´s PHP session
	 * @return Object the stored object
	 */
	public function restoreFromSession() {
		$sessionData = $GLOBALS['TSFE']->fe_user->getKey('ses', $this->name);
		$un = unserialize($sessionData);
		return is_array($un) ? $un : array();
	}
	
	/**
	 * Add filter to session
	 * @param string $key
	 * @param mixed $obj
	 * @return	Tx_Hevents_Domain_Session_FilterSessionHandler this
	 */
	public function setToSession($key,$obj) {
		$arr = $this->restoreFromSession();
		$arr[$key] = $obj;
		$this->writeToSession($arr);
		return $this;
	}
}
?>