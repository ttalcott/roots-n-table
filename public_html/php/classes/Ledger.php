<?php

namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

/**
* Ledger class for Roots 'n Table
*
* @author Travis Talcott <ttalcott@lyradevelopment.com>
* version 1.0.0
**/

class Ledger implements \JsonSerializable {
	//load the ValidateDate file
	use ValidateDate;

	/**
	* id for this ledger
	* @var int $ledgerId
	**/
	private $ledgerId;
	/**
	* id of the purchase this ledger belongs to; this is the foreign key
	* @var int $ledgerPurchaseId
	**/
	private $ledgerPurchaseId;
	/**
	* amount of this ledger
	* @var float $ledgerAmount
	**/
	private $ledgerAmount;
	/**
	* date and time this ledger was created; in a php DateTime object
	* @var \DateTime $ledgerDateTime
	**/
	private $ledgerDateTime;
	 /**
	 * stripe token for this ledger
	 * @var string $ledgerStripeToken
	 **/
	 private $ledgerStripeToken;

	 /**
	 * constructor for the class Ledger
	 *
	 * @param int|null $newLedgerId id for this ledger
	 * @param int $newLedgerPurchaseId id of the purchase this ledger belongs to
	 * @param float $newLedgerAmount amount of this ledger
	 * @param \DateTime $newledgerDateTime date and time of this ledger
	 * @param string $newLedgerStripeToken stripe token of this ledger
	 * @throws \InvalidArgumentException if the data type is incorrect
	 * @throws \RangeException if the data is out of bounds
	 * @throws \TypeError if the data violates type hints
	 * @throws \Exception if any other exception occurs
	 **/
	 public function __construct(int $newLedgerId = null, int $newLedgerPurchaseId, float $newLedgerAmount, $newledgerDateTime = null, string $newLedgerStripeToken) {
		 try {
			 $this->setLedgerId($newLedgerId);
			 $this->setLedgerPurchaseId($newLedgerPurchaseId);
			 $this->setLedgerAmount($newLedgerAmount);
			 $this->setledgerDateTime($newledgerDateTime);
			 $this->setLedgerStripeToken($newLedgerStripeToken);
		 } catch(\InvalidArgumentException $invalidArgument) {
			 //rethrow the exception to the caller
			 throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		 } catch(\RangeException $range) {
			 //rethrow the exception to the caller
			 throw(new \RangeException($range->getMessage(), 0, $range));
		 } catch(\TypeError $typeError) {
			 //rethrow the error to the caller
			 throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		 } catch(\Exception $exception) {
			 //rethrow the exception to the caller
			 throw(new \Exception($exception->getMessage(), 0, $exception));
		 }
	 }

	 /**
	 * accessor method for $ledgerId
	 *
	 * @return int|null value of $ledgerId
	 **/
	 public function getLedgerId() {
		 return($this->ledgerId);
	 }

	 /**
	 * mutator method for $ledgerId
	 *
	 * @param int|null $newLedgerId new value of ledgerId
	 * @throws \RangeException if $newLedgerId is not positive
	 * @throws \TypeError if $newLedgerId is not an integer
	 **/
	 public function setLedgerId(int $newLedgerId = null) {
		 //base case: if ledger id is null, this is a new purchase without a mySQL id (yet)
		 if($newLedgerId === null) {
			 $this->ledgerId = null;
			 return;
		 }
		 //verify the ledgerId is positive
		 if($newLedgerId <= 0) {
			 throw(new \RangeException("ledger id is not positive"));
		 }

		 //convert and store this ledger id
		 $this->ledgerId = $newLedgerId;
	 }

	 /**
	 * accessor method for $ledgerPurchaseId
	 *
	 * @return int value of $ledgerPurchaseId
	 **/
	 public function getLedgerPurchaseId() {
		 return($this->ledgerPurchaseId);
	 }

	 /**
	 * mutator method for $ledgerPurchaseId
	 *
	 * @param int $newLedgerPurchaseId new value of ledger purchase id
	 * @throws \RangeException if $newLedgerPurchaseId is not positive
	 * @throws \TypeError if $newLedgerPurchaseId is not an integer
	 **/
	 public function setLedgerPurchaseId(int $newLedgerPurchaseId) {
		 //verify the ledgerPurchaseId is positive
		 if($newLedgerPurchaseId <= 0) {
			 throw(new \RangeException("ledger purchase id is not positive"));
		 }

		 //convert and store this ledger purchase id
		 $this->ledgerPurchaseId = $newLedgerPurchaseId;
	 }

