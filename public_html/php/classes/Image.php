<?php
class Image{
	/**
	 * @var int $imageId
	 */
	public $imageId;
	/**
	 * @var int $imagePath
	 */
	public $imagePath;
	/**
	 * @var mixed $imageType
	 */
	public $imageType;

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
	public function setImageId($newImageId) {
		//for new image without a mySQL assigned database
		if($newImageId === null){
			$this->imageId = null;
			return;
		}
		$newImageId = filter_var($newImageId, FILTER_VALIDATE_INT);
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
	public function setImagePath($newImagePath) {
		//verify image path
		$newImagePath = filter_var($newImagePath, FILTER_VALIDATE_INT);
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
		$this->imageId = imtval($pdo->lastInsertId());
	}
}