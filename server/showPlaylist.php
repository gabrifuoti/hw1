<?php
require_once("../sql/config.php");
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION["username"])) {
    header("Location: ../index.php");
}
$idPlaylist =  mysqli_real_escape_string($conn, $_GET['id']);
$_SESSION["idPlaylist"] = $idPlaylist;
$username = mysqli_real_escape_string($conn, $_SESSION["username"]);

if ($_GET['id'] == 'favourite') {
    $query = "SELECT * FROM favourite F JOIN userfavourite U ON F.codUser = U.codUser WHERE U.codUser = '" . $username . "'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $rows = array();
        while ($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
    } else {
        $rows = array(
            array(
                "idFavourite" => "0",
                "countSong" => "0"
            ),
            array(
                "idFavourite" => "0",
                "countSong" => "0"
            )
        );
    }

    echo json_encode($rows);
    mysqli_close($conn);
} else {
    $query = "SELECT * FROM playlist JOIN songplaylist ON idPlaylist = codPLaylist WHERE codPlaylist = '" . $idPlaylist . "'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $rows = array();
        while ($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
    } else {
        $query2 = "SELECT * FROM playlist WHERE idPlaylist = '" . $idPlaylist . "'";
        $result2 = mysqli_query($conn, $query2);
        $rows = array();
        while ($r = mysqli_fetch_assoc($result2)) {
            $rows[] = $r;
        }
    }

    echo json_encode($rows);
    mysqli_close($conn);
}
