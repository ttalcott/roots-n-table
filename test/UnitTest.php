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
		$numRows = $this->getConnection()->getRowCount("unit");

		//create a new unit and insert it into mySQL
		$unit = new Unit(null, $this->VALID_UNITNAME);
		$unit->insert($this->getPDO());

		//grab the data from mySQL
		$pdoUnit = Unit::getUnitByUnitId($this->getPDO(), $unit->getUnitId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("unit"));
		$this->assertEquals($pdoUnit->getUnitName(), $this->$VALID_UNITNAME);
	}

	/**
	* test inserting a unit that already exists
	*
	* @expectedException PDOException
	**/
	public function testInsertInvalidUnit() {
		//create a unit with a non-null unit id and watch it fail
		$unit = new Unit(RootsTableTest::INVALID_KEY, $this->VALID_UNITNAME);
		$unit->insert($this->getPDO());
	}

	/**
	* test deleting a unit
	**/
	public function testDeleteValidUnit() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("unit");

		//create a new unit and insert it into mySQL
		$unit = new Unit(null, $this->VALID_UNITNAME);
		$unit->insert($this->getPDO());

		//delete the unit
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("unit"));
		$unit->delete($this->getPDO());

		//grab the data from mySQL and make sure there is no more unit
		$pdoUnit = Unit::getUnitByUnitId($this->getPDO(), $unit->getUnitId());
		$this->assertNull($unit);
		$this->assertEquals($numRows, $this->getconnection()->getRowCount("unit"));
	}

	/**
	* test deleting a unit that doesn't exist
	*
	* @expectedException PDOException
	**/
	public function testDeleteInvalidUnit() {
		//create a new unit and try to delete it without actually deleting it
		$unit = new Unit(null, $this->VALID_UNITNAME);
		$unit->delete($this->getPDO());
	}

}

 ?>
