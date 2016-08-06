<?php

abstract class ProductTest extends \PHPUnit_Extensions_rootstable_TestCase{
	const INVALID_KEY = 4294967296;
	protected $connection = null;

	public final function getDataSet(){
		$dataset = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet
		($this->getConnection());
		$dataset->addTable("profile");
		$dataset->addTable("category");
		$dataset->addTable("image");
		$dataset->addTable("unit");
		$dataset->addTable("purchase");
		$dataset->addTable("ledger");
		$dataset->addTable("location");
		$dataset->addTable("product");
		$dataset->addTable("productCategory");
		$dataset->addTable("productImage");
		$dataset->addTable("productPurchase");
		$dataset->addTable("profileImage");


	}
}