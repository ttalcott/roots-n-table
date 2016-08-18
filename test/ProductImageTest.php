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
	 * @var null product
	 */
	protected $product = null;
	/**
	 * @var product2
	 */
	protected $product2;
	/**
	 * @var null image
	 */
	protected $image = null;
	/**
	 * @var image2
	 */
	protected $image2;

	public final function setUp() {
		//run the default set up method first
		parent::setUp();

		//create and inset product
		$this->product = new Product(null,$this->product->getProductId, $this->profile->getProfileId(), $this->unit->getUnitId(), "Example description", "Carrots", "3.99");
		$this->product->insert($this->getPDO());

		//create and insert image
		$this->image = new Image(null, $this->image->getImageId());
		$this->image->insert($this->getPDO());

		$this->profile = new Profile(null, $this->profile->getProfileId());
		$this->profile->insert($this->getPDO());

		$this->unit = new Unit(null, $this->unit->getUnitId());
		$this->unit->insert($this->getPDO());
	}

	/**
	 * test inserting a valid proudctImage and verify that the mySQL data matches
	 */
	public function testInsertValidProductImage() {
		//get the count of the number of rows in the database
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert into mySQL
		$productImage = new ProductImage($this->product->getProductId(), $this->image->getImageId());
		$productImage->insert($this->getPDO());

		//grab data from mySQL and ensure it matches
		$pdoProductImage = ProductImage::getProductImageByProductImageImageId($this->getPDO(), $productImage->getProductImageImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$this->assertEquals($pdoProductImage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoProductImage->getImageId(), $this->image - getImageId());
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
	 * test inserting a productImage, editing it and then updating it
	 */
	public function testUpdateValidProductImage() {
		//get the count of the number of rows in the data base
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert into mySQL
		$productImage = new ProductImage( $this->product->getProductId(),
			$this->image->getImageId());
		$productImage->insert($this->getPDO());

		//edit the productImage and update it in mySQL
		$productImage->setProductImageProductId($this->product2, $this->image2);
		$productImage->update($this->getPDO());

		//grab data from mySQL and ensure it matches
		$pdoProductImage = ProductImage::getProductImageByProductImageImageId($this->getPDO(), $productImage->getProductImageImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$this->assertEquals($pdoProductImage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoProductImage->getImageId(), $this->image->getImageId());
	}

	/**
	 * test updating a productImage that does not exist
	 *
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidProductImage() {
		//create a productImage and try to update it without inserting it first
		$productImage = new ProductImage( $this->product->getProductId(), $this->image->getImageId());
		$productImage->update($this->getPDO());
	}

	/**
	 * test creating a productImage and then deleting it
	 */
	public function testDeleteValidProductImage() {
		//count the number of rows currently in the data base
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert into mySQL
		$productImage = new ProductIamge( $this->product->getProductId(), $this->image->getImageId());
		$productImage->insert($this->getPDO());

		//confirm the row was added, then delete it
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$productImage->delete($this->getPDO());

		//grab data from mySQL and ensure it doesn't exist
		$pdoProductImage = ProductImage::getProductImageByProductImageImageId($this->getPDO(), $productImage->getProductImageImageId());
		$this->assertNull($pdoProductImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("productImage"));
	}

	/**
	 * test deleteing a productImage that does not exist
	 *
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidProductImage() {
		//create a productImage and delete it without inserting it
		$productImage = new ProductImage( $this->product->getProductId(), $this->image->getImageId());
		$productImage->delete($this->getPDO());
	}

	/**
	 * test inserting a productImage and regrabbing it from mySQL
	 */
	public function testGetValidProductImageByProductImageImageId() {
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert into mySQL
		$productImage = new ProductImage( $this->product->getProductId(),
			$this->image->getImageId());
		$productImage->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$results = ProductImage::getProductImageByProductImageImageId($this->getPDO(), $productImage->getProductImageImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));

		// grab the result and validate it
		$pdoProductImage = $results;
		$this->assertEquals($pdoProductImage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoProductImage->getImageId(), $this->image->getImageId());
	}

	/**
	 * test getting an productImage that does not exist
	 */
	public function testGetInvalidProductImageByImageId() {
		//grab an id that exceeds the maximum allowable value
		$productImage = ProductImage::getProductImageByProductImageImageId(RootsTableTest::INVALID_KEY, RootsTableTest::INVALID_KEY);
		$this->assertCount(0, $productImage);
	}

	/**
	 * test grabbing a productImage by productId
	 */
	public function testGetValidProductImageByProductId() {
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create new product image and insert into mySQL
		$productImage = new ProductImage($this->product->getProductId(),
			$this->image->getImageId());
		$productImage->insert($this->getPDO());

		//create a new productImage and insert it into mySQL
		$results = ProductImage::getProductImageByProductImageProductId($this->getPDO(), $this->product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));

		//grab the result and validate it
		$pdoProductImage = $results;
		$this->assertEquals($pdoProductImage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoProductImage->getImageId(), $this->image->getImageId());
	}

	/**
	 * test grabbing a productImage By productId that does not exist
	 */
	public function testGetInvalidProductImageByProductId() {
		$productImage = ProductImage::getProductImageByProductImageProductId($this->getPDO(), "8925");
		$this->assertEquals(0, $productImage);
	}

	/**
	 * test grabbing a productImage by productId
	 */
	public function testGetAllProductImages() {
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create new product image and insert into mySQL
		$productImage = new ProductImage(null, $this->product->getProductId(),
			$this->image->getImageId());
		$productImage->insert($this->getPDO());

		//create a new productImage and insert it into mySQL
		$results = ProductImage::getAllProductImages($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));

		//grab the result and validate it
		$pdoProductImage = $results;
		$this->assertEquals($pdoProductImage->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoProductImage->getImageId(), $this->image->getImageId());
	}

}