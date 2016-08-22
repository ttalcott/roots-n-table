<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

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

try{
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$email = filter_input($requestObject->email, FILTER_SANITIZE_EMAIL);

	//make sure this profile exists
	if($profile !== null){
		$profileHash === hash_pbkdf2("sha512", $requestObject->password, $profile->getProfileSalt(), 262144, 128);
		if($profileHash === $profile->getProfileHash()){

		}
	}
}