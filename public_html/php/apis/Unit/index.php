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
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}