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
	 * Let's start with the content of the Location class
	 * This is the primary key
	 * @var int $locationId
	 */
	//Not sure if this is correct. Me neither, I just copied Robert
	public $locationId = "YOU'RE NULL Zero, Zip, Nothing Nada, Ni Maizz";
