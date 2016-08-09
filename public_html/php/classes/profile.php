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
	private $profileFirstName;
	/**
	 *profile hash
	 *@var string $profileHash
	 */
	private $profileHash;
	/**
	 * last name for this profile
	 * @var string $profileLastName
	 */
	private $profileLastName;
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
	private $profileUserName;

	/**
	 *accessor method for profile id
	 *
	 * @return int|null value of profile id
	 **/
	public function getProfileId() {
		return($this->profileId);
	}

	/**
	* mutator method for profile id
	*
	* @param int|null $newProfileId value for new profile id
	* @throws \RangeException if $newProfileId is not positive
	* @throws \TypeError if $newProfileId is not an integer
	**/
	public function setProfileId(int $newProfileId = null) {
		if($newProfileId === null) {
			$this->$profileId = null;
			return;
		}

		//verify profile id is positive
		if($newProfileId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}

		//convert and store profile id
		$this->profileId = $newProfileId;
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
	* mutator method for profile activation token
	*
	* @param string $newProfileActivationToken new value for profile activation token
	* @throws \InvalidArgumentException if $newProfileActivationToken is not a string or is insecure
	* @throws \RangeException if $newProfileActivationToken is > 32 characters long
	* @throws \TypeError if $newProfileActivationToken is not a string
	**/
	public function setProfileActivationToken(string $newProfileActivationToken) {
		//verify activation token is secure
		$newProfileActivationToken = trim($newProfileActivationToken);
		$newProfileActivationToken = filter_var($newProfileActivationToken, FILTER_SANITIZE_STRING);
		if(empty($newProfileActivationToken) === true) {
			throw(new \InvalidArgumentException("profile activation token is empty orinsecure"));
		}

		//verify the profile activation token has the correct amount of characters
		if(strlen($newProfileActivationToken) > 32) {
			throw(new \RangeException("profile activation token contains too many characters"));
		}

		//convert and store profile activation token
		$this->profileActivationToken = $newProfileActivationToken;
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
	 * accessor method for profile salt
	 *
	 * @return string value for profile salt
	 */
	public function getProfileSalt() {
		return($this->profileSalt);
	}

	/**
	 * accessor method for profile type
	 *
	 * @return string value of profile type
	 */
	public function getProfileType() {
		return($this->profileType);
	}

	/**
	 * accessor method for profile user name
	 *
	 * @return string value of profile user name
	 */
	public function getProfileUserName() {
		return($this->profileUserName);
	}
}
