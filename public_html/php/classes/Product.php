<?php
namespace Edu\Cnm\Rootstable;

/**
 * Class Product
 * @author Robert Engelbert <rengelbert@cnm.edu
 */
class Product implements \JsonSerializable{
	/**
	 * productId this is the primary key
	 *
	 * @var int $productId
	 */
	private $productId;
	/**
	 * productProfileId this is a foreign key
	 *
	 * @var int $productProfileId
	 */
	private $productProfileId;
	/**
	 * productUnitId this is a foreign key
	 * 
	 * @var int $productUnitId
	 */
	private $productUnitId;
	/**
	 * @var string$productDescription
	 */
	private $productDescription;
	/**
	 * @var string $productName
	 */
	private $productName;
	/**
	 * @var float $productPrice
	 */
	private $productPrice;

	/**
	 * Product constructor.
	 * 
	 * @param int $newProductId
	 * @param int $newProductProfileId
	 * @param int $newProductUnitId
	 * @param string $newProductDescription
	 * @param string $newProductName
	 * @param float $newProductPrice
	 * @throws \InvalidArgumentException for invalid exceptions
	 * @throws \RangeException for exceptions that are out of range
	 * @throws \Exception for all other exceptions
	 */

	public function __construct(int $newProductId = null, int $newProductProfileId, int $newProductUnitId, string $newProductDescription, string $newProductName, float $newProductPrice) {
		try{
			$this->setProductId($newProductId);
			$this->setProductProfileId($newProductProfileId);
			$this->setProductUnitId($newProductUnitId);
			$this->setProductDescription($newProductDescription);
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
	 * @throws \RangeException if productId is not valid
	 */
	public function setProductId(int $newProductId = null) {
		//verify product id is valid
		if($newProductId === null){
			$this->productId = null;
			return;
		}
		if($newProductId <= 0) {
			throw(new \RangeException("Product id must be positive"));
		}
		// convert and store the value
		$this->productId = $newProductId;
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
	 * @throws \RangeException if productProfileId is not valid
	 */
	public function setProductProfileId(int $newProductProfileId){
		//verify productProfileId  is valid
		if($newProductProfileId <= 0) {
			throw(new \RangeException("Product id must be positive"));
		}
		// convert and store the value
		$this->productProfileId = $newProductProfileId;
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
	 * @throws \RangeException if productUnitId is not valid
	 *
	 */
	public function setProductUnitId(int $newProductUnitId){
		//verify productUnitId id is valid
		if($newProductUnitId <= 0) {
			throw(new \RangeException("Product id must be positive"));
		}
		// convert and store the value
		$this->productUnitId = $newProductUnitId;
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
	 *  @throws \InvalidArgumentException if productDescription is not entered
	 * @throws \RangeException if length is more than 255 characters
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
			throw(new \RangeException("Description is longer than 255 characters"));
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
	 *  @throws \InvalidArgumentException if productName is not entered
	 * @throws \RangeException if longer than 64 characters
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
			throw(new \RangeException("Description is longer than 64 characters"));
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
	 *  @throws \InvalidArgumentException if productPrice is not a float greater than 0
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
	 * @param \PDO $pdo
	 * @throws \PDOException if productId is not null
	 */
	public function insert(\PDO $pdo){
		if($this->productId !== null){
			throw(new \PDOException("Give me something new!"));
		}
		//create query template
		$query = "INSERT INTO product(productProfileId,productUnitId,productDescription,productName,productPrice)VALUES(:productProfileId, :productUnitId, :productDescription,:productName, :productPrice)";
		$statement = $pdo->prepare($query);

		//bind variables to the place holders in the template
		$parameters = ["productProfileId" => $this->productProfileId,"productUnitId" => $this->productUnitId,"productDescription" => $this -> productDescription,"productName" => $this->productName,"productPrice" => $this->productPrice];
		$statement->execute($parameters);

		//update productId with what sql returns
		$this->productId = intval($pdo->lastInsertId());
	}
	/**
	 * PDO delete function
	 * @param \PDO $pdo
	 * @throws \PDOException if product is null
	 */
	public function delete(\PDO $pdo){
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
	 * @param \PDO $pdo
	 * @throws \PDOException if productId dosen't exist
	 */
	public function update(\PDO $pdo) {
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
	 * @param \PDO $pdo
	 * @param $productId
	 * @return mixed
	 * @throws \PDOException if value is not valid or not positive
	 */
	public static function getProductByProductId(\PDO $pdo, int $productId){
		//sanitize productId before searching
		if($productId <= 0){
			throw(new \PDOException("Enter a positive number"));
		}
		//create a query template
		$query = "SELECT productId, productProfileId, productUnitId, productDescription, productName, productPrice FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		//bind to values in template
		$parameters = ["productId" => $productId];
		$statement->execute($parameters);

		try{
			$product = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$product = new Product($row["productId"], $row["productProfileId"], $row["productUnitId"], $row["productDescription"], $row["productName"], $row["productPrice"]);
			}
		}catch(\Exception $exception){
			//rethrow exception
			throw(new \PDOException($exception->getMessage(),0,$exception));
		}
		return $product;
		}
	/**
	 * getProductByProductProfileId
	 * @param \PDO $pdo
	 * @param $productProfileId
	 * @return mixed
	 * @throws \PDOException if value is not valid or not positive
	 */
	public static function getProductByProductProfileId(\PDO $pdo, int $productProfileId){
		//sanitize productProfileId before searching
		if($productProfileId <= 0){
			throw(new \PDOException("Enter a positive number"));
		}
		//create a query template
		$query = "SELECT productId, productProfileId, productUnitId, productDescription, productName, productPrice FROM product WHERE productProfileId = :productProfileId";
		$statement = $pdo->prepare($query);

		//bind to values in template
		$parameters = ["productProfileId" => $productProfileId];
		$statement->execute($parameters);

		try{
			$product = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$product = new Product($row["productId"], $row["productProfileId"], $row["productUnitId"], $row["productDescription"], $row["productName"], $row["productPrice"]);
			}
		}catch(\Exception $exception){
			//rethrow exception
			throw(new \PDOException($exception->getMessage(),0,$exception));
		}
		return $product;
	}
	/**
	 * getProductByProductUnitId
	 * @param \PDO $pdo
	 * @param $productId
	 * @return int
	 * @throws \PDOException if value is not valid or not positive
	 */
	public static function getProductByProductUnitId(\PDO $pdo, int $productUnitId){
		//sanitize productUnitId before searching
		if($productUnitId <= 0){
			throw(new \PDOException("Enter a positive number"));
		}
		//create a query template
		$query = "SELECT productId, productProfileId, productUnitId, productDescription, productName, productPrice FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		//bind to values in template
		$parameters = ["productUnitId" => $productUnitId];
		$statement->execute($parameters);

		try{
			$product = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$product = new Product($row["productId"], $row["productProfileId"], $row["productUnitId"], $row["productDescription"], $row["productName"], $row["productPrice"]);
			}
		}catch(\Exception $exception){
			//rethrow exception
			throw(new \PDOException($exception->getMessage(),0,$exception));
		}
		return $product;
	}

	/**
* getProductByProductName
* @param \PDO $pdo
* @param string $productName
* @return mixed
*  @throws \PDOException if value is not valid or not positive
*/
	public static function getProductByProductName(\PDO $pdo, string $productName){
		//sanitize productName before searching
		$productName = trim($productName);
		$productName = filter_var($productName, FILTER_SANITIZE_STRING);
		//check that a productName has been entered
		if(empty($productName) === true){
			throw(new \PDOException("Enter a product name"));
		}
		//create a query template
		$query = "SELECT productId, productProfileId, productUnitId, productDescription, productName, productPrice FROM product WHERE productName = :productName";
		$statement = $pdo->prepare($query);

		//bind values in template
		$parameters = ["productName" => $productName];
		$statement->execute($parameters);

		try{
			$product = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$product = new Product($row["productId"], $row["productProfileId"], $row["productUnitId"], $row["productDescription"], $row["productName"], $row["productPrice"]);
			}
		}catch(\Exception $exception){
			//rethrow exception
			throw(new \PDOException($exception->getMessage(),0,$exception));
		}
		return $product;
	}
/**
* getProductByProductPrice
* @param \PDO $pdo
* @param string $productPrice
* @return mixed
*  @throws \PDOException if value is not valid or not positive
*/
	public static function getProductByProductPrice(\PDO $pdo, float $productPrice){
		//sanitize the value
		$productPrice = filter_var($productPrice);
		//check that value is greater than 0
		if($productPrice <= 0){
			throw(new \PDOException("Enter a positive value"));
		}
		//create a query template
		$query = "SELECT productId, productProfileId,productUnitId, productDescription, productName, productPrice FROM product WHERE productPrice = :productPrice";
		$statement = $pdo->prepare($query);

		//bind values in template
		$parameters = ["productPrice" => $productPrice];
		$statement->execute($parameters);

		try{
			$product = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$product = new Product($row["productId"], $row["productProfileId"], $row["productUnitId"], $row["productDescription"], $row["productName"], $row["productPrice"]);
			}
		}catch(\Exception $exception){
			//rethrow exception
			throw(new \PDOException($exception->getMessage(),0,$exception));
		}
		return $product;
	}

	/**
	 * test getallproducts
	 *
	 * @param \PDO $pdo
	 * @return mixed
	 * @throws \PDOException
	 */
	public static function getAllProduct(\PDO $pdo){
		//create a query template
		$query = "SELECT productId, productProfileId, productUnitId, productDescription, productName, productPrice FROM product";
		$statement = $pdo->prepare($query);
		$statement->execute();
		//call the function and create an array
		try{
			$product = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$product = new Product($row["productId"], $row["productProfileId"], $row["productUnitId"], $row["productDescription"], $row["productName"], $row["productPrice"]);
			}
		}catch(\Exception $exception){
			//rethrow exception
			throw(new \PDOException($exception->getMessage(),0,$exception));
		}
		return $product;
	}
	/**
	 * Includes all json serialization fields
	 *
	 * @return array containing all category fields
	 */
	public function jsonSerialize(){
		return(get_object_vars($this));
	}

}