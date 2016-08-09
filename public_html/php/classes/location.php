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
	 * locationName property,
	 * this will be a private property
	 * @var $locationName
	 **/
	private $locationName;

	/**
	 * locationAttention property,
	 * this will be a private property
	 * @var $locationAttention
	 **/
	private $locationAttention;

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
	 * locationCity property,
	 * this will be a private property
	 * @var $locationCity
	 **/
	private $locationCity;

	/**
	 * locationState property,
	 * this will be a private property
	 * @var $locationState
	 **/
	private $locationState;

	/**
	 * locationZipCode property,
	 * this will be a private property
	 * @var $locationZipCode
	 **/
	private $locationZipCode;
}