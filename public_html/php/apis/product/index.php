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
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] :
		$_SERVER["REQUEST_METHOD"];

	//sanitize input
	$productId = filter_input(INPUT_GET, "productId", FILTER_VALIDATE_INT);
	$productProfileId = filter_input(INPUT_GET, "productProfileId", FILTER_VALIDATE_INT);
	$productUnitId = filter_input(INPUT_GET, "productUnitId", FILTER_VALIDATE_INT);
	$productDescription = filter_input(INPUT_GET, "productDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$productionName = filter_input(INPUT_GET, "productName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$productPrice = filter_input(INPUT_GET, "productPrice", FILTER_VALIDATE_FLOAT);

//make sure the information is valid for methods that require it
	if(($method === "GET" || $method === "PUT") && (empty($productId) === true || $productId < 0)) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	}elseif(($method === "GET" || $method === "PUT") && (empty($productProfileId) === true || $productProfileId < 0)){
		throw(new \InvalidArgumentException("profile id shoud not be empty or negative", 405));
	}elseif(($method === "GET" || $method === "PUT") && (empty($productUnitId) === true || $productUnitId < 0)){
		throw(new \InvalidArgumentException("Unit id shoud not be empty or negative", 405));
	}elseif(($method === "GET" || $method === "PUT") && (empty($productDescription) === true)){
		throw(new \InvalidArgumentException("Description should not be empty", 405));
	}elseif(($method === "GET" || $method === "PUT") && (empty($productionName) === true)){
		throw(new \InvalidArgumentException("Name should not be empty", 405));
	}elseif(($method === "GET" || $method === "PUT") && (empty($productPrice) === true || $productPrice < 0)){
		throw(new \InvalidArgumentException("Price should not be empty or negative", 405));
	}

		//handle GET request - if  id is present, that product is returned, otherwise all products are returned
		if($method === "GET") {
			//set XSRF cookie
			setXsrfCookie();

			//get a specific product by productId
			if(empty($productId) === false) {
				$product = Product::getProductByProductId($pdo, $productId);
				if($product !== null) {
					$reply->data = $product;
				}
				//get products by	productProfileId
			} elseif(empty($productProfileId) === false) {
				$product = Product::getProductByProductProfileId($pdo, $productProfileId);
				if($product !== null) {
					$reply->data = $product;
				}
			} elseif(empty($productUnitId) === false) {
				$product = Product::getProductByProductUnitId($pdo, $productUnitId);
				if($product !== null) {
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
			} else {
				$products = Product::getAllProducts($pdo);
				if($products !== null) {
					$reply->data = $products;
				}
			}
		} else if($method === "PUT" || $method === "POST") {
			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);
		}
		//make sure product id information is available
		if(empty($requestObject->productProfileId) === true){
			throw(new \InvalidArgumentException("Insuficient information", 405));
		}

		//make sure product unit id information is available
		if(empty($requestObject->productUnitId) === true){
			throw(new \InvalidArgumentException("Insuficient information", 405));
		}

		//make sure product description is available
		if(empty($requestObject->productDescription) === true) {
			throw(new \InvalidArgumentException("Insuficient information", 405));
		}

		//make sure product name is available
		if(empty($requestObject->productName) === true) {
			throw(new \InvalidArgumentException("Insuficient information", 405));
		}

		//make sure product price is available
		if(empty($requestObject->productPrice) === true) {
			throw(new \InvalidArgumentException("Insuficient information", 405));
		}

	
	}



