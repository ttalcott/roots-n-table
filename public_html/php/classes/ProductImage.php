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

		//update imageId with what sql returns
		$this->productImageImageId = intval($pdo->lastInsertId());
	}

	/**
	 * PDO delete function
	 * @param PDO $pdo
	 */
	public function delete(PDO $pdo){
		//make sure imageId is'nt null
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
		//make sure imageId is'nt null
		if($this->productImageImageId === null) {
			throw(new \PDOException("This Id doesn't exist"));
		}
		$query = "UPDATE productImage SET productImageImageId = :productImageImageId, productImagaeProductId = :productImageProductId WHERE productImageImageId = :productImageImageId";
		$statement = $pdo->prepare($query);

		//bind variables to placeholders in template
		$parameters = ["productImageImageId" => $this->productImageImageId, "productImageProductId" => $this->productImageProductId];
		$statement->execute($parameters);
	}
	}