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
		$this->productUnitId = new Product("@phpunit", "testnull@phpunit.de");
		$this->productUnitId->insert($this->getPDO());
	}

	/**
	 * test inserting valid variable and verify that the actual mySQL data matches
	 */
	public function testInsertValidProduct(){
		//count the number of rows in the database
		$numRows = $this->getConnection()->getRowCount("product");
		//create a new variable and insert it into mySQL
		$product = new product(null, $this->foodProfileId,$this->foodUnitId, $this->foodDescription, $this->foodName, $this->foodPrice);
		$product->insert($this->getPDO());
		//get the data from mySQL and enforce the fields match
		$pdoProduct = Product::getProductByproductId($this->getPDO(), $product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductProfileId(),$this->foodProfileId);
		$this->assertEquals($pdoProduct->getProductUnitId(),$this->foodtUnitId);
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
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