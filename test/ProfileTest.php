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
	* update activation token
	* @var string $VALID_ACTIVATEFUZZY2
	**/
	protected $VALID_ACTIVATEFUZZY2;
	/**
	* profile email
	* @var string $VALID_FUZZYMAIL
	**/
	protected $VALID_FUZZYMAIL = "senator_arlo@gmail.com";
	/**
	* profile first name
	* @var string $VALID_FUZZYNAME
	**/
	protected $VALID_FUZZYNAME = "Senator";
	/**
	* profile hash
	* @var string $VALID_HASHTHEFUZZY
	**/
	protected $VALID_HASHTHEFUZZY = null;
	/**
	* profile last name
	* @var string $VALID_FUZZYLASTNAME
	**/
	protected $VALID_FUZZYLASTNAME = "Arlo";
	/**
	* profile phone number
	* @var string $VALID_CALLINGFUZZY
	**/
	protected $VALID_CALLINGFUZZY = "+15557215738";
	/**
	* profile salt
	* @var string $VALID_SALTYFUZZY
	**/
	protected $VALID_SALTYFUZZY = null;
	/**
	* profile stripe token
	* @var string $VALID_STRIPEYFUZZY
	**/
	protected $VALID_STRIPEYFUZZY = "tok_18hQmK2eZvKYlo2CSILNY5nY";
	/**
	* profile type
	* @var string $VALID_WHATFUZZY
	**/
	protected $VALID_WHATFUZZY = "f";
	/**
	* profile user name
	* @var string $VALID_USERFUZZY
	**/
	protected $VALID_USERFUZZY = "Farmer Fuzzy";

	//set up dependent objects
	public function setUp() {

		//run default set up method first
		parent::setUp();

		//create activation tokens
		$VALID_ACTIVATEFUZZY = bin2hex(random_bytes(16));
		$VALID_ACTIVATEFUZZY2 = bin2hex(random_bytes(16));

		//create and set up hash and salt
		$password = "farmerFuzzyLikes505";
		$VALID_SALTYFUZZY = bin2hex(random_bytes(32));
		$VALID_HASHTHEFUZZY = hash_pbkdf2("sha512", $password, $salt, 262144);
	}

	/**
	* test inserting a valid profile and verify the actual SQL data matches
	**/
	public function testInsertValidProfile() {
		//count number of rows and save it for later
		$numRows = $this->$getConnection()->getRowCount("profile");

		//create a new profile and insert it into mySQL
		$profile = new Profile(null, $this->$VALID_ACTIVATEFUZZY, $this->$VALID_FUZZYMAIL, $this->$VALID_HASHTHEFUZZY, $this->$VALID_FUZZYLASTNAME, $this->$VALID_CALLINGFUZZY, $this->VALID_SALTYFUZZY, $this->$VALID_STRIPEYFUZZY, $this->VALID_WHATFUZZY, $this->VALID_USERFUZZY);
		
	}
}
