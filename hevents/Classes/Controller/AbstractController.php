<?php
abstract class Tx_Hevents_Controller_AbstractController extends Tx_Extbase_MVC_Controller_ActionController {
	
	protected function addJQ($ui = true){
		if((int)$this->settings['addJQuery']==1){
			$this->response->addAdditionalHeaderData('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/'.$this->settings['JQueryVerion'].'/jquery.min.js"></script>');
			if($ui){
				$this->response->addAdditionalHeaderData('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/'.$this->settings['JQueryUiVerion'].'/jquery-ui.min.js"></script>');
				$this->response->addAdditionalHeaderData('<link media="all" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/'.$this->settings['JQueryUiVerion'].'/themes/base/jquery-ui.css" rel="stylesheet" />');
				$theme = empty($this->settings['jQueryThemeCss']) ? "http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" : $this->settings['jQueryThemeCss'];
				$this->response->addAdditionalHeaderData('<link media="all" type="text/css" href="'.$theme.'" rel="stylesheet" />');
			}
		}
	}
	
	/**
	* @param string $templateName template name (UpperCamelCase)
	* @param array $variables variables to be passed to the Fluid view
	* @return string
	*/
	protected function templateView($templateName, array $variables = array()) {
		$emailView = $this->objectManager->create('Tx_Fluid_View_StandaloneView');
		$emailView->setFormat('html');
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$templateRootPath = t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
		
		$templatePathAndFilename = $templateRootPath . $templateName ;
		$emailView->setTemplatePathAndFilename($templatePathAndFilename);
		$emailView->assignMultiple($variables);
		return $emailView->render();
	}

	
	protected function mail_typo($to, $subject, $message, $from, $cc='', $bcc='',$attachments=array(), $html=false){
		$mail = t3lib_div::makeInstance('t3lib_mail_Message');
		$mail->setFrom(array($from));
		$mail->setTo(array($to));
		$mail->setSubject($subject);
		if($html){
			$mail->setBody($message, 'text/html');
		}else{
			$mail->setBody($message, 'text/plain');
		}
		if(!empty($cc)){
			$ccs = explode(',', $cc);
			foreach($ccs as $c){
				$mail->addCc(trim($c));
			}
		}
		if(!empty($bcc)){
			$bccs = explode(',', $bcc);
			foreach($bccs as $bc){
				$mail->addBcc(trim($bc));
			}
		}
		
		foreach($attachments as $attachment){
			if(is_file($attachment)){
				$attachment = Swift_Attachment::fromPath($attachment);
				$mail->attach($attachment);
			}
		}
		$mail->send();
	}
}
?>