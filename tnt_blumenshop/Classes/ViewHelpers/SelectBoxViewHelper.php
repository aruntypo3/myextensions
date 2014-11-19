<?php

/**
 * This class is a demo view helper for the Fluid templating engine.
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_TntBlumenshop_ViewHelpers_SelectBoxViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
     * Renders some classic dummy content: Lorem Ipsum...
     *
     * @param int $length The number of characters of the dummy content
     * @validate $length IntegerValidator
     * @return string dummy content, cropped after the given number of characters
     * @author Lorem Ipsum <lorem@example.com>
     */
	public function render($length) {
		$options = explode ( ',' , $length ) ;

		$value = (string)$options[0];
		$storedata = (string)$options[1];
		$title = (string)$options[2];
		$content = '';
		$content = '<option value = '.$value.'>'.trim($title).'</option>';
        if ( $value  ==  $storedata ){
			$content = '<option value = '.$value.'  SELECTED>'.trim($title).'</option>';
		}
		return $content;
    }
}

?>