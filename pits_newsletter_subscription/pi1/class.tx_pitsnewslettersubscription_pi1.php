<?php
/***************************************************************
 *  Copyright notice
*
*  (c) 2012 Arun Chandran <arun.c@pitsolutions.com>
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
***************************************************************/

// require_once(PATH_tslib . 'class.tslib_pibase.php');

/**
 * Plugin 'pits_newsletter_subscription' for the 'pits_newsletter_subscription' extension.
*
* @author	Arun Chandran <arun.c@pitsolutions.com>
* @package	TYPO3
* @subpackage	tx_pitsnewslettersubscription
*/
class tx_pitsnewslettersubscription_pi1 extends tslib_pibase {
	public $prefixId      = 'tx_pitsnewslettersubscription_pi1';		// Same as class name
	public $scriptRelPath = 'pi1/class.tx_pitsnewslettersubscription_pi1.php';	// Path to this script relative to the extension dir.
	public $extKey        = 'pits_newsletter_subscription';	// The extension key.
	public $pi_checkCHash = FALSE;

	/**
	 * The main method of the Plugin.
	 *
	 * @param string $content The Plugin content
	 * @param array $conf The Plugin configuration
	 * @return string The content that is displayed on the website
	 */
	public function main($content, array $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_initPIflexform();
		$this->lConf = array();
		$this->pi_USER_INT_obj=1;
			
		$template = $this->cObj->fileResource('EXT:'.$this->extKey.'/template.html');
		$subpart = $this->cObj->getSubpart($template, '###PITSNEWSLETTER###');
		$markerArray['###MSG###'] = "";
		$markerArray['###VALIDMSG###'] = "";
		$markerArray['###FOCUS_SCRIPT###'] = "";
		$email = $_POST['sub_email'];


		//Added by siva@pits On 24-1-2014
		if ( $_REQUEST["cmd"]  == "unsubscribe" ){
			$userId = explode( "_" , $_REQUEST["rid"] );
			if ( $userId[0]  == 'f' ){
				$where = "uid=".$userId[1];
				$table = "fe_users";
				$fields_values["tx_tntfeuser_newsletter"] = 1;
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields = '');
			}
		}
		//Added by siva@pits On 24-1-2014

			
		$piFlexForm = $this->cObj->data['pi_flexform'];
		foreach ( $piFlexForm['data'] as $sheet => $data ) {
			foreach ( $data as $lang => $value ) {
				foreach ( $value as $key => $val ) {
					$this->lConf[$key] = $this->pi_getFFvalue($piFlexForm, $key, $sheet);
				}
			}
		}

		if ($this->lConf['show_successmsg'] == 1){
			$reghashValue = t3lib_div::_GP('tx_pitsnewslettersubscription_pi1');
			if ( $reghashValue['regHash'] == md5('1') ) {
				$subpart = $this->cObj->getSubpart($template, '###PITSNEWSLETTER_SUCCESS###');
				$updateArray['hidden'] = 0;
				$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tt_address', 'uid = "'.$this->piVars["uid"].'"', $updateArray);
				$markerArray['###SUCCESS_MESSAGE###'] = $this->pi_getLL('regsuccess_msg');
				$content = $this->cObj->substituteMarkerArrayCached($subpart, $markerArray);
				return $content;
			}
		}

		if( isset( $_POST['submit'] ) && empty( $this->lConf['show_successmsg'] ) ){
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid,email,hidden,deleted','tt_address','email = "'.$email.'"');
			while($row=mysql_fetch_assoc($res)) {
				$return[] = $row;
			}

			$to = $email;
			$subject = "Newsletter Subscribed";
			$from_email = $this->lConf['from_email'];
			$from_name = $this->lConf['from_name'];

			$mail = t3lib_div::makeInstance('t3lib_mail_Message');
			$mail->setFrom(array($from_email => $from_name));
			$mail->setTo($to);

			if(count($return) > 0){
				if (($return[0]['hidden'] == 1) || ($return[0]['deleted'] == 1)){
					$value = array();
					$value['pid'] = $this->lConf['storage_folder'];
					$value['hidden'] = 1;
					$value['deleted'] = 0;
					$value['module_sys_dmail_html'] = 1;
					$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tt_address', 'uid = "'.$return[0]['uid'].'"', $value);
					$markerArray['###MSG###'] = "success";
					$markerArray['###VALIDMSG###'] = $this->pi_getLL('success_message');
					$mail_content = $this->activationLink( $return[0]['uid'] );
					$mail->setSubject("Cyclinfo.ch: Bitte bestätigen Sie Ihre Anmeldung");
					$mail->setBody($mail_content, 'text/html');
					$mail->send();
				}else{
					$markerArray['###MSG###'] = "error";
					$markerArray['###VALIDMSG###'] = $this->pi_getLL('error_message');
				}
			}else{
				$insertArray = array();
				$insertArray['email'] = $email;
				$insertArray['pid'] = $this->lConf['storage_folder'];
				$insertArray['hidden'] = 1;
				$insertArray['deleted'] = 0;
				$insertArray['module_sys_dmail_html'] = 1;
				$res1 = $GLOBALS['TYPO3_DB']->exec_INSERTquery('tt_address', $insertArray);
				$mail_content = $this->activationLink( $GLOBALS['TYPO3_DB']->sql_insert_id() );
				$markerArray['###MSG###'] = "success";
				$markerArray['###VALIDMSG###'] = $this->pi_getLL('success_message');
				$mail->setSubject("Cyclinfo.ch: Bitte bestätigen Sie Ihre Anmeldung");
				$mail->setBody($mail_content, 'text/html');
				$mail->send();
			}
		}
		return $this->cObj->substituteMarkerArray($subpart, $markerArray);
	}

	//Activation Link Generation
	public function activationLink( $linkValue ){
		$conf = array(
				'parameter' => $this->lConf['success_page'],
				'additionalParams' => '&tx_pitsnewslettersubscription_pi1[regHash]='.md5('1').'&tx_pitsnewslettersubscription_pi1[uid]='.$linkValue,
				'forceAbsoluteUrl' => true,
				'useCashHash' => true,
				'returnLast' => 'url',
		);
		$url = $this->cObj->typoLink('', $conf);
		$mail_message = sprintf($this->pi_getLL('mail_msg'),$url,$url);
		return $mail_message;
	}

}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/pits_newsletter_subscription/pi1/class.tx_pitsnewslettersubscription_pi1.php'])) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/pits_newsletter_subscription/pi1/class.tx_pitsnewslettersubscription_pi1.php']);
}

?>