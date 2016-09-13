<?php
require_once dirname(__DIR__) . "/classes/autoload.php";
require_once ("xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
use Edu\Cnm\Rootstable\Product;

function getCartTotal() {

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rootstable.ini");

	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	if (isset($_SESSION["cart"]) === false) {
		$_SESSION["cart"] = [];
	}
	$totalPrice = 0;
	foreach($_SESSION["cart"] as $cartProductId => $cartQuantity) {
		$product = Product::getProductByProductId($pdo, $cartProductId);
		$totalPrice = $totalPrice + ($product->getProductPrice() * $cartQuantity);
		return($totalPrice * 100);
	}
	return $totalPrice;
}
