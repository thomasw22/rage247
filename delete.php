<?php
session_start();
if(!isset($_GET["p"])) {
    $_SESSION["data"] = "Unknown product id";
    header("location: index.php");
}

$cart = $_SESSION["cart"];
$newcart = [];

for($i = 0; $i < count($cart); $i++) {
    if($cart[$i][0] == $_GET["p"]) {
        //remove
    } else {
        array_push($newcart, [$cart[$i][0], $cart[$i][1]]);
    }
}
$_SESSION["cart"] = $newcart;

$_SESSION["data"] = "Product successfully removed from shopping cart";
header("location: cart.php");

?>