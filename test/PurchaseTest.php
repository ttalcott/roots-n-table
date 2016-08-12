<?php
namespace Edu\Cnm\rootstable\Test;

use Edu\Cnm\Rootstable\{Profile, Purchase};

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Purchase class
 *
 * This is a complete PHPUnit test of the Purchase class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Purchase
 * @author Raul Villarreal <rvillarrcal@cnm.edu>
 **/

class PurchaseTest extends RootsTableTest {

	/**
	 * Profile that created the Purchase; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * String generated by transaction
	 * @var string $randomString
	 */
	protected $randomString = "Stripe";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

// create and insert a Profile to own the test Purchase
		$this->profile = new Profile(null, "@Johnny", "locationtest@phpunit.de", "+011526567986060");
		$this->profile->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Purchase and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("I want money");

		// create a new Purchase and insert to into mySQL
		$purchase = new Purchase(null, $this->profile->getProfileId(), $this->randomString);
		$purchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPurchase = Purchase::getPurchaseByPurchaseId($this->getPDO(), $purchase->getPurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("I want money"));
		$this->assertEquals($pdoPurchase->getProfile(), $this->profile->getprofileId());
		$this->assertEquals($pdoPurchase->getPurchaseStripeToken(), $this->ramdomString);
	}

	/**
	 * test inserting a Purchase that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidPurchase() {
		// create a Purchase with a non null purchase id and watch it fail
		$purchase = new Purchase(RootsTableTest::INVALID_KEY, $this->profile->getProfileId(), $this->randomString);
		$purchase->insert($this->getPDO());
	}

	/**
	 * test inserting a Purchase, editing it, and then updating it
	 **/
	public function testUpdateValidPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("I want money");

		// create a new Purchase and insert to into mySQL
		$purchase = new Purchase(null, $this->profile->getProfileId(), $this->randomString);
		$purchase->insert($this->getPDO());

		// edit the Purchase and update it in mySQL
		$purchase->setPurchaseStripeToken($this->randomString);
		$purchase->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPurchase = Purchase::getPurchaseByPurchaseId($this->getPDO(), $purchase->getPurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("I want money"));
		$this->assertEquals($pdoPurchase->getProfile(), $this->profile->getprofileId());
		$this->assertEquals($pdoPurchase->getPurchaseStripeToken(), $this->randomString);
	}

	/**
	 * test updating a Purchase that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidPurchase() {
		// create a Purchase, try to update it without actually updating it and watch it fail
		$purchase = new Purchase(null, $this->profile->getProfileId(), $this->randomString);
		$purchase->update($this->getPDO());
	}
}