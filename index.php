<?php
session_start();
include 'a.php';
dbconn();

$newitem1 = grabdata("products", "id, colour, price, name, images", " WHERE uid=1 AND colour='white' LIMIT 1");
$newitem2 = grabdata("products", "id, colour, price, name, images", " WHERE uid=1 AND colour='black' LIMIT 1");

$showcart = false;
if(isset($_SESSION["data"])) {
    if($_SESSION["data"] == "addeditem") {
        $showcart = true;
    }

    if(isset($_SESSION["cart"])) {
        $cart = $_SESSION["cart"];
    }
}

$dat = "";
$adat = "";

if(isset($_SESSION["data"])) {
    $dat = $_SESSION["data"];
    $adat = "<p>".$dat."</p><span id='notifclose'>X</span>";
    unset($_SESSION["data"]);
}


// unset($_SESSION["cart"]);

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
        <div class="top-home">
            <a href="index.php"><i class="fas fa-home"></i></a>
        </div>
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
        <div class="cart" id="cart">
            <div class="cart-close" onclick="closeCart();">
                <h2>Close cart</h2>
            </div>
            <h1>
                Shopping cart
            </h1>
            <div class="cart-items">
                <?php
                    if(isset($cart)) {
                        foreach($cart as $item) {
                            $ii = grabdata("products", "*", " WHERE id=".$item[0]);
                            echo "
                                <div class='cart-item'>
                                    <img src='".explode(" ", $ii[9])[0]."' alt=''>
                                    <h3>".$ii[7]."</h3>
                                    <h4 class='cart-grid-1'>".$item[1]."</h4>
                                    <h4 class='cart-grid-2'><span>&euro;</span>".number_format($ii[5] / 100, 2)."</h4>
                                </div>
                            ";
                        }
                    }
                ?>
            </div>
            <div class="cart-link">
                <a href="cart">view full shopping cart</a>
            </div>
        </div>
    </div>
    <div class="notif-wrapper home-notif-wrapper" id="notifw">
        <div class="notif" id="notif"><?=$adat?></div>
    </div>
    <div class="main">
        <div class="main-img-wrapper"></div>
        <div class="main-wrapper">
            <h1>RAGE SPIDER TEE COLLECTION</h1>
            <a href="#shop">SHOP NOW</a>
        </div>
    </div>
    <h1 class="new-items-header" id="shop">NEW</h1>
    <div class="new-items-wrapper">
        <div class="new-items">
            <?php
                echo "
                    <div class='new-item'>
                        <img src='".explode(" ",$newitem1[4])[0]."' alt='".$newitem1[3]."'>
                        <h2>".$newitem1[3]." ".$newitem1[1]."</h2>
                        <a href='view?p=".$newitem1[0]."'>View more</a>
                        <h3><span>&euro;</span>".number_format($newitem1[2]/100, 2)."</h3>
                    </div>
                    <div class='new-item'>
                        <img src='".explode(" ",$newitem2[4])[0]."' alt='".$newitem2[3]."'>
                        <h2>".$newitem2[3]." ".$newitem2[1]."</h2>
                        <a href='view?p=".$newitem2[0]."'>View more</a>
                        <h3><span>&euro;</span>".number_format($newitem2[2]/100, 2)."</h3>
                    </div>
                ";
            ?>
        </div>
    </div>
    <div class="footer">
        <div class="footer-left">
            <div class="footer-contact">
                <div class="footer-contact-block">
                    <a href="mailto:contact@rage247.eu">
                        <i class="far fa-envelope"></i>
                        <span>&nbsp;contact@rage247.eu</span>
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