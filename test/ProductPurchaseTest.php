<?php

namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\{Profile, Product, Purchase, ProductPurchase};

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");


/**
 * Full PHPUnit test for the ProductProduct class
 *
 * This is a complete PHPUnit test of the ProductPurchase class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see ProductPurchase
 * @author Raul Villarreal <rvillarrcal@cnm.edu>
 **/

class ProductPurchaseTest extends RootsTableTest {

	/**
	 * Product that generated the ProductPurchase; this is for foreign key relations
	 * @var int ProductPurchaseProduct id
	 **/
	protected $item = null;

	/**
	 * Purchase that was generated the Purchase of the Product; this is for foreign key relations
	 * @var ProductPurchasePurchase id
	 **/
	protected $shop = null;

	/**
	 * Profile from profile 
	 * @var profile
	 **/
	protected $profile = null;

	/** Hexadecimal string for the purchaser activation token
	 * @var string $activate
	 */
	protected $activate1;

	/** Profile Hash for the purchaser password
	 * @var string $profileHash
	 */
	protected $profileHash1;

	/** Profile Salt for purchaser password
	 * @var string $profileSalt
	 */
	protected $profileSalt1;

	/** Hexadecimal string for the vendor activation token
	 * @var string $activate
	 */
	protected $activate2;

	/** Profile Hash for the vendor password
	 * @var string $profileHash
	 */
	protected $profileHash2;

	/** Profile Salt for vendor password
	 * @var string $profileSalt
	 */
	protected $profileSalt2;

	/**
	 * Amount of the transaction in the Purchase of the Product;
	 * @var coinsAndBills
	 **/
	protected $coinsAndBills1 = "40.50";

	/**
	 * Amount of the transaction in the Purchase of the Product;
	 * @var coinsAndBills2
	 **/
	protected $coinsAndBills2 = "50.40";

	/**
	 * Mock Purchaser
	 * @var purchaser
	 **/
	protected  $purchaser = null;

	/**
	 *Mock Vendor
	 * @var vendor
	 **/
	protected  $vendor = null;

	/**
	 * Unit from productUnitId
	 * @var int unitId
	 */
	protected $unitId;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {

		// run the default setUp() method first
		parent::setUp();

		//create activation token
		$this->activate1 = bin2hex(random_bytes(16));

		//create hash and salt
		$password = "thisisthefirstfakepassword";
		$this->profileSalt1 = bin2hex(random_bytes(32));
		$this->profileHash1 = hash_pbkdf2("sha512", $password, $this->profileSalt1, 262144);

		// create and insert a Purchaser to generate the test ProductPurchase
		$this->purchaser = new Profile(null, $this->activate1, "brian@unmlobosfootball.edu", "Brian", $this->profileHash1, "Urlacher", "+1188493930", $this->profileSalt1, "stripey", "u", "@brianBears");
		$this->purchaser->insert($this->getPDO());

		//create activation token
		$this->activate2 = bin2hex(random_bytes(16));

		//create hash and salt
		$password = "thisisthesecondfakepassword";
		$this->profileSalt2 = bin2hex(random_bytes(32));
		$this->profileHash2 = hash_pbkdf2("sha512", $password, $this->profileSalt2, 262144);

		// create and insert a Vendor to generate the test ProductPurchase
		$this->vendor = new Profile(null, $this->activate2, "kenny@unmlobosbasketball.edu", "Kenny", $this->profileHash2, "Thomas", "+11526564593930", $this->profileSalt2, "stripey", "f", "@kennyPhilly");
		$this->vendor->insert($this->getPDO());

		// create and insert a Purchase to generate the test ProductPurchase
		$this->shop = new Purchase(null, $this->purchaser->getProfileId(), "ldoeFsjtP_rj3W5FS2kt0_FvE4Tl");
		$this->shop->insert($this->getPDO());

		// create and insert a Product to generate the test ProductPurchase
		$this->item = new Product(null, $this->vendor->getProfileId(), $this->unitId->getProductUnitId(),"red and juicy", "tomatoes", $this->coinsAndBills1);
		$this->item->insert($this->getPDO());

	}

	/**
	 * test inserting a valid ProductPurchase and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProductPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");

		// create a new ProductPurchase and insert to into mySQL
		$productPurchase = new ProductPurchase($this->product->getProductId(), $this->purchase->getPurchaseId(), $this->coinsAndBills1);
		$productPurchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByProductPurchaseProductIdAndProductPurchasePurchaseId($productPurchase->getPDO(), $productPurchase->getProductPurchaseProductId(), $this->getProductPurchasePurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productPurchase"));
		$this->assertEquals($pdoProductPurchase->getProductPurchaseProductId(), $this->product->getProductId());
		$this->assertEquals($pdoProductPurchase->getProductPurchasePurchaseId(), $this->purchase->getPurchaseId());
		$this->assertEquals($pdoProductPurchase->getProductPurchaseAmount(), $this->coinsAndBills1);
	}

	/**
	 * test inserting a ProductPurchase that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProductPurchase() {
		// create a ProductPurchase with a non null ProductPurchaseProductId id and watch it fail
		$productPurchase = new ProductPurchase(RootsTableTest::INVALID_KEY, RootsTableTest::INVALID_KEY, $this->coinsAndBills1);
		$productPurchase->insert($this->getPDO());
	}

	/**
	 * test inserting a Product Purchase, editing it, and then updating it
	 **/
	public function testUpdateValidProductPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");

