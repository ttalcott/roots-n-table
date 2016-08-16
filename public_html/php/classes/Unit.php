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
}

 ?>
