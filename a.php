<?php



//::::INCLUDE FILE FOR RAGE247.EU::::// 247contactRAGE
//:::MADE BY THOMAS WESTERDIJK::://
//:::: https://westerdijk.eu :::://

/* EXPLANATION /*

-$db; -> array with database credentials
-dbconn(); -> function to start connection with database
-getpost(a) -> function that turns ["city","street"] into [$_POST["city], $_POST["street]]
-valprocess(a) -> function that turns ["city","street"] into "city, street"
-grabdata(a,b) -> function to grab data (b is string with keys ('name, cost') from table a (string))
-thrustdata(a,b,c) -> function that adds values c with keys b (array) to table a in database $db.name and returns true or false


*/

//$db;
include 'db.php';



function dbconn() {
    global $db;
    global $conn;
    $conn = mysqli_connect($db["server"], $db['username'], $db['password'], $db['name']);
    if(!$conn) {
        die('Error: ' . mysqli_connect_error());
    }
}

function getpost($a) {
    $ret = [];
    foreach($a as $b) {
        array_push($ret, $_POST[$b]);
    }
    return $ret;
}

function valprocess($a) {
    $ret = "";
    foreach($a as $b) {
        $ret = $ret."'".$b."',";
    }
    $ret = substr($ret, 0, -1);
    return $ret;
}

function grabdata($table, $keys, $a=";") {
    global $conn;
    $ret = [];
    $sql = "SELECT ".$keys." FROM ".$table.$a;
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            foreach($row as $value) {
                array_push($ret, $value);
            }
        }
    } else {
        // echo "0 results";
    }
    return $ret;
}

function thrustdata($table, $keys, $values) {
    global $conn;
    $ret = false;
    $sql = "INSERT INTO ".$table." (".implode(",",$keys).") VALUES (".$values.");";
    $res = mysqli_query($conn, $sql);
    if($res) {
        $ret = true;
    } else {
        $ret = false;
    }
    return $ret;
}

function rowcount($table) {
    global $conn;
    $ret = 0;
    $sql = "SELECT * FROM ".$table;
    $res = mysqli_query($conn, $sql);
    $ret = mysqli_num_rows($res);
    return $ret;
}

function datacheck() {
    if(isset($_SESSION["data"])) {
        // print("<script>alert('".$_SESSION["data"]."');</script>");
        echo $_SESSION["data"];
    }
}

function updatedata($table, $key, $value, $cond) {
    global $conn;
    $sql = "UPDATE $table SET $key='$value' WHERE $cond";
    $res = mysqli_query($conn, $sql);
    if($res) {
        return true;
    } else {
        return false;
    }
}

?>