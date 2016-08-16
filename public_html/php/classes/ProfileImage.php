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
	

	/**
	* accessor method for profileImageImageId
	* @return int value of $profileImageImageId
	**/
	public function getProfileImageImageId() {
		return($this->profileImageImageId);
	}
}
 ?>
