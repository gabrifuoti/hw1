<?php
require_once("../sql/config.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
}

if (!empty($_FILES['imgnewplaylist']['tmp_name'])) {
    $image = $_FILES['imgnewplaylist']['tmp_name'];
    $imageData = file_get_contents($image);
    $base64Image = mysqli_real_escape_string($conn, base64_encode($imageData));
} else {
    $base64Image = NULL;
}

if (empty($_POST['nameplaylist'])) {
    $title = "New Playlist";
} else {
    $title = mysqli_real_escape_string($conn, $_POST['nameplaylist']);
}

$user = mysqli_real_escape_string($conn, $_SESSION['username']);

$query1 = "SELECT * FROM account WHERE username = '" . $user . "'";
$result = mysqli_query($conn, $query1);
$row = mysqli_fetch_assoc($result);
$id = mysqli_real_escape_string($conn, $row['idAccount']);

$query2 = "INSERT INTO `playlist`(`title`, `img`, `codAccount`) VALUES ('$title','$base64Image','$id')";

$res2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));
mysqli_close($conn);
header("Location: ../index.php");
