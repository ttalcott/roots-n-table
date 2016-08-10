<?php

/**
 * autoloader function to include other classes
 */
require_once("autoload.php");

/**
 * Class Product
 */
class Product{
	/**
	 * productId this is the primary key
	 *
	 * @var $productId
	 */
	private $productId;
	/**
	 * productProfileId this is a foreign key
	 *
	 * @var $productProfileId
	 */
	private $productProfileId;
	/**
	 * productUnitId this is a foreign key
	 * 
	 * @var $productUnitId
	 */
	private $productUnitId;
	/**
	 * @var $productDescription
	 */
	private $productDescription;
	/**
	 * @var $productName
	 */
	private $productName;
	/**
	 * @var $productPrice
	 */
	private $productPrice;

	/**
	 * Product constructor.
	 * 
	 * @param $newProductId
	 * @param $newProductProfileId
	 * @param $newProductUnitId
	 * @param $newProductDescription
	 * @param $newProductName
	 * @param null $newProductPrice
	 * @throws InvalidArgumentException for invalid exceptions
	 * @throws RangeException for exceptions that are out of range
	 * @throws Exception for all other exceptions
	 */

	public function __construct($newProductId, $newProductProfileId, $newProductUnitId, $newProductDescription,$newProductName, $newProductPrice = null) {
		try{
			$this->setProductId($newProductId);
			$this->setProductProfileId($newProductProfileId);
			$this->setProductUnitId($newProductUnitId);
			$this->setproductDescription($newProductDescription);
			$this->setProductName($newProductName);
			$this->setProductPrice($newProductPrice);
		}catch(\InvalidArgumentException $invalidArgument){
			//rethrow exception
			throw(new \InvalidArgumentException($invalidArgument->getMessage(),0,$invalidArgument));
		}catch(\RangeException $range){
			//rethrow exception
			throw(new \RangeException($range->getMessage(),0,$range));
		}catch(\Exception $exception) {
			//rethrow exception
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * Includes all json serialization fields
	 *
	 * @return array containing all category fields
	 */
	public function jsonSerialize(){
		return(get_object_vars($this));
	}

	/**
	 * Accessor for productID
	 *
	 * @return mixed
	 */

	public function getProductId(){
		return($this->productId);
	}

	/**
	 * Mutator for productId
	 *
	 * @param $newProductId
	 * @throws InvalidArgumentException if productId is not valid
	 */
	public function setProductId(int $newProductId) {
		//verify product id is valid
		$productId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new \InvalidArgumentException("That product is not valid"));
		}
		// convert and store the value
		$this->productId = intval($newProductId);
	}

	/**
	 * Accessor method for productProfileId
	 *
	 * @return mixed
	 */
	public function getProductProfileId(){
		return($this->productProfileId);
	}

	/**
	 * Mutator method for productProfileId
	 *
	 * @param $newProductProfileId
	 * @throws InvalidArgumentException if productProfileId is not valid
	 */
	public function setProductProfileId(int $newProductProfileId){
		//verify productProfileId  is valid
		$productProfileId = filter_var($newProductProfileId, FILTER_VALIDATE_INT);
		if($newProductProfileId === false) {
			throw(new \InvalidArgumentException("That product is not valid"));
		}
		// convert and store the value
		$this->productProfileId = intval($newProductProfileId);
	}

	/**
	 * Accessor method for productUnitId
	 * 
	 * @return mixed
	 */
	public function getProductUnitId(){
		return($this->productUnitId);
	}

	/**
	 * Mutator method for productUnitId 
	 * 
	 * @param $newProductUnitId
	 * @throws InvalidArgumentException if productUnitId is not valid
	 *
	 */
	public function setProductUnitId(int $newProductUnitId){
		//verify productUnitId id is valid
		$productUnitId = filter_var($newProductUnitId, FILTER_VALIDATE_INT);
		if($newProductUnitId === false) {
			throw(new \InvalidArgumentException("That product is not valid"));
		}
		// convert and store the value
		$this->productUnitId = intval($newProductUnitId);
	}

