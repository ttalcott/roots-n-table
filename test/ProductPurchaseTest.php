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
		$this->shop->insert($this->getPDO());

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


}
