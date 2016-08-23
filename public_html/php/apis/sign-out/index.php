<?php
/**
 * api for logging out
 *
 * @author Robert Engelbert <rob@robertengelbert.com>
 */

//if session is active
if(session_status !==PHP_SESSION_ACTIVE);
session_start();

//log the user out
unset($_SESSION["profile"]);