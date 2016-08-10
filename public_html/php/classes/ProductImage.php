<?php

/**
 * Class ProductImage
 */
class ProductImage{
	private $productImageImageId;
	private $productImageProductId;

	public function __construct($newProductImageImageId,$newProductImageProductId =null) {
		try {
			$this->productImageImageId = ($newProductImageImageId);
			$this->productImageProductId = ($newProductImageProductId);
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
		public
		function getProductImageImageId() {
			return ($this->productImageImageId);
		}

		/**
		 * Mutator method for ProductImageImageId
		 *
		 * @param int $newProductImageImageId
		 * @throws RangeException if value is not a positive number
		 */
		public
		function setProductImageImageId(int $newProductImageImageId) {
			//filter productImageImageId
			$productImageImageId = filter_var($newProductImageImageId);
			//check to see if value is greater than 0
			if($newProductImageImageId <= 0) {
				throw(new \RangeException("This must be a positive number"));
			}
			// convert and store the value
			$this->productImageImageId = intval($newProductImageImageId);
		}

		/**
		 * Accessor method for productImageProductId
		 *
		 * @return mixed
		 */
		public
		function getProductImageProductId() {
			return ($this->productImageProductId);
		}

		/**
		 * Mutator method for productImageProductId
		 *
		 * @param $newProductImageProductId
		 * @throws RangeException if value is not a positive number
		 */
		public
		function setProductImageProductId($newProductImageProductId) {
			//filter productImageProductId
			$productImageProductId = filter_var($newProductImageProductId);
			//check to see if value is greater than 0
			if($newProductImageProductId <= 0) {
				throw(new \RangeException("This must be a positive number"));
			}
			// convert and store the value
			$this->productImageProductId = intval($newProductImageProductId);
		}

	/**
	 * Insert method
	 * @param PDO $pdo
	 */
	public function insert(PDO $pdo){
		if($this->productImageImageId !== null){
			throw(new PDOException("Give me something new!"));
		}
		//create query template
		$query = "INSERT INTO productImage(productImageImageId,productImageProductId)VALUES(productImageImageId,productImageProductId)";
		$statement = $pdo->prepare($query);

		//bind variables to the place holders in the template
		$parameters = ["productImageImageId" => $this->productImageImageId, "productImageProductId" => $this->productImageProductId];
		$statement->execute($parameters);

		//update productImageImageId with what sql returns
		$this->productImageImageId = intval($pdo->lastInsertId());
	}

	/**
	 * PDO delete function
	 * @param PDO $pdo
	 */
	public function delete(PDO $pdo){
		//make sure productImageImageId is'nt null
		if($this->productImageImageId === null){
			throw(new \PDOException("This Id doesn't exist"));
		}
		//create query template
		$query = "DELETE FROM productImage WHERE productImageImageId = :productImageImageId";
		$statement = $pdo->prepare($query);

		//bind variables to placeholders in template
		$parameters = ["productImageImageId" => $this->productImageImageId];
		$statement->execute($parameters);
	}

	/**
	 * PDO update function
	 * @param PDO $pdo
	 */
	public function update(PDO $pdo) {
		//make sure productImageImageId is'nt null
		if($this->productImageImageId === null) {
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
	 * @param PDO $pdo
	 * @param $imageId
	 * @return mixed
	 */
	public static function getProductImageByProductImageImageId(PDO $pdo, int $productImageImageId){
		//sanitize productImageImageId before searching
		$productImageImageId = filter_var($productImageImageId);
		if($productImageImageId === false){
			throw(new PDOException("Value is not a valid integer"));
		}
		//make sure productImageImageId is positive
		if($productImageImageId <= 0){
			throw(new PDOException("You should try to be positive"));
		}
		//create query template
		$query = "SELECT productImageImageId, productImageProductId FROM productImage WHERE productImageImageId = :productImageImageId";
		$statement = $pdo->prepare($query);

		//bind productImageImageId to placeholder in the template
		$parameters = ["productImageImageId" => $productImageImageId];
		$statement->execute($parameters);

		//call the function to start alist of fetched results
		try{
			$fetchedImages = Image::storeSQLResultsInArray($statement);
		}catch(Exception $exception){
			//rethrow exception
			throw(new PDOException($exception->getMessage(),0,$exception));
		}
		return $fetchedImages;
	}

	/**
	 * PDO getProductImageByProductImageProductId function
	 *
	 * @param PDO $pdo
	 * @param int $productImageProductId
	 * @return mixed
	 */
	public static function getProductImageByProductImageProductId(PDO $pdo, int $productImageProductId){
		//sanitize productImageProductId before searching
		$productImageProductId = filter_var($productImageProductId);
		if($productImageProductId === false){
			throw(new PDOException("Value is not a valid integer"));
		}
		//make sure productImageProductId is positive
		if($productImageProductId <= 0){
			throw(new PDOException("You should try to be positive"));
		}
		//create query template
		$query = "SELECT productImageImageId, productImageProductId FROM productImage WHERE productImageProductId = :productImageProductId";
		$statement = $pdo->prepare($query);

		//bind variable to placeholder in the template
		$parameters = ["productImageProductId" => $productImageProductId];
		$statement->execute($parameters);

		//call the function to start a list of fetched results
		try{
			$fetchedImages = Image::storeSQLResultsInArray($statement);
		}catch(Exception $exception){
			//rethrow exception
			throw(new PDOException($exception->getMessage(),0,$exception));
		}
		return $fetchedImages;
	}

	/**
	 * PDO getAllProductImages function
	 * @param PDO $pdo
	 * @return mixed
	 */
	public static function getAllProductImages(PDO $pdo){
		//create query template
		$query = "SELECT productImageImageId,productImageProductId FROM productImage";
		$statement = $pdo->prepare($query);
		$statement->execute();
		//call the function and create an array
		try{
			$fetchedImages = Image::storeSQLResultsInArray($statement);
		}catch(Exception $exception){
			//rethrow exciption
			throw(new PDOException($exception->getMessage(),0,$exception));
		}
		return $fetchedImages;
	}
	}