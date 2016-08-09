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
namespace Edu\Cnm\rootstable\public_html\php\classes;

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
}
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
 * @throws \UnexpectedValueException if the value is not an valid integer
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
 * @throws \TypeError if data types violate type hints
 * @throws \Exception if some other exception occurs
 *
 * */	public function __construct($newLocationId, $newLocationProfileId, $newLocationAttention, $newLocationCity, $newLocationName,  $newLocationState, $newLocationStreetOne, $newLocationStreetTwo,  $newLocationZipCode) {
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
	} catch(\UnexpectedValueException $exception) {
		//rethrow to the caller
		throw(new \UnexpectedValueException($unexpectedValue->getMessage(), 0, $unexpectedValue));
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
	/**
	 * Accessor method locationId property
	 *
	 * @return int value for locationId
	 **/
	public function getLocationId() {
		return $this->locationId;
	}




	/**
	 * Accessor method locationProfileId property
	 *
	 * @return int value for locationProfileId
	 **/
	public function getLocationProfileId() {
		return $this->locationProfileId;
	}



	/**
	 * Accessor method locationAttention property
	 *
	 * @return string value for locationAttention
	 **/
	public function getLocationAttention() {
		return $this->locationAttention;
	}



	/**
	 * Accessor method locationCity property
	 *
	 * @return string value for locationCity
	 **/
	public function getLocationCity() {
		return $this->locationCity;
	}


	/**
	 * Accessor method locationName property
	 *
	 * @return string value for locationName
	 **/
	public function getLocationName() {
		return $this->locationName;
	}

	/**
	 * Accessor method locationState property
	 *
	 * @return string value for locationState
	 **/
	public function getLocationState() {
		return $this->locationState;
	}


	/**
	 * Accessor method locationStreetOne property
	 *
	 * @return string value for locationStreetOne
	 **/
	public function getLocationStreetOne() {
		return $this->locationStreetOne;
	}


	/**
	 * Accessor method locationStreetTwo property
	 *
	 * @return string value for locationStreetTwo
	 **/
	public function getLocationStreetTwo) {
		return $this->locationStreetTwo;
	}


	/**
	 * Accessor method locationZipCode property
	 *
	 * @return string value for locationZipCode
	 **/
	public function getLocationZipCode) {
		return $this->locationZipCode;
	}
}