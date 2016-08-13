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

}

 ?>