	 /**
	 * accessor method for $ledgerAmount
	 *
	 * @return decimal value of $ledgerAmount
	 **/
	 public function getLedgerAmount() {
		 return($this->ledgerAmount);
	 }

	 /**
	 * mutator method for $ledgerAmount
	 *
	 * @param float $newLedgerAmount new value of $ledgerAmount
	 * @throws \InvalidArgumentException if $newLedgerAmount is empty or insecure
	 * @throws \TypeError if $newLedgerAmount is not a float
	 **/
	 public function setLedgerAmount(float $newLedgerAmount) {
		 //validate $newLedgerAmount is a float and is secure
		 $newLedgerAmount = trim($newLedgerAmount);
		 if(empty($newLedgerAmount) === true) {
			 throw(new \InvalidArgumentException("ledger amount is empty or insecure"));
		 }

		 //convert and store $newLedgerAmount
		 $this->ledgerAmount = $newLedgerAmount;
	 }

	 /**
	 * accessor method for $ledgerDateTime
	 *
	 * @return \DateTime|string|null value of the ledger date and time
	 **/
	 public function getledgerDateTime() {
		 return($this->ledgerDateTime);
	 }

	 /**
	 * mutator method for $ledgerDateTime
	 *
	 * @param \DateTime $newledgerDateTime ledger date and time as a DateTime object or a string (null for current date and time)
	 * @throws \InvalidArgumentException if $newledgerDateTime is not a valid object or string
	 * @throws \RangeException if $newledgerDateTime is a date that does not exist
	 **/
	 public function setledgerDateTime($newledgerDateTime = null) {
		 //base case: if the date and time are null use the current date and time
		 if($newledgerDateTime === null) {
			 $this->ledgerDateTime = new \DateTime();
			 return;
		 }

		 //store the ledger date and time
		 try {
			 $newledgerDateTime = self::validateDateTime($newledgerDateTime);
	 	} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}

