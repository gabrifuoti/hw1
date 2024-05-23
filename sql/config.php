<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "spotify";
$conn = mysqli_connect($host, $user, $password, $db) or die("Connessione al server non riuscita.");
mysqli_query($conn, "set names 'utf8'");
