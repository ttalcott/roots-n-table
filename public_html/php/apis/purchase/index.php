<?php
namespace Edu\Cnm\Rootstable;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable\Purchase;

/**
* api for the Purchase class
*
* @author Travis Talcott <ttalcott@lyradevelopment.com>
**/

//verify the session, if not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the SQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine what HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize all inputs
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//profile id
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	//purchase stripe token
	$stripeToken = filter_input(INPUT_GET, "stripeToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	if(($method === "GET") && (empty($_SESSION["profile"]) === true) && ($_SESSION["profile"]->getProfileId() !== $id)) {
		throw(new \InvalidArgumentException("cannot access purchases when you are not logged in", 403));
	}

	if($method === "GET") {
		//set xsrf cookie
		setXsrfCookie();

		//get a purchase by purchase id
		if(empty($id) === false) {
			$purcahse = Purchase::getPurchaseByPurchaseId($pdo, $id);
			if($purchase !== null) {
				$reply->data = $purchase;
			}
			//get purchases by profile id
		} else if(empty($profileId) === false) {
			$purchases = Purchase::getPurchaseByPurchaseId($pdo, $profileId);
			if($purchases !== null) {
				$reply->data = $purchases;
			}
			//get purchase by stripe token
		} else if(empty($stripeToken) === false) {
			$purchase = Purchase::getPurchaseByPurchaseStripeToken($pdo, $stripeToken);
			if($purchase !== null) {
				$reply->data = $purchase;
			}
		}
		//handle the post method
	} else if($method === "POST") {
		//verify XSRF cookie
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode("requestContent");

		//make sure profileId is available
		if(empty($requestObject->profileId) === true) {
			throw(new \InvalidArgumentException("No profile ID found", 405));
		}
		//make sure stripe token is available
		if(empty($requestObject->stripeToken) === true) {
			throw(new \InvalidArgumentException("no stripe token found", 405));
		}

		//preform the post
		if($method === "POST") {
			// Get the credit card details submitted by the form
			$token = $_POST['stripeToken'];

			$totalPrice = 0;
			foreach($_SESSION["cart"] as $product) {
				// $product = Product::getProductByProductId($pdo, $product->getProductId());
				$totalPrice = $totalPrice + $product->getProductPrice();
				$productDescription = $product->getProductDescription();
			}
			// implode the $productDescription down here?
			$productDescriptionString = implode(", ", $productDescription);

			$totalPrice = $totalPrice * 100; // Price in cents, not dollars

			// Create a charge: this will charge the user's card
			try {
  			$charge = \Stripe\Charge::create(array(
    		"amount" => $totalPrice, // Amount in cents
    		"currency" => "usd",
    		"source" => $token,
    		"description" => $productDescriptionString
    		));
			} catch(\Stripe\Error\Card $e) {
  		// The card has been declined
			}
		}
	}
	//end of try block catch exceptions
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

//set up the response header
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and reply to caller
echo json_encode($reply);
