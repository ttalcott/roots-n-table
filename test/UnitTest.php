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
	* unit name 2
	* @var string $VALID_UNITNAME2
	**/
	protected $VALID_UNITNAME2 = "Indie";

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

	/**
	* test inserting a unit, editing it, then updating it
	**/
	public function testUpdateValidUnit() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("unit");

		//create a new unit and insert it into mySQL
		$unit = new Unit(null, $this->VALID_UNITNAME);
		$unit->insert($this->getPDO());

		//update the unit
		$unit->setUnitName($this->VALID_UNITNAME2);
		$unit->update($this->getPDO());

		//grab the data from mySQL
		$pdoUnit = Unit::getUnitByUnitId($this->getPDO(), $unit->getUnitId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("unit"));
		$this->assertEquals($pdoUnit->getUnitName(), $this->$VALID_UNITNAME2);
	}

	/**
	* test updating a unit that doesn't exist
	*
	* @expectedException PDOException
	**/
	public function testUpdateInvalidUnit() {
		//create a unit and update it without actually updating it
		$unit = new Unit(null, $this->VALID_UNITNAME);
		$unit->update($this->getPDO());
	}

	/**
	* test grabbing the unit by unit name
	**/
	public function testGetUnitByUnitName() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("unit");

		//create a new unit and insert it into mySQL
		$unit = new Unit(null, $this->VALID_UNITNAME);
		$unit->insert($this->getPDO());

		//grab the data from mySQL and make sure it matches our expectations
		$results = Unit::getUnitByUnitName($this->getPDO(), $unit->getUnitName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("unit"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\Unit");

		//grab the results from the array and validate it
		$pdoUnit = $results[0];
		$this->assertEquals($pdoUnit->getUnitName(), $this->$VALID_UNITNAME);
	}

	/**
	* test grabbing a unit by a name that does not exist
	**/
	public function testGetInvalidUnitByUnitName() {
		//grab a unit by searching for a name that does not exist
		$unit = Unit::getUnitByUnitName($this->getPDO(), "These are not the droids you are looking for");
		$this->assertCount(0, $unit);
	}

	/**
	* test grabbing all units
	**/
	public function testGetAllUnits() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("unit");

		//create a new unit and insert it into mySQL
		$unit = new Unit(null, $this->VALID_UNITNAME);
		$unit->insert($this->getPDO());

		//grab the data from mySQL and make sure it matches our expectations
		$results = Unit::getAllUnits($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("unit"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\Unit");

		//grab the results from the array and validate it
		$pdoUnit = $results[0];
		$this->assertEquals($pdoUnit->getUnitName(), $this->$VALID_UNITNAME);
	}
}

 ?>
