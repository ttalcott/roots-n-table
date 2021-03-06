<?php
namespace Edu\Cnm\Rootstable\Test;

use Edu\Cnm\Rootstable\{Profile, Image, ProfileImage};

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
* php unit test of the ProfileImage class for Roots 'n Table
*
* @see ProfileImage
* @author Travis Talcott <ttalcott@lyradevelopment.com>
**/

class ProfileImageTest extends RootsTableTest {
	/**
	* activation token for the profile that this profileImage belongs to
	* @var string $VALID_ACTIVATEPROFILE
	**/
	protected $VALID_ACTIVATEPROFILE;
	/**
	* email for the profile that this profileImage belongs to
	* @var string $VALID_PROFILEEMAIL
	**/
	protected $VALID_PROFILEEMAIL = "senator@gmail.com";
	/**
	* first name of the profile that this profileImage belongs to
	* @var string $VALID_FIRSTNAME
	**/
	protected $VALID_FIRSTNAME = "Fuzzy";
	/**
	* hash of the profile that this profileImage belongs to
	* @var string $VALID_HASH
	**/
	protected $VALID_HASH = null;
	/**
	* last name of the profile that this profileImage belongs to
	* @var string $VALID_LASTNAME
	**/
	protected $VALID_LASTNAME = "Cat";
	/**
	* phone number of the profile that this profileImage belongs to
	* @var string $VALID_PHONE
	**/
	protected $VALID_PHONE = "+15557216739";
	/**
	* salt for the profile that this profileImage belongs to
	* @var string $VALID_SALT
	**/
	protected $VALID_SALT = null;
	/**
	* stripe token of the profile that this profileImage belongs to
	* @var string $VALID_STRIPE
	**/
	protected $VALID_STRIPE = "tok_18hQmK2eZvKYlo2CSILNY5nH";
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
	* image path of the image that this profileImage belongs to
	* @var string $VALID_IMAGEPATH
	**/
	protected $VALID_IMAGEPATH = "nicepic";
	/**
	* image type of the image that this profileImage belongs to
	* @var string $VALID_IMAGETYPE
	**/
	protected $VALID_IMAGETYPE = ".png";
	/**
	* profile that this profileImage belongs to
	* @var Profile $profile
	**/
	protected $profile = null;
	/**
	* image that this profileImage belongs to
	* @var image $image
	**/
	protected $image = null;

	/**
	* create dependent objects first
	**/
	public final function setUp() {
		//grab the defalut set up method first
		parent::setUp();


		//create an image for this test
		$this->image = new Image(null, $this->VALID_IMAGEPATH, $this->VALID_IMAGETYPE);
		$this->image->insert($this->getPDO());

		//create activation token for the profile
		$this->VALID_ACTIVATEPROFILE = bin2hex(random_bytes(16));

		//create hash and salt for the profile that this profileImage belongs to
		$password = "UseEncryptr!!!";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);

