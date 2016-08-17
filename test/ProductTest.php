<?php
namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\{Product, Profile, Unit};
//grab the project parameters
require_once ("RootsTableTest.php");
//grab the class under scrutiny
require_once (dirname(__DIR__) . "/public_html/php/classes/autoload.php");
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
	 * content of productDescription
	 * @var string $productDescription
	 */
	protected $foodDescription = "Apples and Oranges";
	/**
	 * content of productName
	 * @var string $productName
	 */
	protected $foodName = "Apple";
	/**
	 * content of productPrice
	 * @var float $productPrice
	 */
	protected $foodPrice = "1.99";
	/**
	 * profile of user that is selling the product
	 */
	protected  $profile = null;
	/**
	 * @var profile hash 
	 */
	protected  $profileHash;
	/**
	 * @var profile salt
	 */
	protected  $profileSalt;
	/**
	 * @var activate
	 */
	protected  $activate;
	/**
	 * @var null
	 */
	protected  $unit = null;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		/** create activation token */
		$this->activate = bin2hex(random_bytes(16));

		/**create hash and salt*/
		$password = "theroofisonfire5432167890";
		$this->profileSalt = bin2hex(random_bytes(32));
		$this->profileHash = hash_pbkdf2("sha512", $password, $this->profileSalt, 262144);

		// create and insert a Profile
		$this->profile = new Profile(null, $this->activate, "purchasetest@phpunit.de", "Field", $this->profileHash, "Needs","+011526567986060", $this->profileSalt, "stripey", "u", "@Freefarms");
		$this->profile->insert($this->getPDO());

		$this->unit = new Unit(null, $this->profile->getProfileId());
		$this->unit->insert($this->getPDO());
	}

	/**
	 * test inserting valid variable and verify that the actual mySQL data matches
	 */
	public function testInsertValidProduct(){
		//count the number of rows in the database
		$numRows = $this->getConnection()->getRowCount("product");

		//create a new variable and insert it into mySQL
		$product = new Product(null, $this->profile->getProfileId(),$this->unit->getUnitId(), $this->foodDescription, $this->foodName, $this->foodPrice);
		$product->insert($this->getPDO());

		//get the data from mySQL and enforce the fields match
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getProductUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}

	/**
	 * rest inserting an product that cannot be added
	 *
	 *  @expectedException \PDOException
	 */
	public function testInsertInvalidProduct(){
		//create product with non-null id so it will fail
		$product = new Product(RootsTableTest::INVALID_KEY,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting, editing and updating a product
	 */
	public function testUpdateValidProduct(){
		//get the of the number of rows in the database
		$numRows = $this->getConnection()->getRowCount("product");

		//create a new product and insert into mySQL
		$product = new Product(null, $this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//edit the product and update it in mySQL
		$product->setProductName($this->foodName);
		$product->update($this->getPDO());

		//grab data from SQL and ensure it matches
		$pdoProduct = Product::getProductByProductId($this->getPDO(),$product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription, $this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName, $this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice,
			$this->foodPrice);
	}

	/**
	 * test updating a product that does not exist
	 *
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidProduct(){
		//create a product and try to update without inserting it first
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription, $this->foodName,$this->foodPrice);
		$product->update($this->getPDO());
	}

	/**
	 * test creating a product and deleting it
	 */
	public function testDeleteValidProduct() {
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("product");
		//create a new product and insert into mySQL
		$product = new Product(null, $this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
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
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->delete($this->getPDO());
	}
	/**
	 * test inserting a product and regrabbing it from mySQL
	 */
	public function testGetValidProductByProductId(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("product");

		//creata a new product and insert into mySQL
		$product = new Product(null, $this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProductProfileId(), $this->profile->getProfileId);
		$this->assertEquals($pdoProduct->getUnitId(), $this->unit->getUnitId());
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
	/**
	public function testGetValidProductByProfileId(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("product");

		//create a new product and insert into mySQL
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match
		$pdoProduct = Product::getProductByProductProfileId($this->getPDO(),$this->foodProfileId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct[0]->getProductProfileId(),$this->foodProfileId);
		$this->assertEquals($pdoProduct[0]->getProductUnitId(),$this->foodUnitId);
		$this->assertEquals($pdoProduct[0]->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct[0]->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct[0]->getProductPrice(),$this->foodPrice);
	}**/
	/**
	 * test for grabbing a product by profileId that doesn't exsit
	 */
	/**
	public function testGetInvalidProductByProfileId(){
		$product = Product::getProductByProductProfileId($this->getPDO(), 13);
		$this->assertEquals(0,$product);
	}**/
	/**
	 * test grabbing a product by unitId
	 */
	/**
	public function testGetValidProductByUnitId(){
		//count the number or rows currently in the database
		$numRows = $this->getConnection()->getRowCount("product");
		
		//create a new product and insert it into mySQL
		$product = new Product(null,$this->foodUnitId,$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match
		$pdoProduct = Product::getProductByProductUnitId($this->getPDO(),$this->foodUnitId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct[0]->getProductProfileId(),$this->foodProfileId);
		$this->assertEquals($pdoProduct[0]->getProductUnitId(),$this->foodUnitId);
		$this->assertEquals($pdoProduct[0]->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct[0]->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct[0]->getProductPrice(),$this->foodPrice);
	}**/
	/**
	 * test grabbing a product by unitId that doesn't exist
	 */
	/**
	public function testGetInvalidProductByUnitId(){
		$product = Product::getProductByProductUnitId($this->getPDO(), RootsTableTest::INVALID_KEY);
		$this->assertNull($product);
	}**/
	/**
	 * test grabbing a product by description
	 */
	public function testGetValidProductByDescription(){
		//count the number or rows currently in the database
		$numRows = $this->getConnection()->getRowCount("product");

		//create a new product and insert it into mySQL
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match
		$results = Product::getProductByProductDescription($this->getPDO(),$product->getProductDescription());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\Product", $results);
		
		$pdoProduct = $results[0];
		$this->assertEquals($pdoProduct->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test grabbing a product by description that doesn't exist
	 */
	public function testGetInvalidProductByDescription(){
		$product = Product::getProductByProductDescription($this->getPDO(), "Round and orange");
		$this->assertEquals(0,$product);
	}
	/**
	 * test grabbing a product by name
	 */
	public function testGetValidProductByName(){
		//count the number or rows currently in the database
		$numRows = $this->getConnection()->getRowCount("product");

		//create a new product and insert it into mySQL
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match
		$results = Product::getProductByProductName($this->getPDO(), $product->getProductName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\Product", $results);

		$pdoProduct = $results[0];
		$this->assertEquals($pdoProduct->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test grabbing a product by name that doesn't exist
	 */
	public function testGetInvalidProductByName(){
		$product = Product::getProductByProductName($this->getPDO(), "Purple apples");
		$this->assertEquals(0,$product);
	}
	/**
	 * test grabbing a product by unitId
	 */
	public function testGetValidProductByPrice(){
		//count the number or rows currently in the database
		$numRows = $this->getConnection()->getRowCount("product");

		//create a new product and insert it into mySQL
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match
		$pdoProduct = Product::getProductByProductPrice($this->getPDO(),$this->foodPrice);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertEquals($pdoProduct->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test grabbing a product by unitId that doesn't exist
	 */
	public function testGetInvalidProductByPrice(){
		$product = Product::getProductByProductPrice($this->getPDO(), "5.99");
		$this->assertEquals(0,$product);
	}
}