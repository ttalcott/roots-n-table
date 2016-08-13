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
	 * @var ProductPurchase Location
	 **/
	protected $item = null;

	/**
	 * Prurchase that was generated the Purchase of the Product; this is for foreign key relations
	 * @var ProductPurchase Location
	 **/
	protected $shop = null;

	/**
	 * Amount of the transaction in the Purchase of the Product;
	 * @var coinsAndBills Location
	 **/
	protected $coinsAndBills = "40";

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
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Product to generate the test ProductPurchase
		$this->item = new Item(null, "20", "Walter White", "40");
		$this->item->insert($this->getPDO());

		// create and insert a Purchase to generate the test ProductPurchase
		$this->shop = new Shop(null, "30", "Walter White", "ketchup");
		$this->shop->insert($this->getPDO());

		// create and insert a Purchaser to generate the test ProductPurchase
		$this->purchaser = new Purchaser(null, "@Brian_Urlacher", "brian@unmlobosfootball.edu", "+1188493930");
		$this->purchaser->insert($this->getPDO());

		// create and insert a Vendor to generate the test ProductPurchase
		$this->vendor = new Vendor(null, "@Kenny_Thomas", "kenny2@unmlobosbasketball.edu", "+1198973669");
		$this->vendor->insert($this->getPDO());
	}

	/**
	 * test inserting a valid ProductPurchase and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProductPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("ProductPurchase");

		// create a new ProductPurchase and insert to into mySQL
		$productPurchase = new ProductPurchase(null, $this->productPurchaseProductId->getProductPurchaseProductId(), $this->productPurchasePurchaseId->getProductPurchasePurchaseId(),$this->item, $this->shop, $this->coinsAndBills);
		$productPurchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByProductPurchaseProductIdAndByProductPurchasePurchaseId($this->getPDO(), $productPurchase->getProductPurchaseProductId(), $productPurchase->getProductPurchasePurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ProductPurchase"));
		$this->assertEquals($pdoProductPurchase->getProductPurchaseProductId(), $this->productPurchaseProduct->getProductPurchaseProductId());
		$this->assertEquals($pdoProductPurchase->getProductPurchasePurchaseId(), $this->productPurchasePurchase->getProductPurchasePurchaseId());
		$this->assertEquals($pdoProductPurchase->getProductPurchaseAmount(), $this->coinsAndBills->getCoinsAndBills());
	}

	/**
	 * test inserting a ProductPurchase that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProductPurchase() {
		// create a ProductPurchase with a non null ProductPurchaseProductId id and watch it fail
		$productPurchase = new ProductPurchase(RootsTableTest::INVALID_KEY, $this->productPurchase->getProductPurchaseId(), $this->shop, $this->coinsAndBills, $this->purchaser, $this->vendor);
		$productPurchase->insert($this->getPDO());
	}

	/**
	 * test inserting a Product Purchase, editing it, and then updating it
	 **/
	public function testUpdateValidProductPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("ProductPurchase");

		// create a new Product Purchase and insert to into mySQL
		$productPurchase = new ProductPurchase(null, $this->productPurchaseProductId->getProductPurchaseProductId(), $this->productPurchasePurchaseId->getProductPurchasePurchaseId(),$this->item, $this->shop, $this->coinsAndBills);
		$productPurchase->insert($this->getPDO());

		// edit the ProductPurchase and update it in mySQL
		$productPurchase->setProductPurchaseAmount($this->coinsAndBills);
		$productPurchase->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByProductPurchaseProductIdAndByProductPurchasePurchaseId($this->getPDO(), $productPurchase->getProductPurchaseProductId(), $productPurchase->getProductPurchasePurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ProductPurchase"));
		$this->assertEquals($pdoProductPurchase->getProductPurchaseProductId(), $this->productPurchaseProduct->getProductPurchaseProductId());
		$this->assertEquals($pdoProductPurchase->getProductPurchasePurchaseId(), $this->productPurchasePurchase->getProductPurchasePurchaseId());
		$this->assertEquals($pdoProductPurchase->getProductPurchaseAmount(), $this->coinsAndBills->getCoinsAndBills());
	}


	/**
	 * test updating a ProductPurchase that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidProductPurchase() {
		// create a Product Purchase, try to update it without actually updating it and watch it fail
		$productPurchase = new ProductPurchase(null, $this->productPurchaseProductId->getProductPurchaseProductId(), $this->productPurchasePurchaseId->getProductPurchasePurchaseId(),$this->item, $this->shop, $this->coinsAndBills);
		$productPurchase->update($this->getPDO());
	}

	/**
	 * test creating a Product Purchase and then deleting it
	 **/
	public function testDeleteValidProductPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("ProductPurchase");

		// create a new Product Purchase and insert to into mySQL
		$productPurchase = new ProductPurchase(null, $this->productPurchaseProductId->getProductPurchaseProductId(), $this->productPurchasePurchaseId->getProductPurchasePurchaseId(),$this->item, $this->shop, $this->coinsAndBills);
		$productPurchase->insert($this->getPDO());

		// delete the Product Purchase from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ProductPurchase"));
		$productPurchase->delete($this->getPDO());

		// grab the data from mySQL and enforce the Product Purchase does not exist
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByProductPurchaseProductIdAndByProductPurchasePurchaseId($this->getPDO(), $productPurchase->getProductPurchaseProductId(), $productPurchase->getProductPurchasePurchaseId());
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("ProductPurchase"));
	}


}
