<?php

namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\{Profile, Location};

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Location class
 *
 * This is a complete PHPUnit test of the Location class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Location
 * @author Raul Villarreal <rvillarrcal@cnm.edu>
 **/

class LocationTest extends RootsTableTest {

	/**
	 * Profile that created the Location; this is for foreign key relations
	 * @var Profile Location
	 **/
	protected $profile = null;

	/** Hexadecimal string for the activation token
	 * @var string $activate
	 */
	protected $activate;

	/** Profile Hash for the password
	 * @var string $profileHash
	 */
	protected $profileHash;

	/** Profile Salt for password
	 * @var string $profileSalt
	 */
	protected $profileSalt;

	/**
	 * Person whose Attention we'll send stuff to
	 * @var string $payAttention
	 */
	protected $payAttention = "to whom?";

	/**
	 * City where location is
	 * @var string $sinCity
	 */
	protected $sinCity = "What city?";

	/**
	 * Name of the location
	 * @var string $granjalada
	 */
	protected $granjalada = "What is your farm's name?";

	/**
	 * State where location is
	 * @var string $stateOfMind
	 */
	protected $stateOfMind = "What state are you at?";

	/**
	 * Address where location is
	 * @var string $warzone
	 */
	protected $warzone = "What's your address?";

	/**
	 * Extra space for address
	 * @var string $aptTwo
	 */
	protected $aptTwo = "Additional address space";

	/**
	 * Zip Code of location
	 * @var string $whathood
	 */
	protected $whathood = "Zip Code";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		/** create activation token */
		$this->activate = bin2hex(random_bytes(16));

		/**create hash and salt*/
		$password = "thisisafakerandompassword";
		$this->profileSalt = bin2hex(random_bytes(32));
		$this->profileHash = hash_pbkdf2("sha512", $password, $this->profileSalt, 262144);

