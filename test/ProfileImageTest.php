<?php
namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\{Profile, Image, ProfileImage};

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
* php unit test of the ProfileImage class for Roots 'n Table
*
* @see ProfileImage
* @author Travis Talcott <ttalcott@lyradevelopment.com>
**/

class ProfileImageTest extends RootsTableTest {
	/**
	* activation token for the profile that this profileImage belongs to
	* @var string $VALID_ACTIVATEPROFILE
	**/
	protected $VALID_ACTIVATEPROFILE;
	/**
	* email for the profile that this profileImage belongs to
	* @var string $VALID_PROFILEEMAIL
	**/
	protected $VALID_PROFILEEMAIL = "senator@gmail.com";
	/**
	* first name of the profile that this profileImage belongs to
	* @var string $VALID_FIRSTNAME
	**/
	protected $VALID_FIRSTNAME = "Fuzzy";
	/**
	* hash of the profile that this profileImage belongs to
	* @var string $VALID_HASH
	**/
	protected $VALID_HASH = null;
	/**
	* last name of the profile that this profileImage belongs to
	* @var string $VALID_LASTNAME
	**/
	protected $VALID_LASTNAME = "Cat";
	/**
	* phone number of the profile that this profileImage belongs to
	* @var string $VALID_PHONE
	**/
	protected $VALID_PHONE = "+15557216739";
	/**
	* salt for the profile that this profileImage belongs to
	* @var string $VALID_SALT
	**/
	protected $VALID_SALT = null;
	/**
	* stripe token of the profile that this profileImage belongs to
	* @var string $VALID_STRIPE
	**/
	protected $VALID_STRIPE = "tok_18hQmK2eZvKYlo2CSILNY5nH";
	/**
	* profile type of the profile that this profileImage belongs to
	* @var string $VALID_TYPE
	**/
	protected $VALID_TYPE = "u";
	/**
	* username of the profile that this profileImage belongs to
	* @var string $VALID_USER
	**/
	protected $VALID_USER = "fuzzy cat";

}


 ?>
