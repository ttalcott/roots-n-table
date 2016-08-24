<?php

require_once "autoloader.php";
require_once "lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\Rootstable;

/**API for unit
 *
 * @author Raúl Villarreal  <rvillarrcal@cnm.edu>
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

//loading of images starts here
$type = false;
function openImage($file){
	//detect type and process according to it
	global $type;
	$size = getimagesize($file);
	switch($size["mime"]){
		//in case the file is a .jpeg
		case "image/jpeg":
			$im = imagecreatefromjpeg($file);
			break;
		//in case the file extension is .png
		case "image/png":
			$im = imagecreatefrompng($file);
			break;
		default:
			$im = false;
			break;
	}
	return $im;
}