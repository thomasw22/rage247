<?php

session_start();

$dat = "";
$adat = "";

if(isset($_SESSION["data"])) {
    $dat = $_SESSION["data"];
    $adat = "<p>".$dat."</p><span id='notifclose'>X</span>";
    unset($_SESSION["data"]);
}

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
            <h1>RAGE</h1>
        </div>
    </div>
    <div class="notif-wrapper" id="notifw">
        <div class="notif" id="notif"><?=$adat?></div>
    </div>
    <div class="drop-main">
        <div class="main-img-wrapper"></div>
        <div class="drop-main-wrapper">
            <h1>Get notified about upcoming drops</h1>
            <form action="notify.php" method="POST">
                <input type="email" name="mail" placeholder="E-mail" required>
                <input type="submit" name="notifysubmit" value="notify me!">
            </form>
        </div>
    </div>
    <div class="countdown-wrapper">
        <h1>New drop in:</h1>
        <div class="countdown">
            <div class="countdown-part">
                <h1 id="cd-days">S</h1>
                <p>DAYS</p>
            </div>
            <div class="countdown-separator">
                <h1>:</h1>
            </div>
            <div class="countdown-part">
                <h1 id="cd-hours">O</h1>
                <p>HOURS</p>
            </div>
            <div class="countdown-separator">
                <h1>:</h1>
            </div>
            <div class="countdown-part">
                <h1 id="cd-minutes">O</h1>
                <p>MINUTES</p>
            </div>
            <div class="countdown-separator">
                <h1>:</h1>
            </div>
            <div class="countdown-part">
                <h1 id="cd-seconds">N</h1>
                <p>SECONDS</p>
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
            <div class="footer-notice">

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
    </div>
    <a href="https://westerdijk.eu" target="_blank" class="credits">
        <p><span>&copy;</span> Thomas Westerdijk</p>
    </a>
    <script src="https://kit.fontawesome.com/26580f72e2.js" crossorigin="anonymous"></script>
    <script src="script/main.js"></script><script>initDrop();</script>
</body>

</html>


