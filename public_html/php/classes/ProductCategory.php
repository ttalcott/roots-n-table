<?php
namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

/**
* Product Category class for Roots 'n Table
*
* @author Travis Talcott <ttalcott@lyradevelopment.com>
* version 1.0.0
**/
class ProductCategory {
	/**
	* category id that this productCategory belongs to
	* @var int $productCategoryCategoryId
	**/
	private $productCategoryCategoryId;
	/**
	* product id that this productCategory belongs to
	* @var int $productCategoryProductId
	**/
	private $productCategoryProductId;

	/**
	* constructor for ProductCategory
	*
	* @param int $newProductCategoryCategoryId id of the category this ProductCategory belongs to
	* @param int $newProductCategoryProductId id of the product this ProductCategory belongs to
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

}

 ?>
