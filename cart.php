<?php
session_start();
include 'a.php';
dbconn();

if(isset($_POST["amount"])) {
    $id = $_POST["pid"];
    for($i = 0; $i < count($_SESSION["cart"]); $i++) {
        if($_SESSION["cart"][$i][0] == $id) {
            $_SESSION["cart"][$i][1] = $_POST["amount"];
        }
    }
}

$showcart = false;
if(isset($_SESSION["data"])) {

}
if(isset($_SESSION["cart"])) {
    $cart = $_SESSION["cart"];
} else {
    $cart = [];
}



// https://vpos.jforce.be/mbo/#/login


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
    </div>
    <div class="main">
        <div class="main-img-wrapper"></div>
        <div class="main-wrapper">
            <h1>SHOPPING CART</h1>
        </div>
    </div>
    <h1 class="new-items-header">CART</h1>
    <div class="new-items-wrapper cart-items-wrapper">
        <div class="new-items ccart-items">
            <div class="ccart-items-wrapper">
                <?php
                    if(count($cart) > 0) {
                        foreach($cart as $ci) {
                            $dat = grabdata("products", "*", " WHERE id=".$ci[0]);
                            echo "
                                <div class='ccart-item'>
                                    <div class='img'><img src='".explode(" ", $dat[9])[0]."' alt='$dat[7]'></div>
                                    <h2><a href='view?p=$dat[0]'>$dat[7]</a></h2>
                                    <h4>Price: <span>&euro;</span>".number_format($dat[5] / 100, 2)."</h4>
                                    <h4>Amount:
                                        <form action='cart' method='POST'>
                                            <input type='hidden' name='pid' value='$ci[0]'>
                                            <select name='amount' onchange='this.form.submit();'>";
                                                for($i = 1; $i < $dat[6] + 1; $i++) {
                                                    if($i == $ci[1]) {
                                                        echo "<option value='$i' selected='selected'>$i</option>";
                                                    } else {
                                                        echo "<option value='$i'>$i</option>";
                                                    }
                                                }
                                            echo "</select>
                                        </form>
                                    </h4>
                                    <h4>Size: $dat[4]</h4>
                                    <h4>
                                        <a href='delete?p=$ci[0]'>
                                            <i class='fas fa-trash-alt'></i>
                                        </a>
                                    </h4>
                                </div>
                            ";
                        }
                    } else {
                        echo "
                            <div class='ccart-item'>
                                <div class='img'></div>
                                <h2>EMPTY</h2>
                            </div>
                        ";
                    }
                ?>

                <div class="ccart-c">
                    <?php
                        if(count($cart) > 0) {
                            echo "
                            <a href='checkout'>Proceed to checkout</a>
                            ";
                        } else {
                            echo "
                            <a href='checkout' class='a-disabled'>Proceed to checkout</a>
                            ";
                        }
                    ?>
                </div>
            </div>
            <div class="ccheckout">
                <h1>Checkout options</h1>
                <h2>Payment methods</h2>
                <ul>
                    <li>
                        <img src="">Ideal
                    </li><br />
                    <li>
                        <img src=""></img>Paypal (please contact us for custom order)
                    </li>
                </ul>
                <h2>Shipping</h2>
                <ul>
                    <li>
                        In the Netherlands:
                        <span>Delivery within a week</span>
                    </li>
                    <li>
                        Other countries:
                        <span>Please contact us</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer">
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