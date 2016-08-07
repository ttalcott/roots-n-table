<?php

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





}