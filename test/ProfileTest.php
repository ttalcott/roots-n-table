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
	public final function setUp() {

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
		$profile->insert($this->getPDO());

		//grab the data from mySQL
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->$VALID_ACTIVATEFUZZY);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->$VALID_FUZZYMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->$VALID_FUZZYNAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASHTHEFUZZY);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_FUZZYLASTNAME);
		$this->assertEquals($pdoProfile->getProfilePhoneNumber(), $this->VALID_CALLINGFUZZY);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALTYFUZZY);
		$this->assertEquals($pdoProfile->getProfileStipeToken(), $this->VALID_STRIPEYFUZZY);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_WHATFUZZY);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERFUZZY);
	}

	/**
	* test inserting a profile that already exists
	*
	* @expectedException PDOException
	**/

	public function testInsertInvalidProfile() {
		//create a profile with a non null profie id and watch it fail
		$profile = new Profile(RootsTableTest::INVALID_KEY, $this->$VALID_ACTIVATEFUZZY, $this->$VALID_FUZZYMAIL, $this->$VALID_HASHTHEFUZZY, $this->$VALID_FUZZYLASTNAME, $this->$VALID_CALLINGFUZZY, $this->VALID_SALTYFUZZY, $this->$VALID_STRIPEYFUZZY, $this->VALID_WHATFUZZY, $this->VALID_USERFUZZY);
		$profile->insert($this->getPDO());
	}

	/**
	* test inserting, editing, and updating a valid profile
	**/
	public function testUpdateValidProfile () {
		//count number of rows and save it for later
		$numRows = $this->$getConnection()->getRowCount("profile");

		//create a new profile and insert it into mySQL
		$profile = new Profile(null, $this->$VALID_ACTIVATEFUZZY, $this->$VALID_FUZZYMAIL, $this->$VALID_HASHTHEFUZZY, $this->$VALID_FUZZYLASTNAME, $this->$VALID_CALLINGFUZZY, $this->VALID_SALTYFUZZY, $this->$VALID_STRIPEYFUZZY, $this->VALID_WHATFUZZY, $this->VALID_USERFUZZY);
		$this->insert($this->getPDO());

		//edit the profile and update it in mySQL
		$profile->setProfileActivationToken($this->$VALID_ACTIVATEFUZZY2);
		$profile->update($this->getPDO());

		//grab the data from mySQL
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->$VALID_ACTIVATEFUZZY2);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->$VALID_FUZZYMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->$VALID_FUZZYNAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASHTHEFUZZY);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_FUZZYLASTNAME);
		$this->assertEquals($pdoProfile->getProfilePhoneNumber(), $this->VALID_CALLINGFUZZY);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALTYFUZZY);
		$this->assertEquals($pdoProfile->getProfileStipeToken(), $this->VALID_STRIPEYFUZZY);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_WHATFUZZY);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERFUZZY);
	}

	/**
	* test updating a profile that doesn't exist
	*
	* @expectedException PDOException
	**/
	public function testUpdateInvalidProfile() {
		//create a profile, try to update it without actually updating it and watch it fail
		$profile = new Profile(null, $this->$VALID_ACTIVATEFUZZY, $this->$VALID_FUZZYMAIL, $this->$VALID_HASHTHEFUZZY, $this->$VALID_FUZZYLASTNAME, $this->$VALID_CALLINGFUZZY, $this->VALID_SALTYFUZZY, $this->$VALID_STRIPEYFUZZY, $this->VALID_WHATFUZZY, $this->VALID_USERFUZZY);
		$this->update($this->getPDO());
	}

	/**
	* test creating a profile then deleting it
	**/
	public function testDeleteValidProfile() {
		//count number of rows and save it for later
		$numRows = $this->$getConnection()->getRowCount("profile");

		//create a new profile and insert it into mySQL
		$profile = new Profile(null, $this->$VALID_ACTIVATEFUZZY, $this->$VALID_FUZZYMAIL, $this->$VALID_HASHTHEFUZZY, $this->$VALID_FUZZYLASTNAME, $this->$VALID_CALLINGFUZZY, $this->VALID_SALTYFUZZY, $this->$VALID_STRIPEYFUZZY, $this->VALID_WHATFUZZY, $this->VALID_USERFUZZY);
		$profile->insert($this->getPDO());

		//delete the profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		//grab the data from mySQL and make sure profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection->getRowCount("profile"));
	}

	/**
	* test deleting a profile that does not exist
	*
	* @expectedException PDOException
	**/
	public function testDeleteInvalidProfile () {
		//create a profile and try and delete it without inserting it and watch it fail
		$profile = new Profile(null, $this->$VALID_ACTIVATEFUZZY, $this->$VALID_FUZZYMAIL, $this->$VALID_HASHTHEFUZZY, $this->$VALID_FUZZYLASTNAME, $this->$VALID_CALLINGFUZZY, $this->VALID_SALTYFUZZY, $this->$VALID_STRIPEYFUZZY, $this->VALID_WHATFUZZY, $this->VALID_USERFUZZY);
		$profile->delete($this->getPDO());
	}

	/**
	* test getting a profile by profile activation token
	**/
	public function testGetValidProfileByProfileActivationToken() {
		//count number of rows and save it for later
		$numRows = $this->$getConnection()->getRowCount("profile");

		//create a new profile and insert it into mySQL
		$profile = new Profile(null, $this->$VALID_ACTIVATEFUZZY, $this->$VALID_FUZZYMAIL, $this->$VALID_HASHTHEFUZZY, $this->$VALID_FUZZYLASTNAME, $this->$VALID_CALLINGFUZZY, $this->VALID_SALTYFUZZY, $this->$VALID_STRIPEYFUZZY, $this->VALID_WHATFUZZY, $this->VALID_USERFUZZY);
		$this->insert($this->getPDO());

		//grab the data from mySQL and make sure it matches our expectations
		$results = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\rootstable\\Profile", $results);

		//grab the results from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->$VALID_ACTIVATEFUZZY);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->$VALID_FUZZYMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->$VALID_FUZZYNAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASHTHEFUZZY);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_FUZZYLASTNAME);
		$this->assertEquals($pdoProfile->getProfilePhoneNumber(), $this->VALID_CALLINGFUZZY);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALTYFUZZY);
		$this->assertEquals($pdoProfile->getProfileStipeToken(), $this->VALID_STRIPEYFUZZY);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_WHATFUZZY);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERFUZZY);
	}

	/**
	* test grabbing a profile by activation token that does not exist
	*
	* @expectedException PDOException
	**/
	public function testGetInvalidProfileByProfileActivationToken() {
		//grab a profile by searching for content that does not exist
			$profile = Profile::getProfileByProfileActivationToken($this->getPDO(), "these are not the droids you are looking for");
			$this->assertCount(0, $profile);
	}

	/**
	* test grabbing a profile by email
	**/
	public function testGetProfileByProfileEmail() {
		//count number of rows and save it for later
		$numRows = $this->$getConnection()->getRowCount("profile");

		//create a new profile and insert it into mySQL
		$profile = new Profile(null, $this->$VALID_ACTIVATEFUZZY, $this->$VALID_FUZZYMAIL, $this->$VALID_HASHTHEFUZZY, $this->$VALID_FUZZYLASTNAME, $this->$VALID_CALLINGFUZZY, $this->VALID_SALTYFUZZY, $this->$VALID_STRIPEYFUZZY, $this->VALID_WHATFUZZY, $this->VALID_USERFUZZY);
		$this->insert($this->getPDO());

		//grab the data from mySQL and make sure it matches our expectations
		$results = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\rootstable\\Profile", $results);

		//grab the results from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->$VALID_ACTIVATEFUZZY);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->$VALID_FUZZYMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->$VALID_FUZZYNAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASHTHEFUZZY);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_FUZZYLASTNAME);
		$this->assertEquals($pdoProfile->getProfilePhoneNumber(), $this->VALID_CALLINGFUZZY);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALTYFUZZY);
		$this->assertEquals($pdoProfile->getProfileStipeToken(), $this->VALID_STRIPEYFUZZY);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_WHATFUZZY);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERFUZZY);
	}
}
