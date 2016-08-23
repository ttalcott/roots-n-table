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

//prepare an empty reply