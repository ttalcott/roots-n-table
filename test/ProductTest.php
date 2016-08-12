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
	protected $foodUnitId;
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
		$this->assertEquals($pdoProduct->getProductUnitId(),$this->foodUnitId);
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}

	/**
	 * rest inserting an product that cannot be added
	 *
	 *  @expectedException PDOException
	 */
	public function testInsertInvalidProduct(){
		//create product with non-null id so it will fail
		$product = new product(RootsTableTest::INVALID_KEY, $this->foodProfileId,$this->foodUnitId,$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting, editing and updating a product
	 */
	public function testUpdateValidProduct(){
		//get the of the number of rows in the database
		$numRows = $this->getConnection()->getRowCount("product");

		//create a new product and insert into mySQL
		$product = new \Product(null, $this->foodProfileId,$this->foodUnitId,$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//edit the product and update it in mySQL
		$product->setProductName($this->foodName);
		$product->update($this->getPDO());

		//grab data from SQL and ensure it matches
		$pdoProduct = Product::getProductByProductId($this->getPDO(),$product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductProfileId, $this->foodProfileId);
		$this->assertEquals($pdoProduct->getProductUnitId, $this->foodUnitId);
		$this->assertEquals($pdoProduct->getProductDescription, $this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName, $this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice,
			$this->foodPrice);
	}

	/**
	 * test updating a product that does not exist
	 *
	 * @expectedException PDOException
	 */
	public function testUpdateInvalidProduct(){
		//create a product and try to update without inserting it first
		$product = new Product(null, $this->foodProfileId, $this->foodUnitId,$this->foodDescription, $this->foodName,$this->foodPrice);
		$product->update($this->getPDO());
	}

	/**
	 * test creating a product and deleting it
	 */
	public function testDeleteValidProduct() {
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("product");
		//create a new product and insert into mySQL
		$product = new Product(null, $this->foodProfileId, $this->foodUnitId,$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//confirm the row was added, then delete it
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$product->delete($this->getPDO());

		//grab data from mySQL and make sure it doesn't exsit
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertNull($pdoProduct);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("product"));
	}
	/**
	 * test deleting a product that doesn't exist
	 *
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidProduct(){
		//create a product and delete without inserting it
		$product = new Product(null, $this->foodProfileId,$this->foodUnitId,$this->foodDescription,$this->foodName,$this->foodPrice);
	}
	/**
	 * test inserting a product and regrabbing it from mySQL
	 */
	public function testGetValidProductByProductId(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("product");

		//creata a new product and insert into mySQL
		$product = new Product(null, $this->foodProfileId,$this->foodUnitId,$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductProfileId(),$this->foodProfileId);
		$this->assertEquals($pdoProduct->getProductUnitId(),$this->foodUnitId);
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test getting a product that doesn't exsit
	 */
	public function testGetInvalidProductByProductId(){
		//grab an id that exceeds the maximum allowable value
		$product = Product::getProductByProductId($this->getPDO(), RootsTableTest::INVALID_KEY);
	}
	/**
	 * test grabbing a product by productProfileId
	 */
	public function testGetValidProductByProfileId(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("product");

		//create a new product and insert into mySQL
		$product = new Product(null, $this->foodProfileId,$this->foodUnitId,$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match
		$pdoProduct = Product::getProductByProductProfileId($this->getPDO(),$this->foodProfileId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct[0]->getProductProfileId(),$this->foodProfileId);
		$this->assertEquals($pdoProduct[0]->getProductUnitId(),$this->foodUnitId);
		$this->assertEquals($pdoProduct[0]->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct[0]->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct[0]->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test for grabbing a product by profileId that doesn't exsit
	 */
	public function testGetInvalidProductByProfileId(){
		$product = Product::getProductByProductProfileId($this->getPDO(), "tops");
		$this->assertEquals($product->getSize(),0);
	}
	/**
	 * test grabbing a product by unitId
	 */
	public function testGetValidProductByUnitId(){
		//count the number or rows currently in the database
		$numRows = $this->getConnection()->getRowCount("product");
		
		//create a new product and insert it into mySQL
		$product = new Product(null, $this->foodProfileId,$this->foodUnitId,$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match
		$pdoProduct = Product::getProductByProductUnitId($this->getPDO(),$this->foodUnitId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct[0]->getProductProfileId(),$this->foodProfileId);
		$this->assertEquals($pdoProduct[0]->getProductUnitId(),$this->foodUnitId);
		$this->assertEquals($pdoProduct[0]->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct[0]->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct[0]->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test grabbing a product by unitId that doesn't exist
	 */
	public function testGetInvalidProductByUnitId(){
		$product = Product::getProductByProductUnitId($this->getPDO(), "tops");
		$this->assertEquals($product->getSize(),0);
	}
}