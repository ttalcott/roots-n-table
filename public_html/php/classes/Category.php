<?php
class Category{
	/**
	 * Id of the category
	 *
	 * @var Int $categoryId
	 */
	private $categoryId;
	/**
	 * Name of the category
	 *
	 * @var string $categoryName
	 */
	private $categoryName;

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

	/**
	 * mutator method for category id
	 *
	 * @param integer $newCategoryId value of new category id
	 * @throws InvalidArgumentException if $newCategory is not an integer
	 * @throws RangeException is $newCategory is not positive
	 */
	public function setCategoryId($newCategoryId){
		//if null, doesn't have an mysql assigned id yet
		if($newCategoryId === null){
			$this->categoryId = null;
			return;
		}
		//verify category id is valid
		$newCategoryId = filter_var($newCategoryId, FILTER_VALIDATE_INT);
		if($newCategoryId === false){
			throw(new \InvalidArgumentException("What are you doing to me, that Id is not valid"));
		}
		if($newCategoryId <= 0){
			throw(new RangeException("You should try to be positive"));
		}
		//convert and store category id
		$this->categoryId = intval($newCategoryId);
	}
	/**
	 * accessor method for category name
	 *
	 * @return string value for category name
	 */
	public function getCategoryName(){
		return($this->categoryName);
	}

	/**
	 * mutator method for category name
	 *
	 * @param string $newCategoryName
	 * @throws InvalidArgumentException if $newCategoryName is not a string
	 * @throws RangeException if $newCategoryName is > 32 characters
	 */
	public function setCategoryName($newCategoryName){
		$newCategoryName = trim($newCategoryName);
		$newCategoryName = filter_var($newCategoryName, FILTER_SANITIZE_STRING);
		if(empty($newCategoryName) === true){
			throw(new \InvalidArgumentException("We don't sell that here"));
		}
		//verify the category will fit the database
		if(strlen($newCategoryName) > 32){
			throw(new \RangeException("Category name is to long"));
		}
		$this->categoryName = $newCategoryName;
	}

	/**
	 * function to store multiple database results into a SplFixedArray
	 *
	 * @param PDOStatement $statement pdo statement object
	 * @return SPLFixedArray all listings obtained from database
	 * @throws PDOException if mySQL related errors occur
	 */
	public static function putSQLresultsInArray(PDOStatement $statement){

	}
	/**
	 * Insert method
	 * @param PDO $pdo
	 */
	public function insert(PDO $pdo){
		if($this->categoryId !== null){
			throw(new PDOException("Give me something new!"));
		}
		//create query template
		$query = "INSERT INTO category(categoryId,categoryName)VALUES(categoryId,categoryName)";
		$statement = $pdo->prepare($query);

		//bind variables to the place holders in the template
		$parameters = ["categoryId" => $this->categoryId, "categoryName" => $this->categoryName];
		$statement->execute($parameters);

		//update categoryId with what sql returns
		$this->categoryId = intval($pdo->lastInsertId());
	}
	/**
	 * PDO delete function
	 * @param PDO $pdo
	 */
	public function delete(PDO $pdo){
		//make sure categoryId is'nt null
		if($this->categoryId === null){
			throw(new \PDOException("This Id doesn't exist"));
		}
		//create query template
		$query = "DELETE FROM category WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);

		//bind variables to placeholders in template
		$parameters = ["categoryId" => $this->categoryId];
		$statement->execute($parameters);
	}
	/**
	 * PDO update function
	 * @param PDO $pdo
	 */
	public function update(PDO $pdo) {
		//make sure categoryId is'nt null
		if($this->categoryId === null) {
			throw(new \PDOException("This Id doesn't exist"));
		}
		$query = "UPDATE category SET categoryId = :categoryId, categoryName = :categoryName WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);

		//bind variables to placeholders in template
		$parameters = ["categoryId" => $this->categoryId, "categoryName" => $this->categoryName];
		$statement->execute($parameters);
	}
	/**
	 * getCategoryByCategoryId
	 * @param PDO $pdo
	 * @param $imageId
	 * @return mixed
	 */
	public static function getCategoryByCategoryId(PDO $pdo, int $categoryId){
		//sanitize categoryId before searching
		$categoryId = filter_var($categoryId);
		if($categoryId === false){
			throw(new PDOException("Value is not a valid integer"));
		}
		//make sure categoryId is positive
		if($categoryId <= 0){
			throw(new PDOException("You should try to be positive"));
		}
		//create query template
		$query = "SELECT categoryId, categoryName FROM category WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);

		//bind categoryId to placeholder in the template
		$parameters = ["categotyId" => $categoryId];
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


}
