<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

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
}