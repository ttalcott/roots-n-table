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
	* purchase this ledger belongs to; this is for foreign key relations
	* @var Purchase $purchase
	**/
	protected $purchase = null;

	//create dependent objects before running each test
	public final function setUp() {
		//run the default set up method first
		parent::setUp();

		//create and insert a purchase for this test
		$this->purchase = new Purchase()
	}
}

 ?>
