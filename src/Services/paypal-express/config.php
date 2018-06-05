<?php

//echo $_SESSION['urlPaypalSuccess'];

//start session in all pages
if (session_status() == PHP_SESSION_NONE) { session_start(); } //PHP >= 5.4.0
//if(session_id() == '') { session_start(); } //uncomment this line if PHP < 5.4.0 and comment out line above


//$oDataPayment = new paymentMethods();
//$aResPayment = $oDataPayment->getPayment_methods($getOneItem = FALSE, $bActives = FALSE,  $site= FALSE );

//print_r($aResPayment);
$is_sanbox =  0;//$aResPayment['paypal'][2]['is_sanbox'];
//$paypal_url= "content/paypal-express/process.php?paypal=checkout";//( $is_sanbox == 1)?'https://www.sandbox.paypal.com/cgi-bin/webscr':'https://www.paypal.com/cgi-bin/webscr'; // Test Paypal API URL

// sandbox or live
$enviroment = ($is_sanbox == 1)?"sandbox":"live";
define('PPL_MODE', $enviroment);

if(PPL_MODE=='sandbox'){
	//Sanbox

	define('PPL_API_USER', 'gialvarezlopez-facilitator_api1.gmail.com');
	define('PPL_API_PASSWORD', '4VHL94VJYXQ5BBNL');
	define('PPL_API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AbnaPDBzJsIvrpBjcMv95gKlRMcq');

}
else{
	//Production
	define('PPL_API_USER', 'gialvarezlopez-facilitator_api1.gmail.com');
	define('PPL_API_PASSWORD', '4VHL94VJYXQ5BBNL');
	define('PPL_API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AbnaPDBzJsIvrpBjcMv95gKlRMcq');
}

define('PPL_LANG', 'ES');

define('PPL_LOGO_IMG', ''); //Link de una imagen

//$urlSuccess = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
//$urlCancel =  "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];

define('PPL_RETURN_URL', URLSUCCESS); //Url que procesa la data
define('PPL_CANCEL_URL', URLCANCEL); //Url para cancelar la compra

define('PPL_CURRENCY_CODE', 'USD');

//exit();
