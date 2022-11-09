<?php
session_start();

if(!isset($_GET["p"])) {
    $_SESSION["data"] = "No product found";
    header("location: index");
}

$pid = $_GET["p"];

include 'a.php';
dbconn();

$a = grabdata("products", "*", " WHERE id=".$pid);

if(isset($_POST["size"])) {
    $size = $_POST["size"];
    $uid = $a[1];
    $id = grabdata("products", "id", " WHERE uid=".$uid." AND colour='$a[3]' AND size='".$size."'")[0];
    header("location: view.php?p=".$id);
}

$sizes = grabdata("products", "size", " WHERE uid=".$a[1]." AND colour='".$a[3]."'");
$ssize = $a[4];

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
    <link href="styles/slideshow.css" rel="stylesheet">
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
                <!-- <div class="cart-item">
                    <img src="images/drops/first/ragewhite.jpg" alt="ragewhite.jpg">
                    <h3>Cool shit</h3>
                    <h4 class="cart-grid-1">3</h4>
                    <h4 class="cart-grid-2"><span>&euro;</span>30,-</h4>
                </div>
                <div class="cart-item">
                    <img src="images/drops/first/ballwhite.jpg" alt="ragewhite.jpg">
                    <h3>Cool shitt</h3>
                    <h4 class="cart-grid-1">2</h4>
                    <h4 class="cart-grid-2"><span>&euro;</span>75,-</h4>
                </div> -->
            </div>
            <div class="cart-link">
                <a href="cart">view full shopping cart</a>
            </div>
        </div>
    </div>
    <div class="main view">
        <div class="main-img-wrapper"></div>
        <div class="main-wrapper">

        </div>
    </div>
    <!-- <h1 class="new-items-header">NEW</h1> -->
    <div class="new-items-wrapper view-items-wrapper">
        <div class="new-items view-items">
            <div class="view-item">
                <!-- images -->
                <div class="slideshow-container">
                    <?php
                        $imgs = explode(" ", $a[9]);
                        for($i = 0; $i < count($imgs); $i++) {
                            echo "<div class='mySlides fade'>
                            <div class='numbertext'>". strval($i + 1 ." / ".(count($imgs)))."</div><img src='".$imgs[$i]."' alt='".$a[7]."' onclick='bigImg(this)'>
                            </div>";
                        }
                    ?>
                    <div style="text-align:center" class="dot-wrapper">
                        <?php
                            for($i = 0; $i < count(explode(" ", $a[9])); $i++) {
                                echo "<span class='dot' onclick='currentSlide(".$i.")'></span>";
                            }
                        ?>
                    </div>

                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>

                <!-- <img src="<?=explode(" ",$a[9])[0]?>" alt="<?=$a[7]?>"> -->
                <h1><?=$a[7]?></h1>
                <!-- <p><?=$a[8]?></p> -->
                <div class="item-info">
                    <h2>INFO</h2>
                    <div class="ul">
                        <li>
                            Type: <?=$a[2]?>
                        </li>
                        <li>
                            Colour: <?=$a[3]?>
                        </li>
                        <li>
                            Available: <?=$a[6]?>
                        </li>
                        <li>
                            Size: <?=$a[4]?>
                        </li>
                        <li>
                            Material: Sheep wool
                        </li>
                        <li>
                            Measurements: 12x24x65cm
                        </li>
                    </div>
                </div>
                <div class="size">
                    <div class="size-wrapper">
                        <h2>SIZE</h2>
                        <form method="POST" action="">
                            <select name="size" onchange="this.form.submit();">
                                <!-- echo sizes -->
                                <?php
                                    for($i = 0; $i < count($sizes); $i++) {
                                        if($sizes[$i] == $ssize) {
                                            echo "<option value='".$sizes[$i]."' selected='selected'>".$sizes[$i]."</option>";
                                        } else {
                                            echo "<option value='".$sizes[$i]."'>".$sizes[$i]."</option>";
                                        }
                                    }
                                    echo $ssize;
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="order-item">
                    <h2>Add to cart</h2>
                    <form action="order" method="POST">
                        <select name="amount">
                            <?php
                                for($i = 1; $i < $a[6] + 1; $i++) {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            ?>
                        </select>
                        <input type="hidden" name="productid" value="<?=$pid?>">
                        <input type="submit" value="ORDER">
                    </form>
                </div>
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
    <div class="bigimg" id="bigImg">
        <div class="bigimg-content">
            <span class="bigimg-close" onclick="bigImgClose();">X</span>
            <img src="images/drops/first/ragewhite.jpg" id="big-image">
        </div>
    </div>
    <a href="https://westerdijk.eu" target="_blank" class="credits">
        <p><span>&copy;</span> Thomas Westerdijk</p>
    </a>
    <script src="https://kit.fontawesome.com/26580f72e2.js" crossorigin="anonymous"></script>
    <script src="script/main.js"></script>
    <script src="script/slideshow.js"></script>
</body>

</html>