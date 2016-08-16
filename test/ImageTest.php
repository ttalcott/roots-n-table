<?php
namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\Image;

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * @see Image
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */

class ImageTest extends RootsTableTest{
	/**
	 * @var string $VALID_IMAGEPATH
	 */
	protected $VALID_IMAGEPATH = "coolpic";

	/**
	 * @var string $VALID_IMAGETYPE
	 */
	protected $VALID_IMAGETYPE = ".gif";

	/**
	 * test inserting valid image and verify the mySQL data matches
	 */
	public function testInsertValidImage(){
		//get the count of the number of rows in the database
		$numRows = $this->getConnection()->getRowCount("image");

		//create a new Image and insert into mySQL
		$image = new Image(null, $this->VALID_IMAGEPATH, $this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());

		//grab data from SQL and ensure it matches
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImagePath(),$this->VALID_IMAGEPATH);
		$this->assertEquals($pdoImage->getImageType(),$this->VALID_IMAGETYPE);
	}

	/**
	 * test inserting a Image that cannot be added
	 *
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
		$image = new Image(null, $this->VALID_IMAGEPATH, $this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());

		//edit the image and update it in mySQL
		$image->setImagePath($this->VALID_IMAGEPATH);
		$image->update($this->getPDO());

		//grab data from SQL and ensure it matches
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImagePath(), $this->VALID_IMAGEPATH);
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
	}
	/**
	 * test updating an image that does not exist
	 *
	 * @expectedException PDOException
	 */
	public function testUpdateInvalidImage(){
		//create a image and try to update without inserting it
		$image = new Image(null, $this->VALID_IMAGEPATH, $this->VALID_IMAGETYPE);
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
	/**
	 * test deleting a image that does not exist
	 *
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidImage(){
		//create a image and delete without actually inserting it
		$image = new Image(null, $this->VALID_IMAGEPATH, $this->VALID_IMAGETYPE);
		$image->delete($this->getPDO());
	}
	/**
	 * test inserting a image and regrabbing it from mySQL
	 */
	public function testGetValidImageByImageId(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("image");

		//create a new image and insert into mySQL
		$image = new Image(null, $this->VALID_IMAGEPATH, $this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$results = Image::getImageByImageId($this->getPdo(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		
		//grab result and validate it
		$pdoImage = $results;
		$this->assertEquals($pdoImage->getImagePath(), $this->VALID_IMAGEPATH);
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
	}
	/**
	 * test getting a image that does not exist
	 */
	public function testGetInvalidImageByImageId(){
		//grab an id that exceeds the maximum allowable value
		$image = Image::getImageByImageId($this->getPDO(), RootsTableTest::INVALID_KEY);
		$this->assertEquals(0, $image);
	}
	/**
	 * test grabbing an image by path
	 */
	public function testGetValidImageByPath(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("image");

		//create a new image and insert into mySQL
		$image = new Image(null, $this->VALID_IMAGEPATH, $this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$results = Image::getImageByImagePath($this->getPDO(), $image->getImagePath());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		
		
		//grab the result from the array and validate it
		$pdoImage = $results;
		$this->assertEquals($pdoImage->getImagePath(), $this->VALID_IMAGEPATH);
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
	}
	/**
	 *test for grabbing an image by path that does not exist
	 */
	public function testGetInvalidImageByPath(){
		$image = Image::getImageByImagePath($this->getPDO(),"coolPic");
		$this->assertEquals(0, $image);
	}
	/**
	 * test grabbing an image by type
	 */
	public function testGetValidImageByType(){
		//count the number of rows currently in the database
		$numRows = $this->getConnection()->getRowCount("image");

		//create a new image and insert into mySQL
		$image = new Image(null, $this->VALID_IMAGEPATH, $this->VALID_IMAGETYPE);
		$image->insert($this->getPDO());

		//grab data from mySQL and enforce that the fields match
		$pdoImage = Image::getImageByImageType($this->getPdo(), $this->VALID_IMAGETYPE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImagePath(), $this->VALID_IMAGEPATH);
		$this->assertEquals($pdoImage->getImageType(),
			$this->VALID_IMAGETYPE);
	}
	/**
	 * test for grabbing an image by type that does not exsit
	 */
	public function testGetInvalidImageByType(){
		$image = Image::getImageByImageType($this->getPDO(), "gif");
		$this->assertEquals(0, $image);
	}

}
