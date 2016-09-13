<?php
function getCartTotal() {
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
	}
	return $totalPrice;
}
