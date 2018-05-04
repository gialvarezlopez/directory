<?php
namespace Services;
//namespace AppBundle\Services;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author Owner
 */
/*
echo PPL_LANGx;
//require_once(__DIR__."/adauth/class.auth.php");
include_once(__DIR__."/paypal-express/class.connection.php");
include_once(__DIR__."/paypal-express/config.php");
include_once(__DIR__."/paypal-express/functions.php");
include_once(__DIR__."/paypal-express/paypal.class.php");
*/
class Paypal
{
	
	public function __construct()
	{
		//define('PPL_LANG', 'ES');
		
	}
	
	public function setParameterDB( $nameDB, $hostDB, $userDB, $passwordDB, $portDB, $urlSuccess, $urlCancel )
	{
		define('DATABASE_NAME', $nameDB);
		define('DATABASE_HOSTDB', $hostDB);
		define('DATABASE_USER', $userDB);
		define('DATABASE_PASSWORD', $passwordDB);
		define('DATABASE_PORT', $portDB);
		define("URLSUCCESS", $urlSuccess);
		define("URLCANCEL", $urlCancel);
		
		include_once(__DIR__."/paypal-express/class.connection.php");
		include_once(__DIR__."/paypal-express/config.php");
		include_once(__DIR__."/paypal-express/functions.php");
		include_once(__DIR__."/paypal-express/paypal.class.php");
	}
	
	public function viewTransactionPaypal($token, $PayerID){
		if( $token )
		{
			//$token=$_GET["token"];//Returned by paypal, you can save this in SESSION too			
			$paypal = new \MyPayPal();
			return $paypal->DoExpressCheckoutPayment();
		}
		
	}
	
	public function processPaypal( $clientId, $planId, $months, $paymentProcessorId, $is_checkout ){
		//session_start();
		$paypal= new \MyPayPal();
		//ECHO $planId;
		//echo $is_checkout;
		//exit();
		if( $is_checkout  == "checkout")
		{
			$products = array();
			$items = array();

			$number_item = 0;
			$_SESSION['planId'] = $planId;
			$_SESSION['months'] = $months;
			$_SESSION['clientId'] = $clientId;
			$_SESSION['paymentProcessorId'] = $paymentProcessorId;
			
			$plan = $paypal->getPriceProduct();
			$nameProduct = "Medical Directory";
			$descriptionProduct = $plan["description"];
			$idProduct = $planId; //$paypal->getLastId() + 1;
			//exit();
			$products[$number_item]['ItemName'] = $nameProduct; //Item Name
			$products[$number_item]['ItemPrice'] = $plan["currentPricing"]; //Item Price
			$products[$number_item]['ItemNumber'] = $idProduct; //Item Number
			//$extras = ( count( $detail_extras ) > 0)?" | ".implode("|", $detail_extras):"";
			$products[$number_item]['ItemDesc'] = $descriptionProduct; //Item Number
			$products[$number_item]['ItemQty'] = 1; // Item Quantity		

			//-------------------- prepare charges -------------------------

			$charges = array();

			//Other important variables like tax, shipping cost
			$charges['TotalTaxAmount'] = 0;  //Sum of tax for all items in this order. 
			$charges['HandalingCost'] = 0;  //Handling cost for this order.
			$charges['InsuranceCost'] = 0;  //shipping insurance cost for this order.
			$charges['ShippinDiscount'] = 0; //Shipping discount for this order. Specify this as negative number.
			$charges['ShippinCost'] = "";//$shipping; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.

			//------------------SetExpressCheckOut-------------------
			$_SESSION['products'] = $products;
			/*
				$_SESSION['products'] = $products;
				$_SESSION['email'] = ""; //$email;
				$_SESSION['picture'] = ""; //$picture;
				$_SESSION['description'] = ""; //$description;
				$_SESSION['link'] = ""; //$link;
			*/
			//We need to execute the "SetExpressCheckOut" method to obtain paypal token
			var_dump($products);
			$paypal->SetExpressCheckOut($products, $charges);	
		}
		else
		{
			$paypal->DoExpressCheckoutPayment();
		}
		//return "hello word";
	}
	// mas funciones 
}
