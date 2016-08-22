<?php

require_once "autoloader.php";
require_once "lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\Rootstable;

/** API for the Unit class
 *
 * @author Raul Villarreal <rvillarrcal@cnm.edu>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();

}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the MySQL connection
	$pdo = connectToTncryptedMySQL("/etc/apache2/rootstable-mysql/unit.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"]:
	$_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id can not be empty or negative", 405));
	}

	//handle GET request - if  id is present, that unit is returned, otherwise all units are returned
	if($method === GET) {
		//set XSRF cookie
		setXSRFcookie();

	}






}