		//convert and store $ledgerDateTime
		$this->ledgerDateTime = $newledgerDateTime;
	 }

	 /**
	 * accessor method for $ledger stripe token
	 *
	 * @return string value of $ledgerStripeToken
	 **/
	 public function getLedgerStripeToken() {
		 return($this->ledgerStripeToken);
	 }

	 /**
	 * mutator method for $ledgerStripeToken
	 *
	 * @param string $newLedgerStripeToken new value of ledgerStripeToken
	 * @throws \InvalidArgumentException if $newLedgerStripeToken is empty or insecure
	 * @throws \RangeException if $newLedgerStripeToken !== 28 characters
	 * @throws \TypeError if $newLedgerStripeToken is not a string
	 **/
	 public function setLedgerStripeToken(string $newLedgerStripeToken) {
		 //verify stripe token is secure
		 $newLedgerStripeToken = trim($newLedgerStripeToken);
		 $newLedgerStripeToken = filter_var($newLedgerStripeToken, FILTER_SANITIZE_STRING);
		 if(empty($newLedgerStripeToken) === true) {
			 throw(new \InvalidArgumentException("ledger stripe token is insecure or empty"));
		 }

		 //verify the stripe token is the correct length
		 if(strlen($newLedgerStripeToken) !== 28){
			 throw(new \RangeException("stripe token value is out of bounds"));
		 }

		 //convert and store the stripe token
		 $this->ledgerStripeToken = $newLedgerStripeToken;
	 }

	 /**
	 * inserts this ledger into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if mySQL related error occurs
	 * @throws \TypeError if $pdo is not a PDO object
	 **/
	 public function insert(\PDO $pdo) {
		 //ensure the ledger id is null
		 if($this->ledgerId !== null) {
			 throw(new \PDOException("not a new ledger"));
		 }

		 //create query template
		 $query = "INSERT INTO ledger(ledgerPurchaseId, ledgerAmount, ledgerDateTime, ledgerStripeToken) VALUES(:ledgerPurchaseId, :ledgerAmount, :ledgerDateTime, :ledgerStripeToken)";
		 $statement = $pdo->prepare($query);

		 //bind the member variables to the placeholders in this template
		 $formattedDate = $this->ledgerDateTime->format("Y-m-d H:i:s");
		 $parameters = ["ledgerPurchaseId" => $this->ledgerPurchaseId, "ledgerAmount" => $this->ledgerAmount, "ledgerDateTime" => $formattedDate, "ledgerStripeToken" => $this->ledgerStripeToken];
		 $statement->execute($parameters);

		 //update the null ledger id with the one mySQL just gave us
		 $this->ledgerId = intval($pdo->lastInsertId());
	 }

	 /**
	 * deletes this ledger from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if mySQL related error occurs
	 * @throws \TypeError if $pdo is not a pdo connection object
	 **/
	 public function delete(\PDO $pdo) {
		 //enfore the ledger id is not null
		 if($this->ledgerId === null) {
			 throw(new \PDOException("cannot delete a ledger that doesn't exist"));
		 }

		 //create query template
		 $query = "DELETE FROM ledger WHERE ledgerId = :ledgerId";
		 $statement = $pdo->prepare($query);

		 // bind the member variables to the placeholders in this template
		 $parameters = ["ledgerId" => $this->ledgerId];
		 $statement->execute($parameters);
	 }

	 /**
	 * updates this ledger in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if mySQL related error occurs
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	 public function update(\PDO $pdo) {
		 //enfore the ledger id is NOT null
		 if($this->ledgerId === null) {
			 throw(new \PDOException("cannot update a ledger that does not exist"));
		 }

		 //crete query template
		 $query = "UPDATE ledger SET ledgerPurchaseId = :ledgerPurchaseId, ledgerAmount = :ledgerAmount, ledgerDateTime = :ledgerDateTime, ledgerStripeToken = :ledgerStripeToken";
		 $statement = $pdo->prepare($query);

		 //bind the member variables to the placeholders in this template
		 $formattedDate = $this->ledgerDateTime->format("Y-m-d H:i:s");
		 $parameters = ["ledgerPurchaseId" => $this->ledgerPurchaseId, "ledgerAmount" => $this->ledgerAmount, "ledgerDateTime" => $formattedDate, "ledgerStripeToken" => $this->ledgerStripeToken];
		 $statement->execute($parameters);
	 }

	 /**
	 * get this ledger by the ledger id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $ledgerId id of this ledger we are searching for
	 * @return Ledger|null returns ledger or null if not found
	 * @throws \PDOException if mySQL related error occurs
	 * @throws \TypeError if variables are not the correct data types
	 **/
	 public static function getLedgerByLedgerId(\PDO $pdo, int $ledgerId) {
		 //sanitize the ledger id before searching
		 if($ledgerId <= 0) {
			 throw(new \PDOException("ledger id is not positive"));
		 }

		 //create query template
		 $query = "SELECT ledgerId, ledgerPurchaseId, ledgerAmount, ledgerDateTime, ledgerStripeToken FROM ledger WHERE ledgerId = :ledgerId";
		 $statement = $pdo->prepare($query);

		 //bind the memeber variables to the placeholders in this template
		 $parameters = ["ledgerId" => $ledgerId];
		 $statement->execute($parameters);

		 //grab the ledger from mySQL
		 try {
			 $ledger = null;
			 $statement->setFetchMode(\PDO::FETCH_ASSOC);
			 $row = $statement->fetch();
			 if($row !== false){
				 $ledger = new Ledger($row["ledgerId"], $row["ledgerPurchaseId"], $row["ledgerAmount"], $row["ledgerDateTime"], $row["ledgerStripeToken"]);
			 }
		 } catch(\Exception $exception) {
			 //if row cannot be converted, rethrow it
			 throw(new \PDOException($exception->getMessage(), 0, $exception));
		 }
		 return($ledger);
	 }

	 /**
	 * gets the ledger by the purchaseId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $ledgerPurchaseId id of the purchase this ledger belongs to
	 * @return Ledger|null returns the ledger or null if not found
	 * @throws \PDOException if mySQL related error occurs
	 * @throws \TypeError if variables are not the correct data types
	 **/
	 public static function getLedgerByLedgerPurchaseId(\PDO $pdo, int $ledgerPurchaseId) {
		 //sanitize the ledger purchase id before searching
		 if($ledgerPurchaseId <= 0) {
			 throw(new \PDOException("ledger purchase id is not positive"));
		 }

		 //create query template
		 $query = "SELECT ledgerId, ledgerPurchaseId, ledgerAmount, ledgerDateTime, ledgerStripeToken FROM ledger WHERE ledgerPurchaseId = :ledgerPurchaseId";
		 $statement = $pdo->prepare($query);

		 //bind the member variables to the placeholders in this template
		 $parameters = ["ledgerPurchaseId" => $ledgerPurchaseId];
		 $statement->execute($parameters);

		 //grab the ledger from mySQL
		 try {
			 $ledger = null;
			 $statement->setFetchMode(\PDO::FETCH_ASSOC);
			 $row = $statement->fetch();
			 if($row !== false){
				 $ledger = new Ledger($row["ledgerId"], $row["ledgerPurchaseId"], $row["ledgerAmount"], $row["ledgerDateTime"], $row["ledgerStripeToken"]);
			 }
		 } catch(\Exception $exception) {
			 //if row cannot be converted, rethrow it
			 throw(new \PDOException($exception->getMessage(), 0, $exception));
		 }
		 return($ledger);
	 }

	 /**
	 * gets ledger by $ledgerStripeToken
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $ledgerStripeToken ledger stripe token to search by
	 * @return Ledger|null returns ledger or null if not found
	 * @throws \PDOException if mySQL related error occurs
	 * @throws \TypeError if variables are not the correct data types
	 **/
	 public static function getLedgerByLedgerStripeToken(\PDO $pdo, string $ledgerStripeToken) {
		 //sanitize the ledger stripe token before searching
		 $ledgerStripeToken = trim($ledgerStripeToken);
		 $ledgerStripeToken = filter_var($ledgerStripeToken, FILTER_SANITIZE_STRING);
		 if(empty($ledgerStripeToken) === true) {
			 throw(new \PDOException("stripe token does not exist"));
		 }

		 //create query template
		 $query = "SELECT ledgerId, ledgerPurchaseId, ledgerAmount, ledgerDateTime, ledgerStripeToken FROM ledger WHERE ledgerStripeToken = :ledgerStripeToken";
		 $statement = $pdo->prepare($query);

		 //bind the member variables to the placeholders in this template
		 $parameters = ["ledgerStripeToken" => $ledgerStripeToken];
		 $statement->execute($parameters);

		 //grab the ledger from mySQL
		 try {
			 $ledger = null;
			 $statement->setFetchMode(\PDO::FETCH_ASSOC);
			 $row = $statement->fetch();
			 if($row !== false){
				 $ledger = new Ledger($row["ledgerId"], $row["ledgerPurchaseId"], $row["ledgerAmount"], $row["ledgerDateTime"], $row["ledgerStripeToken"]);
			 }
		 } catch(\Exception $exception) {
			 //if row cannot be converted, rethrow it
			 throw(new \PDOException($exception->getMessage(), 0, $exception));
		 }
		 return($ledger);
	 }

	 /**
	 * gets all ledgrs
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of ledgers found null if not found
	 * @throws \PDOException if mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data types
	 **/
	 public static function getAllLedgers(\PDO $pdo) {
		 //create query statement
		 $query = "SELECT ledgerId, ledgerPurchaseId, ledgerAmount, ledgerDateTime, ledgerStripeToken FROM ledger";
		 $statement = $pdo->prepare($query);
		 $statement->execute();

		 //build an array of ledgers
		 $ledgers = new \SplFixedArray($statement->rowCount());
		 $statement->setFetchMode(\PDO::FETCH_ASSOC);
		 while(($row = $statement->fetch()) !== false) {
			 try {
				 $ledger = new Ledger($row["ledgerId"], $row["ledgerPurchaseId"], $row["ledgerAmount"], $row["ledgerDateTime"], $row["ledgerStripeToken"]);
				 $ledgers[$ledgers->key()] = $ledger;
				 $ledgers->next();
			 } catch(\Exception $exception) {
				 //if the rouw could not be converted, rethrow it
				 throw(new \PDOException($exception->getMessage(), 0, $exception));
			 }
		 }
		 return($ledgers);
	 }

	/**
 	* formats the state variables for JSON serialization
 	*
 	* @return array resulting state variables to serialize
 	**/
 	public function jsonSerialize() {
 		$fields = get_object_vars($this);
		$fields["ledgerDateTime"] = $this->ledgerDateTime->getTimestamp() * 1000;
		unset($fields["ledgerStripeToken"]);
 		return ($fields);
 	}
}

 ?>
