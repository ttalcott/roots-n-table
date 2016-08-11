<?php
namespace Edu\Cnm\Rootstable\Test;

//grab the project testnull parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "public_html/php/classes/Product.php");

/**
 * Full PHPUnit testnull for the Product class
 *
 * This is a complete PHPUnit testnull of the Product class. It is complete becase *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see ProductTest
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */
class ProductTest extends RootsTableTest {
	/**
	 * content of the productProfileId
	 * @var int $productProfileId
	 */
	protected $foodProfileId;
	/**
	 * content of productUnitId
	 * @var int $productUnitId
	 */
	protected $foodtUnitId;
	/**
	 * content of productDescription
	 * @var int $productDescription
	 */
	protected $foodDescription;
	/**
	 * content of productName
	 * @var string $productName
	 */
	protected $foodName;
	/**
	 * content of productPrice
	 * @var int $productPrice
	 */
	protected $foodPrice;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//Create and insert variable on the productTest
		$this->foodUnitId = new Product("@phpunit", "testnull@phpunit.de");
		$this->foodUnitId->insert($this->getPDO());
	}

		/**
		 * test inserting valid variable and verify that the actual mySQL data matches
		 */
		public function testInsertValidProduct(){
		//create a new variable and insert it into mySQL
			$foodUnitId = new foodUnitId(null, $this->product->getFoodUnitId(), $this->foodUnitId);
			$foodUnitId->insert($this->getPDO());
			//get the data from mySQL and enforce the fields match
			$pdoProduct = Product::getProductByFoodId($this->getPDO(), getFoodUnitId());
		}

	/**
	 * test inserting, editing and updating a product
	 */
	public function testUpdateValidProduct(){
		//write test here
	}

	/**
	 * testnull updating a product that does not exist
	 *
	 * @expectedException PDOException
	 */
	public function testUpdateInvaildProduct(){
		//write testnull here
	}

	/**
 * testnull creating a product and deleting it
 */
	public function testDeleteValidProduct() {
		//Write testnull here
	}
}