<?php
require_once("../sql/config.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
}

if (isset($_SESSION["idPlaylist"])) {
    $query = "DELETE FROM `playlist` WHERE idPlaylist='" . $_SESSION['idPlaylist'] . "'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    mysqli_close($conn);
    header("Location: ../index.php");
}
