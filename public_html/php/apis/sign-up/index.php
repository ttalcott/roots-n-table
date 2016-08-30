<?php

require_once(dirname(__DIR__, 2) . "../classes/autoload.php");
require_once(dirname(__DIR__, 2) . "../lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__, 4) . "/vendor/autoload.php");

use Edu\Cnm\Rootstable;

/**
 * api for sign in
 *
 * @author Robert Engelbert <rob@robertengelbert.com>
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

//prepare empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	//determine which HTTP request method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	if($method == "POST") {
		//set Xsrf cookie
		setXsrfCookie();

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
	}

	//ensure all required information is entered
	if(empty($requestObject->profileEmail) === true) {
		throw(new \InvalidArgumentException("Insufficient information", 405));
	}
	if(empty($requestObject->profileFirstName) === true) {
		throw(new \InvalidArgumentException("Insufficient information", 405));
	}
	if(empty($requestObject->profileLastName) === true) {
		throw(new \InvalidArgumentException("Insufficient information", 405));
	}
	if(empty($requestObject->profileType) === true) {
		throw(new \InvalidArgumentException("Insufficient information", 405));
	}
	if(empty($requestObject->profileUserName) === true) {
		throw(new \InvalidArgumentException("Insufficient information", 405));
	}
	if(($method === "PUT" || $method === "GET" || $method === "DELETE")) {
		throw(new \Exception("This action is forbidden", 405));
	}

	//sanitize email and verify that an account doesn't already exist
	$profileEmail = filter_input($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
	$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
	if($profile !== null) {
		throw(new \RuntimeException("An account has already been created with this email", 422));
	}

	//create a new salt and activation token
	$profileSalt = bin2hex(openssl_random_pseudo_bytes(64));
	$profileActivationToken = bin2hex(openssl_random_pseudo_bytes(32));

	//create the hash
	$profileHash = hash_pbkdf2("sha512", $requestObject->password, $profileSalt, 262144, 128);

	//create a new account and insert into mySQL
	$profile = new Profile(null, $requestObject->profileEmail, $requestObject->profileFirstName, $requestObject->profileLastName, $requestObject->profilePhoneNumber, $requestObject->profileType, $requestObject->profileUserName);
	$profile->insert($pdo);
	//reply message
	$reply->message = "Thank you for signing up";


	/**
	 * send the Email via SMTP; the SMTP server here is configured upstream via CNM
	 * this default may or may not be available on all web hosts; consult their documentation/ support for details
	 * SwiftMailer supports many different transport methods; SMTP was chosen because it's the most compatible and has the best error handling
	 *
	 * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwiftMailer
	 */

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
	$farmScript = $_SERVER["SCRIPT_NAME"];
	$smtp = dirname($farmScript, 2) . "/activation/?activate=" . $activate;

	$confirmLink = "https://" . $_SERVER["SEVER_NAME"] . $smtp;

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


	//update reply with exception information
	}catch(\Exception $exception){
		$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}catch(TypeError $typeError){
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null){
	unset($reply->data);
}

//encode and return
echo json_encode($reply);