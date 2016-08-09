<?php
namespace Edu\Cnm\Rootstable;
require_once("autoload.php");

/**
 * profile class for Roots 'n Table
 * @author Travis Talcott <ttalcott@lyradevelopment.com>
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
	* constructor for profile
	*
	* @param int|null $newProfileId id of this profile
	* @param string $newProfileActivationToken value of the profile activation token
	* @param string $newProfileEmail value of the profile email
	* @param string $newProfileFirstName value of the profile first name
	* @param string $newProfileHash value of the profile hash
	* @param string $newProfileLastName value of the profile last name
	* @param string $newProfilePhoneNumber value of the profile phone number
	* @param string $newProfileSalt value of the profile salt
	* @param string $newProfileType value of the profile type
	* @param string $newProfileUsername user name for the profile
	* @throws \InvalidArgumentException if the data type is incorrect
	* @throws \RangeException if the data values are out of bounds
	* @throws \TypeError if the data violates type hints
	* @throws \Exception if any other exception occurs
	**/
	public function __construct(int $newProfileId = null, string $newProfileActivationToken = null, string $newProfileEmail, string $newProfileFirstName, string $newProfileHash, string $newProfileLastName, string $newProfilePhoneNumber, string $newProfileSalt = null, string $newProfileType, string $newProfileUserName) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileFirstName($newProfileFirstName);
			$this->setProfileHash($newProfileHash);
			$this->setProfileLastName($newProfileLastName);
			$this->setProfilePhoneNumber($newProfilePhoneNumber);
			$this->setProfileSalt($newProfileSalt);
			$this->setProfileType($newProfileType);
			$this->setProfileUserName($newProfileUserName);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new\InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new\RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the error to the caller
			throw(new\TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//rethrow the exception to the caller
			throw(new\Exception($exception->getMessage(), 0, $exception));
		}
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
		//base case: if profile id is null, this is a new user without a mySQL id (yet)
		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}
		//verify activation token is secure
		$newProfileActivationToken = trim($newProfileActivationToken);
		if(empty($newProfileActivationToken) === true) {
			throw(new \InvalidArgumentException("profile activation token is empty orinsecure"));
		}

		//verify the profile activation token is a hexidecimal
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new \InvalidArgumentException("profile activation token is empty or insecure"));
		}

		//verify the profile activation token has the correct amount of characters
		if(strlen($newProfileActivationToken) !== 32) {
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
	* mutator method for profile email
	*
	* @param string $newProfileEmail new value for profile email
	* @throws \InvalidArgumentException if $newProfileEmail is not a string or is insecure
	* @throws \RangeException if $newProfileEmail is > 128 characters long
	* @throws \TypeError if $newProfileEmail is not a string
	**/
	public function setProfileEmail(string $newProfileEmail) {
		//verify email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_STRING);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("email content is empty or insecure"));
		}

		//verify the email has the correct amount of characters
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("email contains too many characters"));
		}

		//convert and store profile email
		$this->profileEmail = $newProfileEmail;
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
	* mutator method for profile first name
	*
	* @param string $newProfileFirstName new value for profile first name
	* @throws \InvalidArgumentException if $newProfileFirstName is empty or insecure
	* @throws \RangeException if $newProfileFirstName is > 32 characters long
	* @throws \TypeError if $newProfileFirstName is not a string
	**/
	public function setProfileFirstName(string $newProfileFirstName) {
		//verify first name content is secure
		$newProfileFirstName = trim($newProfileFirstName);
		$newProfileFirstName = filter_var($newProfileFirstName, FILTER_SANITIZE_STRING);
		if(empty($newProfileFirstName) === true) {
			throw(new \InvalidArgumentException("profile first name is empty or insecure"));
		}

		//verify the first name is the correct amount of characters
		if(strlen($newProfileFirstName) > 32) {
			throw(new \RangeException("first name has too many characters"));
		}

		//convert and store profile first name
		$this->profileFirstName = $newProfileFirstName;
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
	* mutator method for profile hash
	*
	* @param string $newProfileHash new value of profile hash
	* @throws \InvalidArgumentException if $newProfileHash is empty or insecure
	* @throws \RangeException if $newProfileHash is > 128 characters
	* @throws \TypeError if $newProfileHash is not a string
	**/
	public function setProfileHash(string $newProfileHash) {
		//verify hash is secure
		$newProfileHash = trim($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("hash is empty or insecure"));
		}

		//verify the hash is a hexidecimal
		if(ctype_xdigit($newProfileHash) === false) {
			throw(new \InvalidArgumentException("hash is empty or insecure"));
		}

		//verify the hash is the correct amount of characters
		if(strlen($newProfileHash) !== 128) {
			throw(new \RangeException("hash is not the correct length"));
		}

		//convert and store the profile hash
		$this->profileHash = $newProfileHash;
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
	* mutator method for profile last name
	*
	* @param string $newProfileLastName new value for profile last name
	* @throws \InvalidArgumentException if $newProfileLastName is empty or insecure
	* @throws \RangeException if $newProfileLastName is > 64 characters long
	* @throws \TypeError if $newProfileLastName is not a string
	**/
	public function setProfileLastName(string $newProfileLastName) {
		//verify last name content is secure
		$newProfileLastName = trim($newProfileLastName);
		$newProfileLastName = filter_var($newProfileLastName, FILTER_SANITIZE_STRING);
		if(empty($newProfileLastName) === true) {
			throw(new \InvalidArgumentException("last name content is empty or insecure"));
		}

		//verify the last name field contains the correct amount of characters
		if(strlen($newProfileLastName) > 64) {
			throw(new \RangeException("last name has too many characters"));
		}

		//convert and store profile last name
		$this->profileLastName = $newProfileLastName;
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
	* mutator method for profile phone number
	*
	* @param string $newProfilePhoneNumber new value of the profile phone number
	* @throws \InvalidArgumentException if $newProfilePhoneNumber is empty or insecure
	* @throws \RangeException if $newProfilePhoneNumber is > 32 characters
	* @throws \TypeError if $newProfilePhoneNumber is not a string
	**/
	public function setProfilePhoneNumber(string $newProfilePhoneNumber){
		//verify the phone number is secure
		$newProfilePhoneNumber = trim($newProfilePhoneNumber);
		$newProfilePhoneNumber = filter_var($newProfilePhoneNumber, FILTER_SANITIZE_STRING);
		if(empty($newProfilePhoneNumber) === true) {
			throw(new \InvalidArgumentException("phone number is empty or insecure"));
		}

		//verify the phone number contains the correct amount of characters
		if(strlen($newProfilePhoneNumber) > 32) {
			throw(new \RangeException("phone number is too long"));
		}

		//convert and store profile phone number
		$this->profilePhoneNumber = $newProfilePhoneNumber;
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
	* mutator method for profile salt
	*
	* @param string $newProfileSalt new value of profile salt
	* @throws \InvalidArgumentException if $newProfileSalt is empty or insecure
	* @throws \RangeException if $newProfileSalt is not 64 characters
	* @throws \TypeError if $newProfileSalt is not a string
	**/
	public function setProfileSalt(string $newProfileSalt) {
		//verify salt is secure
		$newProfileSalt = trim($newProfileSalt);
		if(empty($newProfileSalt) === true) {
			throw(new \InvalidArgumentException("profile salt is empty or insecure"));
		}

		//verify salt is a hexidecimal
		if(ctype_xdigit($newProfileSalt) === false) {
			throw(new \InvalidArgumentException("profile salt is empty or insecure"));
		}

		//verify salt is 64 characters long
		if(strlen($newProfileSalt) !== 64) {
			throw(new \RangeException("profile salt is not the correct length"));
		}

		//convert and store profile salt
		$this->profileSalt = $newProfileSalt;
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
	* mutator method for profile type
	*
	* @param string $newProfileType new value for profile type
	* @throws \InvalidArgumentException if $newProfileType is not a string
	* @throws \RangeException if $newProfileType is > 1 character
	* @throws \TypeError if $newProfileType is not a string
	**/
	public function setProfileType(string $newProfileType) {
		//verify profile type is secure
		$newProfileType = trim($newProfileType);
		$newProfileType = filter_var($newProfileType, FILTER_SANITIZE_STRING);
		if(empty($newProfileType) === true) {
			throw(new \InvalidArgumentException("profile type is empty or insecure"));
		}

		//verify profile type content is the correct length
		if(strlen($newProfileType) > 1) {
			throw(new \RangeException("profile type is too long"));
		}

		//convert and store profile type
		$this->profileType = $newProfileType;
	}

	/**
	 * accessor method for profile user name
	 *
	 * @return string value of profile user name
	 */
	public function getProfileUserName() {
		return($this->profileUserName);
	}

	/**
	* mutator method for profile user name
	*
	* @param string $newProfileUsername new value for profile user name
	* @throws \InvalidArgumentException if $newProfileUsername is insecure
	* @throws \RangeException if $newProfileUsername is > 32 characters long
	* @throws \TypeError if $newProfileUsername is not a string
	**/
	public function setProfileUserName(string $newProfileUsername) {
		//verify the user name is secure
		$newProfileUsername = trim($newProfileUsername);
		$newProfileUsername = filter_var($newProfileUsername, FILTER_SANITIZE_STRING);
		if(empty($newProfileUsername) === true) {
			throw(new \InvalidArgumentException("user name is empty or insecure"));
		}

		//verify the user name has the correct amount of characters
		if(strlen($newProfileUsername) > 32) {
			throw (new \RangeException("user name is too long"));
		}

		//convert and store user name
		$this->profileUserName = $newProfileUsername;
	}

	/**
	* inserts this profile into mySQL
	*
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException if mySQL error occurs
	* @throws \TypeError if $pdo is not a PDO object
  **/
	public function insert(\PDO $pdo) {
		//enforce profile id is null (don't insert a profile that already exists!)
		if($this->profileId !== null) {
			throw(new \PDOException("not a new profile"));
		}

		//create query template
		$query = "INSERT INTO profile(profileActivationToken, profileEmail, profileFirstName, profileHash, profileLastName, profilePhoneNumber, profileSalt, profileType, profileUserName) VALUES(:profileActivationToken, :profileEmail, :profileFirstName, :profileHash, :profileLastName, :profilePhoneNumber, :profileSalt, :profileType, profileUserName)";
		$statement = $pdo->prepare($query);

		//bind the variables to the placeholders in this statement
		$parameters = ["profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileFirstName" => $this->profileFirstName, "profileHash" => $this->profileHash, "profileLastName" => $this->profileLastName, "profilePhoneNumber" => $this->profilePhoneNumber, "profileSalt" => $this->profileSalt, "profileType" => $this->profileType, "profileUserName" => $this->profileUserName];
		$statement->execute($parameters);

		//update null profileId with what mySQL just gave us
		$this->profileId = intval($pdo->lastInsertId());
	}
}
