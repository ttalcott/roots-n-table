<?php
namespace Edu\Cnm\Rootstable;

require_once("autoload.php");
require_once("/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable\Location;

/**
* api for the Location class
*
* @author Travis Talcott <ttalcott@lyradevelopment.com>
**/

//verify the session, if not active start it
if($session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the SQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/location.ini");

	//determine what HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize all inputs
	//location id
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//location profile id (foreign key)
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	//location attention
	$attention = filter_input(INPUT_GET, "attention", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//location City
	$city = filter_input(INPUT_GET, "city", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//location name
	$name = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//location state
	$state = filter_input(INPUT_GET, "state", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//location street One
	$streetOne = filter_input(INPUT_GET, "streetOne", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//location street two
	$streetTwo = filter_input(INPUT_GET, "streetTwo", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//location zip code
	$zipCode = filter_input(INPUT_GET, "zipCode", FILTER_VALIDATE_INT);

	//make sure the user is not using PUT, POST, DELETE when they shouldn't
	if(($method !== "GET") && ($_SESSION["profile"]->getProfileId() !== $id)) {
		setXsrfCookie();
		throw(new \InvalidArgumentException("cannot change these when you are not logged in"));
	}

	//make sure the id is valid for methods that require it
	if(($method === "PUT" || $method = "DELETE") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("id must be positive and there also must be an id...", 405));
	}

//end of try block; catch exceptions
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->code();
	$reply->message = $typeError->getMessage();
}

//set up the header response
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and reply to caller
echo json_encode($reply);


 ?>
