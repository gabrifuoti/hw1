<?php
session_start();
if (isset($_SESSION["token"])) {
    $token = $_SESSION["token"];
    $param = $_GET["q"];
    $type = $_GET["type"];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.spotify.com/v1/search?q=" . $param . "&type=" . $type);
    $headers = array("Authorization: Bearer " . $token);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result_mood = curl_exec($curl);
    echo $result_mood;
    curl_close($curl);
} else {
    echo "Token scaduto";
}
