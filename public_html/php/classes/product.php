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

	public function getProductId(){
		return($this->productId);
	}
	public function setProductId($newProductId){
		$productId = filter_var($newProductId, FILTER_VALIDATE_INT);
	}
}