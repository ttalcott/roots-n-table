<?php

use Edu\Cnm\Rootstable;

/**
 * api for the Profile class
 *
 * @author Robert Engelbert <rob@robertengelbert.com>
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

//prepare empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try{
	//grab the mySQL connection (not sure about this)
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/profile.ini");

	//determine which HTTP request method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$name = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING);

	//ensure the id is valid
	if(($method === "GET" || $method === "PUT" ) && (empty($id) === true || $id < 0)){
		throw(new \InvalidArgumentException("Id cannot be negative or empty", 405));
	}
}finally{
	if(($method === "POST" || $method === "DELETE")){
		throw(new \Exception("This action is forbidden",405));
	}
	//handle GET request
	if($method === "GET") {
		//set XSRF cokkie
		setXsrfCookie("/");

		//get a specific profile
		if(empty($id) === false) {
			$profile = Rootstable\Profile::getProfileByProfileId($pdo, $id);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} elseif(empty($name) === false) {
			$profile = Rootstable\Profile::getProfileByProfileUserName($pdo, $name);
			if($profile !== null) {
				$reply->data = $profile;
			}
		}
	}elseif($method === "PUT"){
			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			//make sure profile information is available
			if(empty($requestObject->profileId) === true){
				throw(new \InvalidArgumentException("Insufficient Information", 405));
			}
		}
}