<?php
namespace Edu\Cnm\rootstable\Test;

//grab the project test parameters
require_once("RootsTableTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/public_html/php/classes/autoload.php");

/**
 * @see Image 
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */

class ImageTest extends rootsTableTest{
	/**
	 * @var Int $VALID_IMAGEID
	 */
	protected $VALID_IMAGEID = NULL;
	/**
	 * @var Int $VALID_IMAGEPATH
	 */
	protected $VALID_IMAGEPATH = NULL;

	/**
	 * @var Int $VALID_IMAGETYPE
	 */
	protected $VALID_IMAGETYPE = NULL;

	public final function setUp(){
		//run default setUp() method first
		parent::setUp();
		
	}
}