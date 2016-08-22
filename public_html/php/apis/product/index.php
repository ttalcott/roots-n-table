<?php

require_once "autoloader.php";
require_once "lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\Rootstable;

/** API for the Product class
 *
 * @author Raúl Villarreal <rvillarrcal@cnm.edu>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->statu = 200;
$reply->data = null;

try {
	//grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"]:
		$_SERVER["REQUEST_METHOD"];

	//sanitize input
	$productId = filter_input(INPUT_GET, "productId", FILTER_VALIDATE_INT);
	$productProfileId = filter_input(INPUT_GET, "productProfileId", FILTER_VALIDATE_INT);
	$productUnitId = filter_input(INPUT_GET, "productUnitId", FILTER_VALIDATE_INT);
	$productDescription = filter_input(INPUT_GET, "productDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$productionName = filter_input(INPUT_GET, "productName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$productPrice = filter_input(INPUT_GET, "productPrice", FILTER_VALIDATE_FLOAT);

//make sure the id is valid for methods that require it
	if(($method === "PUT") && (empty($productId) === true || $productId < 0)){
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));

		//handle GET request - if  id is present, that product is returned, otherwise all products are returned
		if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific product by productId
		if(empty($productId) === false) {
			$product = Product::getProductByProductId($pdo, $productId);
			if($product !== null){
				$reply->data = $product;
			}
		//get products by	productProfileId
		} elseif(empty($productProfileId) === false){
			$product = Product::getProductByProductProfileId($pdo, $productProfileId);
			if($product !== null){
				$reply->data = $product;
			}
		} elseif(empty($productUnitId) === false) {
			$product = Product::getProductByProductUnitId($pdo, $productUnitId);
			if($product !== null){
				$reply->data = $product;
			}
		} elseif(empty($productDescription) === false) {
			$product = Product::getProductByProductDescription($pdo, $productDescription);
			if($product !== null) {
				$reply->data = $product;
			}
		} elseif(empty($productionName) === false) {
			$product = Product::getProductByProductName($pdo, $productionName);
			if($product !== null) {
				$reply->data = $product;
			}
		} elseif(empty($productPrice) === false) {
			$product = Product::getProductByProductPrice($pdo, $productPrice);
			if($product !== null) {
				$reply->data = $product;
			}
		}
		}
		}
	}



