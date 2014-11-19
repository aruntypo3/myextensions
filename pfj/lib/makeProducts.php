<?php
/**
 * Plugin 'Cart' for the 'pfj' extension.
 *
 * @author Arun Chandran <arun.c@pitsolutions.com>
 * @package TYPO3
 * @subpackage pfj
 *
 */
require_once(PATH_tslib.'class.tslib_pibase.php');
require_once(PATH_tslib.'class.tslib_fe.php');
require_once(t3lib_extMgm::extPath(pfj).'pi1/class.tx_pfj_pi1.php');

class makeProducts extends tslib_pibase {
	// make configurations
	public $prefixId = 'pfj_eID';
	public $scriptRelPath = 'lib/makeProducts.php';
	public $extKey = 'pfj';
	public function __construct() {
      tslib_eidtools::connectDB();
      $this->cObj = t3lib_div::makeInstance('tslib_cObj');
  }
  function main() {
    	$this->feUserObj = tslib_eidtools::initFeUser();
    	if ( $_POST['action'] != '' && $_POST['action'] == 'addToBasket' ) {
      		echo $this->addToBasket();
      		exit;
    	}
      if ( $_POST['action'] != '' && $_POST['action'] == 'deleteFromBasket' ) {
      		echo $this->deleteFromBasket();
      		exit;
    	}
      if ( $_POST['action'] != '' && $_POST['action'] == 'clearAll' ) {
      		echo $this->clearAll();
      		exit;
    	}

      if ( $_POST['action'] != '' && $_POST['action'] == 'checkOut' ) {
      		echo $this->checkOut();
      		exit;
    	}

        if ( $_POST['action'] != '' && $_POST['action'] == 'placeOrder' ) {
      		echo $this->placeOrder();
      		exit;
    	}
    	
    	if ( $_GET['action'] != '' && $_GET['action'] == 'qtyChange' ) {
      		echo $this->qtyChange();
      		exit;
    	}
      
    }
  //Function addToBasket  
	function addToBasket() {
		session_start();
	    $this->feUserObj = tslib_eidtools::initFeUser();
	    $feuid = $this->feUserObj->user['uid'];
		  if( !in_array($_POST['productID'], $_SESSION['tx_pfj']['cartRecords_'.$feuid] ) ) {
	    			$_SESSION['tx_pfj']['cartRecords_'.$feuid][] = $_POST['productID'];
	    			$_SESSION['tx_pfj']['qtyKey_'.$_POST['productID']] = 1;
	    		}
    	$totalprice = 0;
    	foreach ($_SESSION['tx_pfj']['cartRecords_'.$feuid] as $key => $value) {
	   		$res = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_pfj_items', 'uid='.$value.' AND deleted = 0 AND hidden = 0');
	   		$intPrice = str_replace(',', '', trim($res[0]['sellingprice'],"$"));
	   		$newPriceVal = $intPrice * $_SESSION['tx_pfj']['qtyKey_'.$_POST['productID']];
        if( empty( $_SESSION['tx_pfj']['pricekey_'.$value] ) ){
            $_SESSION['tx_pfj']['pricekey_'.$value] = '$'.number_format($newPriceVal, 2, '.', '');
        }
	   		$totalprice += $newPriceVal;
	   	}
	   	$_SESSION['tx_pfj']['totalPrice'] = '$'.number_format($totalprice, 2, '.', '');
	   	echo count( $_SESSION['tx_pfj']['cartRecords_'.$feuid] );
		exit;
	}

   //Function removeFromBasket
    function deleteFromBasket() {
  		session_start();
	    $this->feUserObj = tslib_eidtools::initFeUser();
	    $feuid = $this->feUserObj->user['uid'];
	    
		$deleteItem = array_search( $_POST['itemID'], $_SESSION['tx_pfj']['cartRecords_'.$feuid] );
   		unset( $_SESSION['tx_pfj']['cartRecords_'.$feuid][$deleteItem] );
   		unset( $_SESSION['tx_pfj']['qtyKey_'.$_POST['itemID']]);

    	$totalprice = 0;
    	foreach ($_SESSION['tx_pfj']['cartRecords_'.$feuid] as $key => $value) {
	   		$res = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_pfj_items', 'uid='.$value.' AND deleted = 0 AND hidden = 0');
	   		$intPrice = str_replace(',', '', trim($res[0]['sellingprice'],"$"));
	   		$newPriceVal = $intPrice * $_SESSION['tx_pfj']['qtyKey_'.$value];
	   		$_SESSION['tx_pfj']['pricekey_'.$value] = '$'.number_format($newPriceVal, 2, '.', '');
	   		$totalprice += $newPriceVal;
	   	}
	   	$_SESSION['tx_pfj']['totalPrice'] = '$'.number_format($totalprice, 2, '.', '');
	    $deleteArray['itemCount'] = count( $_SESSION['tx_pfj']['cartRecords_'.$feuid] );
	    $deleteArray['totalPrice'] = $_SESSION['tx_pfj']['totalPrice'];
	    echo json_encode($deleteArray);
	    exit;	
   		}
    
     //Function clearAll
    function clearAll() {
      session_start();
      $this->feUserObj = tslib_eidtools::initFeUser();
      $feuid = $this->feUserObj->user['uid'];
      session_unset( $_SESSION['tx_pfj'] );
      echo count( $_SESSION['tx_pfj'] );
      exit;
    }

    //Function CheckOut
    public function checkOut() {
       $this->feUserObj = tslib_eidtools::initFeUser();
       $feuid = $this->feUserObj->user['uid'];
       $chkOut = t3lib_div::makeInstance('tx_pfj_pi1');
       $chkOut->checkOutCart($feuid);
       exit();
    }
    
    //Function Place Order
    public function placeOrder() {
       $this->feUserObj = tslib_eidtools::initFeUser();
       $feuid = $this->feUserObj->user['uid'];
       $plsOrder = t3lib_div::makeInstance('tx_pfj_pi1');
       $plsOrder->placeOrderItems($feuid);
       exit();
    }
    
    public function qtyChange() {
    	session_start();
    	$this->feUserObj = tslib_eidtools::initFeUser();
      	$feuid = $this->feUserObj->user['uid'];
      	$totalprice = 0;
      	foreach ($_SESSION['tx_pfj']['cartRecords_'.$feuid] as $key => $value) {
      		foreach ( $_POST['quantity'] as $quantityKey => $quantityVal) {
      			if ($value == $quantityKey) {
      				$res = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_pfj_items', 'uid='.$value.' AND deleted = 0 AND hidden = 0');
					  $_SESSION['tx_pfj']['qtyKey_'.$quantityKey] = $quantityVal;
	   				  $intPrice = str_replace(',', '', trim($res[0]['sellingprice'],"$"));
	   				  $newPriceVal = $intPrice * $_SESSION['tx_pfj']['qtyKey_'.$quantityKey];
	   				  $_SESSION['tx_pfj']['pricekey_'.$value] = '$'.number_format($newPriceVal, 2, '.', '');
	   				  $totalprice += $newPriceVal;
      			}
      		}
      	}
      	$_SESSION['tx_pfj']['totalPrice'] = '$'.number_format($totalprice, 2, '.', '');
	      $newCart['totalPrice'] = $_SESSION['tx_pfj']['totalPrice'];
	      echo $newCart['totalPrice'];
    	  exit;
    }

}
$makeProducts =t3lib_div::makeInstance('makeProducts');
$makeProducts->main();	
?>		