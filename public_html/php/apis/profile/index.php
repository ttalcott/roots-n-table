<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable\Profile;

/**
 * api for the Profile class
 *
 * @author Robert Engelbert <rob@robertengelbert.com>
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection (not sure about this)
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine which HTTP request method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_EMAIL);
	$type = filter_input(INPUT_GET, "type", FILTER_SANITIZE_STRING);
	$userName = filter_input(INPUT_GET, "userName", FILTER_SANITIZE_STRING);

	//ensure the information is valid
	if($method === "PUT" && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("Id cannot be negative or empty", 405));
	} elseif(($method === "POST" || $method === "DELETE")) {
		throw(new \Exception("This action is forbidden", 405));
	}

	//handle GET request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie("/");

		//get a specific profile
		if(empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile !== null) {
				$reply->data = $profile;
			}
			}elseif(empty($email) === false) {
			$profile = Profile::getProfileByProfileEmail($pdo, $email);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} elseif(empty($userName) === false) {
			$profile = Profile::getProfileByProfileUserName($pdo, $userName);
			if($profile !== null) {
				$reply->data = $profile;
			}
		}
	} elseif($method === "PUT") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure profile information is available
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Insufficient Information", 405));
		}
		if(empty($requestObject->profileFirstName) === true) {
			throw(new \InvalidArgumentException("Insufficient Information", 405));
		}
		if(empty($requestObject->profileLastName) === true) {
			throw(new \InvalidArgumentException("Insufficient Information", 405));
		}
		if(empty($requestObject->profileType) === true) {
			throw(new \InvalidArgumentException("Insufficient Information", 405));
		}
		if(empty($requestObject->profileUserName) === true) {
			throw(new \InvalidArgumentException("Insufficient Information", 405));
		}//perform the put
//	}elseif($method === "PUT") {

		//restrict each user to there own account
		if(empty($_SESSION["profile"]) === false || $_SESSION["profile"]->getProfileId() !== $id) {
			throw (new \InvalidArgumentException("You're not authorized to modify this account"));
		}

		//retrieve the profile to update it
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}

		//put new profile information into profile and update
		$profile->setProfileEmail($requestObject->profilelEmail);
		$profile->setProfileFirstName($requestObject->profielFirstName);
		$profile->setProfileLastName($requestObject->profileLastName);
		$profile->setProfilePhoneNumber($requestObject->profilePhoneNumber);
		$profile->setProfileType($requestObject->profileType);
		$profile->setProfileUserName($requestObject->profileUserName);
		//add a if statement to salt and hash the password and set it

		if($requestObject->profilePassword !== null) {
			$hash = hash_pbkdf2("sha512", $requestObject->profilePassword, $profile->getProfileSalt(), 262144, 128);
			$profile->setProfileHash($hash);
		}
		$profile->update($pdo);

		//update username
		$reply->message = "user information updated";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request"));
	}
} catch(Exception $exception) {
	$reply->session = $_SESSION;
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and return a reply to frontend caller
echo json_encode($reply);
