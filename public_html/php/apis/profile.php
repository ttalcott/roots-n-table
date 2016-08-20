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

//I think I need $reply = new stdClass(); and $reply->status = 200;

try{
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/profile.ini");

	//determine which HTTP request method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//ensure the id is valid
	if(($method === "GET" || $method === "PUT" ) && (empty($id) === true || $id < 0)){
		throw(new \InvalidArgumentException("Id cannot be negative or empty", 405));
	}
}