<?php

/**
 * @api
 */
class Tx_Hevents_ViewHelpers_IsfavuserViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
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
	 * Renders the field.
	 *
	 * @param Tx_Hevents_Domain_Model_Event $event
	 * @return boolean
	 * @api
	 */
	public function render(Tx_Hevents_Domain_Model_Event $event) {
		$userLoged = $GLOBALS['TSFE']->fe_user->user;
		if($userLoged){
			$userLoged = $this->userRepository->findByUid($userLoged['uid']);
			return $userLoged->hasFavs($event);
		}
		return false;
	}

}

?>