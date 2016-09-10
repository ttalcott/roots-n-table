<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable;

/**API for images
 *
 * @author Raúl Villarreal  <rvillarrcal@cnm.edu>
 **/

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
	$productImageProductId = filter_input(INPUT_GET, "productImageProductId", FILTER_VALIDATE_INT);
	$productImageProfileId = filter_input(INPUT_GET, "profileImageProfileId", FILTER_VALIDATE_INT);
	$imagePath = filter_input(INPUT_GET, "imagePath", FILTER_SANITIZE_STRING);
	$imageType = filter_input(INPUT_GET, "imageType", FILTER_SANITIZE_STRING);

	//make sure the ID is valid for methods that require it
	if(($method === "DELETE") && (empty($imageId) === true || $imageId < 0)) {
		throw(new \InvalidArgumentException("Image id can not be negative or empty", 405));
	} elseif(($method === "PUT")) {
		throw(new \Exception("This action is forbidden", 405));
	}

	//handle GET request - if id is present, that image is returned, otherwise all images are returned
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		//get a specific image by image id
		if(empty($imageId) === false) {
			$image = Image::getImageByImageId($pdo, $imageId);
			if($image !== null) {
				$reply->data = $image;
			}
		} elseif(empty($imagePath) === false) {
			// get a specific image by image path
			$image = Image::getImageByImagePath($pdo, $imagePath);
			if($image !== null) {
				$reply->data = $image;
			}
		} elseif(empty($imageType) === false) {
			//get images by image type
			$images = Image::getImageByImageType($pdo, $imageType);
			if($images !== null) {
				$reply->data = $images;
			}
		}
	}

	// if user is logged in, allow POST, DELETE
	if(empty($_SESSION["profile"]) !== false) {

		// handle POST request
		if($method === "POST") {
			verifyXsrf();

			$newImageIsFor = filter_input(INPUT_POST, "newImageIsFor", FILTER_SANITIZE_STRING);
			$newImageType = filter_input(INPUT_POST, "newImageType", FILTER_SANITIZE_STRING);

			if(empty($imageIsFor) === true) {
				throw(new \InvalidArgumentException("Is the image for a product or a profile?"));
			}

			if(empty($newImageType) === true) {
				throw(new \InvalidArgumentException("need an image type"));
			}

			$newImageIsFor = trim($newImageIsFor);
			$newImageType = trim($newImageType);


			//image sanitization process
			//create an array of valid image extensions and valid image MIME types
			$validExtensions = array(".jpg", ".jpeg", ".png");
			$validTypes = array("image/jpg", "image/jpeg", "image/png");

			// Assign variables to the user image name, MIME type and extract image extension
			//tmp_name is the name in the server, we should use that, it will delete itself once this process is over
			$tempImagePath = $_FILES["userImage"]["tmp_name"];
			$tempImageType = $_FILES["userImage"]["type"];
			$tempUserFileExtension = strtolower(strrchr($_FILES["userImage"]["name"], "."));

			//verify and ensure the file has a correct extension and MIME type
			if(!in_array($tempUserFileExtension, $validExtensions) || (!in_array($tempImageType, $validTypes))) {
				throw(new \InvalidArgumentException("That is not a valid image"));
			}

			//image creation when the extension is a valid one .jpg .jpeg or .png
			if($tempUserFileExtension === ".jpg" || $tempUserFileExtension === ".jpeg") {
				$sanitizedUserImage = imagecreatefromjpeg($tempImagePath);
			} elseif($tempUserFileExtension === ".png") {
				$sanitizedUserImage = imagecreatefrompng($tempImagePath);
			} else {
				throw(new \InvalidArgumentException("This is a not a valid image", 405));
			}

			//double check if valid sanitizedUserImage was created
			if($sanitizedUserImage === false) {
				throw(new \InvalidArgumentException("This is a not a valid image", 405));
			}

			// now the image needs to be scaled down to 350 pixels
			$imageScale = imagescale($sanitizedUserImage, 350);

			// create new image file path
			$newImageFilePath = "/var/www/html/public_html/roots-n-table" . hash("ripemd160", microtime(true) + random_int(0, 4294967296)) . $tempUserFileExtension;

			if($tempUserFileExtension === ".jpg" || $tempUserFileExtension === ".jpeg") {
				$createdProperly = imagejpeg($sanitizedUserImage);
			} elseif($tempUserFileExtension === ".png") {
				$createdProperly = imagepng($sanitizedUserImage, $newImageFilePath);
			}

			//put new image into the ProductImage database
			if($createdProperly === true) {

					if($newImageIsFor === "Product") {
						if($_SESSION["profile"]->getProfileType === "f" && empty($requestObject->productId) !== false) {
							//create the image to generate a primary key
							$image = new Image(null, $newImageFilePath, $tempImageType);
							$image->insert($pdo);
						}

						// now insert the image with its composite key into productImage
						if($createdProperly === true && $tempImageType === "f") {
							$productImage = new ProductImage($requestObject->getImageId(), $requestObject->getProductId());
							$productImage->insert($pdo);
						} else {
							throw (new \InvalidArgumentException("only farmers can post products for sale"));
						}
						//repeat process when is for a profile user should be in an active session
					} else if($newImageIsFor === "Profile") {
						if(empty($_SESSION["profile"]) !== false) {

							//create the image to generate a primary key
							$image = new Image(null, $newImageFilePath, $tempImageType);
							$image->insert($pdo);
						}

						// now insert the image with its composite key into profileImage
						if($createdProperly === true) {
							$profileImage = new ProfileImage($requestObject->getImageId(), $requestObject->getProfileId());
							$profileImage->insert($pdo);
						} else {
							throw(new \InvalidArgumentException("You must log in first"));
						}
					} //end elseif imagefor === "Profile"

			} // end if $createdProperly
		} // end if POST

			// Handle DELETE request
			if($method === "DELETE") {
				verifyXsrf();

				//retrieve the Image to be deleted
				$image = Image::getImageId($pdo, $imageId);

				if($image === null) {
					throw(new \RuntimeException("Image does not exists", 404));
				} else {

					/*//avoid deleting images that don't correspond to your profile we'll make this happen from product
					if($_SESSION["profile"]->getProfileId() !== $requestObject->profileImageProfileId) {
						throw(new \InvalidArgumentException("You can only erase your own images"));
					}*/

					//unlink will delete the image from the server
					unlink($image->getImageFilePath());

					//delete image
					$image->delete($pdo);
					$reply->message = "Image deleted";
				}//end unlink and delete image
			} // end DELETE block
		}  // end $_SESSION verification
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

