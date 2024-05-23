<?php
require_once("../sql/config.php");
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
}

header('Content-Type: application/json');
$id = mysqli_real_escape_string($conn, $_GET["id"]);
$query = "SELECT * FROM favourite WHERE codUser = '" . $_SESSION["username"] . "' AND codSong = '$id'";
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));
echo json_encode(array(
    'exists' => mysqli_num_rows($res) > 0 ? true : false,
    'codSong' => $id
));
mysqli_close($conn);
