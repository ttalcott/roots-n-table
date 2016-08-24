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
	}elseif($method === "POST"){
		verifyXsrf();
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);
}	if($method ==="POST"){
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure there is a user to upload the image
		if(empty($requestObject->profileImageProfileId) === true){
			throw(new \InvalidArgumentException("The user doesn't exists", 405));
		}

		//make sure the image path is available
		if(empty($requestObject->imagePath) === true){
			throw(new \InvalidArgumentException("The image path is already in use", 405));
		}

		//make sure the image path is available
		if(empty($requestObject->imagePath) === true){
			throw(new \InvalidArgumentException("The image name does not exist", 405));
		}

		//make sure the image type is a valid one
		if(empty($requestObject->imageType) === true){
			throw(new \InvalidArgumentException("The image type should be .png .jpg or .jpeg"));
		}
	}if($method === "POST") {
			// anitize the image
			$validExtensions = array(".jpg", ",jpeg", ".png");
			// We'll use strrchr to separate the file names from the extensions. strrchr will look for whatever is after the "." $_FILES is a superglobal that will help us manage the array of uploaded image files
			$userFileExtension = strrchr($_FILES["userImage"]["name"], ".");
			if(!in_array($userFileExtension, $validExtensions)){
				throw(new \InvalidArgumentException("Image has to be .jpg .jpeg or .png"));
			}

			//image creation when the extension is a valid one
			if($userFileExtension === ".jpg" || $userFileExtension === ".jpeg"){
				$userImage = imagecreatefromjpeg($requestObject->image);
			}elseif($userFileExtension === ".png"){
				$userImage = imagecreatefrompng($requestObject->image);
			}

			// now the image needs to be scaled down
			$sclaedImage = imagescale($userImage, 350);

		//assign a temporary and safe name to the new file
		$newFileName = round(microtime(true)) . '.' . $scaledImage;
		move_uploaded_file($_FILES["file"]["tmp_name"], "../img/tempImageDirectory/" . $newFileName);
	}




//
			$newfilename = round(microtime(true)) . '.' . $scaledImage;
			move_uploaded_file($_FILES["file"]["tmp_name"], "../img/imageDirectory/" . $newfilename);
			//1) move image to image directory (safe place to work with it) default
			//2) sanitize image name/type ---------image_type_to_extension & sanitize string?? getimagesize
//            3) create image--------imagecreatefromjpeg/imagecreatefrompng
			//4) scale image down to the size I want------imagescale should be in px
			//5) rename image to something I want
//            6)imagefoo to save
		
		
//loading of images starts here
	$type = false;
	function openImage($file){
		//detect type and process according to it
		global ($type);
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






//update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}