echo json_encode($reply);


/*					//start same process for profile images, if nobody is in session throw exception
				} else if($requestObject->imageIsFor === "Profile") {
					if(empty($_SESSION["profile"]) !== false) {
					}
				} else {
					throw (new \InvalidArgumentException("only farmers ..."));
				}*/


			//retrieve the Image to be deleted
			/*$image = Image::getImageByImageId($pdo, $imageId);
			if($image === null) {
				throw(new \RuntimeException("Image does not exists", 404));
			}*/

			//delete images that correspond to your profile only
/*			if($_SESSION["profile"]->getProfileId() !== $requestObject->profileImageProfileId) {
				throw(new \InvalidArgumentException("You can only erase your profile images"));*/

				//unlink will delete the image from the server
/*			}
			unlink($image->getImageFilePath());

			//delete image
			$image->delete($pdo);
			$reply->message = "Image deleted";
		}*/

//delete productImages that were uploaded by your profile only
/*		if($_SESSION["profile"]->getProfileId() !== $requestObject->productProfileId) {
			throw(new \InvalidArgumentException("You can only erase images that you uploaded"));*/

			//unlink will delete the image from the server
/*		}
		unlink($image->getImageFilePath());*/

/*		//delete image
		$image->delete($pdo);
		$reply->message = "Image deleted";
		//update reply with exception information
	}
catch
	(Exception $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	} catch(TypeError $typeError) {
		$reply->status = $typeError->getCode();
		$reply->message = $typeError->getMessage();
	}*/




						// create image
						// insert image

						// create profileImage (with $image->getImageId() and $_SESSION["profile"]->getProfileId())
						// insert profileImage
