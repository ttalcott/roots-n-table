<?php

abstract class ProductTest extends \PHPUnit_Extensions_Database_TestCase{
	const INVALID_KEY = 4294967296;
	protected $connection = null;

	public final function getDataSet() {
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
		return ($dataset);
	}
	public final function getSetUpOperation(){
		return new \PHPUnit_Extensions_Database_Operation_Composite
		(array(\PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL(),
			\PHPUnit_Extensions_Database_Operation_Factory::INSERT()
		));
	}
	public final function getTearDownOperation(){
		return(\PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL());
	}

}