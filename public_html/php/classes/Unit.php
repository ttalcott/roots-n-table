<?php
namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

/**
* Unit class for Roots 'n TABLE
*
* @author Travis Talcott <ttalcott@lyradevelopment.com>
* version 1.0.0
**/

class Unit {
	/**
	* id for this Unit
	* @var int $unitId
	**/
	private $unitId;
	/**
	* name of this unit
	* @var string $unitName
	**/
	private $unitName;

	/**
	* constructor for this class
	*
	* @param int|null $newUnitId id for this unit
	* @param string $newUnitName name of this unit
	* @throws \InvalidArgumentException if the data type is incorrect
	* @throws \RangeException if the data is out of bounds
	* @throws \TypeError if the data violates type hints
	* @throws \Exception if any other exception occurs
	**/
	public function __construct(int $newUnitId = null, string $newUnitName) {
		try {
			$this->setUnitId($newUnitId);
			$this->setUnitName($newUnitName);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
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
	* accessor method for $unitId
	*
	* @return int value of $unitId
	**/
	public function getUnitId() {
		return($this->unitId);
	}

	/**
	* mutator method for unitId
	*
	* @param int|null $newUnitId value of a new unit id
	* @throws \RangeException if $newUnitId is not positive
	* @throws \TypeError if $newUnitId is not an integer
	**/
	public function setUnitId(int $newUnitId = null) {
		//base case: if $newUnitId is null this is a new unit without a mySQL id (yet)
		if($newUnitId === null) {
			$this->unitId = null;
			return;
		}

		//verify unit id is positive
		if($newUnitId <= 0) {
			throw(new \RangeException("unit id is not positive"));
		}

		//convert and store the unit id
		$this->unitId = $newUnitId;
	}

	/**
	* accessor method for $unitName
	*
	* @return srting value of $unitName
	**/
	public function getUnitName() {
		return($this->unitName);
	}

	/**
	* mutator method for $unitName
	*
	* @param string $newUnitName name of a new unit
	* @throws \InvalidArgumentException if $newUnitName is empty or insecure
	* @throws \RangeException if $newUnitName is > 16 characters
	* @throws \TypeError if $newUnitName is not a string
	**/
	public function setUnitName(string $newUnitName) {
		//verify the unit name is secure
		$newUnitName = trim($newUnitName);
		$newUnitName = filter_var($newUnitName, FILTER_SANITIZE_STRING);
		if(empty($newUnitName) === true) {
			throw(new \InvalidArgumentException("unit name is empty or insecure"));
		}

		//verify the unit name is the correct length
		if(strlen($newUnitName) > 16) {
			throw(new \RangeException("unit name is too long"));
		}

		//convert and store the unit name
		$this->unitName = $newUnitName;
	}

	/**
	* inserts this unit into mySQL
	*
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException if mySQL error occurs
	* @throws \TypeError if $pdo is not a PDO connection object
	**/
	public function insert(\PDO $pdo) {
		//ensure the unit id is null
		if($unitId !== null) {
			throw(new \PDOException("unit id is not null"));
		}

		//create query template
		$query = "INSERT INTO unit (unitName) VALUES(:unitName)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this template
		$parameters = ["unitName" => $unitName];
		$statement->execute($parameters);

		//update the null unit id
		$this->unitId = intval($pdo->lastInsertId());
	}

	/**
	* deletes this unit from mySQL
	*
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if $pdo is not a PDO connection object
	**/
	public function delete(\PDO $pdo) {
		//enforce the unit id is NOT null
		if($this->unitId === null) {
			throw(new \PDOException("cannot delete a unit that does not exist"));
		}

		//create query template
		$query = "DELETE FROM unit WHERE unitId = :unitId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this template
		$parameters = ["unitId" => $unitId];
		$statement->execute($parameters);
	}

	/**
	* updates this unit in mySQL
	*
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if $pdo is not a PDO connection object
	**/
	public function update(\PDO $pdo) {
		//enforce the unit id is NOT null
		if($this->unitId === null) {
			throw(new \PDOException("cannot update a unit that does not exist"));
		}

		//create query template
		$query = "UPDATE unit SET unitName = :unitName";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this template
		$parameters = ["unitName" => $unitName];
		$statement->execute($parameters);
	}

	/**
	* gets this unit by unit id
	*
	* @param \PDO $pdo PDO connection object
	* @param int $unitId id of the unit we are searching for
	* @return unit|null returns the unit or null if not found
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if variables are not the correct data types
	**/
	public static function getUnitByUnitId(\PDO $pdo, int $unitId) {
		//sanitize the description before searching
		if($unitId <= 0) {
			throw(new \PDOException("unit id is not positive"));
		}

		//create query template
		$query = "SELECT unitId, unitName FROM unit WHERE unitId = :unitId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this template
		$parameters = ["unitId" => $unitId];
		$statement->execute($parameters);

		//grab the data from mySQL
		try {
			$unit = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$unit = new Unit($row["unitId"], $row["unitName"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($unit);
	}

	/**
	* gets the unit by the unit name
	*
	* @param \PDO $pdo PDO connection object
	* @param string $unitName name of the unit to search for
	* @return \SplFixedArray SplFixedArray of units found
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if variables are not the correct data types
	**/
	public static function getUnitByUnitName(\PDO $pdo, string $unitName) {
		//sanitize the description before searching
		$unitName = trim($unitName);
		$unitName = filter_var($unitName, FILTER_SANITIZE_STRING);
		if(empty($unitName) === true) {
			throw(new \PDOException("unit name is invalid"));
		}

		//create query template
		$query = "SELECT unitId, unitName FROM unit WHERE unitName LIKE :unitName";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this template
		$unitName = "%unitName%";
		$parameters = ["unitName" => $unitName];
		$statement->execute($parameters);

		//build an array of units
		$units = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$unit = new Unit($row["unitId"], $row["unitName"]);
				$units[$units->key()] = $unit;
				$units->next();
			} catch(\Exception $exception) {
				//if the row could not be resolved, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($units);
	}
}

 ?>
