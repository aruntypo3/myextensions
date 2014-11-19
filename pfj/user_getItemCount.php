<?php 
require_once(t3lib_extMgm::extPath(pfj).'lib/makeProducts.php');
require_once(t3lib_extMgm::extPath(pfj).'pi1/class.tx_pfj_pi1.php');
require_once(PATH_tslib.'class.tslib_pibase.php');

class user_getItemCount {
	function getItem() {
	      $ItemCount = 0;
	  		if ($this->countAllProducts() > 0) {
	  			$ItemCount = $this->countAllProducts();
	  		}
	      $basketPid = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_pfj_pi1.']['basketPid'];
	      $cObj = t3lib_div::makeInstance("tslib_cObj");
	      $pagelink = $cObj->typoLink_URL(array('parameter' => $basketPid));
	      $stockistsGroupId = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_pfj_pi1.']['stockistsUsergroupId'];
	   	  $productItem = '<li class="first"><a href='.$pagelink.'><span id="item_count">'.$ItemCount.'</span>&nbsp;ITEM(S)</a></li>'; 	
	
	   	  $usergroupArray = explode(',', $GLOBALS['TSFE']->fe_user->user['usergroup']);
	  	  if( in_array( $stockistsGroupId, $usergroupArray ) ) {
	  			return $productItem;
	  		}
	}
  
	//Function returns item count from session
	function countAllProducts(){
		session_start();
    	$feuid = $GLOBALS['TSFE']->fe_user->user['uid'];
		return count( $_SESSION['tx_pfj']['cartRecords_'.$feuid] );
	}
}
?>
