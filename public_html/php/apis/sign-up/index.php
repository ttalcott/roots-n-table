<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable;

/**
 * api for sign in
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
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine which HTTP request method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_EMAIL);
	$firstName = filter_input(INPUT_GET, "firstName" , FILTER_SANITIZE_STRING);
	$lastName = filter_input(INPUT_GET, "lastName", FILTER_SANITIZE_STRING);
	$phoneNumber = filter_input(INPUT_GET, "phoneNumber", FILTER_SANITIZE_STRING);
	$type = filter_input(INPUT_GET, "type", FILTER_SANITIZE_STRING);
	$userName = filter_input(INPUT_GET, "userName", FILTER_SANITIZE_STRING);


	if($method == "POST"){

		verifyXsrf();
		$requsetContent = file_get_contents("php://input");
		$requestObject - json_decode($requestContent);
	}

		//ensure all required information is entered
		if(($method === "POST") && (empty($id) === true || $id < 0)) {
			throw(new \InvalidArgumentException("Id cannot be negative or empty", 405));
		} elseif(($method === "POST") && (empty($email) === true)) {
			throw(new \InvalidArgumentException("Value must be valid", 405));
		} elseif(($method === "POST") && (empty($firstName) === true)) {
			throw(new \InvalidArgumentException("Value must be valid", 405));
		} elseif(($method === "POST") && (empty($lastName) === true)) {
			throw(new \InvalidArgumentException("Value must be valid", 405));
		} elseif(($method === "POST") && (empty($phoneNumber) === true)) {
			throw(new \InvalidArgumentException("Value must be valid", 405));
		} elseif(($method === "POST") && (empty($type) === true)) {
			throw(new \InvalidArgumentException("Value must be valid", 405));
		} elseif(($method === "POST") && (empty($userName) === true)) {
			throw(new \InvalidArgumentException("Value must be valid", 405));
		} elseif(($method === "PUT" || $method === "GET" || $method === "DELETE")) {
			throw(new \Exception("This action is forbidden", 405));
		}
		//create a new salt and activation token
	$profileSalt = bin2hex(openssl_random_pseudo_bytes(64));
	$profileActivationToken = bin2hex(openssl_random_pseudo_bytes(32));

	//create the hash
	$profileHash = hash_pbkdf2("sha512", $requestObject->password, $profileSalt, 262144, 128);

	//create a new account and insert into mySQL
	$profile = new Profile(null,$requestObject->profileEmail, $requestObject->profileFirstName, $requestObject->profileLastName, $requestObject->profilePhoneNumber, $requestObject->profileType, $requestObject->profileUserName);
	$profile->insert($pdo);
	$reply->message = "Thank you for signing up";

	//update reply with exception information
	}catch(\Exception $exception){
		$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}catch(TypeError $typeError){
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null){
	unset($reply->data);
}

//encode and return
echo json_encode($reply);