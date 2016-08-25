<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

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
	$imagePath = filter_input(INPUT_GET, "imagePath", FILTER_SANITIZE_STRING);
	$imageType = filter_input(INPUT_GET, "imageType", FILTER_SANITIZE_STRING);

	//make sure the information is valid for methods that require it
	if(($method === "DELETE") && (empty($imageId) === true || $imageId < 0)) {
		throw(new \InvalidArgumentException("Image id can not be negative or empty", 405));
	} elseif(($method === "PUT")) {
		throw(new \Exception("This action is forbidden", 405));
	}


	//handle GET request - if id is present, that image is returned, otherwise all images are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
	}

	//get a specific image by image id
	elseif(empty($imageId) === false) {
		$image = Image::getImageByImageId($pdo, $imageId);
		if($image !== null) {
			$reply->data = $image;
		}
	}

	// get a specific image by image path
	elseif(empty($imagePath) === false) {
		$image = Image::getImageByImagePath($pdo, $imagePath);
		if($image !== null) {
			$reply->data = $image;
		}
	}

	//get images by image type
	elseif(empty($imageType) === false) {
		$images = Image::getImageByImageType($pdo, $imageType);
		if($images !== null) {
			$reply->data = $images;
		}



	}if($method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
	}

/*	//make sure there is a user to upload the image
	if(empty($requestObject->profileImageProfileId) === true) {
		throw(new \InvalidArgumentException("The user doesn't exists", 405));
	}*/

	//make sure the image type is available
	if(empty($requestObject->imagePath) === true) {
		throw(new \InvalidArgumentException("The image path does not exist", 405));
	}

	//make sure the image type is a valid one
	if(empty($requestObject->imageType) === true) {
		throw(new \InvalidArgumentException("The image type should be .png .jpg or .jpeg"));

		// image sanitization process
		//create an array of valid image extensions and valid image MIME types
		$validExtensions = array(".jpg", ".jpeg", ".png");
		$validTypes = array("image/jpg", "image/jpeg", "image/png");

		// Assign variables to the user image name, MIME type and extract image entension
		//tmp_name is the name in the server, we should use that, it will delete itself once this process is over
		$tempUserFileName = $_FILES["userImage"]["tmp_name"];
		$tempUserFileType = $_FILES["userImage"]["type"];
		$tempUserFileExtension = strtolower(strrchr($_FILES["userImage"]["name"], "."));
	}

	//verify and ensure the file has a correct extension and MIME type
	if(!in_array($tempUserFileExtension, $validExtensions) || (!in_array($tempUserFileType, $validTypes))) {
		throw(new \InvalidArgumentException("That is not a valid image"));
	}

	//image creation when the extension is a valid one .jpg .jpeg or .png
	if($tempUserFileExtension === ".jpg" || $tempUserFileExtension === ".jpeg") {
		$sanitizedUserImage = imagecreatefromjpeg($tempUserFileName);
	} elseif($tempUserFileExtension === ".png") {
		$sanitizedUserImage = imagecreatefrompng($tempUserFileName);
	}else{
		throw(new \InvalidArgumentException("This is a not a valid image", 405));
	}
	if($sanitizedUserImage === false){
		throw(new \InvalidArgumentException("This is a not a valid image", 405));
	}

	// now the image needs to be scaled down to 350 pixels
	$imageScale = imagescale($sanitizedUserImage, 350);

/*	//assign a temporary and safe name and location to the new file
	$tempUserFileName = round(microtime(true)) . $tempUserFileExtension;

	/*move_uploaded_file($_FILES["file"]["tmp_name"], "../img/tempImageDirectory/" . $tempUserFileName);*/

	$newImageFileName = "/var/www.html/public_html/rootstable" . hash("ripemd160", microtime(true) === (true) + random_int(0,4294967296)) . $tempUserFileExtension;


	if($tempUserFileExtension === ".jpg" || $tempUserFileExtension === ".jpeg") {
		$createdProperly = imagejpeg($sanitizedUserImage);
	} elseif($tempUserFileExtension === ".png") {
		$createdProperly = imagepng($sanitizedUserImage, $newImageFileName);
	}

	//put new image into the database
	if($createdProperly === true) {
		$image = new Image(null, $requestObject->profileImageImageId, $tempUserFileType, $newImageFileName);
		$image->insert($pdo);

	} else if($method === "DELETE") {
		verifyXsrf();

		//retrieve the Image to be deleted
		$image = Image::getImageByImageId($pdo, $imageId);
		if($image === null) {
			throw(new \RuntimeException("Image does not exists", 404));
		}
		//unlink will delete the image from the server
		unlink($image->getImageFileName());
		//delete image
		$image->delete($pdo);
		$reply->message = "Image deleted";
	}else {
		throw(new \InvalidArgumentException("Invalid HTTP method request"));
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