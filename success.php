<?php
session_start();
$showcart = false;

if(!isset($_GET["orderid"])) {
    die("no");
}
include 'a.php';
dbconn();

try {
    $id = $_GET["orderid"];
    $order = grabdata("orders", "*", " WHERE id=$id");
    $user = grabdata("users", "*", " WHERE id=".$order[2]);
    $address = grabdata("addresses", "*", " WHERE id=".$order[4]);
} catch(Throwable $e) {
    $_SESSION["data"] = "UNKNOWN ORDER";
    header("location: index.php");
}
$tracking = $order[1];
$mail = $user[4] ?: "";




// echo var_dump($order);
// echo var_dump($user);
// echo var_dump($address);

if(!updatedata("orders", "status", "payed/processing", "id=$id")) {
    die("Soemthing went wrong");
}

include 'mail.php';
// maill([$mail], "Your order", $tracking);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Thomas Westerdijk">
    <meta name="description" content="Website of Rage247" />
    <meta name="robots" content="index, follow">
    <meta name="copyright" content="Thomas Westerdijk">
    <meta name="keywords" content="">
    <meta name="language" content="EN">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Exa&display=swap" rel="stylesheet">
    <link href="styles/main.css" rel="stylesheet">
    <link href="styles/keyframes.css" rel="stylesheet">
    <link href="styles/breakpoints.css" rel="stylesheet">
    <title>Rage247</title>
</head>

<body>
    <div class="top">
        <div class="logo">
            <h1>
                <span onclick='window.location.href="index";'>RAGE</span>
            </h1>
        </div>
        <div class="mob-top-cart">
            <a href="cart">
                <i class="fas fa-shopping-cart"></i>
            </a>
        </div>
        <div class="top-cart">
            <a href="javascript:void(0);" onclick="showCart();">
                <i class="fas fa-shopping-cart"></i>
            </a>
        </div>
    </div>
    <div class="main">
        <div class="main-img-wrapper"></div>
        <div class="main-wrapper">
            <h1>YOUR ORDER</h1>
        </div>
    </div>
    <h1 class="new-items-header">INFO</h1>
    <div class="new-items-wrapper ss-wrapper">
        <div class="ss-content">
            <h1>Thanks for purchasing!</h1>
            <h2>Your tracking number:</h2>
            <p class="ss-tracking" onclick="navigator.clipboard.writeText(this.innerHTML);alert('copied to clipboard!');"><?=$tracking?></p>
            <h2>Status</h2>
            <p>An E-mail has been sent to [<?=$mail?>]. Further information will be sent to you.</p>
            <p>If you have any questions concerning your order, please mail us at <a href=''>contact@rage247.eu</a> and <strong>include your tracking number!</strong></p>
        </div>
    </div>
    <div class="footer ss-footer">
        <div class="footer-left">
            <div class="footer-contact">
                <div class="footer-contact-block">
                    <a href="mailto:contact@rage247.eu">
                        <i class="far fa-envelope"></i>
                        <span> contact@rage247.eu</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-right">
            <div class="footer-socials">
                <div class="footer-social">
                    <a href="https://www.instagram.com/rage247_/" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
                <div class="footer-social">
                    <a href="https://www.tiktok.com/@rage247clothing" target="_blank">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-more">
            <ul>
                <li>
                    <a href="">Terms and conditions</a>
                </li>
                <li>
                    <a href="">General Data Protection regulation</a>
                </li>
                <li>
                    <i class="fas fa-map-marker-alt"></i>
                    <a href="">Bogardstraat 23</a>
                </li>
            </ul>
        </div>
    </div>
    <a href="https://westerdijk.eu" target="_blank" class="credits">
        <p><span>&copy;</span> Thomas Westerdijk</p>
    </a>
    <script src="https://kit.fontawesome.com/26580f72e2.js" crossorigin="anonymous"></script>
    <script src="script/main.js"></script>
    <?php if($showcart){echo "<script>showCart();</script>";} ?>
</body>

</html>