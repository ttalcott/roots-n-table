<?php
/**
 * Class for Location entity.
 * It will have the following properties:
 * locationId (private)
 * locationProfileId (private)
 * locationName (private)
 * locationAttention (private)
 * locationStreetOne (private)
 * locationStreetTwo (private)
 * locationCity (private)
 * locationState (private)
 * locationZipCode(private)
 * @author rvillarrcal <rvillarrcal@cnm.edu>
 * Date: 8/9/2016
 * Time: 10:35:02 AM
 */
namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

class Location {

	/**
	 * locationId property,
	 * this is our primary key and will be a private property
	 * @var $locationId
	 **/
	private $locationId;

	/**
	 * locationProfileId property,
	 * this is a foreign key and will be a private property
	 * @var $locationProfileId
	 **/
	private $locationProfileId;

	/**
	 * locationAttention property,
	 * this will be a private property
	 * @var $locationAttention
	 **/
	private $locationAttention;

	/**
	 * locationCity property,
	 * this will be a private property
	 * @var $locationCity
	 **/
	private $locationCity;

	/**
	 * locationName property,
	 * this will be a private property
	 * @var $locationName
	 **/
	private $locationName;

	/**
	 * locationState property,
	 * this will be a private property
	 * @var $locationState
	 **/
	private $locationState;

	/**
	 * locationStreetOne property,
	 * this will be a private property
	 * @var $locationStreetOne
	 **/
	private $locationStreetOne;

	/**
	 * locationStreetTwo property,
	 * this will be a private property
	 * @var $locationStreetTwo
	 **/
	private $locationStreetTwo;

	/**
	 * locationZipCode property,
	 * this will be a private property
	 * @var $locationZipCode
	 **/
	private $locationZipCode;

/**This will be the constructor method for Location class
 *
 * @param int $newLocationId new location id number
 * @param int $newLocationProfileId new location profile id of the person selling
 * @param string $newLocationAttention new location Attention
 * @param string $newLocationCity new location City
 * @param string $newLocationName new location Name
 * @param string $newLocationState new location State
 * @param string $newLocationStreetOne new location Street One
 * @param string $newLocationStreetTwo new location Street Two
 * @param string $newLocationZipCode new location Zip Code
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
 * @throws \TypeError if data types violate type hints
 * @throws \Exception if some other exception occurs
 *
 * */
public function __construct($newLocationId, $newLocationProfileId, $newLocationAttention, $newLocationCity, $newLocationName, $newLocationState, $newLocationStreetOne, $newLocationStreetTwo, $newLocationZipCode) {
	try {
		$this->setLocationId($newLocationId);
		$this->setLocationProfileId($newLocationProfileId);
		$this->setLocationAttention($newLocationAttention);
		$this->setLocationCity($newLocationCity);
		$this->setLocationName($newLocationName);
		$this->setLocationState($newLocationState);
		$this->setLocationStreetOne($newLocationStreetOne);
		$this->setLocationStreetTwo($newLocationStreetTwo);
		$this->setLocationZipCode($newLocationZipCode);
	} catch(\InvalidArgumentException $invalidArgument) {
		// rethrow the exception to the caller
		throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
	} catch(\RangeException $range) {
		// rethrow the exception to the caller
		throw(new \RangeException($range->getMessage(), 0, $range));
	} catch(\TypeError $typeError) {
		// rethrow the exception to the caller
		throw(new \TypeError($typeError->getMessage(), 0, $typeError));
	} catch(\Exception $exception) {
		// rethrow the exception to the caller
		throw(new \Exception($exception->getMessage(), 0, $exception));
	}
}

/**
 * Accessor method locationId property
 *
 * @return int value for locationId
 **/
public function getLocationId() {
	return ($this->locationId);
}

/**
 * Mutator method for locationId
 *
 * @param int $newLocationId new value of locationId
  **/
public function setLocationId($newLocationId) {
	if($newLocationId < 0){
		throw(\InvalidArgumentException("Incorrect input"));
	}
	// store locationId
	$this->locationId = $newLocationId;
}

/**
 * Accessor method locationProfileId property
 *
 * @return int value for locationProfileId
 **/
public function getLocationProfileId() {
	return ($this->locationProfileId);
}

/**
 * Mutator method for locationProfileId
 *
 * @param int $newLocationProfileId new value of locationProfileId
  **/
public function setLocationProfileId($newLocationProfileId) {
	if($newLocationProfileId < 0){
		throw(\InvalidArgumentException("Incorrect input"));
	}
	// Store locationProfileId
	$this->locationProfileId = $newLocationProfileId;
}

/**
 * Accessor method locationAttention property
 *
 * @return string value for locationAttention
 **/
public function getLocationAttention() {
	return ($this->locationAttention);
}

/**
 * Mutator method for locationAttention
 *
 * @param string $newLocationAttention new value of locationAttention
  **/
public function setLocationAttention($newLocationAttention) {
	//this is to verify that the location attention field is a valid string
	$newLocationAttention = trim($newLocationAttention);
	$newLocationAttention = filter_var($newLocationAttention, FILTER_SANITIZE_STRING);
	if(empty($newLocationAttention) === true) {
		throw(new \InvalidArgumentException("Attention is empty or insecure"));
	}
	// verify the location Attention will fit in the database
	if(strlen($newLocationAttention) > 32) {
		throw(new \RangeException("Attention content too large"));
	}
	// convert and store locationAttention
	$this->locationAttention = $newLocationAttention;
}

/**
 * Accessor method locationCity property
 *
 * @return string value for locationCity
 **/
public function getLocationCity() {
	return ($this->locationCity);
}

/**
 * Mutator method for locationCity
 *
 * @param string $newLocationCity new value of locationCity
  **/
public function setLocationCity($newLocationCity) {
	//this is to verify that the location city field is a valid string
	$newLocationCity = trim($newLocationCity);
	$newLocationCity = filter_var($newLocationCity, FILTER_SANITIZE_STRING);
	if(empty($newLocationCity) === true) {
		throw(new \InvalidArgumentException("City is empty or insecure"));
	}
	// verify the location City will fit in the database
	if(strlen($newLocationCity) > 32) {
		throw(new \RangeException("City content too large"));
	}
	// convert and store locationCity
	$this->locationCity = $newLocationCity;
}

/**
 * Accessor method locationName property
 *
 * @return string value for locationName
 **/
public function getLocationName() {
	return ($this->locationName);
}