	/**
	 * Accessor method for productDescription
	 * 
	 * @return mixed
	 */
	public function getProductDescription(){
		return($this->productDescription);
	}

	/**
	 * mutator method for productDescription
	 * 
	 * @param $newProductDescription
	 *  @throws InvalidArgumentException if productDescription is not entered
	 * @throws RangeException if length is more than 255 characters
	 */
	public function setProductDescription(string $newProductDescription){
		//trim description string
		$newProductDescription = trim($newProductDescription);
		//filter and clean productDescription
		$productDescription = filter_var($newProductDescription, FILTER_SANITIZE_STRING);
		if(empty($newProductDescription) === true) {
			throw(new \InvalidArgumentException("Enter a description"));
		}
		if(strlen($newProductDescription) > 255){
			throw(new RangeException("Description is longer than 255 characters"));
		}
		// convert and store description
		$this->productDescription = $newProductDescription;
	}

	/**
	 * Accessor method for productName
	 * 
	 * @return mixed
	 */
	public function getProductName(){
		return($this->productName);
	}

	/**
	 * Mutator method for productName
	 * 
	 * @param $newProductName
	 *  @throws InvalidArgumentException if productName is not entered
	 * @throws RangeException if longer than 64 characters
	 */
	public function setProductName(string $newProductName){
		//trim productName
		$newProductName = trim($newProductName);
		//filter and clean productName up
		$productName = filter_var($newProductName, FILTER_SANITIZE_STRING);
		if(empty($newProductName) === true) {
			throw(new \InvalidArgumentException("Enter a description"));
		}
		if(strlen($newProductName) > 64){
			throw(new RangeException("Description is longer than 64 characters"));
		}
		// convert and store name
		$this->productName = $newProductName;
	}

	/**
	 * Accessor method for productPrice
	 *
	 * @return mixed
	 */
	public function getProductPrice(){
		return($this->productPrice);
	}

