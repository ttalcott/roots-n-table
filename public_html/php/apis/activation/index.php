<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__, 4) . "/vendor/autoload.php");


use Edu\Cnm\Rootstable\Profile;

/**
 * activation api
 *
 * @author Robert Engelbert <rob@robertengelbert.com>
 */

//verify the session,
if(session_status() !== PHP_SESSION_ACTIVE) {
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

	//sanitize activation token
	$activate = filter_input(INPUT_GET, "activate", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	if(($method === "GET") && (empty($activate) === true)) {
		throw(new \InvalidArgumentException("Invalid information", 405));
	}

	//handle get request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie("/");

		if(empty($activate) === true) {
			throw(new \InvalidArgumentException("No profile activation token present"));
		}

		//get by activation token
		if(empty($activate) === false) {
			$profile = Rootstable\Profile::getProfileByProfileActivationToken($pdo, $activate);
		}

		if(empty($profile) === true) {
			throw(new \RuntimeException("Profile not found"));
		}

		//if activate is not null then null it out
		if($profile !== null) {
			$profile->setProfileActivationToken(null);
			$profile->update($pdo);
			$reply->message = "Thank you for activating your account";
		}

	} elseif($method === "PUT" || $method === "POST" || $method === "DELETE") {
		throw (new \InvalidArgumentException("This action is not allowed", 405));
	}
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
//not sure if I need this
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