/*					} else {
						throw (new \InvalidArgumentException("must be logged in"));
					}
				}
			}else if ($method === "DELETE") {*/
				// Try to get both ProfileImage and ProductImage by image id in order to figure out if it is a product or profile image
				// Make sure the person trying to delete the image should actually have permission to do so
				// Then and only then - DELETE the image*/


/*			//make sure the profileType is a not a "u"ser and is a "f"armer
			if($requestObject->image === true) {
				if($_SESSION["profile"]->getProfileType() !== "f") {
					throw(new \InvalidArgumentException("Only farmers or growers can post products"));

					//if the profileType is a "f"armer, create the image to generate a primary key
				} else {
					$image = new Image(null, $newImageFilePath, $tempImageType);
					$image->insert($pdo);

					// now insert the image with its composite key into productImage
				}
				if($createdProperly === true && $tempImageType === "f") {
					$productImage = new ProductImage($requestObject->imageId, $requestObject->productId);
					$productImage->insert($pdo);

					//same process to insert an for the profileImage database
					//anyone can upload a profile picture so no need to filter profiles
				} else {
					$image = new Image(null, $newImageFilePath, $tempImageType);
					$image->insert($pdo);

					//create the image composite key to enter it into profileImage
				}
				if($createdProperly === true) {
					$profileImage = new ProfileImage($requestObject->ImageId, $requestObject->profileId);
					$productImage->insert($pdo);
				}
			}
		}*/
// create an additional condition for when the image to upload is actually a product image, anmgular will send a signal when a farmer is in the product posting section with the type of profile "f" for farmer

		/*pseudo code by Rochelle
		if $createdProperly === true {

	  if $requestObject->productImage === true {
		 if $_SESSION["profile"]->getProfileType() !== Farmer {
			throw exception "You are not a Farmer - you can't upload product images"
		 } else {
			//create and insert new Image
			//create and insert new ProductImage
		 }
	  } else {
		 //create and insert new Image
		 //create and insert new ProfileImage
	  }*/


/*	} else if($method === "DELETE") {
	verifyXsrf();

	//retrieve the Image to be deleted
	$image = Image::getImageByImageId($pdo, $imageId);
	if($image === null) {
		throw(new \RuntimeException("Image does not exists", 404));
	}

	//delete images that correspond to your profile only
	if($_SESSION["profile"]->getProfileId() !== $requestObject->profileImageProfileId) {
		throw(new \InvalidArgumentException("You can only erase your profile images"));

		//unlink will delete the image from the server
	}
	unlink($image->getImageFilePath());

	//delete image
	$image->delete($pdo);
	$reply->message = "Image deleted";
}

//delete productImages that were uploaded by your profile only
	if($_SESSION["profile"]->getProfileId() !== $requestObject->productProfileId) {
		throw(new \InvalidArgumentException("You can only erase images that you uploaded"));

		//unlink will delete the image from the server
	}
	unlink($image->getImageFilePath());

	//delete image
	$image->delete($pdo);
	$reply->message = "Image deleted";
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
}*/
/*<?php


Skylar's pseudocode

if ($method === "POST") {
	if ($requestObject->imageIsFor === "Product") {
		if ($_SESSION["profile"]->getProfileType === "f" && empty($requestObject->productId) !== false) {
			// insert image

			// create productImage (with $image->getImageId() and $requestObject->productId)
			// insert productImage
		} else {
			throw (new \InvalidArgumentException("only farmers ..."));
		}
	} else if ($requestObject->imageIsFor === "Profile") {
		if (empty($_SESSION["profile"]) !== false) {
			// create image
			// insert image

			// create profileImage (with $image->getImageId() and $_SESSION["profile"]->getProfileId())
			// insert profileImage
		} else {
			throw (new \InvalidArgumentException("must be logged in"));
		}
	}
} else if ($method === "DELETE") {
    // Try to get both ProfileImage and ProductImage by image id in order to figure out if it is a product or profile image
    // Make sure the person trying to delete the image should actually have permission to do so
    // Then and only then - DELETE the image*/