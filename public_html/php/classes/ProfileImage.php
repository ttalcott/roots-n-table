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
}
 ?>
