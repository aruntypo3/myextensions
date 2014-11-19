<?php
/**
 * Validator for User
 *
 */
class Tx_Hevents_Domain_Validator_ArrayuserValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {
	
	/**
	 * userRepository
	 *
	 * @var Tx_Hevents_Domain_Repository_UserRepository
	 */
	protected $userRepository;

	/**
	 * injectUserRepository
	 *
	 * @param Tx_Hevents_Domain_Repository_UserRepository $userRepository
	 * @return void
	 */
	public function injectUserRepository(Tx_Hevents_Domain_Repository_UserRepository $userRepository) {
		$this->userRepository = $userRepository;
	}
	
	/**
	 * validate
	 *
	 * @param mixxed $user
	 * @return bool
	 */
	public function isValid($user) {
		$this->errors = array();
		$ret = true;
		
		//t3lib_utility_Debug::debug('debug');
		
		$this->emptyField($ret, $user, 'email');
		$this->emptyField($ret, $user, 'password');
		$this->emptyField($ret, $user, 'password_confirm');
		
		if($user['password']!=$user['password_confirm']){
			$this->errors['password_confirm'] = new Tx_Extbase_Validation_PropertyError('password_confirm', time());
            $this->errors['password_confirm']->addErrors(array(new Tx_Extbase_Validation_Error(Tx_Extbase_Utility_Localization::translate('tx_hevents_domain_model_user.error.equal.password', 'hevents'), 84647862842)));
			$ret = false;
		}
		
		$this->emptyField($ret, $user, 'lastName');
		$this->emptyField($ret, $user, 'firstName');
		$this->emptyField($ret, $user, 'address');
		$this->emptyField($ret, $user, 'zip');
		$this->emptyField($ret, $user, 'city');
		$this->emptyField($ret, $user, 'country');
		/*
		$this->emptyField($ret, $user, 'dname');
		$this->emptyField($ret, $user, 'dforename');
		$this->emptyField($ret, $user, 'daddress');
		$this->emptyField($ret, $user, 'dzip');
		$this->emptyField($ret, $user, 'dcity');
		$this->emptyField($ret, $user, 'dcountry');
		*/

		$userExists = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows( 'email','fe_users','email="'.$user['email'].'" AND deleted = 0 AND disable = 0');
		if( !empty( $userExists[0]['email'] ) ){
			$this->errors['email'] = new Tx_Extbase_Validation_PropertyError('email', time());
            $this->errors['email']->addErrors(array(new Tx_Extbase_Validation_Error(Tx_Extbase_Utility_Localization::translate('tx_hevents_domain_model_user.error.userexists', 'hevents'), 84647862842)));
			$ret = false;
		}
		
		if( !empty( $user['email'] ) && empty( $userExists[0]['email'] ) && ( !filter_var ( $user['email'], FILTER_VALIDATE_EMAIL ) ) ){
			$this->errors['email'] = new Tx_Extbase_Validation_PropertyError('email', time());
            $this->errors['email']->addErrors(array(new Tx_Extbase_Validation_Error(Tx_Extbase_Utility_Localization::translate('tx_hevents_domain_model_user.error.invalidemail', 'hevents'), 84647862842)));
			$ret = false;
		}
		
		return $ret;
	}
	
	protected function emptyField(&$ret, $user, $field_name){
		if(empty($user[$field_name])){
			$this->errors[$field_name] = new Tx_Extbase_Validation_PropertyError($field_name, time());
            $this->errors[$field_name]->addErrors(array(new Tx_Extbase_Validation_Error(Tx_Extbase_Utility_Localization::translate('tx_hevents_domain_model_user.error.empty.'.$field_name, 'hevents'), 84647862842)));
			$ret = false;
		}
	}
}

?>