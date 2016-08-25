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
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] :
		$_SERVER["REQUEST_METHOD"];

	//sanitize input
	$imageId = filter_input(INPUT_GET, "imageId", FILTER_VALIDATE_INT);
	$imageType = filter_input(INPUT_GET, "imageType", FILTER_SANITIZE_STRING);
	$imagePath = filter_input(INPUT_GET, "imagePath", FILTER_SANITIZE_STRING);

	//handle GET request - if id is present, that image is returned, otherwise all images are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
	}

	//get a specific image by image id
	if(empty($imageId) === false) {
		$image = Image::getImageByImageId($pdo, $imageId);
		if($image !== null) {
			$reply->data = $image;
		}
	}

	// get a specific image by image path
	if(empty($imagePath) === false) {
		$image = Image::getImageByImagePath($pdo, $imagePath);
		if($image !== null) {
			$reply->data = $image;
		}
	}

	//get images by image type
	if(empty($imageType) === false) {
		$images = Image::getImageByImageType($pdo, $imageType);
		if($images !== null) {
			$reply->data = $images;
		}
	} elseif($method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
	}
	//make sure there is a user to upload the image
	if(empty($requestObject->profileImageProfileId) === true) {
		throw(new \InvalidArgumentException("The user doesn't exists", 405));
	}

	//make sure the image path is available
	if(empty($requestObject->imagePath) === true) {
		throw(new \InvalidArgumentException("The image path is already in use", 405));
	}

	//make sure the image type is available
	if(empty($requestObject->imageType) === true) {
		throw(new \InvalidArgumentException("The image name does not exist", 405));
	}

	//make sure the image type is a valid one
	if(empty($requestObject->imageType) === true) {
		throw(new \InvalidArgumentException("The image type should be .png .jpg or .jpeg"));
	} elseif($method === "POST") {

		// image sanitization process
		//create an array of valid image extensions and valid image MIME types
		$validExtensions = array(".jpg", ".jpeg", ".png");
		$validTypes = array("image/jpg", "image/jpeg", "image/png");

		// Assign variables to the user image name, MIME type and extract image entension
		$tempUserFileName = $_FILES["userImage"]["name"];
		$tempUserFileType = $_FILES["userImage"]["type"];
		$tempUserFileExtension = strrchr($_FILES["userImage"]["name"], ".");
	}

	//verify and ensure the file has a correct extension and MIME type
	if(!in_array($userFileExtension, $validExtensions) || (!in_array($userFileTypes, $validTypes))) {
		throw(new \InvalidArgumentException("That is not a valid image"));
	}

	//image creation when the extension is a valid one .jpg .jpeg or .png
	if($tempUserFileExtension === ".jpg" || $tempUserFileExtension === ".jpeg") {
		$sanitizedUserImage = imagecreatefromjpeg($tempUserFileName);
	} elseif($tempUserFileExtension === ".png") {
		$sanitizedUserImage = imagecreatefrompng($tempUserFileName);
	}

	// now the image needs to be scaled down to 350 pixels
	$scaledImage = imagescale($sanitizedUserImage, 350);

	//assign a temporary and safe name and location to the new file
	$tempUserFileName = round(microtime(true)) . $tempUserFileExtension;
	move_uploaded_file($_FILES["file"]["tmp_name"], "../img/tempImageDirectory/" . $tempUserFileName);

		if($tempUserFileExtension === ".jpg" || $tempUserFileExtension === ".jpeg") {
			$createdProperly = imagejpeg($sanitizedUserImage);
		} elseif($tempUserFileExtension === ".png") {
			$createdProperly = imagepng($sanitizedUserImage);
		}

		//put new image into the profile image database
		if($createdProperly === true) {
			$image = new Image(null, $requestObject->profileImageImageId, $newImagePath, $newImageType);
			$image->insert($pdo);

			//put new image into the product image database
			if($createdProperly === true) {
				$image = new Image(null, $requestObject->productImageImageId, $newImagePath, $newImageType);
				$image->insert($pdo);
			}
		} else if($method === "DELETE") {
			verifyXsrf();

			//retrieve the Image to be deleted
			$image = Image::getImageByImageId($pdo, $imageId);
			if($image === null) {
				throw(new \RuntimeException("Image does not exists", 404));
			}

			//delete image
			$image->delete($pdo);
		}
			//update reply with exception information
		}catch(Exception $exception){
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}catch(TypeError $typeError){
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}