	/**
	 * Mutator method for productPrice
	 *
	 * @param float $newProductPrice
	 *  @throws InvalidArgumentException if productPrice is not a float greater than 0
	 */
	public function setProductPrice(float $newProductPrice){
		//to verify that the productPrice is a valid number
		if($newProductPrice < 0){
			throw(new \InvalidArgumentException("Price must be a penny or more"));
		}
		// convert and store the value
		$this->productDescription = floatval($newProductPrice);
	}
	/**
	 * Insert method
	 *
	 * @param PDO $pdo
	 * @throws PDOException if productId is not null
	 */
	public function insert(PDO $pdo){
		if($this->productId !== null){
			throw(new PDOException("Give me something new!"));
		}
		//create query template
		$query = "INSERT INTO product(productId,productProfileId,productUnitId,productDescription,productName,productPrice)VALUES(productId,productProfileId,productUnitId,productDescription,productName,productPrice)";
		$statement = $pdo->prepare($query);

		//bind variables to the place holders in the template
		$parameters = ["productId" => $this->productId, "productProfileId" => $this->productProfileId,"productUnitId" => $this->productUnitId,"productDescription" =>productDescription,"productName" => $this->productName,"productPrice" => $this->productPrice];
		$statement->execute($parameters);

		//update productId with what sql returns
		$this->productId = intval($pdo->lastInsertId());
	}
	/**
	 * PDO delete function
	 * @param PDO $pdo
	 * @throws PDOException if product is null
	 */
	public function delete(PDO $pdo){
		//make sure productId is'nt null
		if($this->productId === null){
			throw(new \PDOException("This Id doesn't exist"));
		}
		//create query template
		$query = "DELETE FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		//bind variables to placeholders in template
		$parameters = ["productId" => $this->productId];
		$statement->execute($parameters);
	}
	/**
	 * PDO update function
	 * @param PDO $pdo
	 * @throws PDOException if productId dosen't exist
	 */
	public function update(PDO $pdo) {
		//make sure categoryId is'nt null
		if($this->productId === null) {
			throw(new \PDOException("This Id doesn't exist"));
		}
		$query = "UPDATE product SET productId = :productId, productProfileId = :productProfileId, productUnitId = :productUnitId, productDescription = :productDescription, productName = :productName, ProductPrice = :productPrice WHERE productId = :productId, productProfileId = :productProfileId, productUnitId = :productUnitId, productDescription = :productDescription, productName = :productName, ProductPrice = :productPrice";
		$statement = $pdo->prepare($query);

		//bind variables to placeholders in template
		$parameters = ["productId" => $this->productId, "productProfileId" => $this->productProfileId,"productUnitId" => $this->productUnitId,"productDescription" => $this->productDescription,"productName" => $this->productName,"productPrice => $this->productPrice"];
		$statement->execute($parameters);
	}
	/**
	 * getProductByProductId
	 * @param PDO $pdo
	 * @param $productId
	 * @return mixed
	 * @throws PDOException if value is not valid or not positive
	 */
	public static function getProductByProductId(PDO $pdo, int $productId){
		//sanitize productId before searching
	$productId = filter_var($productId);
		if($productId === false){
			throw(new \PDOException("That's an invalid Id"));
		}
		// make sure productId is positive
		if($productId <= 0){
			throw(new \PDOException("Enter a positive number"));
		}
		//create a query template
		$query = "SELECT productId FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		//bind to values in template
		$parameters = ["productId" => $productId];
		$statement->execute($parameters);

		try{
			$fetchedProducts = product::storeSQLResultsInArray($statement);
		}catch(Exception $exception){
			//rethrow exception
			throw(new PDOException($exception->getMessage(),0,$exception));
		}
		return $fetchedProducts;
		}
	/**
	 * getProductByProductProfileId
	 * @param PDO $pdo
	 * @param $productProfileId
	 * @return mixed
	 * @throws PDOException if value is not valid or not positive
	 */
	public static function getProductByProductProfileId(PDO $pdo, int $productProfileId){
		//sanitize productProfileId before searching
		$productProfileId = filter_var($productProfileId);
		if($productProfileId === false){
			throw(new \PDOException("That's an invalid Id"));
		}
		// make sure productId is positive
		if($productProfileId <= 0){
			throw(new \PDOException("Enter a positive number"));
		}
		//create a query template
		$query = "SELECT productProfileId FROM product WHERE productProfileId = :productProfileId";
		$statement = $pdo->prepare($query);

		//bind to values in template
		$parameters = ["productProfileId" => $productProfileId];
		$statement->execute($parameters);

		try{
			$fetchedProducts = product::storeSQLResultsInArray($statement);
		}catch(Exception $exception){
			//rethrow exception
			throw(new PDOException($exception->getMessage(),0,$exception));
		}
		return $fetchedProducts;
	}
	/**
	 * getProductByProductUnitId
	 * @param PDO $pdo
	 * @param $productId
	 * @return mixed
	 * @throws PDOException if value is not valid or not positive
	 */
	public static function getProductByProductUnitId(PDO $pdo, int $productUnitId){
		//sanitize productUnitId before searching
		$productUnitId = filter_var($productUnitId);
		if($productUnitId === false){
			throw(new \PDOException("That's an invalid Id"));
		}
		// make sure productUnitId is positive
		if($productUnitId <= 0){
			throw(new \PDOException("Enter a positive number"));
		}
		//create a query template
		$query = "SELECT productUnitId FROM product WHERE productUnitId = :productUnitId";
		$statement = $pdo->prepare($query);

		//bind to values in template
		$parameters = ["productUnitId" => $productUnitId];
		$statement->execute($parameters);

		try{
			$fetchedProducts = product::storeSQLResultsInArray($statement);
		}catch(Exception $exception){
			//rethrow exception
			throw(new PDOException($exception->getMessage(),0,$exception));
		}
		return $fetchedProducts;
	}
}