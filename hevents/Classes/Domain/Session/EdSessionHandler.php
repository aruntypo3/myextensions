<?php
class Tx_Hevents_Domain_Session_EdSessionHandler extends Tx_Hevents_Domain_Session_BookingSessionHandler {
	
	protected $name = 'tx_hevents_ed';
	
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
	 * Add ed to session
	 * @param string $key
	 * @param mixed $obj
	 * @return	Tx_Hevents_Domain_Session_EdSessionHandler this
	 */
	public function setToSession($key,$obj) {
		$arr = $this->restoreFromSession();
		$arr[$key] = $obj;
		$this->writeToSession($arr);
		return $this;
	}
}
?>