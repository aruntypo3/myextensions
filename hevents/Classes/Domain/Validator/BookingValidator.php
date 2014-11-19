<?php
/**
 * Validator for Booking
 *
 */
class Tx_Hevents_Domain_Validator_BookingValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

	/**
	 * validate
	 *
	 * @param mixxed $booking
	 * @return bool
	 */
	public function isValid($booking) {
	
		$this->errors = array();
		$ret = true;
		
		$v = $booking->getAmount();
		$this->emptyField($ret, $v, 'amount');
		
		$v = $booking->getEmail();
		$this->emptyField($ret, $v, 'email');
		
		$v = $booking->getName();
		$this->emptyField($ret, $v, 'name');
		
		$v = $booking->getForename();
		$this->emptyField($ret, $v, 'forename');
		
		$v = $booking->getAddress();
		$this->emptyField($ret, $v, 'address');
		
		$v = $booking->getZip();
		$this->emptyField($ret, $v, 'zip');
		
		$v = $booking->getCity();
		$this->emptyField($ret, $v, 'city');
		
		$v = $booking->getCountry();
		$this->emptyField($ret, $v, 'country');
		
		if($booking->getDelevieraddress()){
			$v = $booking->getDname();
			$this->emptyField($ret, $v, 'dname');
			
			$v = $booking->getDforename();
			$this->emptyField($ret, $v, 'dforename');
			
			$v = $booking->getDaddress();
			$this->emptyField($ret, $v, 'daddress');
			
			$v = $booking->getDzip();
			$this->emptyField($ret, $v, 'dzip');
			
			$v = $booking->getDcity();
			$this->emptyField($ret, $v, 'dcity');
			
			$v = $booking->getDcountry();
			$this->emptyField($ret, $v, 'dcountry');
		}
		return $ret;
	}
	
	protected function emptyField(&$ret, $value, $field_name){

		$this->edHandler = t3lib_div::makeInstance('Tx_Hevents_Domain_Session_EdSessionHandler');
		$ed_ses = $this->edHandler->restoreFromSession();	

		if(empty($value)){
			$this->errors[$field_name] = new Tx_Extbase_Validation_PropertyError($field_name, time());
            $this->errors[$field_name]->addErrors(array(new Tx_Extbase_Validation_Error(Tx_Extbase_Utility_Localization::translate('tx_hevents_domain_model_booking.error.'.$field_name, 'hevents'), 84647862842)));
			$ret = false;
		}
		
		if( !empty( $value ) && $field_name == "amount" && isset( $ed_ses['date'] ) ){
			$remainingSeatDetails = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('remainseats', 'tx_hevents_domain_model_date', 'uid="'.$ed_ses["date"].'" AND deleted = 0 AND hidden = 0');	
			if( $value > $remainingSeatDetails[0]['remainseats'] ){
				$this->errors[$field_name] = new Tx_Extbase_Validation_PropertyError($field_name, time());
				$this->errors[$field_name]->addErrors(array(new Tx_Extbase_Validation_Error(Tx_Extbase_Utility_Localization::translate('tx_hevents_domain_model_booking.error_avail.'.$field_name, 'hevents'), 84647862842)));
				$ret = false;
			}
		}
	}
}

?>