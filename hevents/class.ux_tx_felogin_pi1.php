<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007-2011 Steffen Kamper <info@sk-typo3.de>
*  Based on Newloginbox (c) 2002-2004 Kasper Skårhøj <kasper@typo3.com>
*
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
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
*
*  The code was adapted from newloginbox, see manual for detailed description
***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Plugin 'Website User Login' for the 'felogin' extension.
 *
 * @author	Steffen Kamper <info@sk-typo3.de>
 * @package	TYPO3
 * @subpackage	tx_felogin
 */
class ux_tx_felogin_pi1 extends TYPO3\CMS\Felogin\Controller\FrontendLoginController {
	
	/**
	 * Shows the forgot password form
	 *
	 * @return string Content
	 */
	protected function showForgot() {
		$subpart = $this->cObj->getSubpart($this->template, '###TEMPLATE_FORGOT###');
		$subpartArray = ($linkpartArray = array());
		$postData = GeneralUtility::_POST($this->prefixId);
		if ($postData['forgot_email']) {
			// Get hashes for compare
			$postedHash = $postData['forgot_hash'];
			$hashData = $GLOBALS['TSFE']->fe_user->getKey('ses', 'forgot_hash');
			if ($postedHash === $hashData['forgot_hash']) {
				$row = FALSE;
				// Look for user record
				$data = $GLOBALS['TYPO3_DB']->fullQuoteStr($this->piVars['forgot_email'], 'fe_users');
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
						'uid, username, password, CONCAT(first_name, " ", last_name) AS userfullname, email',
						'fe_users',
						'(email=' . $data . ' OR username=' . $data . ') AND pid IN (' . $GLOBALS['TYPO3_DB']->cleanIntList($this->spid) . ') ' . $this->cObj->enableFields('fe_users')
				);
				if ($GLOBALS['TYPO3_DB']->sql_num_rows($res)) {
					$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
				}
				$error = NULL;
				if ($row) {
					// Generate an email with the hashed link
					$error = $this->generateAndSendHash($row);
				} elseif ($this->conf['exposeNonexistentUserInForgotPasswordDialog']) {
					$error = $this->pi_getLL('ll_forgot_reset_message_error');
				}
				// Generate message
				if ($error) {
					$markerArray['###STATUS_MESSAGE###'] = $this->cObj->stdWrap($error, $this->conf['forgotErrorMessage_stdWrap.']);
				} else {
					$markerArray['###STATUS_MESSAGE###'] = $this->cObj->stdWrap(
							$this->pi_getLL('ll_forgot_reset_message_emailSent', '', TRUE),
							$this->conf['forgotResetMessageEmailSentMessage_stdWrap.']
					);
				}
				$subpartArray['###FORGOT_FORM###'] = '';
			} else {
				// Wrong email
				$markerArray['###STATUS_MESSAGE###'] = $this->getDisplayText('forgot_reset_message', $this->conf['forgotMessage_stdWrap.']);
				$markerArray['###BACKLINK_LOGIN###'] = '';
			}
		} else {
			$markerArray['###STATUS_MESSAGE###'] = $this->getDisplayText('forgot_reset_message', $this->conf['forgotMessage_stdWrap.']);
			$markerArray['###BACKLINK_LOGIN###'] = '';
		}
		$markerArray['###BACKLINK_LOGIN###'] = $this->getPageLink($this->pi_getLL('ll_forgot_header_backToLogin', '', TRUE), array());
		$markerArray['###STATUS_HEADER###'] = $this->getDisplayText('forgot_header', $this->conf['forgotHeader_stdWrap.']);
		$markerArray['###LEGEND###'] = $this->pi_getLL('legend', $this->pi_getLL('reset_password', '', TRUE), TRUE);
		$markerArray['###ACTION_URI###'] = $this->getPageLink('', array($this->prefixId . '[forgot]' => 1), TRUE);
		$markerArray['###EMAIL_LABEL###'] = $this->pi_getLL('your_email', '', TRUE);
		$markerArray['###FORGOT_PASSWORD_ENTEREMAIL###'] = $this->pi_getLL('forgot_password_enterEmail', '', TRUE);
		$markerArray['###FORGOT_EMAIL###'] = $this->prefixId . '[forgot_email]';
		$markerArray['###SEND_PASSWORD###'] = $this->pi_getLL('reset_password', '', TRUE);
		$markerArray['###DATA_LABEL###'] = $this->pi_getLL('ll_enter_your_data', '', TRUE);
		$markerArray = array_merge($markerArray, $this->getUserFieldMarkers());
		// Generate hash
		$hash = md5($this->generatePassword(3));
		$markerArray['###FORGOTHASH###'] = $hash;
		// Set hash in feuser session
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'forgot_hash', array('forgot_hash' => $hash));
		return $this->cObj->substituteMarkerArrayCached($subpart, $markerArray, $subpartArray, $linkpartArray);
	}
	
	/**
	 * This function checks the hash from link and checks the validity. If it's valid it shows the form for
	 * changing the password and process the change of password after submit, if not valid it returns the error message
	 *
	 * @return string The content.
	 */
	protected function changePassword() {
		$eventData = $_GET['tx_hevents_pi1'];
		$subpartArray = ($linkpartArray = array());
		$done = FALSE;
		$minLength = (int)$this->conf['newPasswordMinLength'] ?: 6;
		$subpart = $this->cObj->getSubpart($this->template, '###TEMPLATE_CHANGEPASSWORD###');
		$markerArray['###STATUS_HEADER###'] = $this->getDisplayText('change_password_header', $this->conf['changePasswordHeader_stdWrap.']);
		$markerArray['###STATUS_MESSAGE###'] = sprintf($this->getDisplayText(
				'change_password_message',
				$this->conf['changePasswordMessage_stdWrap.']
		), $minLength);
	
		$markerArray['###BACKLINK_LOGIN###'] = '';
		$uid = $this->piVars['user'];
		$piHash = $this->piVars['forgothash'];
		$hash = explode('|', $piHash);
		if ((int)$uid === 0) {
			$markerArray['###STATUS_MESSAGE###'] = $this->getDisplayText(
					'change_password_notvalid_message',
					$this->conf['changePasswordNotValidMessage_stdWrap.']
			);
			$subpartArray['###CHANGEPASSWORD_FORM###'] = '';
		} else {
			$user = $this->pi_getRecord('fe_users', (int)$uid);
			$userHash = $user['felogin_forgotHash'];
			$compareHash = explode('|', $userHash);
			if (!$compareHash || !$compareHash[1] || $compareHash[0] < time() || $hash[0] != $compareHash[0] || md5($hash[1]) != $compareHash[1]) {
				$markerArray['###STATUS_MESSAGE###'] = $this->getDisplayText(
						'change_password_notvalid_message',
						$this->conf['changePasswordNotValidMessage_stdWrap.']
				);
				$subpartArray['###CHANGEPASSWORD_FORM###'] = '';
			} else {
				// All is fine, continue with new password
				$postData = GeneralUtility::_POST($this->prefixId);
				if (isset($postData['changepasswordsubmit'])) {
					if (strlen($postData['password1']) < $minLength) {
						$markerArray['###STATUS_MESSAGE###'] = sprintf($this->getDisplayText(
								'change_password_tooshort_message',
								$this->conf['changePasswordTooShortMessage_stdWrap.']),
								$minLength
						);
					} elseif ($postData['password1'] != $postData['password2']) {
						$markerArray['###STATUS_MESSAGE###'] = sprintf($this->getDisplayText(
								'change_password_notequal_message',
								$this->conf['changePasswordNotEqualMessage_stdWrap.']),
								$minLength
						);
					} else {
						$newPass = $postData['password1'];
						if ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['password_changed']) {
							$_params = array(
									'user' => $user,
									'newPassword' => $newPass
							);
							foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['password_changed'] as $_funcRef) {
								if ($_funcRef) {
									GeneralUtility::callUserFunction($_funcRef, $_params, $this);
								}
							}
							$newPass = $_params['newPassword'];
						}
						// Save new password and clear DB-hash
						$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
								'fe_users',
								'uid=' . $user['uid'],
								array('password' => $newPass, 'felogin_forgotHash' => '', 'tstamp' => $GLOBALS['EXEC_TIME'])
						);
						$markerArray['###STATUS_MESSAGE###'] = $this->getDisplayText(
								'change_password_done_message',
								$this->conf['changePasswordDoneMessage_stdWrap.']
						);
						$done = TRUE;
						$subpartArray['###CHANGEPASSWORD_FORM###'] = '';
						$markerArray['###BACKLINK_LOGIN###'] = $this->getPageLink(
								$this->pi_getLL('ll_forgot_header_backToLogin', '', TRUE),
								array($this->prefixId . '[redirectReferrer]' => 'off')
						);
					}
				}
				if (!$done) {
					// Change password form
					if( !empty( $eventData ) ){
						$markerArray['###ACTION_URI###'] = $this->pi_getPageLink($GLOBALS['TSFE']->id, '', array(
								$this->prefixId . '[user]' => $user['uid'],
								'tx_hevents_pi1[event]' => $eventData['event'],
								'tx_hevents_pi1[date]' => $eventData['date'],
								'tx_hevents_pi1[action]' => $eventData['action'],
								'tx_hevents_pi1[controller]' => $eventData['controller'],
								$this->prefixId . '[forgothash]' => $piHash
						));
					}else{
						$markerArray['###ACTION_URI###'] = $this->pi_getPageLink($GLOBALS['TSFE']->id, '', array(
								$this->prefixId . '[user]' => $user['uid'],
								$this->prefixId . '[forgothash]' => $piHash
						));
					}
					$markerArray['###LEGEND###'] = $this->pi_getLL('change_password', '', TRUE);
					$markerArray['###NEWPASSWORD1_LABEL###'] = $this->pi_getLL('newpassword_label1', '', TRUE);
					$markerArray['###NEWPASSWORD2_LABEL###'] = $this->pi_getLL('newpassword_label2', '', TRUE);
					$markerArray['###NEWPASSWORD1###'] = $this->prefixId . '[password1]';
					$markerArray['###NEWPASSWORD2###'] = $this->prefixId . '[password2]';
					$markerArray['###STORAGE_PID###'] = $this->spid;
					$markerArray['###SEND_PASSWORD###'] = $this->pi_getLL('change_password', '', TRUE);
					$markerArray['###FORGOTHASH###'] = $piHash;
				}
			}
		}
		return $this->cObj->substituteMarkerArrayCached($subpart, $markerArray, $subpartArray, $linkpartArray);
	}
	
	/**
	 * Generates a hashed link and send it with email
	 *
	 * @param array $user Contains user data
	 * @return string Empty string with success, error message with no success
	 */
	protected function generateAndSendHash($user) {
		$eventData = $_GET['tx_hevents_pi1'];
		$hours = (int)$this->conf['forgotLinkHashValidTime'] > 0 ? (int)$this->conf['forgotLinkHashValidTime'] : 24;
		$validEnd = time() + 3600 * $hours;
		$validEndString = date($this->conf['dateFormat'], $validEnd);
	
		$hash = md5(GeneralUtility::generateRandomBytes(64));
		$randHash = $validEnd . '|' . $hash;
		$randHashDB = $validEnd . '|' . md5($hash);
		// Write hash to DB
		$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users', 'uid=' . $user['uid'], array('felogin_forgotHash' => $randHashDB));

		// Send hashlink to user
		$this->conf['linkPrefix'] = -1;
		$isAbsRelPrefix = !empty($GLOBALS['TSFE']->absRefPrefix);
		$isBaseURL = !empty($GLOBALS['TSFE']->baseUrl);
		$isFeloginBaseURL = !empty($this->conf['feloginBaseURL']);
		//PITS Modified
		if( !empty( $eventData ) ){
			$link = $this->pi_getPageLink($GLOBALS['TSFE']->id, '', array(
					rawurlencode($this->prefixId . '[user]') => $user['uid'],
					rawurlencode('tx_hevents_pi1[event]') => $eventData['event'],
					rawurlencode('tx_hevents_pi1[date]') => $eventData['date'],
					rawurlencode('tx_hevents_pi1[action]') => $eventData['action'],
					rawurlencode('tx_hevents_pi1[controller]') => $eventData['controller'],
					rawurlencode($this->prefixId . '[forgothash]') => $randHash
			));
		}else{
			$link = $this->pi_getPageLink($GLOBALS['TSFE']->id, '', array(
					rawurlencode($this->prefixId . '[user]') => $user['uid'],
					rawurlencode($this->prefixId . '[forgothash]') => $randHash
			));
		}
		// Prefix link if necessary
		if ($isFeloginBaseURL) {
			// First priority, use specific base URL
			// "absRefPrefix" must be removed first, otherwise URL will be prepended twice
			if (!empty($GLOBALS['TSFE']->absRefPrefix)) {
				$link = substr($link, strlen($GLOBALS['TSFE']->absRefPrefix));
			}
			$link = $this->conf['feloginBaseURL'] . $link;
		} elseif ($isAbsRelPrefix) {
			// Second priority
			// absRefPrefix must not necessarily contain a hostname and URL scheme, so add it if needed
			$link = GeneralUtility::locationHeaderUrl($link);
		} elseif ($isBaseURL) {
			// Third priority
			// Add the global base URL to the link
			$link = $GLOBALS['TSFE']->baseUrlWrap($link);
		} else {
			// No prefix is set, return the error
			return $this->pi_getLL('ll_change_password_nolinkprefix_message');
		}
		$msg = sprintf($this->pi_getLL('ll_forgot_validate_reset_password'), ucwords( $user['userfullname'] ), $link, $validEndString);
		// Add hook for extra processing of mail message
		if (
				isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['forgotPasswordMail'])
				&& is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['forgotPasswordMail'])
		) {
			$params = array(
					'message' => &$msg,
					'user' => &$user
			);
			foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['forgotPasswordMail'] as $reference) {
				if ($reference) {
					GeneralUtility::callUserFunction($reference, $params, $this);
				}
			}
		}
		// no RDCT - Links for security reasons
		$oldSetting = $GLOBALS['TSFE']->config['config']['notification_email_urlmode'];
		$GLOBALS['TSFE']->config['config']['notification_email_urlmode'] = 0;
		// Send the email
		$this->cObj->sendNotifyEmail($msg, $user['email'], '', $this->conf['email_from'], $this->conf['email_fromName'], $this->conf['replyTo']);
		// Restore settings
		$GLOBALS['TSFE']->config['config']['notification_email_urlmode'] = $oldSetting;
		return '';
	}
}
?>
