<?php
namespace Edu\Cnm\Rootstable;
/**
 * autoloader function to include other classes
 */

/**
 * Class ProductImage
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */
class ProductImage implements \JsonSerializable{
	/**
	 * @var int $productImageImageId
	 */
	private $productImageImageId;
	/**
	 * @var int $productImageProductId
	 */
	private $productImageProductId;

	/**
	 * ProductImage constructor.
	 * @param $newProductImageImageId
	 * @param $newProductImageProductId
	 * @throws \RangeException if a value is out of range
	 * @throws \Exception for all generic exceptions
	 */

	public function __construct(int $newProductImageImageId, int $newProductImageProductId) {
		try {
			$this->setProductImageImageId($newProductImageImageId);
			$this->setProductImageProductId($newProductImageProductId);
		} catch(\RangeException $range) {
			//rethrow exception
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\Exception $exception) {
			//rethrow exception
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}


		/**
		 * Accessor method for productImageImageId
		 *
		 * @return mixed
		 */
		public function getProductImageImageId() {
			return ($this->productImageImageId);
		}

		/**
		 * Mutator method for ProductImageImageId
		 *
		 * @param int $newProductImageImageId
		 * @throws \RangeException if value is not a positive number
		 */
		public function setProductImageImageId(int $newProductImageImageId) {
			//confirm the productImageImageId is positive
			if($newProductImageImageId <= 0) {
				throw(new \RangeException("This must be a positive number"));
			}
			// convert and store the value
			$this->productImageImageId = $newProductImageImageId;
		}

		/**
		 * Accessor method for productImageProductId
		 *
		 * @return mixed
		 */
		public function getProductImageProductId() {
			return ($this->productImageProductId);
		}

		/**
		 * Mutator method for productImageProductId
		 *
		 * @param $newProductImageProductId
		 * @throws \RangeException if value is not a positive number
		 */
		public function setProductImageProductId(int $newProductImageProductId) {
			//check to see if value is positive
			if($newProductImageProductId <= 0) {
				throw(new \RangeException("This must be a positive number"));
			}
			// convert and store the value
			$this->productImageProductId = $newProductImageProductId;
		}

	/**
	 * Insert method
	 * @param \PDO $pdo
	 * @throws \PDOException if productImageImageId and productImageProductId are null
	 */
	public function insert(\PDO $pdo){
		//make sure productImageImageId and productImageProductId are not null
		if($this->productImageImageId === null || $this->productImageProductId === null){
			throw(new \PDOException("Give me something new!"));
		}
		//create query template
		$query = "INSERT INTO productImage(productImageImageId,productImageProductId)VALUES(:productImageImageId, :productImageProductId)";
		$statement = $pdo->prepare($query);

		//bind variables to the place holders in the template
		$parameters = ["productImageImageId" => $this->productImageImageId, "productImageProductId" => $this->productImageProductId];
		$statement->execute($parameters);

		//update productImageImageId with what sql returns
		//$this->productImageImageId = intval($pdo->lastInsertId());
	}

	/**
	 * PDO delete function
	 * @param \PDO $pdo
	 * @throws \PDOException if productImageImageId and productImageProductId are not null
	 */
	public function delete(\PDO $pdo){
		//make sure productImageImageId and productImageProductId is null
		if($this->productImageImageId === null || $this->productImageProductId === null ){
			throw(new \PDOException("This Id doesn't exist"));
		}
		//create query template
		$query = "DELETE FROM productImage WHERE productImageImageId = :productImageImageId, productImageProductId = :productImageProductId";
		$statement = $pdo->prepare($query);

		//bind variables to placeholders in template
		$parameters = ["productImageImageId" => $this->productImageImageId, "productImageProductId" => $this->productImageProductId];
		$statement->execute($parameters);
	}

	/**
	 * PDO update function
	 * @param \PDO $pdo
	 * @throws \PDOException if productImageImageId productImageProductId are not null
	 */
	public function update(\PDO $pdo) {
		//make sure productImageImageId productImageProductId are null
		if($this->productImageImageId === null || $this->productImageProductId === null) {
			throw(new \PDOException("This Id doesn't exist"));
		}
		$query = "UPDATE productImage SET productImageImageId = :productImageImageId, productImagaeProductId = :productImageProductId WHERE productImageImageId = :productImageImageId";
		$statement = $pdo->prepare($query);

		//bind variables to placeholders in template
		$parameters = ["productImageImageId" => $this->productImageImageId, "productImageProductId" => $this->productImageProductId];
		$statement->execute($parameters);
	}

	/**
	 * getProductImageByProductImageId
	 * @param \PDO $pdo
	 * @param $imageId
	 * @return mixed
	 */
	public static function getProductImageByProductImageImageId(\PDO $pdo, int $productImageImageId){
		//sanitize productImageImageId before searching
		if($productImageImageId <= 0){
			throw(new \PDOException("Value must be positive"));
		}
		
		//create query template
		$query = "SELECT productImageImageId, productImageProductId FROM productImage WHERE productImageImageId = :productImageImageId";
		$statement = $pdo->prepare($query);

		//bind productImageImageId to placeholder in the template
		$parameters = ["productImageImageId" => $productImageImageId];
		$statement->execute($parameters);

		//create an array of product images
		$productImage = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productImage[$productImage->key()] = $productImage;
				$productImage->next();
			} catch(\Exception $exception) {
				//rethrow exciption
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($productImage);
	}

	/**
	 * PDO getProductImageByProductImageProductId function
	 *
	 * @param \PDO $pdo
	 * @param int $productImageProductId
	 * @return mixed
	 */
	public static function getProductImageByProductImageProductId(\PDO $pdo, int $productImageProductId) {
		//sanitize productImageProductId before searching
		if($productImageProductId <= 0) {
			throw(new \PDOException("Value must be positive"));
		}

		//create query template
		$query = "SELECT productImageImageId, productImageProductId FROM productImage WHERE productImageProductId = :productImageProductId";
		$statement = $pdo->prepare($query);

		//bind productImageProductId to placeholder in the template
		$parameters = ["productImageProductId" => $productImageProductId];
		$statement->execute($parameters);

		//create a array of product images
		$productImage = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productImage[$productImage->key()] = $productImage;
				$productImage->next();
			} catch(\Exception $exception) {
				//rethrow exciption
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($productImage);
	}

	/**
	 * PDO getProductImageByProductImageImageAndProductId function
	 *
	 * @param \PDO $pdo
	 * @param int $productImageProductId
	 * @return mixed
	 */
	public static function getProductImageByProductImageImageIdAndProductId(\PDO $pdo, int $productImageImageId, int $productImageProductId){
		//sanitize productImageProductId before searching
		if($productImageImageId <= 0){
			throw(new \PDOException("Value must be positive"));
		}
		if($productImageProductId <= 0){
			throw(new \PDOException("Value must be positive"));
	}

		//create query template
		$query = "SELECT productImageImageId, productImageProductId FROM productImage WHERE productImageProductId = :productImageProductId";
		$statement = $pdo->prepare($query);

		//bind productImageProductId to placeholder in the template
		$parameters = ["productImageImageId" =>$productImageImageId, "productImageProductId" => $productImageProductId];
		$statement->execute($parameters);

		//retrive data from mySQL
		try{
			$productImage = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false){
				$productImage = new ProductImage($row["productImageImageId"], $row["productImageProductId"]);
			}
		}catch(\Exception $exception){
			//rethrow exception
			throw(new \PDOException($exception->getMessage(),0,$exception));
		}
		return ($productImage);
	}

	/**
	 * PDO getAllProductImages function
	 * @param \PDO $pdo
	 * @return mixed
	 */
	public static function getAllProductImages(\PDO $pdo){
		//create query template
		$query = "SELECT productImageImageId,productImageProductId FROM productImage";
		$statement = $pdo->prepare($query);
		$statement->execute();
		//call the function and create an array
		$productImage = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productImage[$productImage->key()] = $productImage;
				$productImage->next();
			} catch(\Exception $exception) {
				//rethrow exciption
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($productImage);
	}
	/**
	 * Includes all json serialization fields
	 *
	 * @return array containing all productImage fields
	 */
	public function jsonSerialize(){
		return(get_object_vars($this));
	}
	}