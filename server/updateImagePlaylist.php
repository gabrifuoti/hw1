<?php
require_once("../sql/config.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
}
if (isset($_FILES['imgplaylist']) || isset($_FILES['imgeditplaylist'])) {
    if (empty($_FILES['imgplaylist']['tmp_name']) && empty($_FILES['imgeditplaylist']['tmp_name'])) {
        $base64Image = NULL;
        $isFile = false;
    } else if (empty($_FILES['imgplaylist']['tmp_name'])) {
        $image = $_FILES['imgeditplaylist']['tmp_name'];
        $imageData = file_get_contents($image);
        $base64Image = mysqli_real_escape_string($conn, base64_encode($imageData));
        $isFile = true;
    } else if (empty($_FILES['imgeditplaylist']['tmp_name'])) {
        $image = $_FILES['imgplaylist']['tmp_name'];
        $imageData = file_get_contents($image);
        $base64Image = mysqli_real_escape_string($conn, base64_encode($imageData));
        $isFile = true;
    }
} else {
    $base64Image = NULL;
}

$idPlaylist = mysqli_real_escape_string($conn, $_SESSION["idPlaylist"]);
if (!empty($_POST['newnameplaylist'])) {
    $title = mysqli_real_escape_string($conn, $_POST['newnameplaylist']);
} else {
    $title = "New Playlist";
}

if ($isFile) {
    $query = "UPDATE `playlist` SET `img`='$base64Image', title='$title' WHERE idPlaylist = '$idPlaylist'";
} else {
    $query = "UPDATE `playlist` SET title='$title' WHERE idPlaylist = '$idPlaylist'";
}

$res = mysqli_query($conn, $query) or die(mysqli_error($conn));
mysqli_close($conn);
header("Location: ../index.php");