		//create and insert a profile that this profileImage belongs to
		$this->profile = new Profile(null, $this->VALID_ACTIVATEPROFILE, $this->VALID_PROFILEEMAIL, $this->VALID_FIRSTNAME, $this->VALID_HASH, $this->VALID_LASTNAME, $this->VALID_PHONE, $this->VALID_SALT, $this->VALID_STRIPE, $this->VALID_TYPE, $this->VALID_USER);
		$this->profile->insert($this->getPDO());
	}

	/**
	* test inserting a valid profileImage
	**/
	public function testInsertValidProfileImage() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profileImage");

		//create and insert a profileImage to be tested
		$profileImage = new ProfileImage($this->image->getImageId(), $this->profile->getProfileId());
		$profileImage->insert($this->getPDO());

		//grab the data from mySQL and ensure it matches our expectations
		$pdoProfileImage = ProfileImage::getProfileImageByProfileImageImageIdAndProfileId($this->getPDO(), $profileImage->getProfileImageImageId(), $profileImage->getProfileImageProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileImage"));
		$this->assertEquals($pdoProfileImage->getProfileImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoProfileImage->getProfileImageProfileId(), $this->profile->getProfileId());
	}

	/**
	* test inserting an invalid profileImage (one that doesn't exist)
	*
	* @expectedException PDOException
	**/
	public function testInsertInvalidProfileImage() {
		//create an invalid profileImage and try to insert it
		$profileImage = new ProfileImage(RootsTableTest::INVALID_KEY, RootsTableTest::INVALID_KEY);
		$profileImage->insert($this->getPDO());
	}

	/**
	* test creating a profileImage and then deleting it
	**/
	public function testDeleteValidProfileImage() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profileImage");

		//create and insert a profileImage to be tested
		$profileImage = new ProfileImage($this->image->getImageId(), $this->profile->getProfileId());
		$profileImage->insert($this->getPDO());

		//delete the profileImage from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileImage"));
		$profileImage->delete($this->getPDO());

		//grab the data from mySQL and ensure the profileImage does not exist
		$pdoProfileImage = ProfileImage::getProfileImageByProfileImageImageIdAndProfileId($this->getPDO(), $profileImage->getProfileImageImageId(), $profileImage->getProfileImageProfileId());
		$this->assertNull($pdoProfileImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profileImage"));
	}

	/**
	* test deleting a profileImage that does not exist
	**/
	public function testDeleteInvalidProfileImage() {
		//create a profileImage and try to delete it without actually inserting it
		$profileImage = new ProfileImage($this->image->getImageId(), $this->profile->getProfileId());
		$profileImage->delete($this->getPDO());
	}

	/**
	* test grabbing a profileImage by profileImageProfileId and profileImageImageId that do not exist
	**/
	public function testGetInvalidProfileImageByProfileImageImageIdAndProfileId() {
		//grab a profileImage with keys that do not exist
		$profileImage = ProfileImage::getProfileImageByProfileImageImageIdAndProfileId($this->getPDO(), RootsTableTest::INVALID_KEY, RootsTableTest::INVALID_KEY);
		$this->assertNull($profileImage);
	}

	/**
	* test grabbing a profileImage by profileImageImageId
	**/
	public function testGetValidProfileImageByProfileImageImageId() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profileImage");

		//create and insert a profileImage to be tested
		$profileImage = new ProfileImage($this->image->getImageId(), $this->profile->getProfileId());
		$profileImage->insert($this->getPDO());

		//grab the data from mySQL and enforce it meets our expectations
		$results = ProfileImage::getProfileImageByProfileImageImageId($this->getPDO(), $profileImage->getProfileImageImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\ProfileImage", $results);

		//grab the results from the array and validate them
		$pdoProfileImage = $results[0];
		$this->assertEquals($pdoProfileImage->getProfileImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoProfileImage->getProfileImageProfileId(), $this->profile->getProfileId());
	}

	/**
	* test grabbing a profileImage by profileImageProfileId
	**/
	public function testGetValidProfileImageByProfileImageProfileId() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profileImage");

		//create and insert a profileImage to be tested
		$profileImage = new ProfileImage($this->image->getImageId(), $this->profile->getProfileId());
		$profileImage->insert($this->getPDO());

		//grab the data from mySQL and enforce it meets our expectations
		$results = ProfileImage::getProfileImageByProfileImageProfileId($this->getPDO(), $profileImage->getProfileImageProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\ProfileImage", $results);

		//grab the results from the array and validate them
		$pdoProfileImage = $results[0];
		$this->assertEquals($pdoProfileImage->getProfileImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoProfileImage->getProfileImageProfileId(), $this->profile->getProfileId());
	}

	/**
	* test grabbing all profileImages
	**/
	public function testGetAllProfileImages() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profileImage");

		//create and insert a profileImage to be tested
		$profileImage = new ProfileImage($this->image->getImageId(), $this->profile->getProfileId());
		$profileImage->insert($this->getPDO());

		//grab the data from mySQL and enforce it meets our expectations
		$results = ProfileImage::getAllProfileImages($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Rootstable\\ProfileImage", $results);

		//grab the results from the array and validate them
		$pdoProfileImage = $results[0];
		$this->assertEquals($pdoProfileImage->getProfileImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoProfileImage->getProfileImageProfileId(), $this->profile->getProfileId());
	}
}
 ?>
