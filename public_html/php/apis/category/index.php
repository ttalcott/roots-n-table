<?php
require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable\Category;

/**
* api for the Category class
*
* @author Travis Talcott <ttalcott@lyradevelopment.com>
**/

//verify the session, if not active start it
if($session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the SQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/category.ini");

	//determine what HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize all inputs
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$categoryName = filter_input(INPUT_GET, "categoryName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//handle GET request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a category by category id
		if(empty($id) === false) {
			$category = Category::getCategoryByCategoryId($pdo, $id);
			if($category !== null) {
				$reply->data = $category;
			}
			//get a category by category name
		} else if(empty($categoryName) === false) {
			$category = Category::getCategoryByCategoryName($pdo, $categoryName);
			if($category !== null) {
				$reply->data = $category;
			}
			//for all other cases get all categories
		} else {
			$categories = Category::getAllCategory($pdo);
			if($categories !== null) {
				$reply->data = $categories;
			}
		}
	}
	//end of the try block... catch exceptions
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

 ?>
