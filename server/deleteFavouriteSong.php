<?php
require_once("../sql/config.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
}

$id = mysqli_real_escape_string($conn, $_GET["id"]);
$username = mysqli_real_escape_string($conn, $_SESSION["username"]);
$query = "DELETE FROM `favourite` WHERE codSong='$id' and codUser='$username'";
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));
mysqli_close($conn);
