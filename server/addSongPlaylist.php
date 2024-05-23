<?php
require_once("../sql/config.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
}

$idPlaylist = mysqli_real_escape_string($conn, $_GET["idPlaylist"]);
$idSong = mysqli_real_escape_string($conn, $_GET["idSong"]);
$data = date('Y-m-d');

$query = "INSERT INTO `songplaylist`(`codSong`, `codPlaylist`, `data`) VALUES ('$idSong','$idPlaylist','$data')";
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));
mysqli_close($conn);
