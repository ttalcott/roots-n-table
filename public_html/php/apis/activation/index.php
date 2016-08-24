<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable;

/**
 * activation api
 *
 * @author Robert Engelbert <rob@robertengelbert.com>
 */

//verify the session,
if(session_status() !== PHP_SESSION_ACTIVE){
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
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SEVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize activation token
	$activate = filter_input(INPUT_GET, "activate", FILTER_SANITIZE_STRING);

	if(($method === "GET") && (empty($activate) === true)){
		throw(new \InvalidArgumentException("Invalid information", 405));
	}

	//handle get request
	if($method === "GET"){
		//set XSRF cookie
		setXsrfCookie("/");

		//get by activation token
		if(empty($activate) === false){
			$profile = Rootstable\Profile::getProfileByProfileActivationToken($pdo, $activate);
			}//if activate is not null then null it out
		if($activate !== null){
			$activate = null;
			}
		/**
		 * not sure if I need this, It's checking if the profile is not null and if it isn't set it to $reply which get's unset from null upon creating an account.
		 */
		if($profile !== null){
			$reply->data = $profile;
		}
		}elseif($method === "PUT" || $method === "POST" || $method === "DELETE"){
			throw (new \InvalidArgumentException("This action is not allowed", 405));
		}
}catch(\Exception $exception){
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}catch(TypeError $typeError){
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
//not sure if I need this
header("Content-type: application/json");
if($reply->data === null){
	unset($reply->data);
}