<?php

/**
 * Class Product
 */
class Product{
	/**
	 * @var $productId
	 */
	private $productId;
	/**
	 * @var $productProfileId
	 */
	private $productProfileId;
	/**
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
	 */
	public function setProductId($newProductId) {
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
	 */
	public function setProductProfileId($newProductProfileId){
		//verify product id is valid
		$productId = filter_var($newProductProfileId, FILTER_VALIDATE_INT);
		if($newProductProfileId === false) {
			throw(new \InvalidArgumentException("That product is not valid"));
		}
		// convert and store the value
		$this->productId = intval($newProductProfileId);
	}

	/**
	 * Accessor method for productUnitId
	 * 
	 * @return mixed
	 */
	public function getProductUnitId(){
		return($this->productUnitId);
	}
}