<?php

namespace Edu\Cnm\rootstable\Test;

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

	/**
	 * Person whose Attention we'll send stuff to
	 * @var string $locationAttention
	 */
	protected $payAttention = "to whom?";

	/**
	 * City where location is
	 * @var string $locationCity
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
	protected $warzone = "What's your adress?";

	/**
	 * Extra space for address
	 * @var string $aptTwo
	 */
	protected $aptTwo = "Additional adress space";

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

// create and insert a Profile to own the test Location
		$this->profile = new Profile(null, "@Johnny", "locationtest@phpunit.de", "+011526567986060");
		$this->profile->insert($this->getPDO());

		/**
		 * test inserting a valid Location and verify that the actual mySQL data matches
		 **/
		public function testInsertValidLocation() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("CentralSt");

			// create a new Location and insert to into mySQL
			$location = new Location(null, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
			$location->insert($this->getPDO());

// grab the data from mySQL and enforce the fields match our expectations
			$pdoLocation = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CentralSt"));
			$this->assertEquals($pdoLocation->getProfile(), $this->profile->getprofileId());
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
			$numRows = $this->getConnection()->getRowCount("CentralSt");

			// create a new Location and insert to into mySQL
			$location = new Location(null, $this->profile->getProfileId(), $this->payAttention, $this->sinCity, $this->granjalada, $this->stateOfMind, $this->warzone, $this->aptTwo, $this->whathood);
			$location->insert($this->getPDO());

			// edit the Location and update it in mySQL
			$location->setLocationStreetOne($this->warzone);
			$location->update($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$pdoLocation = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("CentralSt"));
			$this->assertEquals($pdoLocation->getProfile(), $this->profile->getprofileId());
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
		
	}
}