<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Arun Chandran <arun@tnt-graphics.ch>, TNT Graphics
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

/**
 * TeaserController
 */
class Tx_TntBlumenshop_Controller_TeaserController extends Tx_Extbase_MVC_Controller_ActionController {

	public $tntblumenshopModel;
	
	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		 $this->tntblumenshopModel = new Tx_TntBlumenshop_Domain_Model_Blumenshop();
	}

    /**
     * action teaserView
     *
     * @return void
     */
    public function teaserViewAction() {
        //	Fetch flexform content
		$flexformArray = $this->settings['flexform_teaser'];
		
    	if( !empty( $flexformArray['teaserImage'] ) ){
       		$flexformArray['teaserImagePath'] = $this->tntblumenshopModel->doGetTeaserImages( $flexformArray['teaserImage'] );
       	}
		
     	if( !empty( $flexformArray['teaserLink'] ) ){
            if( strpos( $flexformArray['teaserLink'], "_blank" ) ){
  	       		$explodeUrl = explode( " ", $flexformArray['teaserLink'] );
  	       		$urlvalue = $explodeUrl[0]; 
      	    }else{
      	     	$urlvalue = $flexformArray['teaserLink'];
      	    }
            if( is_numeric( $urlvalue ) ){
              	$link = array(
          			 'parameter' => $urlvalue,
          			 'additionalParams' => '',
          			 'forceAbsoluteUrl' => true,
          			 'useCashHash' => true,
          			 'returnLast' => 'url',
      			 );
			  	//$flexformArray[ 'targetLink' ] = $GLOBALS['TSFE']->cObj->typoLink('', $link);
			  	$this->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("tslib_cObj");
			  	$flexformArray[ 'targetLink' ] = $this->cObj->typoLink('', $link);
      			 
             }else{
             	if ( !preg_match( "~^(?:f|ht)tps?://~i", $urlvalue ) ) {
    		        $flexformArray[ 'targetLink' ] = "http://".$urlvalue;
    		    }else{
    		    	$flexformArray[ 'targetLink' ] = $urlvalue;	
    		    }
            }
       	}else{
           $flexformArray[ 'targetLink' ] = '';
       	}
       	
       	if( !empty( $flexformArray['teaserText'] ) ){
       		$flexformArray[ 'teaserContent' ] = str_replace( '</b>', '</strong>', str_replace( '<b>', '<strong class="theme-blue">', $flexformArray['teaserText'] ) );	
       	}
       	
       	$this->view->assign( 'flexformArray', $flexformArray );
    }
}
