<?php
namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\{Profile, Category, Unit, Product, ProductCategory};

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
* php unit test of the ProductCategory class for Roots 'n Table
*
* @see ProductCategory
* @author Travis Talcott <ttalcott@lyradevelopment.com>
**/

class ProductCategoryTest extends RootsTableTest {
	/**
	* activation token for the profile that this profileImage belongs to
	* @var string $VALID_ACTIVATEPROFILE
	**/
	protected $VALID_ACTIVATEPROFILE;
	/**
	* email for the profile that this profileImage belongs to
	* @var string $VALID_PROFILEEMAIL
	**/
	protected $VALID_PROFILEEMAIL = "arlo@gmail.com";
	/**
	* first name of the profile that this profileImage belongs to
	* @var string $VALID_FIRSTNAME
	**/
	protected $VALID_FIRSTNAME = "Kitty";
	/**
	* hash of the profile that this profileImage belongs to
	* @var string $VALID_HASH
	**/
	protected $VALID_HASH = null;
	/**
	* last name of the profile that this profileImage belongs to
	* @var string $VALID_LASTNAME
	**/
	protected $VALID_LASTNAME = "Yarn";
	/**
	* phone number of the profile that this profileImage belongs to
	* @var string $VALID_PHONE
	**/
	protected $VALID_PHONE = "+15554216739";
	/**
	* salt for the profile that this profileImage belongs to
	* @var string $VALID_SALT
	**/
	protected $VALID_SALT = null;
	/**
	* stripe token of the profile that this profileImage belongs to
	* @var string $VALID_STRIPE
	**/
	protected $VALID_STRIPE = "tok_18hQmK2eZvKYlo2CSILGY5nH";
	/**
	* profile type of the profile that this profileImage belongs to
	* @var string $VALID_TYPE
	**/
	protected $VALID_TYPE = "u";
	/**
	* username of the profile that this profileImage belongs to
	* @var string $VALID_USER
	**/
	protected $VALID_USER = "fuzzy cat";
	/**
	* name of the category for this test
	* @var string $VALID_CATEGORY
	**/
	protected $VALID_CATEGORY = "IndieCat";
	/**
	* name of the unit for this test
	* @var string $VALID_UNIT
	**/
	protected $VALID_UNIT = "CatPounds";
	/**
	* description of this product
	* @var string $VALID_DESCRIPTION
	**/
	protected $VALID_DESCRIPTION = "fuzzy arlo";
	/**
	* name of the product for this test
	* @var string $VALID_PRODUCTNAME
	**/
	protected $VALID_PRODUCTNAME = "HappyCat";
	/**
	* price of the product for this test
	* @var $VALID_PRODUCTPRICE
	**/
	protected $VALID_PRODUCTPRICE = "2.00";
}



 ?>
