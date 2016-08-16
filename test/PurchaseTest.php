<?php
namespace Edu\Cnm\Rootstable\Test;

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

	/** Hexadecimal string for the activation token
	 * @var string $activate
	 */
	protected $activate;

	/** Profile Hash for the password
	 * @var string $profileHash
	 */
	protected $profileHash;

	/** Profile Salt for password
	 * @var string $profileSalt
	 */
	protected $profileSalt;
	
	/**
	 * String generated by transaction
	 * @var string $purchaseStripeToken
	 */
	protected $purchaseStripeToken = "tok_18hQmK2eZvKYlo2SILNY5nTt";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		/** create activation token */
		$this->activate = bin2hex(random_bytes(16));

		/**create hash and salt*/
		$password = "thisisafakerandompassword";
		$this->profileSalt = bin2hex(random_bytes(32));
		$this->profileHash = hash_pbkdf2("sha512", $password, $this->profileSalt, 262144);

// create and insert a Profile to own the test Purchase
		$this->profile = new Profile(null, $this->activate, "purchasetest@phpunit.de", "Chriss", $this->profileHash, "Kross","+011526567986060", $this->profileSalt, $this->purchaseStripeToken, "u", "@ChrissKross");
		$this->profile->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Purchase and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("purchase");

		// create a new Purchase and insert to into mySQL
		$purchase = new Purchase(null, $this->profile->getProfileId(), $this->purchaseStripeToken);
		$purchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPurchase = Purchase::getPurchaseByPurchaseId($this->getPDO(), $purchase->getPurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("purchase"));
		$this->assertEquals($pdoPurchase->getPurchaseProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPurchase->getPurchaseStripeToken(), $this->purchaseStripeToken);
	}

	/**
	 * test inserting a Purchase that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidPurchase() {
		// create a Purchase with a non null purchase id and watch it fail
		$purchase = new Purchase(RootsTableTest::INVALID_KEY, $this->profile->getProfileId(), $this->purchaseStripeToken);
		$purchase->insert($this->getPDO());
	}

	/**
	 * test inserting a Purchase, editing it, and then updating it
	 **/
	public function testUpdateValidPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("purchase");

		// create a new Purchase and insert to into mySQL
		$purchase = new Purchase(null, $this->profile->getProfileId(), $this->purchaseStripeToken);
		$purchase->insert($this->getPDO());

		// edit the Purchase and update it in mySQL
		$purchase->setPurchaseStripeToken($this->purchaseStripeToken);
		$purchase->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPurchase = Purchase::getPurchaseByPurchaseId($this->getPDO(), $purchase->getPurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("purchase"));
		$this->assertEquals($pdoPurchase->getPurchaseProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPurchase->getPurchaseStripeToken(), $this->purchaseStripeToken);
	}

	/**
	 * test updating a Purchase that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidPurchase() {
		// create a Purchase, try to update it without actually updating it and watch it fail
		$purchase = new Purchase(null, $this->profile->getProfileId(), $this->purchaseStripeToken);
		$purchase->update($this->getPDO());
	}

	/**
	 * test creating a Purchase and then deleting it
	 **/
	public function testDeleteValidPurchase() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("purchase");

		// create a new Purchase and insert to into mySQL
		$purchase = new Purchase(null, $this->profile->getProfileId(), $this->purchaseStripeToken);
		$purchase->insert($this->getPDO());

		// delete the Purchase from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("purchase"));
		$purchase->delete($this->getPDO());

		// grab the data from mySQL and enforce the Purchase does not exist
		$pdoPurchase = Purchase::getPurchaseByPurchaseId($this->getPDO(), $purchase->getPurchaseId());
		$this->assertNull($pdoPurchase);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("purchase"));
	}

	/**
	 * test deleting a Purchase that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidPurchase() {
		// create a Purchase and try to delete it without actually inserting it
		$purchase = new Purchase(null, $this->profile->getProfileId(), $this->purchaseStripeToken);
		$purchase->delete($this->getPDO());
	}


	/**
	 * test grabbing a Purchase by purchase Id
	 **/
	public function testGetValidPurchaseByPurchaseId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("purchase");

		// create a new Purchase and insert to into mySQL
		$purchase = new Purchase(null, $this->profile->getProfileId(), $this->purchaseStripeToken);
		$purchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Purchase::getPurchaseByPurchaseId($this->getPDO(), $purchase->getPurchaseId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("purchase"));
		$this->assertEquals($results->getPurchaseProfileId(), $this->profile->getProfileId());
		$this->assertEquals($results->getPurchaseStripeToken(), $this->purchaseStripeToken);

		/*$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable", $results);*/
		/*$this->assertCount(1, $results);*/
		// grab the result from the array and validate it
		/*$pdoPurchase = $results[0];*/

	}

	/**
	 * test grabbing a Purchase by purchase Id that does not exist
	 *
	 * @expectedException \PDOException when mySQL related Errors occur
	 **/
	public function testGetInvalidPurchaseByPurchaseId() {

		// grab a purchase by searching for purchase id that does not exist
		$purchase = Purchase::getPurchaseByPurchaseId($this->getPDO(), RootsTableTest::INVALID_KEY);
		$this->assertNull($purchase);
	}

	/**
	 * test grabbing a Purchase by purchase profile Id
	 **/
	public function testGetValidPurchaseByPurchaseProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("purchase");

		// create a new Purchase and insert to into mySQL
		$purchase = new Purchase(null, $this->profile->getProfileId(), $this->purchaseStripeToken);
		$purchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Purchase::getPurchaseByPurchaseProfileId($this->getPDO(), $purchase->getPurchaseProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("purchase"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\Purchase", $results);

		// grab the result from the array and validate it
		$pdoPurchase = $results[0];
		$this->assertEquals($pdoPurchase->getPurchaseProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPurchase->getPurchaseStripeToken(), $this->purchaseStripeToken);
	}

	/**
	 * test grabbing a Purchase by purchase profile Id that does not exist
	 *
	 * @expectedException \PDOException when mySQL related errors occur
	 **/

	public function testGetInvalidPurchaseByPurchaseProfileId() {
		// grab a purchase by searching for purchase id that does not exist
		$purchase = Purchase::getPurchaseByPurchaseProfileId($this->getPDO(), RootsTableTest::INVALID_KEY);
		$this->assertCount(0, $purchase);
	}

	/**
	 * test grabbing a Purchase by purchase stripe token Id
	 **/
	public function testGetValidPurchaseByPurchaseStripeToken() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("purchase");

		// create a new Purchase and insert to into mySQL
		$purchase = new Purchase(null, $this->profile->getProfileId(), $this->purchaseStripeToken);
		$purchase->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPurchase = Purchase::getPurchaseByPurchaseStripeToken($this->getPDO(), $purchase->getPurchaseStripeToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("purchase"));
		$this->assertEquals($pdoPurchase->getPurchaseProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPurchase->getPurchaseStripeToken(), $this->purchaseStripeToken);
	}

	/**
	 * test grabbing a Purchase by purchase Stripe Token that does not exist
	 * 
	 * @expectedException \PDOException
	 **/
	public function testGetInvalidPurchaseByPurchaseStripeToken() {
		// grab a purchase by searching for purchase stripe token that does not exist
		$purchase = Purchase::getPurchaseByPurchaseStripeToken($this->getPDO(), "");
		$this->assertNull($purchase);
	}

	/**
	 * test grabbing all Purchases
	 **/
	public function testGetAllValidPurchases() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("purchase");

		// create a new Purchase and insert to into mySQL
			$purchase = new Purchase(null, $this->profile->getProfileId(), $this->purchaseStripeToken);
			$purchase->insert($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$results = Purchase::getAllPurchases($this->getPDO());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("purchase"));
			$this->assertCount(1, $results);
			$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\Purchase", $results);

			// grab the result from the array and validate it
			$pdoPurchase = $results[0];
			$this->assertEquals($pdoPurchase->getPurchaseProfileId(), $this->profile->getProfileId());
			$this->assertEquals($pdoPurchase->getPurchaseStripeToken(), $this->purchaseStripeToken);
	}
}

