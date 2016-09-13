<?php
namespace Edu\Cnm\Rootstable;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 2) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__, 4) . "/vendor/autoload.php");

use Edu\Cnm\Rootstable\{Purchase, Profile};

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

	$config = readConfig("/etc/apache2/capstone-mysql/rootstable.ini");
	$stripe = json_decode($config["stripe"]);



	if($method === "GET") {
		//set xsrf cookie
		setXsrfCookie();
		if((empty($_SESSION["profile"]) === true) && ($_SESSION["profile"]->getProfileId() !== $id)) {
			throw(new \InvalidArgumentException("cannot access purchases when you are not logged in", 403));
		}
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
		$requestObject = json_decode($requestContent);
		//
		// //make sure profileId is available
		// if(empty($_SESSION["profile"]->getProfileId()) === true) {
		// 	throw(new \InvalidArgumentException("No profile ID found", 405));
		// }

		if(empty($requestObject->customerEmail) === true) {
			throw(new \InvalidArgumentException("You must enter a valid email address", 405));
		}

		//preform the post
		if($method === "POST") {
			\Stripe\Stripe::setApiKey($stripe->privateKey);
			// Get the credit card details submitted by the form
			$token = $_POST['stripeToken'];

			$totalPrice = 0;

			$customer = \Stripe\Customer::create(array(
      'email' => $requestObject->customerEmail,
      'source'  => $token
  		));

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

	// 	//create transport
	// 	$smtp = Swift_SmtpTransport::newInstance("localhost", 25);
	// 	//create the mailer using the created transport
	// 	$mailer = Swift_Mailer::newInstance($smtp);
	//
	//
	// 	//create swift message
	// 	$swiftMessage = Swift_Message::newInstance();
	//
	// 	//attach the sender to the message
	// 	//this takes the form of an associtive array where the Email is the key for the real name
	// 	$swiftMessage->setFrom(["ttalcott@lyradevelopment.com" => "Roots-n-table"]);
	//
	// 	/**
	// 	 * attach the recipients to the message
	// 	 * This array can include or omit the recipient's real name
	// 	 * use the recipient's real name when possible to keep the message from being marked as spam
	// 	 */
	// 	$recipients = [$requestObject->profileEmail];
	// 	$swiftMessage->setTo($recipients);
	//
	// 	//attach the subject line to the message
	// 	$swiftMessage->setSubject("Roots 'n Table Recipt Attached'");
	//
	// // 	$message = <<< EOF
	// // 	<h1>Thank you for your business!</h1>
	// // <p></p>
	// // 	EOF;
	//
	// $message = <<< EOF
	// <h1>Thank you for your business!</h1>
	// <p></p>
	// EOF;
	//
	// 	$swiftMessage->setBody($message, "text/html");
	// 	$swiftMessage->addPart(html_entity_decode(filter_var($message, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)), "text/plain");
	//
	//
	// 	//send the message
	// 	$numSent = $mailer->send($swiftMessage, $failedRecipients);
	// 	/**
	// 	 * the send method returns the number of recipients that accepted the email
	// 	 * so, if the number attempted is not the number accepted, throw an exception
	// 	 */
	// 	if($numSent !== count($recipients)) {
	// 		//the $failedRecipients parameter passed in the send() method now contains an array of the emails that failed
	// 		throw(new \RuntimeException("unable to send email"));
	// 	}
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
