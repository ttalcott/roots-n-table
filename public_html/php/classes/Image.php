<?php

namespace Edu\Cnm\Rootstable;

/**
 * autoloader function to include other classes
 */


/**
 * Class Image
 *
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */
class Image implements \JsonSerializable{
	/**
	 * imageId this is the primary key
	 *
	 * @var int $imageId
	 */
	private $imageId;
	/**
	 * imagePath
	 *
	 * @var int $imagePath
	 */
	private $imagePath;
	/**
	 * imageType
	 *
	 * @var mixed $imageType
	 */
	private $imageType;

	/**
	 * Image constructor.
	 *
	 * @param int $newImageId
	 * @param int $newImagePath
	 * @param mixed $newImageType
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of range
	 * @throws \Exception if some other exception is thrown
	 */
	public function __construct(int $newImageId, int $newImagePath, string $newImageType){
		try{
			$this->setImageId($newImageId);
			$this->setImagePath($newImagePath);
			$this->setImageType($newImageType);
		}catch(\InvalidArgumentException $invalidArgument){
			//rethrow exception
			throw(new \InvalidArgumentException($invalidArgument->getMessage(),0,$invalidArgument));
		}catch(\RangeException $range){
			//rethrow exception
			throw(new \RangeException($range->getMessage(),0,$range));
		}catch(\Exception $exception){
			//rethrow exception
			throw(new \Exception($exception->getMessage(),0,$exception));
		}
	}
	

	/**
	 * accessor method for imageId
	 *
	 * @return int $imageId
	 */
	public function getImageId() {
		return ($this->imageId);
	}

	/**
	 * Mutator method for imageId
	 *
	 * @param int $imageId
	 * @throws \InvalidArgumentException if imageId is not a integer
	 * @throws \RangeException if imageId is not positive
	 */
	public function setImageId(int $newImageId) {
		//for new image without a mySQL assigned database
		if($newImageId === null){
			$this->imageId = null;
			return;
		}
		//confirm the imageId is positive
		if($newImageId <= 0){
			throw(new \RangeException("You should try to be positive"));
		}
		//convert and store the imageId
		$this->imageId = $newImageId;
	}

	/**
	 *  accessor method for imagePath
	 *
	 * @return int $imagePath
	 */
	public function getImagePath() {
		return ($this->imagePath);
	}

	/**
	 * Mutator method for imagePath
	 *
	 * @param int $imagePath
	 * @throws \InvalidArgumentException if imageId is not a integer
	 * @throws \RangeException if imageId is not positive
	 */
	public function setImagePath(int $newImagePath) {
		//verify image path is positive
		if($newImagePath <=0){
			throw(new \RangeException("Image path needs to be positive"));
		}
		//convert and store image path
		$this->imagePath = $newImagePath;
	}

	/**
	 * Accessor method for imageType
	 *
	 * @return mixed $imageType
	 */
	public function getImageType() {
		return ($this->imageType);
	}
	/**
	 * Mutator method for imageType
	 *
	 * @return mixed $imageType
	 *  @throws \InvalidArgumentException if imageId is not a integer
	 * @throws \RangeException if imageId is not positive
	 */
	public function setImageType(string $newImageType){
		//verify the imageType
		$newImageType = trim($newImageType);
		$newImageType = filter_var($newImageType, FILTER_SANITIZE_STRING);
		if(empty($newImageType) === true){
			throw(new \InvalidArgumentException("What type are you?"));
		}

		//verify the imageType will fit in the database
		if(strlen($newImageType) > 10){
			throw(new \RangeException("Image type is too large"));
		}
		//Store image type in database
		$this->imageType = $newImageType;
	}

