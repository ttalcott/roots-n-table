<?php

namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

	/**
	 * Class for my Purchase entity.
	 * It will have the following properties:
	 * -purchaseId (private)
	 * -purchaseProfileId (private)
	 * -purchaseStripeToken (private)
	 * @author rvillarrcal <rvillarrcal@cnm.edu>
	 * Date: 8/8/2016
	 * Time: 4:50:0
*/
	class Purchase implements \JsonSerializable {
	/**
	  * purchaseId property,
	 * this is our primary key and will be a private property
	 * @var $purchaseId ;
	 **/
	private $purchaseId = null;

	/**
	 * purchaseProfileId property, this is a foreign key and will be a private property
	 * @var $purchaseProfileId ;
	 **/
	private $purchaseProfileId;

	/**
	 * purchaseStripeToken property, this will be a private property
	 * @var $purchaseStripeToken ;
	 **/
	private $purchaseStripeToken;

	/**This will be the constructor method for Purchase entity
	 *
	 * @param int $newPurchaseId new purchase id number
	 * @param int $newPurchaseProfileId new purchase profile id of the person purchasing
	 * @param string $newPurchaseStripeToken new purchase Stripe Token string provided by stripe
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 *
	 **/

	public function __construct(int $newPurchaseId = null, int $newPurchaseProfileId, string $newPurchaseStripeToken) {
		try {
			$this->setPurchaseId($newPurchaseId);
			$this->setPurchaseProfileId($newPurchaseProfileId);
			$this->setPurchaseStripeToken($newPurchaseStripeToken);
		}  catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * Accessor method purchaseId property
	 *
	 * @return int value for purchaseId
	 **/
	public function getPurchaseId() {
		return ($this->purchaseId);
	}

	/**
	 * Mutator method for purchaseId
	 *
	 * @param int $newPurchaseId new value of purchaseId
	 * @throws \RangeException if $newPurchaseId is not positive
	 * @throws \TypeError if $newPurchaseId is not an integer
	 **/
	public function setPurchaseId(int $newPurchaseId = null) {
		if($newPurchaseId === null) {
			$this->purchaseId = null;
			return;
		}

		//verify the new purchase id is positive
		if($newPurchaseId <= 0) {
			throw(new \RangeException("purchase id is not positive"));
		}

		//convert and store the purchase id
		$this->purchaseId = $newPurchaseId;
	}

	/**
	 * Accessor method purchaseProfileId property
	 *
	 * @return int value for purchaseProfileId
	 **/
	public function getPurchaseProfileId() {
		return ($this->purchaseProfileId);
	}

	/**
	 * Mutator method for purchaseProfileId
	 *
	 * @param int $newpurchaseProfileId new value of purchaseProfile Id
	 **/
	public function setPurchaseProfileId(int $newPurchaseProfileId) {
		if($newPurchaseProfileId < 0){
			throw(\InvalidArgumentException("Incorrect input"));
		}
		// convert and store purchaseProfileId
		$this->purchaseProfileId = intval($newPurchaseProfileId);
	}

	/**
	 * accessor method for purchase stripe token
	 *
	 * @return string value of purchase stripe token
	 **/
	public function getPurchaseStripeToken() {
		return ($this->purchaseStripeToken);
	}

	/**
	 * mutator method for Purchase Stripe Token
	 * @param string $newPurchaseStripeToken new value of Purchase Stripe Token
	 * @throws \InvalidArgumentException if $newPurchaseStripeToken is not a string or insecure
	 * @throws \RangeException if $newPurchaseStripeToken is === 28 characters
	 * @throws \TypeError if $newPurchaseStripeToken is not a string
	 **/
	public function setPurchaseStripeToken(string $newPurchaseStripeToken) {
		// verify the Purchase Stripe Token is secure
		$newPurchaseStripeToken = trim($newPurchaseStripeToken);
		$newPurchaseStripeToken = filter_var($newPurchaseStripeToken, FILTER_SANITIZE_STRING);
		if(empty($newPurchaseStripeToken) === true) {
			throw(new \InvalidArgumentException("Purchase Stripe Token is empty or insecure"));
		}

		// verify the Purchase Stripe Token fulfills the database requirements
		if(strlen($newPurchaseStripeToken) !== 28) {
			throw(new \RangeException("Purchase Stripe Token is not of 28 characters"));
		}

		// convert and store the Purchase Stripe Token
		$this->purchaseStripeToken = $newPurchaseStripeToken;
	}

	/**
	 * inserts this purchase into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if mySQL error occurs
	 * @throws \TypeError if $pdo is not a PDO object
	 **/
	public function insert(\PDO $pdo) {
		//enforce purchase id is null (don't insert a purchase that already exists!)
		if($this->purchaseId !== null) {
			throw(new \PDOException("not a new purchase"));
		}

		//create query template
		$query = "INSERT INTO purchase(purchaseProfileId, purchaseStripeToken) VALUES(:purchaseProfileId, :purchaseStripeToken)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this statement
		$parameters = ["purchaseProfileId" => $this->purchaseProfileId, "purchaseStripeToken" => $this->purchaseStripeToken];
		$statement->execute($parameters);

		//update null purchaseId with what mySQL just gave us
		$this->purchaseId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this purchase from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if mySQL error occurs
	 * @throws \TypeError if $pdo is not a PDO object
	 **/
	public function delete(\PDO $pdo) {
		//enforce the purchase id is not null
		if($this->purchaseId === null) {
			throw(new \PDOException("cannot delete a purchase that does not exist"));
		}
		//create query template
		$query = "DELETE FROM purchase WHERE purchaseId = :purchaseId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this statement
		$parameters = ["purchaseId" => $this->purchaseId];
		$statement->execute($parameters);
	}

	/**
	 * updates purchase in mySQL
	 *
	 * @param \PDO $pdo PDO connection statement
	 * @throws \PDOException if mySQL error occurs
	 * @throws \TypeError if $pdo is not a PDO object
	 **/
	public function update(\PDO $pdo) {
		//enforce the purchaseId is not null
		if($this->purchaseId === null) {
			throw(new \PDOException("cannot update a purchase that does not exist"));
		}

		//create query template
		$query = "UPDATE purchase SET purchaseProfileId = :purchaseProfileId, purchaseStripeToken = :purchaseStripeToken";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in this statement
		$parameters = ["purchaseProfileId" => $this->purchaseProfileId, "purchaseStripeToken" => $this->purchaseStripeToken];
		$statement->execute($parameters);
	}

	/**
	 * gets the Purchase by PurchaseId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $purchaseId purchase id to search for
	 * @return Purchase|null Purchase found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPurchaseByPurchaseId(\PDO $pdo, int $purchaseId = null) {
		// sanitize the purchase Id before searching
		if($purchaseId <= 0) {
			throw(new \PDOException("purchase id is not positive"));
		}

		// create query template
		$query = "SELECT purchaseId, purchaseProfileId, purchaseStripeToken FROM purchase WHERE purchaseId = :purchaseId";
		$statement = $pdo->prepare($query);

		// bind the purchase id to the place holder in the template
		$parameters = ["purchaseId" => $purchaseId];
		$statement->execute($parameters);

		// grab the Purchase from mySQL
		try {
			$purchase = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$purchase = new Purchase($row["purchaseId"], $row["purchaseProfileId"], $row["purchaseStripeToken"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($purchase);
	}

	/**
	 * gets the Purchase by purchaseProfileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $purchaseProfileId purchase Profile id to search for
	 * @return \SplFixedArray SplFixedArray of Purchases found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPurchaseByPurchaseProfileId(\PDO $pdo, int $purchaseProfileId) {
		// sanitize the purchase Profile Id before searching
		if($purchaseProfileId <= 0) {
			throw(new \RangeException("purchase Profile id is not positive"));
		}

		// create query template
		$query = "SELECT purchaseId, purchaseProfileId, purchaseStripeToken FROM purchase WHERE purchaseProfileId = :purchaseProfileId";
		$statement = $pdo->prepare($query);

		// bind the purchase Profile id to the place holder in the template
		$parameters = ["purchaseProfileId" => $purchaseProfileId];
		$statement->execute($parameters);

		//build and array of Purchases
		$purchases = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$purchase = new Purchase($row["purchaseId"], $row["purchaseProfileId"], $row["purchaseStripeToken"]);
				$purchases[$purchases->key()] = $purchase;
				$purchases->next();
			} catch(\PDOException $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($purchases);
	}

	/**
	 * gets the Purchase by purchaseStripeToken
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $purchaseStripeToken purchase Stripe Token to search for
	 * @return Purchase|null Purchase found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPurchaseByPurchaseStripeToken(\PDO $pdo, string $purchaseStripeToken) {
		// sanitize the purchase Stripe Token before searching
		$purchaseStripeToken = trim($purchaseStripeToken);
		$purchaseStripeToken = filter_var($purchaseStripeToken, FILTER_SANITIZE_STRING);
		if(empty($purchaseStripeToken) === true) {
			throw(new \PDOException("Purchase Stripe Token is invalid"));
		}

		// create query template
		$query = "SELECT purchaseId, purchaseProfileId, purchaseStripeToken FROM purchase WHERE purchaseStripeToken = :purchaseStripeToken";
		$statement = $pdo->prepare($query);

		// bind the purchase Stripe Token to the place holder in the template
		$parameters = ["purchaseStripeToken" => $purchaseStripeToken];
		$statement->execute($parameters);

		// grab the Purchase from mySQL
		try {
			$purchase = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$purchase = new Purchase($row["purchaseId"], $row["purchaseProfileId"], $row["purchaseStripeToken"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($purchase);
	}

		/**
		 * gets all Purchases
		 *
		 * @param \PDO $pdo PDO connection object
		 * @return \SplFixedArray SplFixedArray of Tweets found or null if not found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 **/
		public static function getAllPurchases(\PDO $pdo){
			//create query template
			$query = "SELECT purchaseId, purchaseProfileId, purchaseStripeToken FROM purchase";
			$statement = $pdo->prepare($query);
			$statement->execute();

			// build an array of purchases
			$purchases = new \SplFixedArray($statement->rowCount());
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while(($row = $statement->fetch()) !== false) {
				try {
					$purchase = new Purchase($row["purchaseId"], $row["purchaseProfileId"], $row["purchaseStripeToken"]);
					$purchases[$purchases->key()] = $purchase;
					$purchases->next();
				} catch(\Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
			}
			return ($purchases);
		}

		/**
		 * formats the state variables for JSON serialization
		 *
		 * @return array resulting state variables to serialize
		 **/
		public function jsonSerialize() {
			$fields = get_object_vars($this);
			unset($fields["purchaseStripeToken"]);
			return($fields);
		}
	}

?>
