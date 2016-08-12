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
	public function testInsertProductPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Let's buy veggies");

		// create a new ProductPurchase and insert to into mySQL
		$productPurchase = new ProductPurchase(null, $this->item->getItemId(), $this->shop, $this->purchaser, $this->vendor);
		$productPurchase->insert($this->getPDO());

// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPurchase = ProductPurchase::getProductPurchaseByProductPurchaseProductIdAndByProductPurchasePurchaseId($this->getPDO(), $productPurchaseProductId->getProductPurchaseProductId(), $productPurchasePurchaseId->getProductPurchasePurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Let's buy veggies"));
		$this->assertEquals($pdoProductPurchase->getProductPurchaseProduct(), $this->item->getItemId());
		$this->assertEquals($pdoProductPurchase->getProductPurchasePurchase(), $this->shop->getShopId());
		$this->assertEquals($pdoProductPurchase->getProductPurchaseAmount(), $this->coinsAndBills->getCoinsAndBillsId());
		$this->assertEquals($pdoProductPurchase->getLocationAttention(), $this->payAttention);
		$this->assertEquals($pdoProductPurchase->getLocationCity(), $this->sinCity);

	}
}
