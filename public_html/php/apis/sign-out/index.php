<?php
/**
 * api for logging out
 *
 * @author Robert Engelbert <rob@robertengelbert.com>
 */

//verify the session, start if not active
if(session_status() !==PHP_SESSION_ACTIVE){
session_start();
}

//log the user out by setting to an empty array
$_SESSION = [];