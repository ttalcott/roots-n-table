<?php

/**
 * creating profile class
 * @author Travis Talcott <ttalcott@cnm.edu>
 * version 1.0.0
 */
class Profile {
	/**
	 * id for this profile; this is the primary key
	 * @var int $profileId
	 */
	private $profileId;
	/**
	 * activation token for this profile
	 * @var  string $profileActivationToken
	 */
	private $profileActivationToken;
	/**
	 * email for this profile
	 * @var string $profileEmail
	 */
	private $profileEmail;
	/**
	 * first name for this profile
	 * @var string $profileFirstName
	 */
	public $profileFirstName;
	/**
	 *profile hash
	 *@var string $profileHash
	 */
	private $profileHash;
	/**
	 * last name for this profile
	 * @var string $profileLastName
	 */
	public $profileLastName;
	/**
	 * phone number for profile
	 * @var string $profilePhoneNumber
	 */
	private $profilePhoneNumber;
	/**
	 * profile salt
	 * @var string $profileSalt
	 */
	private $profileSalt;
	/**
	 * type of profile
	 * @var string $profileType
	 **/
	private $profileType;
	/**
	 * user name for profile
	 * @var string $profileUserName
	 **/
	public $profileUserName;

	/**
	 *accessor method for profile id
	 *
	 * @return int|null value of profile id
	 **/
	public function getProfileId() {
		return($this->profileId);
	}

	/**
	 * accessor method for profile activation token
	 *
	 * @return string value of profile activation token
	 */
	public function getProfileActivationToken() {
		return($this->profileActivationToken);
	}

	/**
	 * accessor method for profile email
	 *
	 * @return string value of profile email
	 */
	public function getProfileEmail() {
		return($this->profileEmail);
	}
	
	/**
	 * accessor method for profile first name
	 *
	 * @return string value of profile first name
	 */
	public function getProfileFirstName() {
		return($this->profileFirstName);
	}

	/**
	 * accessor method for profile hash
	 *
	 * @return string value of profile hash
	 */
	public function getProfileHash() {
		return($this->profileHash);
	}

	/**
	 *accessor method for profile last name
	 *
	 * @return string value for profile last name
	 */
	public function getProfileLastName() {
		return($this->profileLastName);
	}

	/**
	 * accessor method for profile phone number
	 *
	 * @return string value of profile phone number
	 */
	public function getProfilePhoneNumber() {
		return($this->profilePhoneNumber);
	}

	/**
	 * accessor method for profile type
	 *
	 * @return string value of profile type
	 */
	public function getProfileType() {
		return($this->profileType);
	}
}