<?php
/**
 * Class for my Purchase entity.
 * It will have the following properties:
 * -purchaseId (private)
 * -purchaseProfileId (private)
 * -purchaseStripeToken (private)
 * @author rvillarrcal <rvillarrcal@cnm.edu>
 * Date: 8/8/2016
 * Time: 4:50:02 PM
 */
namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

class Purchase {
	/**
	 * purchaseId property,
	 * this is our primary key and will be a private property
	 * @var $purchaseId ;
	 **/
	private $purchaseId;

	/**
	 * purchaseProfileId property, this is a foreign key and will be a private property
	 * @var $purchaseProfileId ;
	 **/
	private $purchaseProfileId;

	/**
	 * purchaseStripeToken property, this will be a private property
	 * @var $purchaseStripeToken ;
	 **/
	private $purchaseStripeToken;

	/**This will be the constructor method for Purchase entity
	 *
	 * @param int $newPurchaseId new purchase id number
	 * @param int $newPurchaseProfileId new purchase profile id of the person purchasing
	 * @param string $newPurchaseStripeToken new purchase Stripe Token string provided by stripe
	 * @throws \UnexpectedValueException if the value is not an valid integer
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 *
	 **/

	public function __construct($newPurchaseId, $newPurchaseProfileId, $newPurchaseStripeToken) {
		try {
			$this->setPurchaseId($newPurchaseId);
			$this->setPurchaseProfileId($newPurchaseProfileId);
			$this->setPurchaseStripeToken($newPurchaseStripeToken);
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
	}

	/**
	 * Accessor method purchaseId property
	 *
	 * @return int value for purchaseId
	 **/
	public function getPurchaseId() {
		return $this->purchaseId;
	}

	/**
	 * Mutator method for purchaseId
	 *
	 * @param int $newPurchaseId new value of purchaseId
	 * @throws \UnexpectedValueException if $newpurchaseId is not an integer
	 **/
	public function setPurchaseId($newPurchaseId) {
		//this is to verify that the purchase id is a valid integer
		$newPurchaseId = filter_var($newPurchaseId, FILTER_VALIDATE_INT);
		if($newPurchaseId === false) {
			throw(new \UnexpectedValueException("Purchase id is not a valid integer"));
		}
		// convert and store purchaseId
		$this->purchaseId = intval($newPurchaseId);
	}


	/**
	 * Accessor method purchaseProfileId property
	 *
	 * @return int value for purchaseProfileId
	 **/
	public function getPurchaseProfileId() {
		return $this->purchaseProfileId;
	}

	/**
	 * Mutator method for purchaseProfileId
	 *
	 * @param int $newpurchaseProfileId new value of purchaseProfile Id
	 * @throws \UnexpectedValueException if $newpurchaseProfileId is not an integer
	 **/
	public function setPurchaseProfileId($newPurchaseProfileId) {
		//this is to verify that the purchaseProfile id is a valid integer
		$newPurchaseProfileId = filter_var($newPurchaseProfileId, FILTER_VALIDATE_INT);
		if($newPurchaseProfileId === false) {
			throw(new \UnexpectedValueException("purchaseProfile Id is not a valid integer"));
		}
		// convert and store purchaseProfileId
		$this->purchaseProfileId = intval($newPurchaseProfileId);
	}

	/**
	 * accessor method for purchase stripe token
	 *
	 * @return string value of purchase stripe token
	 **/
	public function getPurchaseStripeToken() {
		return ($this->purchaseStripeToken);
	}

	/**
	 * mutator method for Purchase Stripe Token
	 * @param string $newPurchaseStripeToken new value of Purchase Stripe Token
	 * @throws \InvalidArgumentException if $newPurchaseStripeToken is not a string or insecure
	 * @throws \RangeException if $newPurchaseStripeToken is === 28 characters
	 * @throws \TypeError if $newPurchaseStripeToken is not a string
	 **/
	public function setPurchaseStripeToken(string $newPurchaseStripeToken) {
		// verify the Purchase Stripe Token is secure
		$newPurchaseStripeToken = trim($newPurchaseStripeToken);
		$newPurchaseStripeToken = filter_var($newPurchaseStripeToken, FILTER_SANITIZE_STRING);
		if(empty($newPurchaseStripeToken) === true) {
			throw(new \InvalidArgumentException("Purchase Stripe Token is empty or insecure"));
		}

		// verify the Purchase Stripe Token fulfills the database requirements
		if(strlen($newPurchaseStripeToken) === 28) {
			throw(new \RangeException("Purchase Stripe Token is not of 28 characters"));
		}

		// convert and store the Purchase Stripe Token
		$this->purchaseStripeToken = $newPurchaseStripeToken;
	}

	/**
	 * Insert this purchase into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when $pdo is not aPDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the purchaseId to be null, we don't insert something that is already there
		if($this->purchaseId !== null) {
			throw(new \PDOException("Purchase already exists"));
		}
		// create query template
		$query = "INSERT INTO purchase(purchaseId, purchaseProfileId, purchaseStripeToken) VALUES(:purchaseId, :purchaseProfileId, :purchaseStripeToken)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in the template
		$parameters = ["purchaseId" => $this->purchaseId, "purchaseProfileId" => $this->purchaseProfileId, "purchaseStripeToken" => $this->purchaseStripeToken];
		$statement->execute($parameters);
	}
}

?>