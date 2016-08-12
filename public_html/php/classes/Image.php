<?php

namespace Edu\Cnm\Rootstable;

/**
 * autoloader function to include other classes
 */
require_once("autoload.php");

/**
 * Class Image
 *
 * @author Robert Engelbert <rengelbert@cnm.edu>
 */
class Image{
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
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of range
	 * @throws Exception if some other exception is thrown
	 */
	public function __construct($newImageId, $newImagePath, $newImageType){
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
	 * Includes all json serialization fields
	 *
	 * @return array containing all image fields
	 */
	public function jsonSerialize(){
		return(get_object_vars($this));
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
	 * @throws InvalidArgumentException if imageId is not a integer
	 * @throws RangeException if imageId is not positive
	 */
	public function setImageId(int $newImageId) {
		//for new image without a mySQL assigned database
		if($newImageId === null){
			$this->imageId = null;
			return;
		}
		$newImageId = filter_var($newImageId);
		if($newImageId === false){
			throw(new \InvalidArgumentException("I need a number"));
		}
		//confirm the imageId is positive
		if($newImageId <= 0){
			throw(new \RangeException("You should try to be positive"));
		}
		//convert and store the imageId
		$this->imageId = intval($newImageId);
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
	 * @throws InvalidArgumentException if imageId is not a integer
	 * @throws RangeException if imageId is not positive
	 */
	public function setImagePath(int $newImagePath) {
		//verify image path
		$newImagePath = filter_var($newImagePath);
		if($newImagePath === false){
			throw(new InvalidArgumentException("Image path is invalid"));
		}

		//verify image path is positive
		if($newImagePath <=0){
			throw(new RangeException("You need to try to be positive"));
		}
		//convert and store image path
		$this->imagePath = intval($newImagePath);
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
	 */
	public function setImageType($newImageType){
		$newImageType = trim($newImageType);
		$newImageType = filter_var($newImageType, FILTER_SANITIZE_STRING);
		if(empty($newImageType) === true){
			throw(new InvalidArgumentException("What type are you?"));
		}
		//Store image type in database
		$this->imageType = $newImageType;
	}

	/**
	 * PDO insert method
	 * @param PDO $pdo
	 * @throws PDOException if new id is not entered
	 */
	public function insert(PDO $pdo){
		if($this->imageId !== null){
			throw(new PDOException("Give me something new!"));
		}
		//create query template
		$query = "INSERT INTO image(imageId,imagePath,imageType)VALUES(imageId,imagePath,imageType)";
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
	 * @throws PDOException if imageId is null
	 */
	public function delete(PDO $pdo){
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
	 * @param PDO $pdo
	 * @param $imagePath
	 * @throws Exception
	 * @throws PDOException if imageId is null
	 */
	public function update(PDO $pdo) {
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
	 * @param PDO $pdo
	 * @param $imageId
	 * @return mixed
	 * @throws PDOException if imageId doesn't match
	 * @throws Exception for generic exceptions
	 */
	public static function getImageByImageId(PDO $pdo, $imageId){
	//sanitize ImageId before searching
	$imageId = filter_var($imageId, FILTER_VALIDATE_INT);
	if($imageId === false){
		throw(new PDOException("ImageId is not a valid integer"));
	}
	//make sure imageId is positive
	if($imageId <= 0){
		throw(new PDOException("You should try to be positive"));
	}
	//create query template
	$query = "SELECT imageId,imagePath,imageType FROM image WHERE imageId = :imageId";
	$statement = $pdo->prepare($query);

	//bind image id to placeholder in the template
	$parameters = ["imageId" => $imageId];
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

	/**
	 * get image by image path
	 *
	 * @param PDO $pdo
	 * @param $imagePath
	 * @throws Exception for all generic exceptions
	 * @throws PDOException if value is not valid
	 */
	public static function getImageByImagePath(PDO $pdo, $imagePath){
		//sanitize imagePath before searching
		$imagePath = filter_var($imagePath, FILTER_VALIDATE_INT);
		if($imagePath === false){
			throw(new \PDOException("This needs to be valid"));
		}
		//verify imagePath is positive
		if($imagePath <= 0){
			throw(new \PDOException("Why can't you just be positive"));
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
	 * @param PDO $pdo
	 * @param $imageType
	 * @throws Exception for all generic exceptions
	 * @throws PDOException if value doesn't match database.
	 */
	public static function getImageByImageType(PDO $pdo, $imageType){
		//sanitize imagePath before searching
		$imageType = trim($imageType);
		$imageType = filter_var($imageType, FILTER_SANITIZE_STRING);
		if(empty($imageType) === true){
			throw(new \PDOException("This needs to be valid"));
		}
		//create query template
		$query = "SELECT imageId,imagePath,imageType FROM image WHERE imageType = :imageType";
		$statement = $pdo->prepare($query);

		//bind image path to placeholders in the template
		$parameters = ["imageType" => $imageType];
		$statement->execute($parameters);
	}
	/**
	 * fetches all images
	 *
	 * @throws Exception for all generic exceptions
	 * @throws PDOException if array is empty
	 */
	public static function getAllImages(PDO $pdo){
		//create query template
		$query = "SELECT imageId,imagePath,imageType FROM image";
		$statement = $pdo->prepare($query);
		$statement->execute();
		//call the function and create an array
		try{
			$fetchedImages = Image::storeSQLResultsInArray($statement);
		}catch(Exception $exception){
			//rethrow exciption
			throw(new PDOException($exception->getMessage(),0,$exception));
		}
		return $fetchedImages;
	}
}
