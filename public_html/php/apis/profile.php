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
	//I think I need a filter for everything a user can edit
	$name = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING);

	//ensure the id is valid
	//I think I need a if/elseif block like this for everything a user can edit/input
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
			}//not sure if I really need this
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
			if(empty($requestObject->profileUserName) === true){
				throw(new \InvalidArgumentException("Insufficient Information", 405));
			}
		}
		//preform the put
		if($method === "PUT"){

			//retrieve the profile to update it
			$profile = Rootstable\Profile::getProfileByProfileId($pdo, $id);
			if($profile === null){
				throw(new RuntimeException("Profile does not exist", 404));
			}

			//put new profile information into profile and update
			$profile->setProfileUserName($requestObject->profileUserName);
			$profile->update($pdo);

			//update username
			$reply->message = "user name updated";
		}
}