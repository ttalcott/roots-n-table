<?php
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




 ?>
