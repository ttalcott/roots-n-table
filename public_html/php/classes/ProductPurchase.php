<?php
/**
 * We'll create a class for my ProductPurchase.
 * It will have the following properties:
 * -productPurchaseProductId (private)
 * -productPurchasePurchaseId (private)
 * -productPurchaseAmount (private)
 * @author rvillarrcal <rvillarrcal@cnm.edu>
 * Date: 8/8/2016
 * Time: 4:10:02 PM
 */
namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

class ProductPurchase {
	/**
	 * productPurchaseProductId property, this is a foreign key and will be a private property
	 * @var $productPurchaseProductId ;
	 **/
	private $productPurchaseProductId;

	/**
	 * productPurchasePurchaseId property, this is a foreign key and will be a private property
	 * @var $productPurchasePurchaseId ;
	 **/
	private $productPurchasePurchaseId;

	/**
	 * productPurchaseAmount property,
	 * @var $productPurchaseAmount ;
	 **/
	private $productPurchaseAmount;

	/**This will be the constructor method for ProductPurchase entity
	 *
	 * @param int $newProductPurchaseProductId new productPurchase Product id
	 *    * @param int $newProductPurchasePurchaseId new productPurchase Purchase id
	 * @param float $newProductPurchaseAmount new productPurchase Amount
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 *
	 **/

	public function __construct($newProductPurchaseProductId, $newProductPurchasePurchaseId, $newProductPurchaseAmount) {
		try {
			$this->setProductPurchaseProductId($newProductPurchaseProductId);
			$this->setProductPurchasePurchaseId($newProductPurchasePurchaseId);
			$this->setProductPurchaseAmount($newProductPurchaseAmount);
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
	 * Accessor method productPurchaseProductId property
	 *
	 * @return int value for productPurchaseProductId
	 **/
	public function getProductPurchaseProductId() {
		return $this->productPurchaseProductId;
	}

	/**
	 * Mutator method for productPurchaseProductId
	 *
	 * @param int $newProductPurchaseProductId new value of productPurchaseProductId
	 * @throws \TypeError if $newProductPurchaseProductId is not an integer
	 **/
	public function setProductPurchaseProductId(int $newProductPurchaseProductId) {
		//this is to verify that the productPurchaseAmount is a valid number dec(12,2)
		if($newProductPurchaseProductId <= 0) {
			throw(\InvalidArgumentException("Incorrect input"));
		}

		// Store productPurchaseProductId
		$this->productPurchaseProductId = $newProductPurchaseProductId;
	}


	/**
	 * Accessor method productPurchasePurchaseId property
	 *
	 * @return int value for productPurchasePurchaseId
	 **/
	public function getProductPurchasePurchaseId() {
		return $this->productPurchasePurchaseId;
	}

	/**
	 * Mutator method for productPurchasePurchaseId
	 *
	 * @param int $newProductPurchasePurchaseId new value of productPurchasePurchaseId
	 * @throws \TypeError if $newProductPurchasePurchaseId is not an integer
	 **/
	public function setProductPurchasePurchaseId(int $newProductPurchasePurchaseId) {
		//this is to verify that the productPurchaseAmount is a valid number dec(12,2)
		if($newProductPurchasePurchaseId <= 0) {
			throw(\InvalidArgumentException("Incorrect input"));
		}
		// store productPurchasePurchaseId
		$this->productPurchasePurchaseId = $newProductPurchasePurchaseId;
	}

	/**
	 * Accessor method productPurchaseAmount property
	 *
	 * @return float value for productPurchaseProductId
	 **/
	public function getProductPurchaseAmount() {
		return $this->productPurchaseAmount;
	}

	/**
	 * Mutator method for productPurchaseAmount
	 *
	 * @param float $newProductPurchaseAmount new value of productPurchaseAmount
	 * @throws \TypeError if $newProductPurchaseAmount is not the expected data type
	 **/
	public function setProductPurchaseAmount(float $newProductPurchaseAmount) {
		//this is to verify that the productPurchaseAmount is a valid number dec(12,2)
		if($newProductPurchaseAmount <= 0) {
			throw(\InvalidArgumentException("No FREE Lunch"));
		}
		// convert and store productPurchaseAmount
		$this->productPurchaseAmount = floatval($newProductPurchaseAmount);
	}

	/**
	 * Insert this productPurchaseProduct into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when $pdo is not aPDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the productPurchaseProductId to be null, we don't insert something that is already there
		if($this->productPurchaseProductId !== null) {
			throw(new \PDOException("Product Purchase already exists"));
		}
		// create query template
		$query = "INSERT INTO productPurchase(productPurchaseProductId, productPurchasePurchaseId) VALUES(:productPurchaseProductId, :productPurchasePurchaseId)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in the template
		$parameters = ["productPurchaseProductId" => $this->productPurchaseProductId, "productPurchasePurchaseId" => $this->productPurchasePurchaseId];
		$statement->execute($parameters);
	}
}

?>