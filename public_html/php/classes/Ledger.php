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
	* @var decimal $ledgerAmount
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
	 public function setLedgerId() {
		 //verify the ledgerId is positive
		 
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
	 * accessor method for $ledgerAmount
	 *
	 * @return decimal value of $ledgerAmount
	 **/
	 public function getLedgerAmount() {
		 return($this->ledgerAmount);
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
}

 ?>
