<?php
namespace Edu\Cnm\Rootstable;

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable\{Location, Profile};

/**
* api for the Location class
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

try {
	//grab the SQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine what HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize all inputs
	//location id
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//location profile id (foreign key)
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	//location street one
	$streetOne = filter_input(INPUT_GET, "streetOne", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the user is not using PUT, POST, DELETE when they shouldn't
	if(($method !== "GET") && (empty($_SESSION["profile"]) === true) && ($_SESSION["profile"]->getProfileId() !== $profileId)) {
		throw(new \InvalidArgumentException("cannot change these when you are not logged in", 403));
	}

	//make sure the id is valid for methods that require it
	if(($method === "PUT" || $method === "DELETE") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("id must be positive and there also must be an id...", 405));
	}

	//handle GET request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a location by the location id
		if(empty($id) === false) {
			$location = Location::getLocationByLocationId($pdo, $id);
			if($location !== null) {
				$reply->data = $location;
			}
			//get locations by location profile id
		} else if(empty($profileId) === false) {
			$locations = Location::getLocationByLocationProfileId($pdo, $profileId);
			if($locations !== null) {
				$reply->data = $locations;
			}
			//get locations by location street one
		} else if(empty($streetOne) === false) {
			$locations = Location::getLocationByLocationStreetOne($pdo, $streetOne);
			if($locations !== null) {
				$reply->data = $locations;
			}
			//for all other cases get all locations
		} else {
			$locations = Location::getAllLocations($pdo);
			if($locations !== null) {
				$reply->data = $locations;
			}
		}
		//handle the put and post methods
	} else if($method === "PUT" || $method === "POST") {
		//verify XSRF cookie
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure location city is available
		if(empty($requestObject->locationCity) === true) {
			throw(new \InvalidArgumentException("No location city found", 405));
		}

		//make sure location name is available
		if(empty($requestObject->locationName) === true) {
			throw(new \InvalidArgumentException("No location name found", 405));
		}

		//make sure location state is available
		if(empty($requestObject->locationState) === true) {
			throw(new \InvalidArgumentException("No location state found", 405));
		}

		//make sure location street one is available
		if(empty($requestObject->locationStreetOne) === true) {
			throw(new \InvalidArgumentException("No location street one found", 405));
		}

		//make sure location zip code is available
		if(empty($requestObject->locationZipCode) === true) {
			throw(new \InvalidArgumentException("No location Zip Code found", 405));
		}

		//preform the actual put
		if($method === "PUT") {
			// verifyXsrf();
			//retrieve the location to update
			$location = Location::getLocationByLocationId($pdo, $id);
			//verify there even is a location to update
			if($location === null) {
				throw(new \RuntimeException("Location does not exist", 404));
			}

			//update all attributes
			$location->setLocationAttention($requestObject->locationAttention);
			$location->setLocationCity($requestObject->locationCity);
			$location->setLocationName($requestObject->locationName);
			$location->setLocationState($requestObject->locationState);
			$location->setLocationStreetOne($requestObject->locationStreetOne);
			$location->setLocationStreetTwo($requestObject->locationStreetTwo);
			$location->setLocationZipCode($requestObject->locationZipCode);
			$location->update($pdo);

			//update reply
			$reply->message = "Location was updated successfully";

			//preform the post
		} else if($method === "POST") {
			// verifyXsrf();
			//create a new location and insert it into the database
			$location = new Location(null, $requestObject->locationAttention, $requestObject->locationCity, $requestObject->locationName, $requestObject->locationState, $requestObject->locationStreetOne, $requestObject->locationStreetTwo, $requestObject->locationZipCode);
			$location->insert($pdo);

			//update reply
			$reply->message = "Location was inserted successfully";
		}

		//preform the delete
	} else if($method === "DELETE") {
		//verify XSRF
		verifyXsrf();

		//retrieve the location to be deleted
		$location = Location::getLocationByLocationId($pdo, $id);
		if($location === null) {
			throw(new \RuntimeException("Locartion does not exist", 404));
		}

		//delete the location
		$location->delete($pdo);

		//update reply
		$reply->message = "Location deleted successfully";

	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request"));
	}
	//end of try block; catch exceptions
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


?>
