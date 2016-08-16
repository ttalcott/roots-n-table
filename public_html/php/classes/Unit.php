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
	* accessor method for $unitName
	*
	* @return srting value of $unitName
	**/
	public function getUnitName() {
		return($this->unitName);
	}
}

 ?>
