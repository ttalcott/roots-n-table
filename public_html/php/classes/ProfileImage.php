<?php
namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

/**
* Profile Image class for Roots 'n Table
*
* @author Travis Talcott <ttalcott@lyradevelopment.com>
* version 1.0.0
**/
class ProfileImage implements \JsonSerializable {
	/**
	* image id that this image belongs to
	* @var int $profileImageImageId
	**/
	private $profileImageImageId;
	/**
	* profile id that this image belongs to
	* @var int $profileImageProfileId
	**/
	private $profileImageProfileId;
	/**
	* constructor for ProfileImage class
	*
	* @param int $newProfileImageImageId id of the profile this image belongs to
	* @param int $newProfileImageProfileId id of the image this image belongs to
	* @throws \RangeException if data values are out of bounds
	* @throws \TypeError if data values are not the correct type
	* @throws \Exception if any other exception occurs
	**/
	public function __construct(int $newProfileImageProfileId, int $newProfileImageImageId) {
		try {
			$this->setProfileImageImageId($newProfileImageImageId);
			$this->setProfileImageProfileId($newProfileImageProfileId);
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
	* inserts this ProfileImage composite primary key into mySQL
	*
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if $pdo is not a PDO connection object
	**/
	public function insert(\PDO $pdo) {
		//enforce the foreign keys are not null
		if($this->profileImageImageId === null || $this->profileImageProfileId === null) {
			throw(new \PDOException("not a valid composite key"));
		}

		//crete query template
		$query = "INSERT INTO profileImage(profileImageImageId, profileImageProfileId) VALUES(:profileImageImageId, :profileImageProfileId)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this template
		$parameters = ["profileImageImageId" => $this->profileImageImageId, "profileImageProfileId" => $this->profileImageProfileId];
		$statement->execute($parameters);
	}

	/**
	* deletes this ProfileImage composite primary key from mySQL
	*
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException if mySQL related erros occur
	* @throws \TypeError if $pdo is not a PDO connection object
	**/
	public function delete(\PDO $pdo) {
		//enforce the foreign keys are not null
		if($this->profileImageImageId === null || $this->profileImageProfileId === null) {
			throw(new \PDOException("cannot delete a key that doesn't exist"));
		}

		//create query template
		$query = "DELETE FROM profileImage WHERE profileImageImageId = :profileImageImageId AND profileImageProfileId = :profileImageProfileId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in this statement
		$parameters = ["profileImageImageId" => $this->profileImageImageId, "profileImageProfileId" => $this->profileImageProfileId];
		$statement->execute($parameters);
	}

	/**
	* gets profileImage by profileImageImageId
	*
	* @param \PDO $pdo PDO connection object
	* @param int $profileImageImageId Image Id to search for
	* @return \SplFixedArray SplFixedArray of profileImages found or null if not found
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if variables are not the correct data type
	**/
	public static function getProfileImageByProfileImageImageId(\PDO $pdo, int $profileImageImageId) {
		//sanitize the profile image image id before searching
		if($profileImageImageId <= 0) {
			throw(new \PDOException("profile image image id is not valid"));
		}

		//create query template
		$query = "SELECT profileImageImageId, profileImageProfileId FROM profileImage WHERE profileImageImageId = :profileImageImageId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in this template
		$parameters = ["profileImageImageId" => $profileImageImageId];
		$statement->execute($parameters);

		//build an array of profileImages
		$profileImages = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profileImage = new ProfileImage($row["profileImageImageId"], $row["profileImageProfileId"]);
				$profileImages[$profileImages->key()] = $profileImage;
				$profileImages->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profileImages);
	}

	/**
	* gets profileImage by profileImageProfileId
	*
	* @param \PDO $pdo PDO connection object
	* @param int $profileImageProfileId profileImageProfileId to search for
	* @return \SplFixedArray SplFixedArray of profileImages found or null if not found
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if variables are not the correct data type
	**/
	public static function getProfileImageByProfileImageProfileId(\PDO $pdo, int $profileImageProfileId) {
		//sanitize the profileImageProfileId before searching
		if($profileImageProfileId <= 0) {
			throw(new \PDOException("profile image profile id is invalid"));
		}

		//create query template
		$query = "SELECT profileImageImageId, profileImageProfileId FROM profileImage WHERE profileImageProfileId = :profileImageProfileId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this template
		$parameters = ["profileImageProfileId" => $profileImageProfileId];
		$statement->execute($parameters);

		//build an array of profile images
		$profileImages = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profileImage = new ProfileImage($row["profileImageImageId"], $row["profileImageProfileId"]);
				$profileImages[$profileImages->key()] = $profileImage;
				$profileImages->next();
			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profileImages);
	}

	/**
	* gets profileImage by profileImageImageId and profileImageProfileId
	*
	* @param \PDO $pdo PDO connection object
	* @param int $profileImageImageId profileImageImageId to search for
	* @param int $profileImageProfileId profileImageProfileId to search for
	* @return profileImage profileImage found or null if not found
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if variables are not the correct data type
	**/
	public static function getProfileImageByProfileImageImageIdAndProfileId(\PDO $pdo, int $profileImageImageId, int $profileImageProfileId) {
		//sanitize the profileImageImageId before searching
		if($profileImageImageId <= 0) {
			throw(new \PDOException("profileImageImageId is invalid"));
		}

		//sanitize the profileImageProfileId before searching
		if($profileImageProfileId <= 0) {
			throw(new \PDOException("profileImageProfileId is invalid"));
		}

		//create query template
		$query = "SELECT profileImageImageId, profileImageProfileId FROM profileImage WHERE profileImageImageId = :profileImageImageId AND profileImageProfileId = :profileImageProfileId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this template
		$parameters = ["profileImageImageId" => $profileImageImageId, "profileImageProfileId" => $profileImageProfileId];
		$statement->execute($parameters);

		//grab the data from mySQL
		try {
			$profileImage = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profileImage = new ProfileImage($row["profileImageImageId"], $row["profileImageProfileId"]);
			}
		} catch(\Exception $exception) {
			//if the row could not be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profileImage);
	}

	/**
	* gets all profile images
	*
	* @param \PDO $pdo PDO connection object
	* @return \SplFixedArray SplFixedArray of profileImages found null if not found
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if variables are not the correct data type
	**/
	public static function getAllProfileImages(\PDO $pdo) {
		//create query template
		$query = "SELECT profileImageImageId, profileImageProfileId FROM profileImage";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of profileImages
		$profileImages = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profileImage = new ProfileImage($row["profileImageImageId"], $row["profileImageProfileId"]);
				$profileImages[$profileImages->key()] = $profileImage;
				$profileImages->next();
			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profileImages);
	}

	/**
 	* formats the state variables for JSON serialization
 	*
 	* @return array resulting state variables to serialize
 	**/
 	public function jsonSerialize() {
 		$fields = get_object_vars($this);
 		return ($fields);
 	}
}
 ?>