	/**
	 * Mutator method for locationName
 *
 * @param string $newLocationName new value of locationName
 **/
public function setLocationName($newLocationName) {
		//this is to verify that the location Name field is a valid string
		$newLocationName = trim($newLocationName);
		$newLocationName = filter_var($newLocationName, FILTER_SANITIZE_STRING);
		if(empty($newLocationName) === true) {
			throw(new \InvalidArgumentException("Name is empty or insecure"));
		}
		// verify the location Name will fit in the database
		if(strlen($newLocationName) > 32) {
			throw(new \RangeException("Name content too large"));
		}
		// Store location Name
		$this->locationName = $newLocationName;
	}

/**
 * Accessor method locationState property
 *
 * @return string value for locationState
 **/
public function getLocationState() {
	return ($this->locationState);
}

/**
 * Mutator method for locationState
 *
 * @param string $newLocationState new value of locationState
 **/
public function setLocationState($newLocationState) {
	//this is to verify that the location state field is a valid string
	$newLocationState = trim($newLocationState);
	$newLocationState = filter_var($newLocationState, FILTER_SANITIZE_STRING);
	if(empty($newLocationState) === true) {
		throw(new \InvalidArgumentException("State is empty or insecure"));
	}
	// verify the location State will fit in the database
	if(strlen($newLocationState) > 32) {
		throw(new \RangeException("State content too large"));
	}
	// convert and store locationState
	$this->locationState = $newLocationState;
}

/**
 * Accessor method locationStreetOne property
 *
 * @return string value for locationStreetOne
 **/
public function getLocationStreetOne() {
	return ($this->locationStreetOne);
}

/**
 * Mutator method for locationStreetOne
 *
 * @param string $newLocationStreetOne new value of locationStreetOne
 **/
public function setLocationStreetOne($newLocationStreetOne) {
	//this is to verify that the location street one field is a valid string
	$newLocationStreetOne = trim($newLocationStreetOne);
	$newLocationStreetOne = filter_var($newLocationStreetOne, FILTER_SANITIZE_STRING);
	if(empty($newLocationStreetOne) === true) {
		throw(new \InvalidArgumentException("Street One field is empty or insecure"));
	}
	// verify the location Street One will fit in the database
	if(strlen($newLocationStreetOne) > 128) {
		throw(new \RangeException("Street One content too large"));
	}
	// Store locationStreetOne
	$this->locationStreetOne = $newLocationStreetOne;
}

/**
 * Accessor method locationStreetTwo property
 *
 * @return string value for locationStreetTwo
 **/
public function getLocationStreetTwo() {
	return ($this->locationStreetTwo);
}

/**
 * Mutator method for locationStreetTwo
 *
 * @param string $newLocationStreetOTwo new value of locationStreetTwo
 **/
public function setLocationStreetTwo($newLocationStreetTwo) {
	//this is to verify that the location street two field is a valid string
	$newLocationStreetTwo = trim($newLocationStreetTwo);
	$newLocationStreetTwo = filter_var($newLocationStreetTwo, FILTER_SANITIZE_STRING);
	if(empty($newLocationStreetTwo) === true) {
		throw(new \InvalidArgumentException("Street Two field is empty or insecure"));
	}
	// verify the location Street Two will fit in the database
	if(strlen($newLocationStreetTwo) > 128) {
		throw(new \RangeException("Street Two content too large"));
	}
	// Store locationStreetTwo
	$this->locationStreetTwo = $newLocationStreetTwo;
}

	/**
	 * Accessor method locationZipCode property
	 *
	 * @return string value for locationZipCode
	 **/
	public function getLocationZipCode() {
	return ($this->locationZipCode);
}

/**
 * Mutator method for locationZipCode
 *
 * @param string $newLocationZipCode new value of locationZipCode
 **/
public function setLocationZipCode($newLocationZipCode) {
	//this is to verify that the location Zip Code field is a valid string
	$newLocationZipCode = trim($newLocationZipCode);
	$newLocationZipCode = filter_var($newLocationZipCode, FILTER_SANITIZE_STRING);
	if(empty($newLocationZipCode) === true) {
		throw(new \InvalidArgumentException("Zip Code field is empty or insecure"));
	}
	// verify the location Zip Code will fit in the database
	if(strlen($newLocationZipCode) > 10) {
		throw(new \RangeException("Zip Code content is too large"));
	}
	// Store and store locationZipCode
	$this->locationZipCode = $newLocationZipCode;
}
}
