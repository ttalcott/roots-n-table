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
	* accessor method for $productCategoryProductId
	* @return int $productCategoryProductId
	**/
	public function getProductCategoryProductId() {
		return($this->productCategoryProductId);
	}
}

 ?>
