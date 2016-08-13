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
}