		// create and insert a Profile to own the test Purchase
		$this->profile = new Profile(null, $this->activate, "purchasetest@phpunit.de", "Chriss", $this->profileHash, "Kross","+011526567986060", $this->profileSalt, "stripey", "u", "@ChrissKross");
		$this->profile->insert($this->getPDO());
	}

		/**
		 * test inserting a valid Location and verify that the actual mySQL data matches
		 **/
		public function testInsertValidLocation() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("location");

			// create a new Location and insert to into mySQL
			$location = new Location(null, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
			$location->insert($this->getPDO());

// grab the data from mySQL and enforce the fields match our expectations
			$pdoLocation = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
			$this->assertEquals($pdoLocation->getLocationProfileId(), $this->profile->getProfileId());
			$this->assertEquals($pdoLocation->getLocationAttention(), $this->payAttention);
			$this->assertEquals($pdoLocation->getLocationCity(), $this->sinCity);
			$this->assertEquals($pdoLocation->getLocationName(), $this->granjalada);
			$this->assertEquals($pdoLocation->getLocationState(), $this->stateOfMind);
			$this->assertEquals($pdoLocation->getLocationStreetOne(), $this->warzone);
			$this->assertEquals($pdoLocation->getLocationStreetTwo(), $this->aptTwo);
			$this->assertEquals($pdoLocation->getLocationZipCode(), $this->whathood);
		}

		/**
		 * test inserting a Location that already exists
		 *
		 * @expectedException PDOException
		 **/
		public function testInsertInvalidLocation() {
			// create a Location with a non null location id and watch it fail
			$location = new Location(RootsTableTest::INVALID_KEY, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
			$location->insert($this->getPDO());
		}

		/**
		 * test inserting a Location, editing it, and then updating it
		 **/
		public function testUpdateValidLocation() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("location");

			// create a new Location and insert to into mySQL
			$location = new Location(null, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
			$location->insert($this->getPDO());

			// edit the Location and update it in mySQL
			$location->setLocationStreetOne($this->warzone);
			$location->update($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$pdoLocation = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
			$this->assertEquals($pdoLocation->getLocationProfileId(), $this->profile->getProfileId());
			$this->assertEquals($pdoLocation->getLocationAttention(), $this->payAttention);
			$this->assertEquals($pdoLocation->getLocationCity(), $this->sinCity);
			$this->assertEquals($pdoLocation->getLocationName(), $this->granjalada);
			$this->assertEquals($pdoLocation->getLocationState(), $this->stateOfMind);
			$this->assertEquals($pdoLocation->getLocationStreetOne(), $this->warzone);
			$this->assertEquals($pdoLocation->getLocationStreetTwo(), $this->aptTwo);
			$this->assertEquals($pdoLocation->getLocationZipCode(), $this->whathood);
		}

		/**
		 * test updating a Location that does not exist
		 *
		 * @expectedException PDOException
		 **/
		public function testUpdateInvalidLocation() {
			// create a Location, try to update it without actually updating it and watch it fail
			$location = new Location(null, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
			$location->update($this->getPDO());
		}

	/**
	 * test creating a Location and then deleting it
	 **/
	public function testDeleteValidLocation() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$location = new Location(null, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
		$location->insert($this->getPDO());

		// delete the Location from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$location->delete($this->getPDO());

		// grab the data from mySQL and enforce the Location does not exist
		$pdoLocation = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertNull($pdoLocation);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("location"));
	}

	/**
	 * test deleting a Location that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidLocation() {
		// create a Location and try to delete it without actually inserting it
		$location = new Location(null, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
		$location->delete($this->getPDO());
	}


	/**
	 * test grabbing a Location by location Id
	 **/
	public function testGetValidLocationByLocationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$location = new Location(null, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertEquals($results->getLocationProfileId(), $this->profile->getProfileId());
		$this->assertEquals($results->getLocationAttention(), $this->payAttention);
		$this->assertEquals($results->getLocationCity(), $this->sinCity);
		$this->assertEquals($results->getLocationName(), filter_var($this->granjalada, FILTER_SANITIZE_STRING));
		$this->assertEquals($results->getLocationState(), $this->stateOfMind);
		$this->assertEquals($results->getLocationStreetOne(), filter_var($this->warzone, FILTER_SANITIZE_STRING));
		$this->assertEquals($results->getLocationStreetTwo(), $this->aptTwo);
		$this->assertEquals($results->getLocationZipCode(), $this->whathood);
		
	}

	/**
	 * test grabbing a Location by location Id that does not exist
	 *
	 * @expectedException \PDOException when mySQL related Errors occur
	 **/
	public function testGetInvalidLocationByLocationId() {

		// grab a location by searching for location id that does not exist
		$location = Location::getLocationByLocationId($this->getPDO(), RootsTableTest::INVALID_KEY);
		$this->assertNull($location);
	}

	/**
	 * test grabbing a Location by location Profile Id
	 **/
	public function testGetValidLocationByLocationProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$location = new Location(null, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Location::getLocationByLocationProfileId($this->getPDO(), $location->getLocationProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\Location", $results);
		
		//grab the result of the array and validate it
		$pdoLocation = $results[0];
		$this->assertEquals($pdoLocation->getLocationProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoLocation->getLocationAttention(), $this->payAttention);
		$this->assertEquals($pdoLocation->getLocationCity(), $this->sinCity);
		$this->assertEquals($pdoLocation->getLocationName(), $this->granjalada);
		$this->assertEquals($pdoLocation->getLocationState(), $this->stateOfMind);
		$this->assertEquals($pdoLocation->getLocationStreetOne(), $this->warzone);
		$this->assertEquals($pdoLocation->getLocationStreetTwo(), $this->aptTwo);
		$this->assertEquals($pdoLocation->getLocationZipCode(), $this->whathood);
	}

	/**
	 * test grabbing a Location by location Profile Id that does not exist
	 *
	 * @expectedException \PDOException when mySQL related Errors occur
	 **/
	public function testGetInvalidLocationByLocationProfileId() {
		// grab a location by searching for location id that does not exist
		$location = Location::getLocationByLocationProfileId($this->getPDO(), RootsTableTest::INVALID_KEY);
		$this->assertCount(0, $location);
	}

	/**
	 * test grabbing a Location by location Street One
	 **/
	public function testGetValidLocationByLocationStreetOne() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$location = new Location(null, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Location::getLocationByLocationStreetOne($this->getPDO(), $location->getLocationStreetOne());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\Location", $results);

		// grab the result from the array and validate it
		$pdoLocation = $results[0];
		$this->assertEquals($pdoLocation->getLocationProfileId(), $this->profile->getprofileId());
		$this->assertEquals($pdoLocation->getLocationAttention(), $this->payAttention);
		$this->assertEquals($pdoLocation->getLocationCity(), $this->sinCity);
		$this->assertEquals($pdoLocation->getLocationName(), $this->granjalada);
		$this->assertEquals($pdoLocation->getLocationState(), $this->stateOfMind);
		$this->assertEquals($pdoLocation->getLocationStreetOne(), $this->warzone);
		$this->assertEquals($pdoLocation->getLocationStreetTwo(), $this->aptTwo);
		$this->assertEquals($pdoLocation->getLocationZipCode(), $this->whathood);
	}

	/**
	 * test grabbing a Location by location Street One that does not exist
	 **/
	public function testGetInvalidLocationByLocationStreetOne() {
		// grab a location by searching for street one that does not exist
		$location = Location::getLocationByLocationStreetOne($this->getPDO(), "That's a ghost street");
		$this->assertCount(0, $location);
	}

	/**
	 * test grabbing all Locations
	 **/
	public function testGetAllValidLocations() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$location = new Location(null, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Location::getAllLocations($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\Location", $results);

		// grab the result from the array and validate it
		$pdoLocation = $results[0];
		$this->assertEquals($pdoLocation->getLocationProfileId(), $this->profile->getprofileId());
		$this->assertEquals($pdoLocation->getLocationAttention(), $this->payAttention);
		$this->assertEquals($pdoLocation->getLocationCity(), $this->sinCity);
		$this->assertEquals($pdoLocation->getLocationName(), $this->granjalada);
		$this->assertEquals($pdoLocation->getLocationState(), $this->stateOfMind);
		$this->assertEquals($pdoLocation->getLocationStreetOne(), $this->warzone);
		$this->assertEquals($pdoLocation->getLocationStreetTwo(), $this->aptTwo);
		$this->assertEquals($pdoLocation->getLocationZipCode(), $this->whathood);
	}
}
