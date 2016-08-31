<?php
namespace Edu\Cnm\Rootstable;
require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Rootstable\Unit;

/** API for the unit class
 *
 * @author Raul Villarreal <rvillarrcal@cnm.edu>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$unitId = filter_input(INPUT_GET, "unitId", FILTER_VALIDATE_INT);
	$unitName = filter_input(INPUT_GET, "unitName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//handle GET request - if  id is present, that unit is returned, otherwise all units are returned
	if($method === "GET") {
		//set XSRF cookie
		setXSRFcookie();

	}

	//get a specific unit or all units and update reply
	if(empty($unitId) === false) {
		$unit = Unit::getUnitByUnitId($pdo, $unitId);
		if($unit !== null) {
			$reply->data = $unit;
		}
		//get a unit by unit name
	} else if(empty($unitName) === false) {
		$unit = Unit::getUnitByUnitName($pdo, $unitName);
		if($unit !== null) {
			$reply->data = $unit;
		}
		//get all units
	}else{
		$units = Unit::getAllUnits($pdo);
		if($units !== null) {
			$reply->data = $units;
		}
	}
	//update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
	}

header("Content-type: application/json");
if($reply->data === null){
	unset($reply->data);

//encode and return reply to front end caller
echo json_encode($reply);

}
