<?php
session_start();
include 'a.php';
dbconn();

if(!isset($_POST["notifysubmit"])) {
    header("location: drop.php");
}

$mail = trim(htmlspecialchars($_POST["mail"]));
if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["data"] = "Invalid E-mail";
    header("location: drop.php");
}


if(in_array($mail, grabdata('droplist', 'email'))) {
    $_SESSION["data"] = "E-mail has already been submitted";
    header("location: drop.php");
} else {
    if(thrustdata('droplist', ["email"], "'".$mail."'")) {
        $_SESSION["data"] = "You'll be notified!";
        header("location: drop.php");
    } else {
        $_SESSION["data"] = "Sorry, something went wrong ".mysqli_error($conn);
        header("location: drop.php");
    }
}

?>