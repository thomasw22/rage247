<?php
session_start();
include 'a.php';
dbconn();


$showcart = false;
// $cart = [];
if(isset($_SESSION["cart"])) {
    $cart = $_SESSION["cart"];
}
$total = 0;
foreach($cart as $item) {
    $cost = grabdata("products", "price", " WHERE id=".$item[0])[0];
    $total += $item[1] * $cost;
}
$coupon = "";
if(isset($_POST["coupon"])) {
    $coupon = $_POST["coupon"];
    if($coupon == "pers0nal") {
        $coupon = 1;
        $total -= 500;
    }
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
            <h1>CHECKOUT</h1>
        </div>
    </div>
    <h1 class="new-items-header">CHECKOUT</h1>
    <div class="new-items-wrapper checkout-items-wrapper">
        <div class="new-items checkout-items">
            <div class="co-items">
                <h1>Items</h1>
                <?php
                    foreach($cart as $item) {
                        $dat = grabdata("products", "*", " WHERE id=".$item[0]);
                        echo "
                            <div class='co-item'>
                                <img src='".explode(" ",$dat[9])[0]."' alt='$dat[7]'>
                                <h3>$dat[7]</h3>
                                <h3>Price: <span>&euro;</span>".number_format($dat[5] / 100, 2)."</h3>
                                <h3>Amount: $item[1]</h3>
                            </div>
                        ";
                    }
                ?>
                <div class="co-coupon">
                    <h1>COUPON</h1>
                    <p>Enter your coupon code here. You can only use one at a time</p>
                    <form action="" method="POST" class="cpform">
                        <div class="cpform-field">
                            <input type="text" name="coupon" id="coupon" placeholder=" ">
                            <label for="coupon">Coupon</label>
                        </div>
                        <div class="cpform-field">
                            <input type="submit" value="ENTER">
                        </div>
                    </form>
                </div>
                <div class="co-total">
                    <h1>TOTAL</h1>
                    <table>
                        <tr>
                            <td>Subtotal (products)</td>
                            <td><span>&euro;</span><?=number_format($total / 100 - (($total / 100 / 121) * 21) , 2)?></td>
                        </tr>
                        <tr>
                            <td>Subtotal including VAT (21%)</td>
                            <td><span>&euro;</span><span id="csv"><?=number_format(($total / 100), 2)?></td>
                        </tr>
                        <tr>
                            <td>Shipping costs</td>
                            <td id="csd"><span>&euro;</span>5.00</td>
                        </tr>
                        <tr>
                            <?php
                                if($coupon != "") {
                                    echo "<td>Discount</td><td>-<span>&euro;</span>5.00</td";
                                }
                            ?>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th id="cst"><span>&euro;</span><?=number_format(($total / 100) + 5, 2)?></th>
                    </table>
                </div>
            </div>
            <div class="co-info">
                <h1>Your info</h1>
                <form action="checkoutprocess.php" method="POST" class="cform">
                    <h2 class="co-pn">Personal</h2>
                    <div class="info-field-wrapper">
                        <div class="info-field">
                            <input type="text" name="firstname" id="fname" placeholder=" " required>
                            <label for="fname">
                                First name
                                <span class="fs"> *</span>
                            </label>
                        </div>
                        <div class="info-field">
                            <input type="text" name="preposition" id="prep" placeholder=" ">
                            <label for="prep">Preposition</label>
                        </div>
                        <div class="info-field">
                            <input type="text" name="lastname" id="lname" placeholder=" " required>
                            <label for="lname">Last name<span class="fs"> *</span></label>
                        </div>
                        <div class="info-field">
                            <input type="email" name="mail" id="mail" placeholder=" " required>
                            <label for="mail">E-mail<span class="fs"> *</span></label>
                        </div>
                        <div class="info-field">
                            <input type="text" name="phone" id="phone" placeholder=" ">
                            <label for="phone">Phone</label>
                        </div>
                        <div class="info-field">
                            <input type="date" name="birthdate" id="birth" value="01-01-1800">
                            <label for="birth">Birthdate</label>
                        </div>
                    </div>

                    <h2 class="co-pn">Address</h2>
                    <div class="info-field-wrapper">
                        <div class="info-field">
                            <select name="country" id="cs">
                                <option value="nl">The Netherlands</option>
                                <option value="be">Belgium</option>
                            </select>
                        </div>
                        <div class="info-field">
                            <input type="text" name="state" id="prep" placeholder=" " required>
                            <label for="prep">State<span class="fs"> *</span></label>
                        </div>
                        <div class="info-field">
                            <input type="text" name="city" id="lname" placeholder=" " required>
                            <label for="lname">City<span class="fs"> *</span></label>
                        </div>
                        <div class="info-field">
                            <input type="text" name="street" id="mail" placeholder=" " required>
                            <label for="mail">Street<span class="fs"> *</span></label>
                        </div>
                        <div class="info-field">
                            <input type="text" name="housenumber" id="phone" placeholder=" " required>
                            <label for="phone">Housenumber<span class="fs">*</span></label>
                        </div>
                        <div class="info-field">
                            <input type="text" name="zip" id="phone" placeholder=" " required>
                            <label for="phone">Zip code<span class="fs"> *</span></label>
                        </div>
                    </div>
                    <div class="cform-terms">
                        <h2>Please</h2>
                        <input type="checkbox" required>Agree to our <a href="termsconditions.html"
                            target="_blank">terms and conditions</a>
                        <span class="fs">*</span>
                    </div>

                    <input type="hidden" name="coupon" value="<?=$coupon?>">
                    <input type="hidden" name="total" value="" id="cstd">
                    <div class="cform-bottom">
                        <p>*required</p>
                        <input type="submit" name="checkoutsubmit" value="CONTINUE TO PAYMENT">
                    </div>
                </form>
                <p>
                    By continueing you will be sent to a third-party payment provider. After completing your payment you
                    will be sent back to our site.
                </p>
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
    <script>
    initCheckout();
    </script>
    <?php if($showcart){echo "<script>showCart();</script>";} ?>
</body>

</html>