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
	 * @return \DateTime value of the ledger date and time
	 **/
	 public function getLedgerDate() {
		 return($this->ledgerDate);
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
}

 ?>
