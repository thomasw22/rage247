<?php
session_start();
if(!isset($_POST["checkoutsubmit"])) {
    die();
}

include 'a.php';
dbconn();

$c = $_SESSION["cart"];
$cids = [];
foreach($c as $i) {
    array_push($cids, $i[0]);
}

$firstname = $_POST["firstname"];
$preposition = $_POST["preposition"] ?: "";
$lastname = $_POST["lastname"];
$mail = $_POST["mail"];
$birthdate = $_POST["birthdate"] ?: "1800-01-01";
$phone = $_POST["phone"] ?: "";
date_default_timezone_set("Europe/Amsterdam");
$date = Date("Y-m-d H-i-s");

if(!thrustdata("users", ["firstname", "prep", "lastname", "email", "birthdate", "phone", "created"], "'$firstname', '$preposition', '$lastname', '$mail', '$birthdate', '$phone', '$date'")) {
    echo mysqli_error($conn);
    die("something went wrong");
}

$userid = grabdata("users", "id", " ORDER BY id DESC LIMIT 1")[0];

$country = $_POST["country"];
$state = $_POST["state"];
$city = $_POST["city"];
$street = $_POST["street"];
$house = $_POST["housenumber"];
$zip = $_POST["zip"];

if(!thrustdata("addresses", ["country", "state","city","street","housenumber","postalcode"], "'$country','$state','$city','$street','$house','$zip'")) {
    echo mysqli_error($conn);
    die("something went wrong");
}
$addressid = grabdata("addresses", "id", " ORDER BY id DESC LIMIT 1")[0];

$tracking = uniqid(chr(rand(65,90))."_", true);
$total = $_POST["total"];

$coupon = $_POST["coupon"] ?: "";

if(!thrustdata("orders", ["tracking_number","user_id","products","address_id","created","status","total_cost", "coupons"], "'$tracking','$userid','".implode(",",$cids)."','$addressid','$date','Processing','".strval($total*100)."', '$coupon'")) {
    echo mysqli_error($conn);
    die("something went wrong");
}

$orderid = grabdata("orders", "id", " ORDER BY id DESC LIMIT 1")[0];


$ch = curl_init();
$data = array(
    "amount" => $total,
    "currency" => "eur",
    "method"=>"ideal",
    // "returnUrl" => "http://localhost/rage247/success?orderid=".$orderid,
    "returnUrl" => "https://rage247.eu/success?orderid=$orderid",
    "description"=>"ORDER #".$orderid,
    "language"=>"eng"
);
$payload = json_encode($data);
curl_setopt($ch, CURLOPT_URL, "https://redirect.jforce.be/api/v1/payment");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, $apikey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Content-Length: '.strlen($payload)));

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$res = array();
$res = curl_exec($ch);

$httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch);
if ( $httpCode != 200 ){
    echo "Return code is {$httpCode} \n"
        .curl_error($ch);
} else {
    $url = explode("\"", explode('payUrl":"',explode("Secure", explode(" ", $res)[28])[1])[1])[0];
    // echo var_dump($url);
    // echo "<pre>".htmlspecialchars($res)."</pre>";

    foreach($c as $cid) {
        $av = grabdata("products", "available", " WHERE id=$cid[0]")[0];
        echo var_dump($cid);
        if(!updatedata("products", "available", intval($av) - intval($cid[1]), " id=$cid[0]")) {
            echo mysqli_error($conn);
        }
    }

    header("location: ".$url);
    exit;
}
?>





