<?php
namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

/**
* Product Category class for Roots 'n Table
*
* @author Travis Talcott <ttalcott@lyradevelopment.com>
* version 1.0.0
**/
class ProductCategory {
	/**
	* category id that this productCategory belongs to
	* @var int $productCategoryCategoryId
	**/
	private $productCategoryCategoryId;
	/**
	* product id that this productCategory belongs to
	* @var int $productCategoryProductId
	**/
	private $productCategoryProductId;

	/**
	* accessor method for $productCategoryCategoryId
	* @return int value of $productCategoryCategoryId
	**/
	public function getProductCategoryCategoryId() {
		return($this->productCategoryCategoryId);
	}

	/**
	* mutator method for productCategoryCategoryId
	*
	* @param int $newProductCategoryCategoryId new value of productCategoryCategoryId
	* @throws \RangeException if $newProductCategoryCategoryId is not positive
	* @throws \TypeError if $newProductCategoryCategoryId is not an integer
	**/
	public function setProductCategoryCategoryId(int $newProductCategoryCategoryId) {
		//verify $newProductCategoryCategoryId is positive
		if($newProductCategoryCategoryId <= 0) {
			throw(new \RangeException("productCategoryCategoryId is not positive"));
		}

		//convert and store the productCategoryCategoryId
		$this->productCategoryCategoryId = $newProductCategoryCategoryId;
	}

	/**
	* accessor method for $productCategoryProductId
	* @return int $productCategoryProductId
	**/
	public function getProductCategoryProductId() {
		return($this->productCategoryProductId);
	}

	/**
	* mutator method for productCategoryProductId
	*
	* @param int $newProductCategoryProductId new value of productCategoryProductId
	* @throws \RangeException if $newProductCategoryProductId is not positive
	* @throws \TypeError if $newProductCategoryProductId is not an integer
	**/
	public function setProductCategoryProductId(int $newProductCategoryProductId) {
		//verivy $newProductCategoryProductId is positive
		if($newProductCategoryProductId <= 0) {
			throw(new \RangeException("newProductCategoryProductId is not positive"));
		}

		//convert and store productCategoryProductId
		$this->productCategoryProductId = $newProductCategoryProductId;
	}
}

 ?>
