<?php
namespace Edu\Cnm\rootstable\Test;

//grab the project test parameters
require_once("rootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Product class
 *
 * This is a complete PHPUnit test of the Product class. It is complete becase *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see ProductTest
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */
class ProductTest extends rootstableTest {
	/**
	 * content of the product
	 * This is the primary key
	 * @var int $productId
	 */
	//Not sure if this is correct.
	public $productId = "YOU'RE NULL";
	/**
	 * content of the productProfileId
	 * @var int $productProfileId
	 */
	public $productProfileId = "Fuzzy?";
	/**
	 * content of productUnitId
	 * @var int $productUnitId
	 */
	public $productUnitId = "How much would you like.";
	/**
	 * content of productDescription
	 * @var int $productDescription
	 */
	public $productDescription ="Fresh produce";
	/**
	 * content of productName
	 * @var string $productName
	 */
	public $productName = "Peppers";
	/**
	 * content of productPrice
	 * @var int $productPrice
	 */
	public $productPrice = "13.49";

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//Create and insert a productId on the product test
		$this->productId = new Product("@phpunit", "test@phpunit.de");
		$this->productId->insert($this->getPDO());
	}

		/**
		 * test inserting valid productId and verify that the actual mySQL data matches
		 */
		public function testInsertValidProduct(){
		//create a new productId and insert it into mySQL
			$productId = new ProductId(null, $this->profile->getProfileId(), $this->VALID_PRODUCTID);
			$productId->insert($this->getPDO());
			//get the data from mySQL and enforce the fields match
			$pdoProduct = Product::getProductByProductId($this->getPDO(), getProductId());
		}

	/**
	 * test inserting, editing and updating a product
	 */
	public function testUpdateValidProduct(){
		//write test here
	}

	/**
	 * test updating a product that does not exist
	 *
	 * @expectedException PDOException
	 */
	public function testUpdateInvaildProduct(){
		//write test here
	}

	/**
 * test creating a product and deleting it
 */
	public function testDeleteValidProduct() {
		//Write test here
	}
}