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
	 * @var $productPurchaseAmount;
	 **/
	private $productPurchaseAmount;

	/**This will be the constructor method for ProductPurchase entity
	 *
	 * @param int $newProductPurchaseProductId new productPurchase Product id
* 	 * @param int $newProductPurchasePurchaseId new productPurchase Purchase id
	 * @param dec(12,4) $newProductPurchaseAmount new productPurchase Amount
	 * @throws \UnexpectedValueException if the value is not an valid integer
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

		} catch(UnexpectedValueException $exception) {
			//rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct ProductPurchase", 0, $exception));

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
	 * @throws UnexpectedValueException if $newProductPurchaseProductId is not an integer
	 **/
	public function setProductPurchaseProductId($newProductPurchaseProductId) {
		//this is to verify that the productPurchaseProduct id is a valid integer
		$newProductPurchaseProductId = filter_var($newProductPurchaseProductId, FILTER_VALIDATE_INT);
		IF($newProductPurchaseProductId === false) {
			throw(new UnexpectedValueException("productPurchaseProduct id is not a valid integer"));
		}
		// convert and store productPurchaseProductId
		$this->productPurchaseProductId = intval($newProductPurchaseProductId);
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
	 * @throws UnexpectedValueException if $newProductPurchasePurchaseId is not an integer
	 **/
	public function setProductPurchasePurchaseId($newProductPurchasePurchaseId) {
		//this is to verify that the productPurchaseProduct id is a valid integer
		$newProductPurchasePurchaseId = filter_var($newProductPurchasePurchaseId, FILTER_VALIDATE_INT);
		IF($newProductPurchasePurchaseId === false) {
			throw(new UnexpectedValueException("productPurchasePurchase id is not a valid integer"));
		}
		// convert and store productPurchasePurchaseId
		$this->productPurchasePurchaseId = intval($newProductPurchasePurchaseId);
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
		$parameters = ["productPurchaseProductId" => $this-> productPurchaseProductId, "productPurchasePurchaseId" => $this->productPurchasePurchaseId];
		$statement->execute($parameters);
	}
}

?>