<?php

namespace Edu\Cnm\rootstable\Test;

//grab the project test parameters
require_once("rootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Location class
 *
 * This is a test of the Location class in PHP Unit. It's purpose is to test all mySQL/PDO enabled methods for both invalid and valid inputs.
 *
 * @see LocationTest
 * @author Raul Villarreal <rvillarrcal@cnm.edu>
 */

class LocationTest extends rootstableTest {
	/**
	 * Let's start with the content of the locationId
	 * This is the primary key
	 * @var int $locationId
	 */
	//Not sure if this is correct I just copied Robert
	public $locationId = "YOU'RE NULL Zero, Zip, Nothing, Nada, Ni Maizz";

	/**
	 * content of the locationProfileId
	 * @var int $locationProfileId
	 */
	public $locationProfileId = "Fuzzy to the second power?";

	/**
	 * content of the locationName
	 * @var int $locationName
	 */
	public $locationName = "What is ur place's name?";

	/**
	 * content of the locationAttention
	 * @var int $locationAttention
	 */
	public $locationAttention = "Who's the gatekeeper?";

	/**
	 * content of the locationStreetOne
	 * @var int $locationStreetOne
	 */
	public $locationStreetOne = "Where's your farm at?";

	/**
	 * content of the locationStreetTwo
	 * @var int $locationStreetTwo
	 */
	public $locationStreetTwo = "I need more details?";

	/**
	 * content of the locationCity
	 * @var int $locationCity
	 */
	public $locationCity = "Is it ABQ?";

	/**
	 * content of the locationState
	 * @var int $locationState
	 */
	public $locationState = "Is it in the Land of Enchantment?";

	/**
	 * content of the locationZipCode
	 * @var int $locationZipCode
	 */
	public $locationZipCode = "Gimmy 5... digits";

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//Create and insert a locationId on the location test
		$this->locationId = new Location("@phpunit", "test@phpunit.de");
		$this->locationId->insert($this->getPDO());
	}

	/**
	 * Test to insert a valid locationId and verify that the actual mySQL data matches
	 */
	public function testInsertValidLocation(){
		//create a new locationId and insert it into mySQL
		$locationId = new locationId(null, $this->location->getLocationId(), $this->VALID_LOCATIONID);
		$locationId->insert($this->getPDO());
		//get the data from mySQL and enforce the fields match
		$pdoLocation = Location::getLocationByLocationId($this->getPDO(), getLocationId());
	}

	/**
	 * test inserting, editing and updating a location
	 */
	public function testUpdateValidLocation(){
		//write test here
	}

	/**
	 * test updating a location that does not exist
	 *
	 * @expectedException PDOException
	 */
	public function testUpdateInvaildLocation(){
		//write test here
	}

	/**
	 * test creating a location and deleting it
	 */
	public function testDeleteValidLocation() {
		//Write test here
	}
}