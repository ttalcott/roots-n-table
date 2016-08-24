<?php
namespace Edu\Cnm\Rootstable;

require_once dirname(__DIR__, 2) . "/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable\Location;

/**
* api for the Purchase class
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/category.ini");

	//determine what HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize all inputs
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//profile id
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	//purchase stripe token
	$stripeToken = filter_input(INPUT_GET, "stripeToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	if(($method === "GET") && (empty($_SESSION["profile"]) === true) && ($_SESSION["profile"]->getProfileId() !== $id)) {
		throw(new \InvalidArgumentException("cannot access purchases when you are not logged in"));
	}
	
}
