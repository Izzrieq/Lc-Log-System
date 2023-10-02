<?php
require_once 'vendor/autoload.php';
use Twilio\Rest\Client;

$sid = "AC86aa1ccd5d3ae5ba3c171a554f03b08a";
$token = "f1d38338b94008b84b645865e4999745";

$twilio_number = "+12015375617";

$twilio = new Client($sid, $token);

    $call = $twilio->calls
    ->create("+60179999058",
            $twilio_number,
    ["url" => "http://demo.twilio.com/docs/voice.xml"]
    );
 echo '<pre>';
 print_r($call);
 echo '</pre>';
?>