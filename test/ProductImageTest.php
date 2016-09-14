<?php
namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\{
	ProductImage, Product, Image, Profile, Unit
};

//grab the project parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * PHPUnit test for ProductImage.php
 *
 * @see ProductIamge
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */
class ProductImageTest extends RootsTableTest {
	/**
	 * @var Profile
	 */
	protected $profile = null;
	/**
	 * @var activate
	 */
	protected $activate;
	/**
	 * @var $profileHash
	 */
	protected $profileHash = null;
	/**
	 * @var $profileSalt
	 */
	protected $profileSalt = null;
	/**
	 * @var unit
	 */
	protected  $unit;
	/**
	 * @var null
	 */
	protected $product = null;
	/**
	 * @var product2
	 */
	protected $product2 = null;
	/**
	 * @var null image
	 */
	protected $image = null;
	/**
	 * @var image2
	 */
	protected $image2 = null;

	/**
	 * create dependent object first
	 */
	public final function setUp() {
		//run the default set up method first
		parent::setUp();

		/** create activation token */
		$this->activate = bin2hex(random_bytes(16));

		/**create hash and salt*/
		$password = "theroofisonfire5432167890";
		$this->profileSalt = bin2hex(random_bytes(32));
		$this->profileHash = hash_pbkdf2("sha512", $password, $this->profileSalt, 262144);

		// create and insert a Profile
		$this->profile = new Profile(null, $this->activate, "purchasetest@phpunit.de", "Field", $this->profileHash, "Needs","+011526567986060", $this->profileSalt, "stripey", "u", "@Freefarms");
		$this->profile->insert($this->getPDO());

		$this->unit = new Unit(null, "thenameofaunit");
		$this->unit->insert($this->getPDO());

		//create and insert image
		$this->image = new Image(null, "coolpic", "jpeg");
		$this->image->insert($this->getPDO());

		//create and insert image2
		$this->image2 = new Image(null, "winterbreeze", "png");
		$this->image2->insert($this->getPDO());

		//create and inset product
		$this->product = new Product(null, $this->profile->getProfileId(), $this->unit->getUnitId(), "Example description", "Carrots", "3.99");
		$this->product->insert($this->getPDO());

		//create and insert product2
		$this->product2 = new Product(null, $this->profile->getProfileId(), $this->unit->getUnitId(), "Some description", "beets", "2.99");
		$this->product2->insert($this->getPDO());

	}

	/**
	 * test inserting a valid proudctImage and verify that the mySQL data matches
	 */
	public function testInsertValidProductImage() {
		//get the count of the number of rows in the database
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert into mySQL
		$productImage = new ProductImage($this->image->getImageId(), $this->product->getProductId());
		$productImage->insert($this->getPDO());

		//grab data from mySQL and ensure it matches
		$pdoProductImage = ProductImage::getProductImageByProductImageImageIdAndProductId($this->getPDO(),$productImage->getProductImageImageId(), $productImage->getProductImageProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$this->assertEquals($pdoProductImage->getProductImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoProductImage->getProductImageProductId(), $this->product->getProductId());
	}

	/**
	 * test inserting a productImage that cannot be added
	 *
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidProductImage() {
		//create productImage with non-null id
		$productImage = new ProductImage(RootsTableTest::INVALID_KEY, RootsTableTest::INVALID_KEY);
		$productImage->insert($this->getPDO());
	}


	/**
	 * test creating a productImage and then deleting it
	 */
	public function testDeleteValidProductImage() {
		//count the number of rows currently in the data base
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert into mySQL
		$productImage = new ProductImage($this->image->getImageId(), $this->product->getProductId());
		$productImage->insert($this->getPDO());

		//confirm the row was added, then delete it
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$productImage->delete($this->getPDO());

		//grab data from mySQL and ensure it doesn't exist
		$pdoProductImage = ProductImage::getProductImageByProductImageImageIdAndProductId($this->getPDO(), $productImage->getProductImageImageId(), $productImage->getProductImageProductId());
		$this->assertNull($pdoProductImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("productImage"));
	}

	/**
	 * test deleteing a productImage that does not exist
	 *
	 */
	public function testDeleteInvalidProductImage() {
		//create a productImage and delete it without inserting it
		$productImage = new ProductImage($this->image->getImageId(), $this->product->getProductId());
		$productImage->delete($this->getPDO());
	}

	/**
	 * test inserting a productImage and regrabbing it from mySQL
	 */
	public function testGetValidProductImageByProductImageImageId() {
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert into mySQL
		$productImage = new ProductImage($this->image->getImageId(), $this->product->getProductId());
		$productImage->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$results = ProductImage::getProductImageByProductImageImageId($this->getPDO(), $productImage->getProductImageImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\ProductImage", $results);

		// grab the result and validate it
		$pdoProductImage = $results[0];
		$this->assertEquals($pdoProductImage->getProductImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoProductImage->getProductImageProductId(), $this->product->getProductId());

	}

	/**
	 * test getting an productImage that does not exist
	 */
	public function testGetInvalidProductImageByImageIdAndProductId() {
		//grab an id that exceeds the maximum allowable value
		$productImage = ProductImage::getProductImageByProductImageImageIdAndProductId($this->getPDO(), RootsTableTest::INVALID_KEY, RootsTableTest::INVALID_KEY);
		$this->assertNull($productImage);
	}

	/**
	 * test grabbing a productImage by productId
	 *
	 * @throws \PDOException
	 */
	public function testGetValidProductImageByProductId() {
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create new product image and insert into mySQL
		$productImage = new ProductImage($this->image->getImageId(), $this->product->getProductId());
		$productImage->insert($this->getPDO());

		//create a new productImage and insert it into mySQL
		$results = ProductImage::getProductImageByProductImageProductId($this->getPDO(), $this->product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\ProductImage", $results);

		//grab the result and validate it
		$pdoProductImage = $results[0];
		$this->assertEquals($pdoProductImage->getProductImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoProductImage->getProductImageProductId(), $this->product->getProductId());
	}


	/**
	 * test grabbing a productImage by productId
	 */
	public function testGetAllProductImages() {
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create new product image and insert into mySQL
		$productImage = new ProductImage($this->image->getImageId(), $this->product->getProductId());
		$productImage->insert($this->getPDO());

		//create a new productImage and insert it into mySQL
		$results = ProductImage::getAllProductImages($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\ProductImage", $results);

		//grab the result and validate it
		$pdoProductImage = $results[0];
		$this->assertEquals($pdoProductImage->getProductImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoProductImage->getProductImageProductId(), $this->product->getProductId());
	}

}