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
	 * 
	 * @var string
	 */
	protected $foodName2 = "Apple";
	/**
	 * content of productPrice
	 * @var float $productPrice
	 */
	protected $foodPrice = "1.99";
	/**
	 * profile of user that is selling the products
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
		$numRows = $this->getConnection()->getRowCount("products");

		//create a new variable and insert it into mySQL
		$product = new Product(null, $this->profile->getProfileId(),$this->unit->getUnitId(), $this->foodDescription, $this->foodName, $this->foodPrice);
		$product->insert($this->getPDO());

		//get the data from mySQL and enforce the fields match
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("products"));
		$this->assertEquals($pdoProduct->getProductProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getProductUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}

	/**
	 * rest inserting an products that cannot be added
	 *
	 *  @expectedException \PDOException
	 */
	public function testInsertInvalidProduct(){
		//create products with non-null id so it will fail
		$product = new Product(RootsTableTest::INVALID_KEY,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting, editing and updating a products
	 */
	public function testUpdateValidProduct(){
		//get the of the number of rows in the database
		$numRows = $this->getConnection()->getRowCount("products");

		//create a new products and insert into mySQL
		$product = new Product(null, $this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//edit the products and update it in mySQL
		$product->setProductName($this->foodName2);
		$product->update($this->getPDO());

		//grab data from SQL and ensure it matches
		$pdoProduct = Product::getProductByProductId($this->getPDO(),$product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("products"));
		$this->assertEquals($pdoProduct->getProductProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getProductUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(), $this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(), $this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),
			$this->foodPrice);
	}

	/**
	 * test updating a products that does not exist
	 *
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidProduct(){
		//create a products and try to update without inserting it first
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription, $this->foodName,$this->foodPrice);
		$product->update($this->getPDO());
	}

	/**
	 * test creating a products and deleting it
	 */
	public function testDeleteValidProduct() {
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("products");
		//create a new products and insert into mySQL
		$product = new Product(null, $this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//confirm the row was added, then delete it
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("products"));
		$product->delete($this->getPDO());

		//grab data from mySQL and make sure it doesn't exsit
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertNull($pdoProduct);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("products"));
	}
	/**
	 * test deleting a products that doesn't exist
	 *
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidProduct(){
		//create a products and delete without inserting it
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->delete($this->getPDO());
	}
	/**
	 * test inserting a products and regrabbing it from mySQL
	 */
	public function testGetValidProductByProductId(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("products");

		//creata a new products and insert into mySQL
		$product = new Product(null, $this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("products"));
		$this->assertEquals($pdoProduct->getProductProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getProductUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test getting a products that doesn't exsit
	 */
	public function testGetInvalidProductByProductId(){
		//grab an id that exceeds the maximum allowable value
		$product = Product::getProductByProductId($this->getPDO(), RootsTableTest::INVALID_KEY);
	}
/**
* test inserting a products and regrabbing it from mySQL
*/
	public function testGetValidProductByProductProfileId(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("products");

		//creata a new products and insert into mySQL
		$product = new Product(null, $this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$pdoProduct = Product::getProductByProductProfileId($this->getPDO(), $product->getProductProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("products"));
		$this->assertEquals($pdoProduct->getProductUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test getting a products that doesn't exsit
	 */
	public function testGetInvalidProductByProductProfileId(){
		//grab an id that exceeds the maximum allowable value
		$product = Product::getProductByProductProfileId($this->getPDO(), RootsTableTest::INVALID_KEY);
	}
/**
* test inserting a products and regrabbing it from mySQL
*/
	public function testGetValidProductByProductUnitId(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("products");

		//creata a new products and insert into mySQL
		$product = new Product(null, $this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$pdoProduct = Product::getProductByProductUnitId($this->getPDO(), $product->getProductUnitId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("products"));
		$this->assertEquals($pdoProduct->getProductProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getProductUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test getting a products that doesn't exsit
	 */
	public function testGetInvalidProductByProductUnitId(){
		//grab an id that exceeds the maximum allowable value
		$product = Product::getProductByProductUnitId($this->getPDO(), RootsTableTest::INVALID_KEY);
	}
	/**
	 * test grabbing a products by description
	 */
	public function testGetValidProductByDescription(){
		//count the number or rows currently in the database
		$numRows = $this->getConnection()->getRowCount("products");

		//create a new products and insert it into mySQL
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match
		$results = Product::getProductByProductDescription($this->getPDO(),$product->getProductDescription());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("products"));
		
		$pdoProduct = $results;
		$this->assertEquals($pdoProduct->getProductProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getProductUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test grabbing a products by description that doesn't exist
	 */
	public function testGetInvalidProductByDescription(){
		$product = Product::getProductByProductDescription($this->getPDO(), "Round and orange");
		$this->assertEquals(0,$product);
	}
	/**
	 * test grabbing a products by name
	 */
	public function testGetValidProductByName(){
		//count the number or rows currently in the database
		$numRows = $this->getConnection()->getRowCount("products");

		//create a new products and insert it into mySQL
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match
		$results = Product::getProductByProductName($this->getPDO(), $product->getProductName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("products"));
		//$this->assertCount(1, $results);
		//$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\Product", $results);

		$pdoProduct = $results;
		$this->assertEquals($pdoProduct->getProductProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getProductUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test grabbing a products by name that doesn't exist
	 */
	public function testGetInvalidProductByName(){
		$product = Product::getProductByProductName($this->getPDO(), "Purple apples");
		$this->assertEquals(0,$product);
	}
	/**
	 * test grabbing a products by unitId
	 */
	public function testGetValidProductByPrice(){
		//count the number or rows currently in the database
		$numRows = $this->getConnection()->getRowCount("products");

		//create a new products and insert it into mySQL
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match
		$pdoProduct = Product::getProductByProductPrice($this->getPDO(),$this->foodPrice);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("products"));
		$this->assertEquals($pdoProduct->getProductProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getProductUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}
	/**
	 * test grabbing a products by unitId that doesn't exist
	 */
	public function testGetInvalidProductByPrice(){
		$product = Product::getProductByProductPrice($this->getPDO(), "5.99");
		$this->assertEquals(0,$product);
	}
	/**
	 * test grabbing a all products
	 */
	public function testGetAllProduct(){
		//count the number or rows currently in the database
		$numRows = $this->getConnection()->getRowCount("products");

		//create a new products and insert it into mySQL
		$product = new Product(null,$this->profile->getProfileId(),$this->unit->getUnitId(),$this->foodDescription,$this->foodName,$this->foodPrice);
		$product->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match
		$results = Product::getAllProduct($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("products"));
		
		//grab the results and validate
		$pdoProduct = $results;
		$this->assertEquals($pdoProduct->getProductProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProduct->getProductUnitId(), $this->unit->getUnitId());
		$this->assertEquals($pdoProduct->getProductDescription(),$this->foodDescription);
		$this->assertEquals($pdoProduct->getProductName(),$this->foodName);
		$this->assertEquals($pdoProduct->getProductPrice(),$this->foodPrice);
	}
}