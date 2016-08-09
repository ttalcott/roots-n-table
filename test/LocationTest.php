<?php

namespace Edu\Cnm\rootstable\Test;

//grab the project testnull parameters
require_once("RootsTableTest-foo.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Full PHPUnit testnull for the Location class
 *
 * This is a testnull of the Location class in PHP Unit. It's purpose is to testnull all mySQL/PDO enabled methods for both invalid and valid inputs.
 *
 * @see LocationTest
 * @author Raul Villarreal <rvillarrcal@cnm.edu>
 */
class LocationTest extends RootsTableTest {
	/**
	 * Let's start with the content of the locationId
	 * This is the primary key
	 * @var int $locationId
	 */
	//Not sure if this is correct I just copied Robert
	protected $locationId = "YOU'RE NULL Zero, Zip, Nothing, Nada, Ni Maizz";

	/**
	 * content of the locationProfileId
	 * @var int $locationProfileId
	 */
	protected $locationProfileId = "Fuzzy to the second power?";

	/**
	 * content of the locationName
	 * @var int $locationName
	 */
	protected $locationName = "What is ur place's name?";

	/**
	 * content of the locationAttention
	 * @var int $locationAttention
	 */
	protected $locationAttention = "Who's the gatekeeper?";

	/**
	 * content of the locationStreetOne
	 * @var int $locationStreetOne
	 */
	protected $locationStreetOne = "Where's your farm at?";

	/**
	 * content of the locationStreetTwo
	 * @var int $locationStreetTwo
	 */
	protected $locationStreetTwo = "I need more details?";

	/**
	 * content of the locationCity
	 * @var int $locationCity
	 */
	protected $locationCity = "Is it ABQ?";

	/**
	 * content of the locationState
	 * @var int $locationState
	 */
	protected $locationState = "Is it in the Land of Enchantment?";

	/**
	 * content of the locationZipCode
	 * @var int $locationZipCode
	 */
	protected $locationZipCode = "Gimmy 5... digits";

	/**
	 * create dependent objects before running each testnull
	 */
	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//Create and insert a profile to own the location
		$this->location = new Location(null "Granjas el Pollon", "Don Pancho", "400 Central Ave.", "Apt.3a-5", "Albuquerque", "NM", "87293");
		$this->location->insert($this->getPDO());
	}

	/**
	 * Test to insert a valid location and verify that the actual mySQL data matches
	 */
	public function testInsertValidLocation() {
		//create a new locationId and insert it into mySQL
		$locationId = new location(null, $this->location->getLocation(), $this->VALID_LOCATION);
		$location->insert($this->getPDO());
		//get the data from mySQL and enforce the fields match
		$pdoLocation = Location::getLocationByLocationId($this->getPDO(), getLocationId());
	}

	/**
	 * testnull inserting, editing and updating a location
	 */
	public function testUpdateValidLocation() {
		//write testnull here
	}

	/**
	 * testnull updating a location that does not exist
	 *
	 * @expectedException PDOException
	 */
	public function testUpdateInvaildLocation() {
		//write testnull here
	}

	/**
	 * testnull creating a location and deleting it
	 */
	public function testDeleteValidLocation() {
		//Write testnull here
	}
}