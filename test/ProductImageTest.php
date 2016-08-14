<?php
namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\ProductImage;

//grab the project parameters
require_once ("RootsTableTest.php");

//grab the class under scrutiny
require_once (dirname(__DIR__) . "public_html/php/classes/autoload.php");
/**
 * PHPUnit test for ProducImage.php
 * 
 * @see ProductIamge
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */
class ProductImageTest extends RootsTableTest{
	/**
	 * @var $CATIMAGEIMAGEID;
	 */
	protected $CATIMAGEIMAGEID;
	/**
	 * @var  $CATIMAGEPRODUCTID;
	 */
	protected  $CATIMAGEPRODUCTID;
	/**
	 * test inserting a valid proudctImage and verify that the mySQL data matches
	 */
	public function testInsertValidProductImage(){
		//get the count of the number of rows in the database
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert into mySQL
		$productImage = new ProductImage(null, $this->CATIMAGEIMAGEID, $this->CATIMAGEPRODUCTID);
		$productImage->insert($this->getPDO());

		//grab data from mySQL and ensure it matches
		$pdoProductImage = ProductImage::getProductImageByProductImageImageId($this->getPDO(), $productImage->getProductImageImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$this->assertEquals($pdoProductImage->getProductImageImageId(), $this->CATIMAGEIMAGEID);
		$this->assertEquals($pdoProductImage->getProductImageProducId(), $this->CATIMAGEPRODUCTID);
	}
	/**
	 * test inserting a productImage that cannot be added
	 *
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidProducImage(){
		//create productImage with non-null id
		$productImage = new ProductImage(RootsTableTest::INVALID_KEY, $this->CATIMAGEIMAGEID, $this->CATIMAGEPRODUCTID);
		$productImage->insert($this->getPDO());
	}
	/**
	 * test inserting a productImage, editing it and then updating it
	 */
	public function testUpdateValidProductImage(){
		//get the count of the number of rows in the data base
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert into mySQL
		$productImage = new ProductImage(null, $this->CATIMAGEIMAGEID, $this->CATIMAGEPRODUCTID);
		$productImage->insert($this->getPDO());

		//edit the productImage and update it in mySQL
		$productImage->setProductImageProductId($this-$this->CATIMAGEPRODUCTID);
		$productImage->update($this->getPDO());

		//grab data from mySQL and ensure it matches
		$pdoProductImage = ProductImage::getProductImageByProductImageImageId($this->getPDO(), $productImage->getProductImageImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$this->assertEquals($pdoProductImage->getProductImageImageId(), $this->CATIMAGEIMAGEID);
		$this->assertEquals($pdoProductImage->getProductImageProductId(), $this->CATIMAGEPRODUCTID);
	}
	/**
	 * test updating a productImage that does not exist
	 *
	 *@expectedException \PDOException
	 */
	public function testUpdateInvalidProductImage(){
		//create a productImage and try to update it without inserting it first
		$productImage = new ProductImage(null, $this->CATIMAGEIMAGEID, $this->CATIMAGEPRODUCTID);
		$productImage->update($this->getPDO());
	}
	/**
	 * test creating a productImage and then deleting it
	 */
	public function testDeleteValidProductImage(){
		//count the number of rows currently in the data base
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert into mySQL
		$productImage = new ProductIamge(null, $this->CATIMAGEIMAGEID, $this->CATIMAGEPRODUCTID);
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
	public function testDeleteInvalidProductImage(){
		//create a productImage and delete it without inserting it
		$productImage = new ProductImage(null, $this->CATIMAGEIMAGEID, $this->CATIMAGEPRODUCTID);
		$productImage->delete($this->getPDO());
	}
	/**
	 * test inserting a productImage and regrabbing it from mySQL
	 */
	public function testGetvalidProductImageByProductImageImageId(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert into mySQL
		$productImage = new ProductImage(null, $this->CATIMAGEIMAGEID, $this->CATIMAGEPRODUCTID);
		$productImage->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$pdoProductImage = ProductImage::getProductImageByProductImageImageId($this->getPDO(), $productImage-getProductImageImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$this->assertEquals($pdoProductImage->getProductImageImageId(), $this->CATIMAGEIMAGEID);
		$this->assertEquals($pdoProductImage->getProductImageProductId(), $this->CATIMAGEPRODUCTID);
	}
	/**
	 * test getting an productImage that does not exist
	 */
	public function testGetInvalidProductImageByImageId(){
		//grab an id that exceeds the maximum allowable value
		$productImage = ProductImage::getProductImageByProductImageImageId($this->getPDO(), RootsTableTest::INVALID_KEY);
		$this->assertNull($productImage);
	}
	/**
	 * test grabbing a productImage by productId
	 */
	public function testGetValidProductImageByProductId(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("productImage");

		//create a new productImage and insert it into mySQL
		$pdoProductImage = ProductImage::getProductImageByProductImageProductId($this->getPDO(), $this->CATIMAGEIMAGEID);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productImage"));
		$this->assertEquals($pdoProductImage[0]->getProductImageImageId(), $this->CATIMAGEIMAGEID);
		$this->assertEquals($pdoProductImage[0]->getProductImageProductId(), $this->CATIMAGEPRODUCTID);
	}
	/**
	 * test grabbing a productImage By productId that does not exist
	 */
	public function testGetInvalidProductImageByProductId(){
		$productImage = ProductImage::getProductImageByProductImageProductId($this->getPDO(), "8925");
		$this->assertEquals($productImage->getSize(), 0);
	}

}