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

	//sanitize input
}