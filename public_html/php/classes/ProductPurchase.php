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

class ProductPurchase implements \JsonSerializable {
	/**
	 * This will be our ProductPurchase class, it will have the following properties:
	 * -productPurchaseProductId property, this is a foreign key and will be a private property
	 * -productPurchasePurchaseId property, this is a foreign key and will be a private property
	 * -productPurchaseAmount property, it will be a private property
	 * @var $productPurchaseProductId
	 * @var $productPurchasePurchaseId
	 * @var $productPurchaseAmount
	 * @author rvillarrcal <rvillarrcal@cnm.edu>
	 * Date: 8/10/2016
	 * Time: 1:04:02 PM
	 *
	 **/

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

	/**
	 * This will be the constructor method for ProductPurchase entity
	 *
	 * @param int $newProductPurchaseProductId new productPurchase Product id
	 * @param int $newProductPurchasePurchaseId new productPurchase Purchase id
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
		return ($this->productPurchaseProductId);
	}

	/**
	 * Mutator method for productPurchaseProductId
	 *
	 * @param int $newProductPurchaseProductId new value of productPurchaseProductId
	 * @throws \TypeError if $newProductPurchaseProductId is not an integer
	 **/
	public function setProductPurchaseProductId(int $newProductPurchaseProductId) {
		//this is to verify that the productPurchaseProduct is a valid integer
		if($newProductPurchaseProductId <= 0) {
			throw(new \InvalidArgumentException("Incorrect input"));
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
		return ($this->productPurchasePurchaseId);
	}

	/**
	 * Mutator method for productPurchasePurchaseId
	 *
	 * @param int $newProductPurchasePurchaseId new value of productPurchasePurchaseId
	 * @throws \TypeError if $newProductPurchasePurchaseId is not an integer
	 **/
	public function setProductPurchasePurchaseId(int $newProductPurchasePurchaseId) {
		//this is to verify that the productPurchasePurchase is a valid integer
		if($newProductPurchasePurchaseId <= 0) {
			throw(new \InvalidArgumentException("Incorrect input"));
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
		return ($this->productPurchaseAmount);
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
			throw(new \InvalidArgumentException("No FREE Lunch"));
		}
		// convert and store productPurchaseAmount
		$this->productPurchaseAmount = $newProductPurchaseAmount;
	}

	/**
	 * Insert this productPurchaseProduct into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when $pdo is not aPDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the productPurchaseProductId is not null
		if($this->productPurchaseProductId !== null) {
			throw(new \PDOException("Product Purchase Product already exists"));
		}
		//enforce the Product Purchase id is not null
		if($this->productPurchasePurchaseId === null) {
			throw(new \PDOException("Product Purchase Purchase already exists"));
		}

		// create query template
		$query = "INSERT INTO productPurchase(productPurchaseProductId, productPurchasePurchaseId, productPurchaseAmounr) VALUES(:productPurchaseProductId, :productPurchasePurchaseId, :productPurchaseAmount)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in the template
		$parameters = ["productPurchaseProductId" => $this->productPurchaseProductId, "productPurchasePurchaseId" => $this->productPurchasePurchaseId, "productPurchaseAmount" => $this->productPurchaseAmount];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Product Purchase from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if mySQL error occurs
	 * @throws \TypeError if $pdo is not a PDO object
	 **/
	public function delete(\PDO $pdo) {
		//enforce the Product Purchase Product id is not null
		if($this->productPurchaseProductId === null) {
			throw(new \PDOException("cannot delete a Product Purchase Product that does not exist"));
		}
		//enforce the Product Purchase Purchase id is not null
		if($this->productPurchasePurchaseId === null) {
			throw(new \PDOException("cannot delete a Product Purchase Purchase that does not exist"));
		}

		//create query template
		$query = "DELETE FROM productPurchase WHERE productPurchaseProductId = :productPurchaseProductId AND productPurchasePurchaseId = :productPurchasePurchase";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this statement
		$parameters = ["productPurchaseProductId" => $this->productPurchaseProductId, "productPurchasePurchaseID" => $this->productPurchasePurchaseId, "productPurchaseAmount" => $this->productPurchaseAmount];
		$statement->execute($parameters);
	}

	/**
	 * updates Product Purchase in mySQL
	 *
	 * @param \PDO $pdo PDO connection statement
	 * @throws \PDOException if mySQL error occurs
	 * @throws \TypeError if $pdo is not a PDO object
	 **/
	public function update(\PDO $pdo) {
		//enforce the product Purchase Product id is not null
		if($this->productPurchaseProductId === null) {
			throw(new \PDOException("cannot update a Product Purchase Product that does not exist"));
		}
		//enforce the product Purchase Purchase id is not null
		if($this->productPurchasePurchaseId === null) {
			throw(new \PDOException("cannot update a Product Purchase Purchase that does not exist"));
		}

		//create query template
		$query = "UPDATE productPurchase SET productPurchaseProductId = :productPurchaseProductId, productPurchasePurchaseId = :productPurchasePurchaseId, productPurchaseAmount = :productPurchaseAmount";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this statement
		$parameters = ["productPurchaseProductId" => $this->productPurchaseProductId, "productPurchasePurchaseId" => $this->productPurchasePurchaseId, "productPurchaseAmount" => $this->productPurchaseAmount];
		$statement->execute($parameters);
	}

	/**
	 * gets the ProductPurchase by productPurchaseProductId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $productPurchaseProductId productPurchaseProduct id to search for
	 * @return ProductPurchase|null ProductPurchase found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProductPurchaseByProductPurchaseProductId(\PDO $pdo, int $productPurchaseProductId) {
		// sanitize the productPurchaseProductId before searching
		if($productPurchaseProductId <= 0) {
			throw(new \PDOException("product purchase product id is not positive"));
		}

		// create query template
		$query = "SELECT productPurchaseProductId, productPurchasePurchaseId, productPurchaseAmount FROM ProductPurchase WHERE productPurchaseProductId = :productPurchaseProductId";
		$statement = $pdo->prepare($query);

		// bind the Product Purchase Product id to the place holder in the template
		$parameters = ["productPurchaseProductId" => $productPurchaseProductId];
		$statement->execute($parameters);

		// build an array of product purchases
		$productPurchases = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productPurchase = new ProductPurchase($row["productPurchaseProductId"], $row["productPurchasePurchaseId"], $row["productPurchaseAmount"]);
				$productPurchases[$productPurchases->key()] = $productPurchase;
				$productPurchases->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($productPurchases);
	}

	/**
	 * gets the ProductPurchase by productPurchasePurchaseId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $productPurchasePurchaseId productPurchasePurchase id to search for
	 * @return ProductPurchase|null ProductPurchase found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProductPurchaseByProductPurchasePurchaseId(\PDO $pdo, int $productPurchasePurchaseId) {
		// sanitize the productPurchasePurchaseId before searching
		if($productPurchasePurchaseId <= 0) {
			throw(new \PDOException("product purchase purchase id is not positive"));
		}

		// create query template
		$query = "SELECT productPurchaseProductId, productPurchasePurchaseId, productPurchaseAmount FROM ProductPurchase WHERE productPurchasePurchaseId = :productPurchasePurchaseId";
		$statement = $pdo->prepare($query);

		// bind the Product Purchase Purchase id to the place holder in the template
		$parameters = ["productPurchasePurchaseId" => $productPurchasePurchaseId];
		$statement->execute($parameters);

		// build an array of product purchases
		$productPurchases = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productPurchase = new ProductPurchase($row["productPurchaseProductId"], $row["productPurchasePurchaseId"], $row["productPurchaseAmount"]);
				$productPurchases[$productPurchases->key()] = $productPurchase;
				$productPurchases->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($productPurchases);
	}

	/**
	 * gets the ProductPurchase by productPurchaseProductId and productPurchasePurchaseId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $productPurchaseProductId productPurchaseProduct id to search for
	 * @param int $productPurchasePurchaseId productPurchasePurchase id to search for
	 * @return ProductPurchase|null ProductPurchase found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProductPurchaseByProductPurchaseProductIdAndProductPurchasePurchaseId(\PDO $pdo, int $productPurchaseProductId, \PDO $pdo, int $productPurchasePurchaseId) {
		// sanitize the productPurchaseProductId and the productPurchasePurchaseId before searching
		if($productPurchaseProductId <= 0) {
			throw(new \PDOException("product purchase product id is not positive"));
		}
		if($productPurchasePurchaseId <= 0) {
			throw(new \PDOException("product purchase purchase id is not positive"));
		}

		// create query template
		$query = "SELECT productPurchaseProductId, productPurchasePurchaseId, productPurchaseAmount FROM ProductPurchase WHERE productPurchaseProductId = :productPurchaseProductId AND productPurchasePurchaseId = :productPurchasePurchaseId";
		$statement = $pdo->prepare($query);

		// bind the Product Purchase Product id and the Product Purchase Purchase id to the place holder in the template
		$parameters = ["productPurchaseProductId" => $productPurchaseProductId, "productPurchasePurchaseId" => $productPurchasePurchaseId];
		$statement->execute($parameters);

		// grab the Product Product from mySQL
		try {
			$productPurchase = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$productPurchase = new ProductPurchase($row["productPurchaseProductId"], $row["productPurchasePurchaseId"], $row["productPurchaseAmount"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($productPurchase);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}
?>