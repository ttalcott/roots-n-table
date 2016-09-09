<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable;

/**
 * api for sign-in
 *
 * @author Robert Engelbert <rob@robertengelbert.com
 */

//verify the session, start if not active
if(session_status() !==PHP_SESSION_ACTIVE){
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$email = filter_input($requestObject->email, FILTER_SANITIZE_EMAIL);

	if($method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Please enter a valid email", 405));
		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}

		if(empty($requestObject->password) === true) {
			throw(new \InvalidArgumentException("Please enter a password", 405));
		} else {
			$password = filter_var($requestObject->password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}

		//get profile by profile email
		$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
		if(empty($profile) === true) {
			throw(new \InvalidArgumentException("Profile Not Found"));
		}

		//hash password
		$hash = hash_pbkdf2("sha512", $password, $profile->getProfileSalt(), 262144, 128);
		if($hash !== $profile->getProfileHash()) {
			throw(new \InvalidArgumentException("Incorrect password... please revise"));
		}

		//grab the profile and put it into a session
		$profile = Profile::getProfileByProfileId($pdo, $profile->getProfileId());
		$_SESSION["profile"] = $profile;
	} else {
	 	throw(new \InvalidArgumentException("Invalid user information"));
	}
}catch(\Exception $exception){
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
echo json_encode($reply);
