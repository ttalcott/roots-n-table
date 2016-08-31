<?php

namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

/**
 * profile class for Roots 'n Table
 * @author Travis Talcott <ttalcott@lyradevelopment.com>
 * version 1.0.0
 **/
class Profile implements \JsonSerializable {
	/**
	 * id for this profile; this is the primary key
	 * @var int $profileId
	 **/
	private $profileId;
	/**
	 * activation token for this profile
	 * @var  string $profileActivationToken
	 **/
	private $profileActivationToken;
	/**
	 * email for this profile
	 * @var string $profileEmail
	 **/
	private $profileEmail;
	/**
	 * first name for this profile
	 * @var string $profileFirstName
	 **/
	private $profileFirstName;
	/**
	 *profile hash
	 *@var string $profileHash
	 **/
	private $profileHash;
	/**
	 * last name for this profile
	 * @var string $profileLastName
	 **/
	private $profileLastName;
	/**
	 * phone number for profile
	 * @var string $profilePhoneNumber
	 **/
	private $profilePhoneNumber;
	/**
	 * profile salt
	 * @var string $profileSalt
	 **/
	private $profileSalt;
	/**
	* profile stripe token
	* @var string $profileStripeToken
	**/
	private $profileStripeToken;
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
	* @param string $newProfileStripeToken value of the profile stripe token
	* @param string $newProfileType value of the profile type
	* @param string $newProfileUsername user name for the profile
	* @throws \InvalidArgumentException if the data type is incorrect
	* @throws \RangeException if the data values are out of bounds
	* @throws \TypeError if the data violates type hints
	* @throws \Exception if any other exception occurs
	**/
	public function __construct(int $newProfileId = null, string $newProfileActivationToken = null, string $newProfileEmail, string $newProfileFirstName, string $newProfileHash, string $newProfileLastName, string $newProfilePhoneNumber = null, string $newProfileSalt = null, string $newProfileStripeToken = null, string $newProfileType, string $newProfileUserName) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileFirstName($newProfileFirstName);
			$this->setProfileHash($newProfileHash);
			$this->setProfileLastName($newProfileLastName);
			$this->setProfilePhoneNumber($newProfilePhoneNumber);
			$this->setProfileSalt($newProfileSalt);
			$this->setProfileStripeToken($newProfileStripeToken);
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
			$this->profileId = null;
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
		//base case: if the profile id is null, this is a new user without a mySQL assigned id (yet)
		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}

		//verify activation token is secure
		$newProfileActivationToken = trim($newProfileActivationToken);
		if(empty($newProfileActivationToken) === true) {
			throw(new \InvalidArgumentException("profile activation token is empty or insecure"));
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
		if($newProfilePhoneNumber === null) {
			$this->profilePhoneNumber = null;
			return;
		}
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
	* accessor method for profile stripe token
	*
	* @return string value of profile stripe token
	**/
	public function getProfileStripeToken() {
		return($this->profileStripeToken);
	}

	/**
	* mutator method for profileStripeToken
	*
	* @param string $newProfileStripeToken new value of the profile stripe token
	* @throws \InvalidArgumentException if $newProfileStripeToken is empty or insecure
	* @throws \RangeException if $newProfileStripeToken is > 32 characters long
	* @throws \TypeError if $newProfileStripeToken is not a string
	**/
	public function setProfileStripeToken(string $newProfileStripeToken) {
		if($newProfileStripeToken === null) {
			$this->profileStripeToken = null;
			reutn;
		}
		//verify profileStripeToken is secure
		$newProfileStripeToken = trim($newProfileStripeToken);
		$newProfileStripeToken = filter_var($newProfileStripeToken, FILTER_SANITIZE_STRING);
		if(empty($newProfileStripeToken) === true) {
			throw(new \InvalidArgumentException("profile stripe token is empty or insecure"));
		}

		//verify the stripe token is the correct length
		if(strlen($newProfileStripeToken) > 32) {
			throw(new \RangeException("profile stripe token is too long"));
		}

		//convert and store profileStripeToken
		$this->profileStripeToken = $newProfileStripeToken;
	}

	/**
	 * accessor method for profile type
	 *
	 * @return string value of profile type
	 **/
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
	public function setProfileUserName(string $newProfileUserName) {
		//verify the user name is secure
		$newProfileUserName = trim($newProfileUserName);
		$newProfileUserName = filter_var($newProfileUserName, FILTER_SANITIZE_STRING);
		if(empty($newProfileUserName) === true) {
			throw(new \InvalidArgumentException("user name is empty or insecure"));
		}

		//verify the user name has the correct amount of characters
		if(strlen($newProfileUserName) > 32) {
			throw (new \RangeException("user name is too long"));
		}

		//convert and store user name
		$this->profileUserName = $newProfileUserName;
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
		$query = "INSERT INTO profile(profileActivationToken, profileEmail, profileFirstName, profileHash, profileLastName, profilePhoneNumber, profileSalt, profileStripeToken, profileType, profileUserName) VALUES(:profileActivationToken, :profileEmail, :profileFirstName, :profileHash, :profileLastName, :profilePhoneNumber, :profileSalt, :profileStripeToken, :profileType, :profileUserName)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this statement
		$parameters = ["profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileFirstName" => $this->profileFirstName, "profileHash" => $this->profileHash, "profileLastName" => $this->profileLastName, "profilePhoneNumber" => $this->profilePhoneNumber, "profileSalt" => $this->profileSalt, "profileStripeToken" => $this->profileStripeToken, "profileType" => $this->profileType, "profileUserName" => $this->profileUserName];
		$statement->execute($parameters);

		//update null profileId with what mySQL just gave us
		$this->profileId = intval($pdo->lastInsertId());
	}

	/**
	* deletes this profile from mySQL
	*
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException if mySQL error occurs
	* @throws \TypeError if $pdo is not a PDO object
	**/
	public function delete(\PDO $pdo) {
		//enforce the profile id is not null
		if($this->profileId === null) {
			throw(new \PDOException("cannot delete a profile that does not exist"));
		}

		//create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this statement
		$parameters = ["profileId" => $this->profileId];
		$statement->execute($parameters);
	}

	/**
	* updates profile in mySQL
	*
	* @param \PDO $pdo PDO connection statement
	* @throws \PDOException if mySQL error occurs
	* @throws \TypeError if $pdo is not a PDO object
	**/
	public function update(\PDO $pdo) {
		//enforce the profileId is not null
		if($this->profileId === null) {
			throw(new \PDOException("cannot update a profile that does not exist"));
		}

		//create query template
		$query = "UPDATE profile SET profileActivationToken = :profileActivationToken, profileEmail = :profileEmail, profileFirstName = :profileFirstName, profileHash = :profileHash, profileLastName = :profileLastName, profilePhoneNumber = :profilePhoneNumber, profileSalt = :profileSalt, profileStripeToken = :profileStripeToken, profileType = :profileType, profileUserName = :profileUserName";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this statement
		$parameters = ["profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileFirstName" => $this->profileFirstName, "profileHash" => $this->profileHash, "profileLastName" => $this->profileLastName, "profilePhoneNumber" => $this->profilePhoneNumber, "profileSalt" => $this->profileSalt, "profileStripeToken" => $this->profileStripeToken, "profileType" => $this->profileType, "profileUserName" => $this->profileUserName];
		$statement->execute($parameters);
	}

	/**
	* gets profile by profileId
	*
	* @param \PDO $pdo PDO connection statement
	* @param int $profileId profile id to search for
	* @return Profile|null Profile found or null if not found
	* @throws \PDOException if mySQL error occurs
	* @throws \TypeError when variables are not the correct data types
	**/
	public static function getProfileByProfileId(\PDO $pdo, int $profileId) {
		//sanitize the profileId before searching
		if($profileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}

		//create query template
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileFirstName, profileHash, profileLastName, profilePhoneNumber, profileSalt, profileStripeToken, profileType, profileUserName FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		//bind the profileId to the place holder in the template
		$parameters = ["profileId" => $profileId];
		$statement->execute($parameters);

		//grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profilePhoneNumber"], $row["profileSalt"], $row["profileStripeToken"], $row["profileType"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	* gets profile by profile activation token
	*
	* @param \PDO $pdo PDO connection object
	* @param string $profileActivationToken profile activation token to search forgetConsole
	* @return profile|null returns profile or null if the profile isn't found
	* @throws \PDOException if mySQL error occurs
	* @throws \TypeError if variables are not the correct data type
	**/
	public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) {
		//sanitize the description before searching
		$profileActivationToken = trim($profileActivationToken);
		$profileActivationToken = filter_var($profileActivationToken, FILTER_SANITIZE_STRING);
		if(empty($profileActivationToken) === true) {
			throw(new \PDOException("profile activation token does not exist"));
		}

		//create query template
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileFirstName, profileHash, profileLastName, profilePhoneNumber, profileSalt, profileStripeToken, profileType, profileUserName FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);

		//bind the member variable to the place holder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);

		//grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profilePhoneNumber"], $row["profileSalt"], $row["profileStripeToken"], $row["profileType"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	* gets profile by profile email
	*
	* @param \PDO $pdo PDO connection object
	* @param string $profileEmail email of the profile
	* @return profile|null profile associated with the email or null if email does not exist
	* @throws \PDOException if mySQL error occurs
	* @throws \TypeError if variables are not the correct data type
	**/
	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail) {
		//sanitize the description before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileEmail) === true) {
			throw(new \PDOException("email content is empty"));
		}

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileFirstName, profileHash, profileLastName, profilePhoneNumber, profileSalt, profileStripeToken, profileType, profileUserName FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);

		//bind the member variable to the place holder in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);

		//grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profilePhoneNumber"], $row["profileSalt"], $row["profileStripeToken"], $row["profileType"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	* gets profile by profileUserName
	*
	* @param \PDO $pdo PDO connection object
	* @param string $profileUserName profile user name to search for
	* @return \SplFixedArray SplFixedArray of profiles found
	* @throws \PDOException if mySQL error occurs
	* @throws \TypeError if variable is not the correct data type
	**/
	public static function getProfileByProfileUserName(\PDO $pdo, string $profileUserName) {
		//sanitize the description before searching
		$profileUserName = trim($profileUserName);
		$profileUserName = filter_var($profileUserName, FILTER_SANITIZE_STRING);
		if(empty($profileUserName) === true) {
			throw(new \PDOException("user name is invalid"));
		}

		//create query template
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileFirstName, profileHash, profileLastName, profilePhoneNumber, profileSalt, profileStripeToken, profileType, profileUserName FROM profile WHERE profileUserName LIKE :profileUserName";
		$statement = $pdo->prepare($query);

		//bind member variables to the place holder in the template
		$profileEmail = "%profileUserName%";
		$parameters = ["profileUserName" => $profileUserName];
		$statement->execute($parameters);

		//build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profilePhoneNumber"], $row["profileSalt"], $row["profileStripeToken"], $row["profileType"], $row["profileUserName"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\PDOException $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

	/**
	* formats the state variables for JSON serialization
	*
	* @return array resulting state variables to serialize
	**/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		unset($fields["profileHash"]);
		unset($fields["profileSalt"]);
		unset($fields["profileStripeToken"]);
		return ($fields);
	}
}