	/**
	 * \PDO insert method
	 * @param \PDO $pdo
	 * @throws \PDOException if new id is not entered
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 */
	public function insert(\PDO $pdo){
		//enforce the imageId is null
		if($this->imageId !== null){
			throw(new \PDOException("Give me something new!"));
		}
		//create query template
		$query = "INSERT INTO image(imageId,imagePath,imageType)VALUES(:imageId, :imagePath, :imageType)";
		$statement = $pdo->prepare($query);

		//bind variables to the place holders in the template
		$parameters = ["imageId" => $this->imageId, "imagePath" => $this->imagePath, "imageType" => $this->imageType];
		$statement->execute($parameters);

		//update imageId with what sql returns
		$this->imageId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this image in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if imageId is null
	 * @throws \TypeError if $pdo is not a PDO connection
	 */
	public function delete(\PDO $pdo){
		//make sure imageId is'nt null
		if($this->imageId === null){
			throw(new \PDOException("This imageId doesn't exist"));
		}
		//create query template
		$query = "DELETE FROM image WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);

		//bind variables to placeholders in template
		$parameters = ["imageId" => $this->imageId];
		$statement->execute($parameters);
	}
	/**
	 * updates image in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {
		//make sure imageId is'nt null
		if($this->imageId === null) {
			throw(new \PDOException("This imageId doesn't exist"));
		}
		$query = "UPDATE image SET imagePath = :imagePath,imageType = :imageType WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);

		//bind variables to placeholders in template
		$parameters = ["imageId" => $this->imageId, "imagePath" => $this->imagePath, "imageType" => $this->imageType];
		$statement->execute($parameters);
	}

	/**
	 * getImageByImageId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $imageId
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when variables are not the correct type
	 */
	public static function getImageByImageId(\PDO $pdo, int $imageId){
	//sanitize ImageId before searching
	if($imageId <= 0){
		throw(new \PDOException("ImageId is not positive"));
	}
	//create query template
	$query = "SELECT imageId,imagePath,imageType FROM image WHERE imageId = :imageId";
	$statement = $pdo->prepare($query);

	//bind image id to placeholder in the template
	$parameters = ["imageId" => $imageId];
	$statement->execute($parameters);

	//call the function to start alist of fetched results
	try{
		$image = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false){
			$image = new Image($row["imageId"], $row["imagePath"], $row["imageType"]);
		}
	}catch(\Exception $exception){
		//rethrow exception
		throw(new \PDOException($exception->getMessage(),0,$exception));
	}
	return $image;
}

	/**
	 * get image by image path
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $imagePath
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data types
	 */
	public static function getImageByImagePath(\PDO $pdo, int $imagePath){
		//sanitize imagePath before searching
		if($imagePath <= 0){
			throw(new \RangeException("Why can't you just be positive?"));
		}
		//create query template
		$query = "SELECT imageId,imagePath,imageType FROM image WHERE imagePath = :imagePath";
		$statement = $pdo->prepare($query);

		//bind image path to placeholders in the template
		$parameters = ["imagePath" => $imagePath];
		$statement->execute($parameters);
	}

	/**
	 * function to getImageByImageType
	 *
	 * @param \PDO $pdo
	 * @param string $imageType
	 * @throws \PDOException if value doesn't match database.
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getImageByImageType(\PDO $pdo, string $imageType){
		//sanitize imagePath before searching
		$imageType = trim($imageType);
		$imageType = filter_var($imageType, FILTER_SANITIZE_STRING);
		if(empty($imageType) === true){
			throw(new \PDOException("This needs to be valid"));
		}
		//create query template
		$query = "SELECT imageId,imagePath,imageType FROM image WHERE imageType = :imageType";
		$statement = $pdo->prepare($query);

		//bind image type to placeholders in the template
		$parameters = ["imageType" => $imageType];
		$statement->execute($parameters);
	}
	/**
	 * fetches all images
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \Exception for all generic exceptions
	 * @throws \PDOException if array is empty
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getAllImages(\PDO $pdo){
		//create query template
		$query = "SELECT imageId,imagePath,imageType FROM image";
		$statement = $pdo->prepare($query);
		$statement->execute();
		//call the function and create an array
		try{
			$fetchedImages = Image::storeSQLResultsInArray($statement);
		}catch(\Exception $exception){
			//rethrow exciption
			throw(new \PDOException($exception->getMessage(),0,$exception));
		}
		return $fetchedImages;
	}
	/**
	 * Includes all json serialization fields
	 *
	 * @return array containing all image fields
	 */
	public function jsonSerialize(){
		return(get_object_vars($this));
	}
}
