<?php
require_once("../sql/config.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
}

if (isset($_SESSION["idPlaylist"])) {
    $idSong = mysqli_real_escape_string($conn, $_GET["id"]);
    $query = "DELETE FROM `songplaylist` WHERE codPlaylist='" . $_SESSION['idPlaylist'] . "' AND codSong='$idSong'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    mysqli_close($conn);
}
