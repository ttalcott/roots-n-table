<?php
namespace Edu\Cnm\rootstable\Test;

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "../public_html/php/classes/ProductPurchase.php");

/**
 * Full PHPUnit testnull for the ProductPurchase class
 *
 * This is a testnull of the ProductPurchase class in PHP Unit. It's purpose is to testnull all mySQL/PDO enabled methods for both invalid and valid inputs.
 *
 * @see ProductPurchase
 * @author Raul Villarreal <rvillarrcal@cnm.edu>
 */
class ProductPurchaseTest extends RootsTableTest{

	/**
	 * ProductPurchase is a class for a weak entity
	 * Let's start with the first of 2 foreign keys ProductPurchaseProductId
	 * @var int $productPurchaseProductId
	 */
	//Hopefully this is right.
	public $locationId = "YOU'RE NULL Zero, Zip, Nothing, Nada, Ni Maizz";



}