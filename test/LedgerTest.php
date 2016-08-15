<?php

namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\{Ledger, Profile, Purchase};

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
* Full PHP Unit test of  the Ledger Class
*
* @see Ledger
* @author Travis Talcott <ttalcott@lyradevelopment.com>
**/

class LedgerTest extends RootsTableTest {
	/**
	* ledger amount
	* @var float $VALID_PAYARLO
	**/
	protected $VALID_PAYARLO = "1000.00";
	/**
	* updated ledger amount
	* @var $VALID_PAYARLO2
	**/
	protected $VALID_PAYARLO2 = "2000.00";
	/**
	* ledger date
	* @var DateTime $VALID_ARLODATE
	**/
	protected $VALID_ARLODATE = null;
	/**
	* ledger stripe token
	* @var string $VALID_ARLOSTRIPE
	**/
	protected $VALID_ARLOSTRIPE = "tok_18hQmK2eZvKYlo2CSILNY5nZ";
	/**
	* activation token for the profile that made this purchase
	* @var string $VALID_ACTIVATEPROFILE
	**/
	protected $VALID_ACTIVATEPROFILE;
	/**
	* email for the profile that made this purchase
	* @var string $VALID_PROFILEEMAIL
	**/
	protected $VALID_PROFILEEMAIL = "arlo@gmail.com";
	/**
	* first name of the profile that made this purchase
	* @var string $VALID_FIRSTNAME
	**/
	protected $VALID_FIRSTNAME = "Meow";
	/**
	* hash of the profile that made this purchase
	* @var string $VALID_HASH
	**/
	protected $VALID_HASH = null;
	/**
	* last name of the profile that made this purchase
	* @var string $VALID_LASTNAME
	**/
	protected $VALID_LASTNAME = "Arlo";
	/**
	* phone number of the profile that made this purchase
	* @var string $VALID_PHONE
	**/
	protected $VALID_PHONE = "+15557215739";
	/**
	* salt for the profile that made this purchase
	* @var string $VALID_SALT
	**/
	protected $VALID_SALT = null;
	/**
	* stripe token of the profile that made this purchase
	* @var string $VALID_STRIPE
	**/
	protected $VALID_STRIPE = "tok_18hQmK2eZvKYlo2CSILNY5nB";
	/**
	* profile type of the profile that made this purchase
	* @var string $VALID_TYPE
	**/
	protected $VALID_TYPE = "u";
	/**
	* username of the profile that made this purchase
	* @var string $VALID_USER
	**/
	protected $VALID_USER = "senator arlo";
	/**
	* stripe token of the purchase that this ledger belongs to
	* @var string $VALID_STRIPEPURCHASE
	**/
	protected $VALID_STRIPEPURCHASE = "tok_18hQmK2eZvKYlo2CSILNY5nA";
	/**
	* profile that made the purchase
	* @var Profile $profile
	**/
	protected $profile = null;
	/**
	* purchase this ledger belongs to; this is for foreign key relations
	* @var Purchase $purchase
	**/
	protected $purchase = null;

	//create dependent objects before running each test
	public final function setUp() {
		//run the default set up method first
		parent::setUp();

		//create activation token for the profile
		$this->VALID_ACTIVATEPROFILE = bin2hex(random_bytes(16));

		//create hash and salt for the profile that made this purchase
		$password = "Bootstrap";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);

		//create and insert a profile that makes a purchase for this ledger
		$this->profile = new Profile(null, $this->VALID_ACTIVATEPROFILE, $this->VALID_PROFILEEMAIL, $this->VALID_FIRSTNAME, $this->VALID_HASH, $this->VALID_LASTNAME, $this->VALID_PHONE, $this->VALID_SALT, $this->VALID_STRIPE, $this->VALID_TYPE, $this->VALID_USER);
		$this->profile->insert($this->getPDO());

		//create and insert a purchase for this test
		$this->purchase = new Purchase(null, $this->profile->getProfileId(), $this->VALID_STRIPEPURCHASE);
		$this->purchase->insert($this->getPDO());

