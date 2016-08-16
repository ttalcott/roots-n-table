<?php
namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

/**
* Profile Image class for Roots 'n Table
*
* @author Travis Talcott <ttalcott@lyradevelopment.com>
* version 1.0.0
**/
class ProfileImage {
	/**
	* profile id that this image belongs to
	* @var int $profileImageProfileId
	**/
	private $profileImageProfileId;
	/**
	* image id that this image belongs to
	* @var int $profileImageImageId
	**/
	private $profileImageImageId;

	/**
	* constructor for ProfileImage class
	*
	* @param int $newProfileImageProfileId id of the profile this image belongs to
	* @param int $newProfileImageImageId id of the image this image belongs to
	* @throws \RangeException if data values are out of bounds
	* @throws \TypeError if data values are not the correct type
	* @throws \Exception if any other exception occurs
	**/
	public function __construct(int $newProfileImageProfileId, int $newProfileImageImageId) {
		try {
			$this->setProfileImageProfileId($newProfileImageProfileId);
			$this->setProfileImageImageId($newProfileImageImageId);
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the error to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	* accessor method for $profileImageProfileId
	* @return int value of $profileImageProfileId
	**/
	public function getProfileImageProfileId() {
		return($this->profileImageProfileId);
	}

	/**
	* mutator method for profileImageProfileId
	*
	* @param int $newProfileImageProfileId new value of profileImageProfileId
	* @throws \RangeException if $newProfileImageProfileId is not positive
	* @throws \TypeError if $newProfileImageProfileId is not an integer
	**/
	public function setProfileImageProfileId(int $newProfileImageProfileId) {
		//verify $newProfileImageProfileId is positive
		if($newProfileImageProfileId <= 0) {
			throw(new \RangeException("profile image profile id is not positive"));
		}

		//convert and store profileImageProfileId
		$this->profileImageProfileId = $newProfileImageProfileId;
	}

	/**
	* accessor method for profileImageImageId
	* @return int value of $profileImageImageId
	**/
	public function getProfileImageImageId() {
		return($this->profileImageImageId);
	}

	/**
	* mutator method for profileImageImageId
	*
	* @param int $newProfileImageImageId new value of profileImageImageId
	* @throws \RangeException if $newProfileImageImageId is not positive
	* @throws \TypeError if $newProfileImageImageId is not an integer
	**/
	public function setProfileImageImageId(int $newProfileImageImageId) {
		//verify $newProfileImageImageId is positive
		if($newProfileImageImageId <= 0) {
			throw(new \RangeException("profile image image id is not positive"));
		}

		//convert and store profileImageImageId
		$this->profileImageImageId = $newProfileImageImageId;
	}
}
 ?>
