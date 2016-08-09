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
		//trim descriptionstring
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
}