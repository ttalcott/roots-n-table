<?php
namespace Edu\Cnm\Rootstable\Test;

//grab the project test parameters
use Edu\Cnm\Rootstable\Category;

require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * PHPUnit test for the Category class 
 * 
 * @see
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */

class CategoryTest extends RootsTableTest {
	protected $CAT_NAME = null;


	/**
	 * test inserting a valid categoty and verify the mySQL data matches
	 */
	public function testInsertValidCategory() {
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into mySQL
		$category = new Category(null, $this->CAT_NAME);
		$category->insert<$this->getPDO();

		//grab data from SQL and ensure it matches
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryName(), $this->CAT_NAME);
	}
	/**
	 * test inserting a category that cannot be added
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidCategory(){
		//create a category with non-null id for it to fail
		$category = new Category(RootsTableTest::INVALID_KEY, $this->CAT_NAME);
		$category->insert($this->getPDO());
	}

	/**
	 * test inserting a category, editing it then updating it
	 */
	public function testUpdateValidCategory(){
		//get the count of the number of rows in the database
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into mySQL
		$category = new Category(null, $this->CAT_NAME);
		$category->update($this->getPDO());

		//grab data from SQL and ensure it matches
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryName(), $this->CAT_NAME);
	}
}