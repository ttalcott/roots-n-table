<?php
class Category{
	/**
	 * Id of the category
	 *
	 * @var Int $categoryId
	 */
	public $categoryId;
	/**
	 * Name of the category
	 *
	 * @var string $categoryName
	 */
	public $categoryName;

	/**
	 * constructor for category
	 *
	 * @param int $categoryId Id of this category
	 * @param string $categoryName Name of this category
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of range
	 * @throws Exception if some other exciption is thrown
	 */
	public function __construct($newCategoryId, $newCategoryName){
		try{
			$this->setCategoryId($newCategoryId);
			$this->setCategoryName($newCategoryName);
		}catch(InvalidArgumentException $invalidArgument){
			//rethrow exception
			throw(new InvalidArgumentException($invalidArgument->getMessage(),0,$invalidArgument));
		}catch(RangeException $range){
			//rethrow exception
			throw(new RangeException($range->getMessage(),0,$range));
		}catch(Exception $exception){
			//rethrow exception
			throw(new Exception($exception->getMessage(),0,$exception));
		}
	}

	/**
	 * accessor method for category id
	 *
	 * @return integer value for category id
	 */
	public function getCategoryId(){
		return($this->categoryId);
	}

	


}