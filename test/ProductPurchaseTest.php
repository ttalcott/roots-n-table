<?php

namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\{Profile, Product, ProductPurchase};

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
	 * @var Amount Location
	 **/
	protected $quantity = "50";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Product to generate the test ProductPurchase
		$this->item = new Item(null, "20", "tomato", "ketchup");
		$this->shop->insert($this->getPDO());

		// create and insert a Purchase to generate the test ProductPurchase
		$this->shop = new Shop(null, "20", "tomato", "ketchup");
		$this->shop->insert($this->getPDO());
	}


}