		// create a new Product Purchase and insert to into mySQL
		$productPurchase = new ProductPurchase($this->product->getProductId(),$this->purchase->getPurchaseId(), $this->coinsAndBills1);
		$productPurchase->insert($this->getPDO());

		// edit the ProductPurchase and update it in mySQL
		$productPurchase->setProductPurchaseAmount($this->coinsAndBills2);
		$productPurchase->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByProductPurchaseProductIdAndProductPurchasePurchaseId($productPurchase->getPDO(), $productPurchase->getProductPurchaseProductId(), $this->getProductPurchasePurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productPurchase"));
		$this->assertEquals($pdoProductPurchase->getProductPurchaseProductId(), $this->product->getProductId());
		$this->assertEquals($pdoProductPurchase->getProductPurchasePurchaseId(), $this->purchase->getPurchaseId());
		$this->assertEquals($pdoProductPurchase->getProductPurchaseAmount(), $this->coinsAndBills2->getCoinsAndBills2());
	}


	/**
	 * test updating a ProductPurchase that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidProductPurchase() {
		// create a Product Purchase, try to update it without actually updating it and watch it fail
		$productPurchase = new ProductPurchase($this->product->getProductId(), $this->purchase->getPurchaseId());
		$productPurchase->update($this->getPDO());
	}

	/**
	 * test deleting a productPurchase that does not exist
	 **/
	public function testDeleteInvalidProductPurchase() {
		//create a productPurchase and without inserting it, try to delete it 
		$productPurchase = new ProductPurchase($this->product->getProductId(), $this->purchase->getPurchaseId());
		$productPurchase->delete($this->getPDO());
	}

	/**
	 * test creating a Product Purchase and then deleting it
	 **/
	public function testDeleteValidProductPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");

		// create a new Product Purchase and insert to into mySQL
		$productPurchase = new ProductPurchase($this->product->getProductId(), $this->purchase->getPurchaseId(),$this->coinsAndBills1);
		$productPurchase->insert($this->getPDO());

		// delete the Product Purchase from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productPurchase"));
		$productPurchase->delete($this->getPDO());

		// grab the data from mySQL and enforce the Product Purchase does not exist
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByProductPurchaseProductIdAndByProductPurchasePurchaseId($this->getPDO(), $productPurchase->getProductPurchaseProductId(), $productPurchase->getProductPurchasePurchaseId());
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("productPurchase"));
	}

	/**
	 * test grabbing a Product Purchase by ProductPurchaseAmount
	 **/
	public function testGetValidProductPurchaseByProductPurchaseAmount() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");

		// create a new ProductPurchase and insert to into mySQL
		$productPurchase = new ProductPurchase($this->product->getProductId(), $this->purchase->getPurchaseId(),$this->coinsAndBills1);
		$productPurchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = ProductPurchase::getProductPurchaseByProductPurchaseAmount($this->getPDO(), $productPurchase->getProductPurchaseAmount());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productPurchase"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\ProductPurchase", $results);

		// grab the result from the array and validate it
		$pdoProductPurchase = $results[0];
		$this->assertEquals($pdoProductPurchase->getProductPurchaseProduct(), $this->product->getProductId());
		$this->assertEquals($pdoProductPurchase->getProductPurchaseProduct(), $this->purchase->getPurchaseId());
		$this->assertEquals($pdoProductPurchase->getProductPurchaseAmount(), $this->coinsAndBills1);
	}

	/**
	 * test grabbing a Product Purchase by product Purchase Amount that does not exist
	 **/
	public function testGetInvalidProductPurchaseByProductPurchaseAmount() {
		// grab a product Purchase by searching for amount that does not exist
		$productPurchase = ProductPurchase::getProductPurchaseByProductPurchaseAmount($this->getPDO(), "Nobody paid that amount");
		$this->assertCount(0, $productPurchase);
	}

	/**
	 * test grabbing all Products Purchases
	 **/
	public function testGetAllValidProductsPurchases() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPurchase");

		// create a new Product Purchase and insert to into mySQL
		$productPurchase = new ProductPurchase($this->product->getProductId(), $this->purchase->getPurchaseId, $this->coinsAndBills1);
		$productPurchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = ProductPurchase::getAllProductPurchases($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productPurchase"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\ProductPurchase", $results);

		// grab the result from the array and validate it
		$pdoProductPurchase = $results[0];
		$this->assertEquals($pdoProductPurchase->getProductPurchaseProductId(), $this->product->getProductId());
		$this->assertEquals($pdoProductPurchase->getProductPurchasePurchaseId(), $this->purchase->getPurchaseId());
		$this->assertEquals($pdoProductPurchase->getProductPurchaseAmount(), $this->coinsAndBills1);
	}
}
