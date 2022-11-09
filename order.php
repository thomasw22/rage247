<?php
session_start();
if(!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}
if(isset($_POST["amount"])) {
    $amount = $_POST["amount"];
    echo $amount;
    if($amount > 0) {
        $id = $_POST["productid"];
        echo $amount."/".$id;
        $cartitem = [$id, $amount];
        array_push($_SESSION["cart"], $cartitem);
        $_SESSION["data"] = "added item";
    } else {
        $_SESSION["data"] = "SOLD OUT";
    }
    header("location: index.php");
} else {
    $_SESSION["data"] = "SOLD OUT";
    header("location: index.php");
}

?>