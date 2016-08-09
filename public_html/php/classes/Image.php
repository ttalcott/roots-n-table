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
		return $this->imageId;
	}

	/**
	 * @param int $imageId
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
}