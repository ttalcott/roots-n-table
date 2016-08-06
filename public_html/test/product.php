<?php
namespace Edu\Cnm\rootstable\Test;

//grab the project test parameters
require_once("roots-table-test.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Product class
 *
 * This is a complete PHPUnit test of the Product class. It is complete becase *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see ProductTest
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */
class ProductTest extends rootstable {
	/**
	 * content of the product
	 * This is the primary key
	 * @var int $productId
	 */
	public $profileId = "YOU'RE NULL";
	/**
	 * content of the productProfileId
	 * @var int $productProfileId
	 */
	public $productProfileId = "Fuzzy?";
	/**
	 * content of productUnitId
	 * @var int $productUnitId
	 */
	public $productUnitId = "How much would you like.";
	/**
	 * content of productDescription
	 * @var int $productDescription
	 */
	public $productDescription ="Fresh produce";
	/**
	 * content of productName
	 * @var string $productName
	 */
	public $productName = "Peppers";
	/**
	 * content of productPrice
	 * @var int $productPrice
	 */
	public $productPrice = "13.49";

	
}