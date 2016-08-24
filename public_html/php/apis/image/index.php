<?php

require_once "autoloader.php";
require_once "lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\Rootstable;

/**API for images
 *
 * @author Raúl Villarreal  <rvillarrcal@cnm.edu>
 */

	//verify the session, start if not active
	if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

	//prepare an empty reply
	$reply = new stdClass();
	$reply->status = 200;
	$reply->data = null;

try{
	//grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"]:
		$_SERVER["REQUEST_METHOD"];

	//sanitize input
	$imageId = filter_input(INPUT_GET, "imageId", FILTER_VALIDATE_INT);
	$imageType = filter_input(INPUT_GET, "imageType", FILTER_SANITIZE_STRING);
	$imagePath = filter_input(INPUT_GET, "imagePath", FILTER_SANITIZE_STRING);

	//handle GET request - if id is present, that image is returned, otherwise all images are returned
	if($method === "GET"){
		//set XSRF cookie
		setXsrfCookie();
	}

	//get a specific image by image id
	if(empty($imageId) === false){
		$image = Image::getImageByImageId($pdo, $imageId);
		if($image !== null){
			$reply->data = $image;
		}
	}

	// get a specific image by image path
	if(empty($imagePath) === false){
		$image = Image::getImageByImagePath($pdo, $imagePath);
		if($image !== null) {
			$reply->data = $image;
		}
	}

	//get images by image type
	if(empty($imageType) === false){
		$images = Image::getImageByImageType($pdo, $imageType);
		if($images !== null) {
			$reply->data = $images;
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





	//update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}









//loading of images starts here
$type = false;
function openImage($file){
	//detect type and process according to it
	global $type;
	$size = getimagesize($file);
	switch($size["mime"]){
		//in case the file is a .jpeg
		case "image/jpeg":
			$im = imagecreatefromjpeg($file);
			break;
		//in case the file extension is .png
		case "image/png":
			$im = imagecreatefrompng($file);
			break;
		default:
			$im = false;
			break;
	}
	return $im;
}