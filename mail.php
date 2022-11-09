<?php

function maill($t, $s, $tr) {

    $to  = implode(",",$t);

    $message = '
    <img src="https://rage247.eu/images/full.png" alt="Logo">
    <h1>Your order</h1>
    <h2>Thanks for ordering at RAGE247!</h2>
    <h4>Your tracking number:</h4>
    <p><strong>'.$tr.'</strong></p>
    <p>Information concerning the shipment will be sent to you soon</p>
    <p>If you have any questions, please mail us at <a href="mailto:contact@rage247.eu">contact@rage247.eu</a>, including your tracking number. Do not reply to this email!</p>
    ';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

    $headers .= "To: ".$to."\r\n";
    $headers .= 'From: NoreplyRAGE247 <no-reply@rage247.eu>' . "\r\n";


    if(!mail($to, $s, $message, $headers)) {
        echo error_get_last()['message'];
    } else {
        echo "hihi";
    }

}



?>