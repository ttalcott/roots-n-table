<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__, 4) . "/vendor/autoload.php");


use Edu\Cnm\Rootstable;

/**
 * activation api
 *
 * @author Robert Engelbert <rob@robertengelbert.com>
 */

//verify the session,
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize activation token
	$activate = filter_input(INPUT_GET, "activate", FILTER_SANITIZE_STRING);

	if(($method === "GET") && (empty($activate) === true)) {
		throw(new \InvalidArgumentException("Invalid information", 405));
	}

	//handle get request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie("/");

		//get by activation token
		if(empty($activate) === false) {
			$profile = Rootstable\Profile::getProfileByProfileActivationToken($pdo, $activate);
		}//if activate is not null then null it out
		if($profile !== null) {
			$profile->setProfileActivationToken(null);
			$reply->message = "Thank you for activating your account";
		}
		
	} elseif($method === "PUT" || $method === "POST" || $method === "DELETE") {
		throw (new \InvalidArgumentException("This action is not allowed", 405));
	}

	//swift mailer
	//create transport
	$smtp = Swift_SmtpTransport::newInstance("localhost", 25);
	//create the mailer using the created transport
	$mailer = Swift_Mailer::newInstance($smtp);


	//create swift message
	$swiftMessage = Swift_message::newInstance();

	//attach the sender to the message
	//this takes the form of an associtive array where the Email is the key for the real name
	$swiftMessage->setFrom(["rootsNtable@gmail.com" => "Roots-n-table"]);

	/**
	 * attach the recipients to the message
	 * This array can include or omit the recipient's real name
	 * use the recipient's real name when possible to keep the message from being marked as spam
	 */
	$recipients = [$requestObject->profileEmail];
	$swiftMessage->setTo($recipients);

	//attach the subject line to the message
	$swiftMessage->setSubject("Confirm your account with Roots-n-table to activate");

	//building the activation link
	$lastSlash = strrpos($_SERVER["SCRIPT_NAME"], "/");
	$basePath = substr($_SERVER["SCRIPT_NAME"], 0, $lastSlash + 1);
	$urlglue = $basePath . "email-confirmation?emailActivation=" . $profileActivationToken;

	$confirmLink = "https://" . $_SERVER["SEVER_NAME"] . $urlglue;

	$message = <<< EOF
	<h1>Thanks for signing up with Roots-n-table!</h1>
<p>Visit the following URL to confirm your email and complete the registration process <a href = "$confirmLink">$confirmLink</a></p>
EOF;

	$swiftMessage->setBody($message, "text/html");
	$swiftMessage->addPart(html_entity_decode(filter_var($message, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)), "text/plain");


	//send the message
	$numSent = $mailer->send($swiftMessage, $failedRecipients);
	/**
	 * the send method returns the number of recipients that accepted the email
	 * so, if the number attempted is not the number accepted, throw an exception
	 */
	if($numSent !== count($recipients)) {
		//the $failedRecipients parameter passed in the send() method now contains an array of the emails that failed
		throw(new \RuntimeException("unable to send email"));
	}
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
//not sure if I need this
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}