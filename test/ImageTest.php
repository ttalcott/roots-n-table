<?php
namespace Edu\Cnm\Rootstable\Test;

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * @see Image
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */

class ImageTest extends rootsTableTest{
	/**
	 * @var Int $VALID_IMAGEID
	 */
	protected $VALID_IMAGEID = NULL;
	/**
	 * @var Int $VALID_IMAGEPATH
	 */
	protected $VALID_IMAGEPATH = NULL;

	/**
	 * @var Int $VALID_IMAGETYPE
	 */
	protected $VALID_IMAGETYPE = NULL;

	/**
	 * test inserting valid image and verify the mySQL data matches
	 */
	public function testInsertValidImage(){
		//get the count of the number of rows in the database
		$numRows = $this->getConnection()->getRowCount("Image");

		//create a new Image and insert into mySQL
		$image = new Image(null,$this->VALID_IMAGEID,$this->VALID_IMAGEPATH,$this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());

		//grab data from SQL and ensure it matches
		$pdoImage = Image::getImageByImageID($this->getPDO(),$image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImagePath(),$this->VALID_IMAGEPATH);
		$this->assertEquals($pdoImage->getImageType(),$this->VALID_IMAGETYPE);
	}

	/**
	 * test inserting a Image that cannot be added
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidImage(){
		//create image with non-null id so it will fail
		$image = new Image(RootsTableTest::INVALID_KEY,$this->VALID_IMAGEPATH,$this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());
	}
	/**
	 * test inserting an image, edit it, then update it
	 */
	public function testUpdateValidImage(){
		//get the count of the number of rows
		$numRows = $this->getConnection()->getRowCount("image");

		//create a new image and insert into mySQL
		$image = Image(null, $this->VALID_IMAGEPATH, $this->VALID_IMAGETYPE);
		$image-insert($this->getPDO());

		//edit the image and update it in mySQL
		$image->setImagePath($this->VALID_IMAGEPATH);
		$image->update($this->getPDO());

		//grab data from SQL and ensure it matches
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assetEquals($pdoImage->getImagePath(), $this->VALID_IMAGEPATH);
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
	}
	/**
	 * test updating an image that does not exist
	 *
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidImage(){
		//create a image and tyr to update without inserting it
		$image = Image(null, $this->VALID_IMAGEPATH, $this->VALID_IMAGETYPE);
		$image->update($this->getPDO());
	}
	/**
	 * test creating an image an then deleting it
	 */
	public function testDeleteValidImage(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("image");

		//create a new image and insert it into mySQL
		$image = new Image(null, $this->VALID_IMAGEPATH, $this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());

		//confirm the image was added and then deleted
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$image->delete($this->getPDO());

		//grab data from mySQL and ensure it doesn't exist
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertNull($pdoImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("image"));
	}

}
