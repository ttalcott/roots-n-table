<?php
namespace Edu\Cnm\Rootstable;
require_once (dirname(__DIR__, 2) . "/classes/autoload.php");
require_once (dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable\Product;

/**
* api for the Cart
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

//temporary for testing only!!!!!!!!!!!!!!!!!
if(isset($_SESSION["cart"]) === false) {
	$_SESSION["cart"] = [];
}

try {
	//grab the SQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine what HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	if($method === "GET") {
		//set xsrf cookie
		setXsrfCookie();
		$reply->data = $_SESSION["cart"];

	} elseif($method === "POST") {
		//verify XSRF cookie
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode("requestContent");

		$productId = filter_var($requestObject->productId, FILTER_VALIDATE_INT);
		$cartQuantity = filter_var($requestObject->cartQuantity, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

		//retrieve the product information to update the session cart
		$product = Product::getProductByProductId($pdo, $id);
		if($product === null) {
			throw(new \RuntimeException("product does not exist", 404));
		}

		$_SESSION["cart"][$requestObject->productId] = $requestObject->cartQuantity;
		if($cartQuantity == 0) {
			unset($_SESSION["cart"][$productId]);
		}
		//update the session cart
		$_SESSION["cart"][] = $product;

	} else if ($method === "DELETE") {
		$_SESSION["cart"] = [];
	} elseif ($method === "PUT") {
		throw(new \InvalidArgumentException("HTTP method not allowed", 418));
	}
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->code();
	$reply->message = $typeError->getMessage();
}

//set up the header response
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and reply to caller
echo json_encode($reply);
