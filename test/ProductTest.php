<?php
namespace Edu\Cnm\rootstable\Test;

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
	 * create dependent objects before running each testnull
	 */
	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//Create and insert a productId on the product testnull
		$this->productId = new Product("@phpunit", "testnull@phpunit.de");
		$this->productId->insert($this->getPDO());
	}

		/**
		 * testnull inserting valid productId and verify that the actual mySQL data matches
		 */
		public function testInsertValidProduct(){
		//create a new productId and insert it into mySQL
			$productId = new ProductId(null, $this->profile->getProfileId(), $this->VALID_PRODUCTID);
			$productId->insert($this->getPDO());
			//get the data from mySQL and enforce the fields match
			$pdoProduct = Product::getProductByProductId($this->getPDO(), getProductId());
		}

	/**
	 * testnull inserting, editing and updating a product
	 */
	public function testUpdateValidProduct(){
		//write testnull here
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