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
		//make sure this profile exists
		if($profile !== null) {
			$profileHash === hash_pbkdf2("sha512", $requestObject->password, $profile->getProfileSalt(), 262144, 128);
			if($profileHash === $profile->getProfileHash()) {
				$_SESSION["profile"] = $profile;
				$reply->status = 200;
				$reply->message = "You're logged in";
			} else {
				throw(new \InvalidArgumentException("Invalid user information"));
			}
		} else {
			throw(new \InvalidArgumentException("Invalid user information"));
			//create an exception to pass back to the RESTful caller
		}
	}

}catch(\Exception $exception){
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
echo json_encode($reply);
