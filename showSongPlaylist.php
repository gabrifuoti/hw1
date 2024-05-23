<?php
session_start();
$token = $_SESSION["token"];

$ids = $_GET["ids"];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://api.spotify.com/v1/tracks?ids=" . $ids);
$headers = array("Authorization: Bearer " . $token);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
echo $result;
curl_close($curl);
