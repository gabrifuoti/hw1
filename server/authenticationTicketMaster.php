<?php
$url = "https://app.ticketmaster.com/discovery/v2/attractions.json";

$params = ['apikey' => $ticketmaster_key, 'classificationName' => 'music'];
$request_url = $url . '?' . http_build_query($params);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $request_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
echo $result;
curl_close($curl);
