<?php
/**
 * Validator for User
 *
 */
class Tx_Hevents_Domain_Validator_UserValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

	/**
	 * validate
	 *
	 * @param mixxed $user
	 * @return bool
	 */
	public function isValid($user) {
		$this->errors = array();
		$ret = true;
		

		$this->emptyField($ret, $user->getEmail(), 'email');
		$this->emptyField($ret, $user->getFirstName(), 'firstName');
		$this->emptyField($ret, $user->getLastName(), 'lastName');
		$this->emptyField($ret, $user->getAddress(), 'address');
		$this->emptyField($ret, $user->getZip(), 'zip');
		$this->emptyField($ret, $user->getCity(), 'city');
		$this->emptyField($ret, $user->getCountry(), 'country');
		
		return $ret;
	}
	
	protected function emptyField(&$ret, $value, $field_name){
		if(empty( $value )){
			$this->errors[$field_name] = new Tx_Extbase_Validation_PropertyError($field_name, time());
            $this->errors[$field_name]->addErrors(array(new Tx_Extbase_Validation_Error(Tx_Extbase_Utility_Localization::translate('tx_hevents_domain_model_user.error.empty.'.$field_name, 'hevents'), 84647862842)));
			$ret = false;
		}
	}
}

?>