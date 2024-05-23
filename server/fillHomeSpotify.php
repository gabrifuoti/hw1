<?php

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://accounts.spotify.com/api/token");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
$headers = array("Authorization: Basic " . base64_encode($client_id . ":" . $client_secret));
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
curl_close($curl);

$token = json_decode($result)->access_token;

$param = $_GET["p"];
$limit = $_GET["limit"];

if (isset($_GET["p"])) {
    if ($param == 'last8') {
        $url = "categories/0JQ5DAqbMKFzHmL4tf05da/playlists";
    } else if ($param == 'm4y') {
        $url = "categories/0JQ5DAqbMKFQ00XGBls6ym/playlists";
    } else if ($param == 'newreleases') {
        $url = "new-releases";
    } else if ($param == 'popular') {
        $url = "featured-playlists";
    }
} else {
    echo "Errore nel passaggio dei parametri";
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://api.spotify.com/v1/browse/" . $url . "?limit=" . $limit);
$headers = array("Authorization: Bearer " . $token);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result_mood = curl_exec($curl);
echo $result_mood;
curl_close($curl);
