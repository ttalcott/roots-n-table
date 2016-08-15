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

		//create and insert a profile that makes a purchase for this ledger
		$this->profile = new Profile()

		//create and insert a purchase for this test
		$this->purchase = new Purchase();
	}
}

 ?>
