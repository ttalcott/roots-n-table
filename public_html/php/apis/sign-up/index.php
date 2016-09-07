<?php

require_once(dirname(__DIR__, 2) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__, 4) . "/vendor/autoload.php");

//require_once(dirname(__DIR__, 4) . "/public_html/composer.json");

use Edu\Cnm\Rootstable\Profile;

/**
 * api for sign up
 *
 * @author Robert Engelbert <rob@robertengelbert.com>
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	$config = readConfig("/etc/apache2/capstone-mysql/rootstable.ini");
	$stripe = json_decode($config["stripe"]);

	//determine which HTTP request method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	var_dump($method);

	if(($method === "PUT" || $method === "GET" || $method === "DELETE")) {
		throw(new \Exception("This action is forbidden", 405));
	}

	if($method === "POST") {
		//set Xsrf cookie
		setXsrfCookie();

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		/**
		 *  ensure all required information is entered
		 *
		 *  check weather it's a user or a farmer
		 */
		if(($requestObject->profileType)!== "f" && ($requestObject->profileType) !== "u"){
			throw(new \InvalidArgumentException("If your a farmer click f if your a user click u."));
		}
		if(($requestObject->profileType) === "f"){
			//do it farmer style

			//legal-entity: address objects
			if(empty($requestObject->profileAddressCity) === true) {
				throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
			}
			if(empty($requestObject->profileCountry) === true){
				throw(new\InvalidArgumentException("Make sure you provide all required information", 405));
			}
			if(empty($requestObject->profileAddressLineOne) === true) {
				throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
			}
			if(empty($requestObject->profileAddressState) === true) {
				throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
			}
			if(empty($requestObject->profileAddressZip) === true) {
				throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
			}
			//legal entity DOB
			if(empty($requestObject->profileDobDay) === true){
				throw(new\InvalidArgumentException("Make sure you provide all required information", 405));
			}
			if(empty($requestObject->profileDobMonth) === true) {
				throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
			}
			if(empty($requestObject->profileDobYear) === true) {
				throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
			}

			//bank objects
			if(empty($requestObject->profileBankAccountNumber) === true) {
				throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
			}
			if(empty($requestObject->profileBankRoutingNumber) === true) {
				throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
			}
			if(empty($requestObject->profileSSN) === true && empty($requestObject->profileEIN) === true){
				throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
			}
			if(empty($requestObject->profileBusinessOrIndividual) === true) {
				throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
			}
		}

		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
		}
		if(empty($requestObject->profileFirstName) === true) {
			throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
		}
		if(empty($requestObject->profileLastName) === true) {
			throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
		}
		if(empty($requestObject->profilePhoneNumber) === true){
			$requestObject->profilePhoneNumber = null;
		}
		if(empty($requestObject->profileUserName) === true) {
			throw(new \InvalidArgumentException("Make sure you provide all required information", 405));
		}

		if($requestObject->profileType === "f") {
			try {
				\Stripe\Stripe::setApiKey($stripe->privateKey);
				\Stripe\Account::create(
					[
						"managed" => true,
						"external_account" => [
							"object" => "bank_account",
							"account_number" => $requestObject->profileBankAccountNumber,
							"country" => $requestObject->profileCountry,
							"currency" => "usd",
							"routing_number" => $requestObject->profileBankRoutingNumber
						],
						"legal_entity" => [
							"address" => [
								"city" => $requestObject->profileAddressCity,
								"country" => $requestObject->profileCountry,
								"line1" => $requestObject->profileAddressLineOne,
								"line2" => null,
								"postal_code" => $requestObject->profileAddressZip,
								"state" => $requestObject->profileAddressState
							],
							"dob" => [
								"day" => $requestObject->profileDobDay,
								"month" => $requestObject->profileDobMonth,
								"year" => $requestObject->profileDobYear
							],
							"first_name" => $requestObject->profileFirstName,
							"last_name" => $requestObject->profileLastName,
							"personal_id_number" => $requestObject->profileSSN,
							"ssn_last_4" => substr($requestObject->profileSSN, - 4),
							"type" => $requestObject->profileBusinessOrIndividual
						],
						"tos_acceptance" => [
							"date" => time(),
							"ip" => $_SERVER["REMOTE_ADDR"],
							"user_agent" => $_SERVER["HTTP_USER_AGENT"]
						],
						"country" => "US",

						"email" => $requestObject->profileEmail
					]
				);
			}catch(\Stripe\Error\Card $e){
				throw(new\RangeException(""));
			}
		}


	//verify
	$profile = Profile::getProfileByProfileEmail($pdo, $requestObject->profileEmail);
	if($profile !== null) {
		throw(new \RuntimeException("An account has already been created with this email", 422));
	}

	//create a new salt and activation token
	$profileSalt = bin2hex(openssl_random_pseudo_bytes(32));
	$profileActivationToken = bin2hex(openssl_random_pseudo_bytes(16));
//$requestObject->profilePassword second argument from line 74
	//create the hash
	$profileHash = hash_pbkdf2("sha512", $profileSalt, 262144, 128);

	//Not sure if I need this code?
	//create a new account and insert into mySQL
	$profile = new Profile(null, $profileActivationToken, $requestObject->profileEmail, $requestObject->profileFirstName,$profileHash,$requestObject->profileLastName, null, $profileSalt,  null,  $requestObject->profileType,$requestObject->profileUserName);
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
	$swiftMessage = Swift_Message::newInstance();

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

	//=" . $activate removed from the end of line 121
	//building the activation link
	$farmScript = $_SERVER["SCRIPT_NAME"];
	$smtp = dirname($farmScript, 2) . "/activation/?activate";

	$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $smtp;

	$message = <<< EOF
	<h1>Thanks for signing up with Roots-n-table!</h1>
<p>Visit the following URL to confirm your email and complete the registration process <a href = "$confirmLink">Confirm Link</a></p>
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
}

	//update reply with exception information
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and return
echo json_encode($reply);
