<?php
namespace Edu\Cnm\Rootstable;

use Edu\Cnm\Rootstable\Unit;

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
* php unit test of the Unit class for Roots 'n Table
*
* @see Unit
* @author Travis Talcott <ttalcott@lyradevelopment.com>
**/

class UnitTest extends RootsTableTest {
	/**
	* unit name
	* @var string $VALID_UNITNAME
	**/
	protected $VALID_UNITNAME = "Kitty";

	/**
	* test inserting a valid unit
	**/
	public function testInsertValidUnit() {
		//count the number of rows and save for later 
	}
}

 ?>
