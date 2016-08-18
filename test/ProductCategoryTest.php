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
	/**
	* profile for this test
	**/
	protected $profile = null;
	/**
	* category for this test
	**/
	protected $category = null;
	/**
	* unit for this test
	**/
	protected $unit = null;
	/**
	* product for this test
	**/
	protected $product = null;

	public final function setUp() {
		//grab the defalut set up method first
		parent::setUp();

		//create activation token for the profile
		$this->VALID_ACTIVATEPROFILE = bin2hex(random_bytes(16));

		//create hash and salt for the profile that this profileImage belongs to
		$password = "passwordlol";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);

		//create and insert a profile for this test
		$this->profile = new Profile(null, $this->VALID_ACTIVATEPROFILE, $this->VALID_PROFILEEMAIL, $this->VALID_FIRSTNAME, $this->VALID_HASH, $this->VALID_LASTNAME, $this->VALID_PHONE, $this->VALID_SALT, $this->VALID_STRIPE, $this->VALID_TYPE, $this->VALID_USER);
		$this->profile->insert($this->getPDO());

		//create and insert a category for this test
		$this->category = new Category(null, $this->VALID_CATEGORY);
		$this->category->insert($this->getPDO());

		//create a unit for this test
		$this->unit = new Unit(null, $this->VALID_UNIT);
		$this->unit->insert($this->getPDO());

		//create and insert a product for this test
		$this->product = new Product(null, $this->profile->getProfileId(), $this->unit->getUnitId(), $this->VALID_DESCRIPTION, $this->VALID_PRODUCTNAME, $this->VALID_PRODUCTPRICE);
		$this->product->insert($this->getPDO());
	}

	/**
	* test inserting a valid productCategory
	**/
	public function testInsertValidProductCategory() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("productCategory");

		//create and insert a productCategory to be tested
		$productCategory = new ProductCategory($this->category->getCategoryId(), $this->product->getProductId());
		$productCategory->insert($this->getPDO());

		//grab the data from mySQL and ensure it matches our expectations
		$pdoProductCategory = ProductCategory::getProductCategoryByProductCategoryCategoryIdAndProductId($this->getPDO(), $productCategory->getProductCategoryCategoryId(), $productCategory->getProductCategoryProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productCategory"));
		$this->assertEquals($pdoProductCategory->getProductCategoryCategoryId(), $this->category->getCategoryId());
		$this->assertEquals($pdoProductCategory->getProductCategoryProductId(), $this->product->getProductId());
	}

	/**
	* test inserting a productCategory that doesn't exist
	*
	* @expectedException PDOException
	**/
	//create an invalid ProductCategory and try to insert it
	public function testInsertInvalidProductCategory() {
		$productCategory = new ProductCategory(RootsTableTest::INVALID_KEY, RootsTableTest::INVALID_KEY);
		$productCategory->insert($this->getPDO());
	}

	/**
	* test deleting a valid ProductCategory
	**/
	public function testDeleteValidProductCategory() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("productCategory");

		//create and insert a productCategory to be tested
		$productCategory = new ProductCategory($this->category->getCategoryId(), $this->product->getProductId());
		$productCategory->insert($this->getPDO());

		//delete the ProductCategory from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productCategory"));
		$productCategory->delete($this->getPDO());

		//grab the data from mySQL and ensure it matches our expectations
		$pdoProductCategory = ProductCategory::getProductCategoryByProductCategoryCategoryIdAndProductId($this->getPDO(), $productCategory->getProductCategoryCategoryId(), $productCategory->getProductCategoryProductId());
		$this->assertNull($pdoProductCategory);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("productCategory"));
	}
}



 ?>
