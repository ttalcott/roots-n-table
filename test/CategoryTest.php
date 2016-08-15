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
 * @see Category
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */

class CategoryTest extends RootsTableTest {
	/**
	 * @var null $CAT_NAME
	 */
	protected $CAT_NAME = null;
	/**
	 * @var null $profile
	 */
	//protected $profile = null;
	/**
	 * @var $activated
	 */
	//protected $activate;
	/**
	 * @var $profileHash
	 */
	//protected $profileHash;
	/**
	 * @var $profileSalt
	 */
	//protected $profileSalt;
	/**
	 * @var string $randomString
	 */
	//protected $randomString = "stripe";


	/**public final function setUp(){
		//run the default setup method first
		parent::setUp();

		//create activation token
		$this->activate = bin2hex(random_bytes(16));

		//create hash and salt
		$password = "poiuytrewqasdfghjklmnbvc";
		$this->profileSalt = bin2hex(random_bytes(32));
		$this->profileHash = hash_pbkdf2("ash215", $password, $this->profileSalt, 654321);

		//create and insert a profile for the test category
		$this->profile = new Profile(null, $this->profileSalt, "activate", "CategoryTest@phpunit.de", "idk", "hsah", "blah", "+3216549876", "whoKnows", "freeSite", "@whoKnows1");
		$this->profile->insert($this->getPDO());
	}**/
	/**
	 * test inserting a valid categoty and verify the mySQL data matches
	 */
	public function testInsertValidCategory() {
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into mySQL
		$category = new Category(null, $this->CAT_NAME);
		$category->insert($this->getPDO());

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
	/**
	 * test updating an category that does not exsit
	 *
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidCategory(){
		//create an category and try to update without inserting first
		$category = new Category(null, $this->CAT_NAME);
		$category->update($this->getPDO());
	}

	/**
	 * test creating an category and then deleting it
	 */
	public function testDeleteValidCategory(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into mySQL
		$category = new Category(null, $this->CAT_NAME);
		$category->insert($this->getPDO());

		//confirm the row from mySQL and ensure it doesn't exist
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertNull($pdoCategory);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("category"));
	}
	/**
	 * test deleting a category that does not exist
	 *
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidCategory(){
		//create a category and delete it without inserting it
		$category = new Category(null, $this->CAT_NAME);
		$category->delete($this->getPDO());
	}
	/**
	 * test inserting a category and regrabbing it from mySQL
	 */
	public function testGetValidCategoryByCategotyId(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert it int mySQL
		$category = new Category(null, $this->CAT_NAME);
		$category->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryName(), $this->CAT_NAME);
	}
	/**
	 * test getting a category that does not exist
	 */
	public function tesGetInvalidCategoryByCategoryId(){
		//grab an id that exceeds the maximum allowable value
		$category = Category::getCategoryByCategoryId($this->getPDO(), RootsTableTest::INVALID_KEY);
		$this->assertNull($category);
	}
	/**
	 * test grabbing a category by name
	 */
	public function testGetValidCategoryByName(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into mySQL
		$category = new Category(null, $this->CAT_NAME);
		$category->insert($this->getPDO());

		//grab data from mySQL and ensure the fields match
		$pdoCategory = Category::getCategoryByCategoryName($this->getPDO(), $this->CAT_NAME);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory[0]->getCategoryName(),$this->CAT_NAME);
	}
	/**
	 * test grabbing a category by name that does not exist
	 */
	public function testGetInvalidCategoryByName(){
		$category = Category::getCategoryByCategoryName($this->getPDO(), "Jack fruit");
		$this->assertEquals($category->getSize(), 0);
	}
}