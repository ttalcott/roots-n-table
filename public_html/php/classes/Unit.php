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
}

 ?>
