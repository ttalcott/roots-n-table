<?php

namespace Edu\Cnm\Rootstable;

require_once("autoload.php");

/**
* Ledger class for Roots 'n Table
*
* @author Travis Talcott <ttalcott@lyradevelopment.com>
* version 1.0.0
**/

class Ledger {
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
	* @var \DateTime $ledgerDate
	**/
	private $ledgerDate;
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
	 * @param \DateTime $newLedgerDate date and time of this ledger
	 * @param string $newLedgerStripeToken stripe token of this ledger
	 * @throws \InvalidArgumentException if the data type is incorrect
	 * @throws \RangeException if the data is out of bounds
	 * @throws \TypeError if the data violates type hints
	 * @throws \Exception if any other exception occurs
	 **/
	 public function __construct(int $newLedgerId = null, int $newLedgerPurchaseId, float $newLedgerAmount, $newLedgerDate = null, string $newLedgerStripeToken) {
		 try {
			 $this->setLedgerId($newLedgerId);
			 $this->setLedgerPurchaseId($ledgerPurchaseId);
			 $this->setLedgerAmount($newLedgerAmount);
			 $this->setLedgerDate($newLedgerDate);
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
	 * @throws \RangeException if $newLedgerAmount is not positive
	 * @throws \TypeError if $newLedgerAmount is not a float
	 **/
	 public function setLedgerAmount(float $newLedgerAmount) {
		 //validate $newLedgerAmount is a float and is secure
		 $newLedgerAmount = filter_var($newLedgerAmount, FILTER_VALIDATE_FLOAT);
		 if(empty($newLedgerAmount) === true) {
			 throw(new \InvalidArgumentException("ledger amount is empty or insecure"));
		 }

		 //verify $newLedgerAmount is positive
		 if($newLedgerAmount <= 0) {
			 throw(new \RangeException("ledger amount is not valid"));
		 }

		 //convert and store $newLedgerAmount
		 $this->ledgerAmount = $newLedgerAmount;
	 }

	 /**
	 * accessor method for $ledgerDate
	 *
	 * @return \DateTime|string|null value of the ledger date and time
	 **/
	 public function getLedgerDate() {
		 return($this->ledgerDate);
	 }

	 /**
	 * mutator method for $ledgerDate
	 *
	 * @param \DateTime $newLedgerDate ledger date and time as a DateTime object or a string (null for current date and time)
	 * @throws \InvalidArgumentException if $newLedgerDate is not a valid object or string
	 * @throws \RangeException if $newLedgerDate is a date that does not exist
	 **/
	 public function setLedgerDate($newLedgerDate = null) {
		 //base case: if the date and time are null use the current date and time
		 if($newLedgerDate === null) {
			 $this->ledgerDate = new \DateTime();
			 return;
		 }

		 //store the ledger date and time
		 try {
			 $newLedgerDate = slef::validateDateTime($newLedgerDate);
	 	} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}

		//convert and store $ledgerDate
		$this->ledgerDate = $newLedgerDate;
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
		 $query = "INSERT INTO ledger(ledgerPurchaseId, ledgerAmount, ledgerDate, ledgerStripeToken) VALUES(:ledgerPurchaseId, :ledgerAmount, :ledgerDate, :ledgerStripeToken)";
		 $statement = $pdo->prepare($query);

		 //bind the member variables to the placeholders in this template
		 $parameters = ["ledgerPurchaseId" => $this->ledgerPurchaseId, "ledgerAmount" => $this->ledgerAmount, "ledgerDate" => $this->ledgerDate, "ledgerStripeToken" => $this->ledgerStripeToken];
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
		 $query = "UPDATE ledger SET ledgerPurchaseId = :ledgerPurchaseId, ledgerAmount = :ledgerAmount, ledgerDate = :ledgerDate, ledgerStripeToken = :ledgerStripeToken";
		 $statement = $pdo->prepare($query);

		 //bind the member variables to the placeholders in this template
		 $parameters = ["ledgerPurchaseId" => $this->ledgerPurchaseId, "ledgerAmount" => $this->ledgerAmount, "ledgerDate" => $this->ledgerDate, "ledgerStripeToken" => $this->ledgerStripeToken];
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
		 $query = "SELECT ledgerId, ledgerPurchaseId, ledgerAmount, ledgerDate, ledgerStripeToken FROM ledger WHERE ledgerId = :ledgerId";
		 $statement = $pdo->prepare($query);

		 //bind the memeber variables to the placeholders in this template
		 $parameters = ["ledgerId" => $this->ledgerId];
		 $statement->execute($parameters);

		 //grap the ledger from mySQL
		 try {
			 $ledger = null;
			 $statement->setFetchMode(\PDO::FETCH_ASSOC);
			 $row = $statement->fetch();
			 if($row !== false){
				 $ledger = new Ledger($row["ledgerId"], $row["ledgerPurchaseId"], $row["ledgerAmount"], ["ledgerDate"], $row["ledgerStripeToken"]);
			 }
		 } catch(\Exception $exception) {
			 //if row cannot be converted, rethrow it
			 throw(new \PDOException($exception->getMessage(), 0, $exception));
		 }
		 return($ledger);
	 }
}

 ?>