		//calculate the date using the time the test was set up
		$this->VALID_ARLODATE = new \DateTime();
	}

	/**
	* test inserting a valid ledger and verify the SQL data matches
	**/
	public function testInsertValidLedger() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->rowCount("ledger");

		//create and insert a ledger for this test
		$this->ledger = new Ledger(null, $this->purchase->getPurchaseId(), $this->$VALID_PAYARLO, $this->$VALID_ARLODATE, $this->VALID_ARLOSTRIPE);
		$this->ledger->insert($this->getPDO());

		//grab the data from mySQL
		$pdoLedger = Ledger::getLedgerByLedgerId($this->getPDO(), $ledger->getLedgerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ledger"));
		$this->assertEquals($pdoLedger->getLedgerPurchaseId(), $this->ledger->getPurchaseId());
		$this->assertEquals($pdoLedger->getLedgerAmount(), $this->VALID_PAYARLO);
		$this->assertEquals($pdoLedger->getLedgerDate(), $this->VALID_ARLODATE);
		$this->assertEquals($pdoLedger->getLedgerStripeToken(), $this->VALID_ARLOSTRIPE);
	}

	/**
	* test inserting a ledger that already exists
	*
	* @expectedException \PDOException
	**/
	public function testInsertInvalidLedger() {
		//create a ledger with a non null ledgerId and watch it fail
		$this->ledger = new Ledger(RootsTableTest::INVALID_KEY, $this->purchase->getPurchaseId(), $this->$VALID_PAYARLO, $this->$VALID_ARLODATE, $this->VALID_ARLOSTRIPE);
		$this->ledger->insert($this->getPDO());
	}

	/**
	* test deleting a ledger from mySQL
	**/
	public function testDeleteValidLedger() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->rowCount("ledger");

		//create and insert a ledger for this test
		$this->ledger = new Ledger(null, $this->purchase->getPurchaseId(), $this->$VALID_PAYARLO, $this->$VALID_ARLODATE, $this->VALID_ARLOSTRIPE);
		$this->ledger->insert($this->getPDO());

		//delete the ledger
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ledger"));
		$ledger->delete($this->getPDO());

		//grab the data from mySQL and enforce the ledger is dust in the wind
		$pdoLedger = Ledger::getLedgerByLedgerId($this->getPDO(), $ledger->getLedgerId());
		$this->assertNull($pdoLedger);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("ledger"));
	}

	/**
	* test deleting a ledger that does not exist
	*
	* @expectedException \PDOException
	**/
	public function testDeleteInvalidLedger() {
		//create a ledger and try to delete it without actually inserting it
		$this->ledger = new Ledger(null, $this->purchase->getPurchaseId(), $this->$VALID_PAYARLO, $this->$VALID_ARLODATE, $this->VALID_ARLOSTRIPE);
		$this->delete($this->getPDO());
	}

	/**
	* test inserting a ledger, editing it, then updating it
	**/
	public function testUpdateValidLedger() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->rowCount("ledger");

		//create and insert a ledger for this test
		$this->ledger = new Ledger(null, $this->purchase->getPurchaseId(), $this->$VALID_PAYARLO, $this->$VALID_ARLODATE, $this->VALID_ARLOSTRIPE);
		$this->ledger->insert($this->getPDO());

		//update the ledger
		$ledger->setLedgerAmount($this->VALID_PAYARLO2);
		$ledger->update($this->getPDO());

		//grab the data from mySQL
		$pdoLedger = Ledger::getLedgerByLedgerId($this->getPDO(), $ledger->getLedgerId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ledger"));
		$this->assertEquals($pdoLedger->getLedgerPurchaseId(), $this->ledger->getPurchaseId());
		$this->assertEquals($pdoLedger->getLedgerAmount(), $this->VALID_PAYARLO2);
		$this->assertEquals($pdoLedger->getLedgerDate(), $this->VALID_ARLODATE);
		$this->assertEquals($pdoLedger->getLedgerStripeToken(), $this->VALID_ARLOSTRIPE);
	}

	/**
	* test updating a ledger that does not exist
	*
	* @expectedException PDOException
	**/
	public function testUpdateInvalidLedger() {
		//create a ledger and try to update it without actually updating it
		$this->ledger = new Ledger(null, $this->purchase->getPurchaseId(), $this->$VALID_PAYARLO, $this->$VALID_ARLODATE, $this->VALID_ARLOSTRIPE);
		$ledger->update($this->getPDO());
	}

	/**
	* test grabbing a ledger by ledger stripe token
	**/
	public function testGetLedgerByLedgerStripeToken() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->rowCount("ledger");

		//create and insert a ledger for this test
		$this->ledger = new Ledger(null, $this->purchase->getPurchaseId(), $this->$VALID_PAYARLO, $this->$VALID_ARLODATE, $this->VALID_ARLOSTRIPE);
		$this->ledger->insert($this->getPDO());

		//grab the data from mySQL and make sure it matches our expectations
		$results = Ledger::getLedgerByLedgerStripeToken($this->getPDO(), $ledger->getLedgerStripeToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ledger"));

		//Validate the data
		$pdoLedger = $results;
		$this->assertEquals($pdoLedger->getLedgerPurchaseId(), $this->ledger->getPurchaseId());
		$this->assertEquals($pdoLedger->getLedgerAmount(), $this->VALID_PAYARLO);
		$this->assertEquals($pdoLedger->getLedgerDate(), $this->VALID_ARLODATE);
		$this->assertEquals($pdoLedger->getLedgerStripeToken(), $this->VALID_ARLOSTRIPE);
	}

	/**
	* test getting a ledger by an invalid stripe token
	*
	* @expectedException PDOException
	**/
	public function testGetInvalidLedgerByLedgerStripeToken() {
		//grab a ledger by searching for a stripe token that doesn't exist
		$ledger = Ledger::getLedgerByLedgerStripeToken($this->getPDO(), "You shall not pass this test");
		$this->assertCount(0, $ledger);
	}
}

 ?>
