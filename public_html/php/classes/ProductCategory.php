<?php
namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

/**
* Product Category class for Roots 'n Table
*
* @author Travis Talcott <ttalcott@lyradevelopment.com>
* version 1.0.0
**/
class ProductCategory implements \JsonSerializable {
	/**
	* category id that this productCategory belongs to
	* @var int $productCategoryCategoryId
	**/
	private $productCategoryCategoryId;
	/**
	* products id that this productCategory belongs to
	* @var int $productCategoryProductId
	**/
	private $productCategoryProductId;

	/**
	* constructor for ProductCategory
	*
	* @param int $newProductCategoryCategoryId id of the category this ProductCategory belongs to
	* @param int $newProductCategoryProductId id of the products this ProductCategory belongs to
	* @throws \RangeException if data values are out of bounds
	* @throws \TypeError if data violates type hints
	* @throws \Exception if any other exception occurs
	**/
	public function __construct(int $newProductCategoryCategoryId, int $newProductCategoryProductId) {
		try {
			$this->setProductCategoryCategoryId($newProductCategoryCategoryId);
			$this->setProductCategoryProductId($newProductCategoryProductId);
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the error to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	* accessor method for $productCategoryCategoryId
	* @return int value of $productCategoryCategoryId
	**/
	public function getProductCategoryCategoryId() {
		return($this->productCategoryCategoryId);
	}

	/**
	* mutator method for productCategoryCategoryId
	*
	* @param int $newProductCategoryCategoryId new value of productCategoryCategoryId
	* @throws \RangeException if $newProductCategoryCategoryId is not positive
	* @throws \TypeError if $newProductCategoryCategoryId is not an integer
	**/
	public function setProductCategoryCategoryId(int $newProductCategoryCategoryId) {
		//verify $newProductCategoryCategoryId is positive
		if($newProductCategoryCategoryId <= 0) {
			throw(new \RangeException("productCategoryCategoryId is not positive"));
		}

		//convert and store the productCategoryCategoryId
		$this->productCategoryCategoryId = $newProductCategoryCategoryId;
	}

	/**
	* accessor method for $productCategoryProductId
	* @return int $productCategoryProductId
	**/
	public function getProductCategoryProductId() {
		return($this->productCategoryProductId);
	}

	/**
	* mutator method for productCategoryProductId
	*
	* @param int $newProductCategoryProductId new value of productCategoryProductId
	* @throws \RangeException if $newProductCategoryProductId is not positive
	* @throws \TypeError if $newProductCategoryProductId is not an integer
	**/
	public function setProductCategoryProductId(int $newProductCategoryProductId) {
		//verivy $newProductCategoryProductId is positive
		if($newProductCategoryProductId <= 0) {
			throw(new \RangeException("newProductCategoryProductId is not positive"));
		}

		//convert and store productCategoryProductId
		$this->productCategoryProductId = $newProductCategoryProductId;
	}

	/**
	* inserts this ProductCategory into mySQL
	*
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if $pdo is not a PDO connection object
	**/
	public function insert(\PDO $pdo) {
		//enforce the foreign keys are not null
		if($this->productCategoryCategoryId === null || $this->productCategoryProductId === null) {
			throw(new \PDOException("not a valid composite key"));
		}

		//create query template
		$query = "INSERT INTO productCategory(productCategoryCategoryId, productCategoryProductId) VALUES(:productCategoryCategoryId, :productCategoryProductId)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this template
		$parameters = ["productCategoryCategoryId" => $this->productCategoryCategoryId, "productCategoryProductId" => $this->productCategoryProductId];
		$statement->execute($parameters);
	}

	/**
	* deletes this ProductCategory from mySQL
	*
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException if mySQL related erros occur
	* @throws \TypeError if $pdo is not a PDO connection object
	**/
	public function delete(\PDO $pdo) {
		//enforce the foreign keys are not null
		if($this->productCategoryCategoryId === null || $this->productCategoryProductId === null) {
			throw(new \PDOException("cannot delete a key that doesn't exist"));
		}

		//create query template
		$query = "DELETE FROM productCategory WHERE productCategoryCategoryId = :productCategoryCategoryId AND productCategoryProductId = :productCategoryProductId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this template
		$parameters = ["productCategoryCategoryId" => $this->productCategoryCategoryId, "productCategoryProductId" => $this->productCategoryProductId];
		$statement->execute($parameters);
	}

	/**
	* gets productCategory by productCategoryCategoryId and productCategoryProductId
	*
	* @param \PDO $pdo PDO connection object
	* @param int $productCategoryCategoryId productCategoryCategoryId to search for
	* @param int $productCategoryProductId productCategoryProductId to search for
	* @return productCategory found or null if not found
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if variables are not the correct data type
	**/
	public static function getProductCategoryByProductCategoryCategoryIdAndProductId(\PDO $pdo, int $productCategoryCategoryId, int $productCategoryProductId) {
		//sanitize the productCategoryCategoryId before searching
		if($productCategoryCategoryId <= 0) {
			throw(new \PDOException("productCategoryCategoryId is invalid"));
		}

		//sanitize the productCategoryProductId before searching
		if($productCategoryProductId <= 0) {
			throw(new \PDOException("productCategoryProductId is invalid"));
		}

		//create query template
		$query = "SELECT productCategoryCategoryId, productCategoryProductId FROM productCategory WHERE productCategoryCategoryId = :productCategoryCategoryId AND productCategoryProductId = :productCategoryProductId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this template
		$parameters = ["productCategoryCategoryId" => $productCategoryCategoryId, "productCategoryProductId" => $productCategoryProductId];
		$statement->execute($parameters);

		//grab the data from mySQL
		try {
			$productCategory = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$productCategory = new ProductCategory($row["productCategoryCategoryId"], $row["productCategoryProductId"]);
			}
		} catch(\Exception $exception) {
			//if the row could not be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($productCategory);
	}

	/**
	* gets productCategory by productCategoryCategoryId
	*
	* @param \PDO $pdo PDO connection object
	* @param int $productCategoryCategoryId productCategoryCategoryId to search for
	* @return \SplFixedArray SplFixedArray of productCategories found null if not found
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if $pdo is not a pdo connection object
	**/
	public static function getProductCategoryByProductCategoryCategoryId(\PDO $pdo, int $productCategoryCategoryId) {
		//sanitize productCategoryCategoryId before searching
		if($productCategoryCategoryId <= 0) {
			throw(new \PDOException("productCategoryCategoryId is invalid"));
		}

		//create query template
		$query = "SELECT productCategoryCategoryId, productCategoryProductId FROM productCategory WHERE productCategoryCategoryId = :productCategoryCategoryId";
		$statement = $pdo->prepare($query);

		//bind the member variable to the placeholder in this template
		$parameters = ["productCategoryCategoryId" => $productCategoryCategoryId];
		$statement->execute($parameters);

		//build an array of products categories
		$productCategories = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productCategory = new ProductCategory($row["productCategoryCategoryId"], $row["productCategoryProductId"]);
				$productCategories[$productCategories->key()] = $productCategory;
				$productCategories->next();
			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($productCategories);
	}

	/**
	* gets productCategory by productCategoryProductId
	*
	* @param \PDO $pdo PDO connection object
	* @param int $productCategoryProductId productCategoryProductId to search for
	* @return \SplFixedArray SplFixedArray of productCategories found null if not found
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if $pdo is not a pdo connection object
	**/
	public static function getProductCategoryByProductCategoryProductId(\PDO $pdo, int $productCategoryProductId) {
		//sanitize the productCategoryProductId before searching
		if($productCategoryProductId <= 0) {
			throw(new \PDOException("productCategoryProductId is invalid"));
		}

		//create query template
		$query = "SELECT productCategoryCategoryId, productCategoryProductId FROM productCategory WHERE productCategoryProductId = :productCategoryProductId";
		$statement = $pdo->prepare($query);

		//bind the member variable to the placeholder in this template
		$parameters = ["productCategoryProductId" => $productCategoryProductId];
		$statement->execute($parameters);

		//build an array of products categories
		$productCategories = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productCategory = new ProductCategory($row["productCategoryCategoryId"], $row["productCategoryProductId"]);
				$productCategories[$productCategories->key()] = $productCategory;
				$productCategories->next();
			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($productCategories);
	}

	/**
	* gets all productCategories
	*
	* @param \PDO $pdo PDO connection object
	* @return \SplFixedArray SplFixedArray of productCategories found null if not found
	* @throws \PDOException if mySQL related error occurs
	* @throws \TypeError if $pdo is not a pdo connection object
	**/
	public static function getAllProductCategories(\PDO $pdo) {
		//create a query statement
		$query = "SELECT productCategoryCategoryId, productCategoryProductId FROM productCategory";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of products categories
		$productCategories = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productCategory = new ProductCategory($row["productCategoryCategoryId"], $row["productCategoryProductId"]);
				$productCategories[$productCategories->key()] = $productCategory;
				$productCategories->next();
			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($productCategories);
	}

	/**
 	* formats the state variables for JSON serialization
 	*
 	* @return array resulting state variables to serialize
 	**/
 	public function jsonSerialize() {
 		$fields = get_object_vars($this);
 		return ($fields);
 	}
}

 ?>
