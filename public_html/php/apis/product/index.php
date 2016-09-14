<?php
require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable\{
	Product, Profile, Unit
};

/** API for the Product class
 *
 * @author Raúl Villarreal <rvillarrcal@cnm.edu>
 **/

//verify the session, start if not active

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] :
		$_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$productProfileId = filter_input(INPUT_GET, "productProfileId", FILTER_VALIDATE_INT);
	$productUnitId = filter_input(INPUT_GET, "productUnitId", FILTER_VALIDATE_INT);
	$productDescription = filter_input(INPUT_GET, "productDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$productionName = filter_input(INPUT_GET, "productName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$productPrice = filter_input(INPUT_GET, "productPrice", FILTER_VALIDATE_FLOAT);


//make sure the information is valid for methods that require it
	if(($method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	} 
	if($method === "DELETE") {
		throw(new \Exception("This action is forbidden", 405));
	}

	//handle GET request - if  id is present, that product is returned, otherwise all product are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific product by productId
		if(empty($id) === false) {

			//make sure the profile has access only to its own product
			$product = Product::getProductByProductId($pdo, $id);
			//get the product
		}
		if($product !== null) {
			$reply->data = $product;
		} //get product by productProfileId
		elseif(empty($productProfileId) === false) {
			$product = Product::getProductByProductProfileId($pdo, $productProfileId);
			if($product !== null) {
				$reply->data = $product;
			}
			//get product by product unit id
		} elseif(empty($productUnitId) === false) {
			$product = Product::getProductByProductUnitId($pdo, $productUnitId);
			if($product !== null) {
				$reply->data = $product;
			}
			//get product by product description
		} elseif(empty($productDescription) === false) {
			$product = Product::getProductByProductDescription($pdo, $productDescription);
			if($product !== null) {
				$reply->data = $product;
			}
			//get product by product name
		} elseif(empty($productionName) === false) {
			$product = Product::getProductByProductName($pdo, $productionName);
			if($product !== null) {
				$reply->data = $product;
			}
			//get product by product price
		} elseif(empty($productPrice) === false) {
			$product = Product::getProductByProductPrice($pdo, $productPrice);
			if($product !== null) {
				$reply->data = $product;
			}
			//get all product
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

		//make sure product unit id information is available
		if(empty($requestObject->productUnitId) === true) {
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

		//perform the actual put or post
		if($method === "PUT") {

			//retrieve the product to update
			$product = Product::getProductByProductId($pdo, $id);
			if($product === null) {
				throw(new \RuntimeException("Product does not exist", 404));
			}

			if((empty($_SESSION["profile"]) === true) || ($_SESSION["profile"]->getProfileId() !== $product->getProductProfileId())) {
				throw(new \InvalidArgumentException("cannot change these when you are not logged in", 403));
			}

			//put the new product description into the product and update
			$product->setProductDescription($requestObject->productDescription);
			$product->update($pdo);

			//put the new product name into the product and update
			$product->setProductName($requestObject->productName);
			$product->update($pdo);

			//put the new product price into the product and update
			$product->setProductPrice($requestObject->productPrice);
			$product->update($pdo);

			//update reply
			$reply->message = "Product updated OK";
		} else if($method === "POST") {


			//create new product and insert into the database
			$product = new Product(null, $_SESSION["profile"]->getProfileId(),  $requestObject->productUnitId, $requestObject->productDescription, $requestObject->productName, $requestObject->productPrice);
			$product->insert($pdo);
			//update reply
			$reply->message = "Product created Ok";
		}
	}
	//update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
//encode and return reply to front end caller
echo json_encode($reply);

?>