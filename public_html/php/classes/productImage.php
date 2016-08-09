<?php

/**
 * Class ProductImage
 */
class ProductImage{
	private $productImageImageId;
	private $productImageProductId;

	/**
	 * Accessor method for productImageImageId
	 *
	 * @return mixed
	 */
	public function getProductImageImageId(){
		return($this->productImageImageId);
	}

	/**
	 * Mutator method for ProductImageImageId
	 *
	 * @param int $newProductImageImageId
	 * @throws RangeException if value is not apositive number
	 */
	public function setProductImageImageId(int $newProductImageImageId){
		//filter productImageImageId
		$productImageImageId = filter_var($newProductImageImageId);
		//check to see if value is greater than 0
		if($newProductImageImageId <= 0){
			throw(new \RangeException("This must be a positive number"));
		}
		// convert and store the value
		$this->productImageImageId = intval($newProductImageImageId);
	}
}