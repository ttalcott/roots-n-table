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
	}