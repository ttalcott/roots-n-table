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


}