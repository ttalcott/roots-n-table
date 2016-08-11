<?php
namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\Profile;

//grab the project test parameters
require_once("RootsTableTest");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/classes/autoload.php");

/**
* Full PHPUnit test of the Profile class
*
* @see Profile
* @author Travis Talcott <ttalcott@lyradevelopment.com>
**/

class ProfileTest extends RootsTableTest {
	/**
	* profile activation token
	* @var string $VALID_ACTIVATEFUZZY
	**/
	protected $VALID_ACTIVATEFUZZY;
	/**
	* profile email
	* @var string $VALID_FUZZYMAIL
	**/
	protected $VALID_FUZZYMAIL;
	/**
	* profile first name
	* @var string $VALID_FUZZYNAME
	**/
	protected $VALID_FUZZYNAME;
	/**
	* profile hash
	* @var string $VALID_HASHTHEFUZZY
	**/
	protected $VALID_HASHTHEFUZZY = null;
	/**
	* profile last name
	* @var string $VALID_FUZZYLASTNAME
	**/
	protected $VALID_FUZZYLASTNAME;
	/**
	* profile phone number
	* @var string $VALID_CALLINGFUZZY
	**/
	protected $VALID_CALLINGFUZZY;
	/**
	* profile salt
	* @var string $VALID_SALTYFUZZY
	**/
	protected $VALID_SALTYFUZZY = null;
	/**
	* profile stripe token
	* @var string $VALID_STRIPEYFUZZY
	**/
	protected $VALID_STRIPEYFUZZY;
	/**
	* profile type
	* @var string $VALID_WHATFUZZY
	**/
	protected $VALID_WHATFUZZY;
	/**
	* profile user name
	* @var string $VALID_USERFUZZY
	**/
	protected $VALID_USERFUZZY;

	//set up dependent objects
	public function setUp() {
		//run default set up method first
		parent::setUp();

		//create and set up hash and salt
		$password = "farmerFuzzyLikes212";
		$salt = bin2hex(random_bytes(16));
		$hash = hash_pbkdf2("sha512", $password, $salt, 262144);
	}

	/**
	* test inserting a valid profile and verify the actual SQL data matches
	**/
	public function testInsertValidProfile() {
		//count number of rows and save it for later
		$numRows = $this->$getConnection()->getRowCount("profile");

		
	}
}
