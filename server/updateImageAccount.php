<?php
require_once("../sql/config.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
}
if (isset($_FILES['imgaccount'])) {
    $image = $_FILES['imgaccount']['tmp_name'];
    $user = mysqli_real_escape_string($conn, $_SESSION['username']);

    $imageData = file_get_contents($image);
    $base64Image = mysqli_real_escape_string($conn, base64_encode($imageData));

    $query = "UPDATE `user` SET `profilepic`='$base64Image' WHERE name = '$user'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    mysqli_close($conn);
    header("Location: ../index.php");
}
