<?php
session_start();
require_once("sql/config.php");
if (isset($_SESSION["username"])) {
    $query = "SELECT * FROM account JOIN user ON username = name WHERE username = '" . $_SESSION["username"] . "'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}
?>
<html>

<head>
    <title>Spotify • <?php if (isset($_SESSION["username"])) {
                            echo $_SESSION["username"];
                        } else {
                            echo "Home page";
                        } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/logo.png" rel="icon">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/leftpart.css" rel="stylesheet">
    <link href="css/rightpart.css" rel="stylesheet">
    <link href="css/playlistview.css" rel="stylesheet">
    <link href="css/reproduction.css" rel="stylesheet">
    <link href="css/index_media.css" rel="stylesheet">
    <script src="js/index.js" defer></script>
    <script src="js/fillHomeSpotify.js" defer></script>
    <script src="js/showItem.js" defer></script>
    <script src="js/showPlaylist.js" defer></script>
    <script src="js/showReproduction.js" defer></script>
</head>

<body>
    <div class="modal hidden">
        <div class="modal-createplaylist">
            <svg xmlns="http://www.w3.org/2000/svg" class="closemodal icon" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
            </svg>
            <h2>Create New Playlist</h2>
            <form id="form-playlist" action="server/addPlaylist.php" method="post" enctype="multipart/form-data">
                <label for="img"> Image (not necessarily required)</label>
                <input type="file" name="imgnewplaylist" accept="image/png, image/jpeg">
                <label for="name"> Name</label>
                <input type="text" name="nameplaylist" placeholder="Playlist's name" autocomplete="off">
                <input name="submit-playlist" type="submit" value="Create Playlist">
            </form>
        </div>
        <div class="modal-editplaylist">
            <svg xmlns="http://www.w3.org/2000/svg" id="close-modal-edit" class="closemodal icon" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
            </svg>
            <h2>Edit this playlist</h2>
            <form id="form-editplaylist" action="server/updateImagePlaylist.php" method="post" enctype="multipart/form-data">
                <label for="imgeditplaylist"> Image (not necessarily required)</label>
                <br>
                <input type="file" name="imgeditplaylist" accept="image/png, image/jpeg">
                <br>
                <label for="newnameplaylist"> Name</label>
                <input type="text" name="newnameplaylist" placeholder="Playlist's name" autocomplete="off">
                <input name="submit-playlist" type="submit" value="Edit Playlist">
            </form>
        </div>
        <div class="modal-deleteplaylist">
            <h2>Are you sure to delete this playlist?</h2>
            <div class="table-song">
                <div id='btn-delete-yes' class="btn-noncurrent">Yes</div>
                <form id="form-deletePlaylist" action="server/deletePlaylist.php" method="post"></form>
                <div id='btn-delete-no' class="btn-noncurrent">No</div>
            </div>
        </div>
    </div>

    <div class="page">
        <!-- Left -->
        <div class="left-part-page">
            <div class="home-search-container">
                <a href="index.php">
                    <div class="home-search"> <!-- SVG Home -->
                        <svg xmlns="http://www.w3.org/2000/svg" id="btn-home" class="icon" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z" />
                            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" id="btn-nothome" class="icon hidden" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                        </svg>
                        Home
                    </div>
                </a>
                <div class="home-search"> <!-- SVG Search -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                    <input type="text" id="search-item" placeholder="Search" autocomplete="off" <?php if (!isset($_SESSION['username'])) echo "class='none-input'"; ?>>
                </div>
            </div>

            <!-- Library -->
            <div class="library">
                <div class="header-library">
                    <div class="mylibrary"> <!-- SVG Library -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="currentColor">
                            <path d="M3 22a1 1 0 0 1-1-1V3a1 1 0 0 1 2 0v18a1 1 0 0 1-1 1zM15.5 2.134A1 1 0 0 0 
                                    14 3v18a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V6.464a1 1 0 0 0-.5-.866l-6-3.464zM9 2a1 1 0 0 0-1 1v18a1 1 0 1 0 2 0V3a1 1 0 0 0-1-1z">
                            </path>
                        </svg>
                        <span> Your Library </span>
                    </div>
                    <div>
                        <!-- SVG New Playlist -->
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo "<svg xmlns='http://www.w3.org/2000/svg' class='icon' id='btnCreatePlaylist' fill='currentColor' viewBox='0 0 16 16'>";
                            echo "<path fill-rule='evenodd' d='M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2'/>";
                            echo "</svg><div class='overlay-newp'>Create new playlist</div>";
                        }
                        ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                        </svg>
                    </div>
                </div>

                <nav class="filter-myplaylist">
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo "<div id='btn-playlists' class='btn-current'> Playlists </div>";
                        echo "<div id='btn-events' class='btn-noncurrent'> Events </div>";
                    } else {
                        echo "<div id='btn-events' class='btn-current'> Events </div>";
                    }
                    ?>
                </nav>
                <div class="container-overflow">
                    <div class="search-playlist"> <!-- SVG Search -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                        <span class="recents">
                            Recents
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                            </svg>
                        </span>
                    </div>
                    <div class="myplaylist-container">
                        <div id="playlist-list">
                            <div id="favourite" class="myplaylist-item" <?php if (!isset($_SESSION["username"])) echo "style='display:none'"; ?>>
                                <img class="myplaylist-img" src="images/favourite.png">
                                <div class="myplaylist-desc">
                                    <strong> Liked Song </strong>
                                    <span> Playlist </span>
                                </div>
                            </div>
                            <?php
                            if (isset($_SESSION["username"])) {
                                $query_playlist = "SELECT * FROM account JOIN playlist ON idAccount = codAccount WHERE codAccount = '" . $row["idAccount"] . "'";
                                $result_playlist = mysqli_query($conn, $query_playlist);
                                if (mysqli_num_rows($result_playlist) > 0) {
                                    while ($row_playlist = mysqli_fetch_assoc($result_playlist)) {
                                        echo "<div id=" . $row_playlist["idPlaylist"] . " class='myplaylist-item'>";
                                        if ($row_playlist["img"] == NULL) {
                                            echo "<img class='myplaylist-img' src='images/default.png'>";
                                        } else {
                                            echo "<img class='myplaylist-img' src=data:image/png;base64," . $row_playlist["img"] . ">";
                                        }
                                        echo "<div class='myplaylist-desc'><strong>" . $row_playlist["title"] . "</strong>";
                                        echo "<span>Playlist</span>";
                                        echo "</div></div>";
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div id="event-list" <?php if (isset($_SESSION['username'])) echo "class='hidden'"; ?>></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right -->
        <div class="right-part-page">
            <!-- Header -->
            <div class="scrollbar-fixed">
                <header>
                    <div class="header-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" id="left-arrow" fill="currentColor" class="icon bg-icon-header" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" id="right-arrow" fill="currentColor" class="icon bg-icon-header" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </div>
                    <div class="header-account">
                        <?php
                        if (isset($_SESSION["username"])) {
                            echo "<svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' class='icon bg-icon-header' viewBox='0 0 16 16'>";
                            echo "<path d='M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6' />";
                            echo "</svg>";
                            echo "<div class='overlay-bell'>What's new</div>";
                            if ($row["profilepic"] != NULL) {
                                echo "<img class='icon bg-icon-header' id='btn-account' src=data:image/png;base64," . $row["profilepic"] . ">";
                            } else {
                                echo "<svg xmlns='http://www.w3.org/2000/svg' id='btn-account' fill='currentColor' class='icon bg-icon-header' viewBox='0 0 16 16'>";
                                echo "<path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0' />";
                                echo "<path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1' />";
                                echo "</svg>";
                            }
                            echo "<div class='overlay-account'>" . $row["name"] . "</div>";
                        } else {
                            echo "<a href='signup.php'>Sign up</a>";
                            echo "<a href='login.php' class='btn-login'>Log in</a>";
                        }
                        ?>
                        <div class="overlay-click-account hidden">
                            <div class="flex-account image">
                                <form id="form-imgaccount" action="server/updateImageAccount.php" method="post" enctype="multipart/form-data">
                                    <label for="imgaccount"> Set Account Image </label>
                                    <input type="file" name="imgaccount" class="hidden" accept="image/png, image/jpeg">
                                </form>
                                <svg xmlns=" http://www.w3.org/2000/svg" class="icon" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5" />
                                    <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z" />
                                </svg>
                            </div>
                            <div class="flex-account">
                                Set up your Family plan
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5" />
                                    <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z" />
                                </svg>
                            </div>
                            <div> Profile </div>
                            <div> Settings </div>
                            <div class="account-last-div"><a href="logout.php">Log out</a></div>
                        </div>
                    </div>
                </header>
                <nav class="filter-mynav">
                    <div class="btn-current"> All </div>
                    <div class="btn-noncurrent"> Music </div>
                    <div class="btn-noncurrent"> Podcasts </div>
                </nav>
            </div>

            <!-- Home -->
            <div class="home">

                <!-- Search song or an album -->
                <div id="div-search" class="hidden">
                    <div class="home-section">
                        <div class="home-section-title">
                            <h2></h2>
                            <select name="filter-search">
                                <option value="none" disabled selected> Filter Search </option>
                                <option value="tracks"> Only Tracks </option>
                                <option value="albums"> Only Albums </option>
                                <option value="all"> All </option>
                            </select>
                        </div>
                        <div class="home-section-list"></div>
                    </div>

                    <div class="flex-icon-search hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="lightgray" class="icon heart-song" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                        </svg>
                        <select class="addplaylist-select">
                            <option disabled selected> Add to a playlist </option>
                            <?php
                            if (isset($_SESSION["username"])) {
                                $query_playlist_select = "SELECT * FROM account JOIN playlist ON idAccount = codAccount WHERE codAccount = '" . $row["idAccount"] . "'";
                                $result_playlist_select = mysqli_query($conn, $query_playlist_select);
                                if (mysqli_num_rows($result_playlist_select) > 0) {
                                    while ($row_playlist_select = mysqli_fetch_assoc($result_playlist_select)) {
                                        echo "<option value='" . $row_playlist_select["idPlaylist"] . "'>" . $row_playlist_select["title"] . "</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- User's Playlist View -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="lightgray" class="icon heart-playlist hidden" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                </svg>
                <div id="div-playlist-user" class="hidden">
                    <div class="home-section">
                        <div class="playlist-title">
                            <img class="playlist-title-img">
                            <div class='overlay-img'>Edit this photo</div>
                            <form id="form-imgplaylist" action="server/updateImagePlaylist.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="imgplaylist" class="hidden" accept="image/png, image/jpeg">
                            </form>
                            <div class="playlist-subtitle">
                                <div class="playlist-flex-img-account">
                                    <?php
                                    if ($row["profilepic"] != NULL) {
                                        echo "<img class='icon' id='btn-account' src=data:image/png;base64," . $row["profilepic"] . ">";
                                    } else {
                                        echo "<svg xmlns='http://www.w3.org/2000/svg' id='btn-account' fill='currentColor' class='icon' viewBox='0 0 16 16'>";
                                        echo "<path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0' />";
                                        echo "<path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1' />";
                                        echo "</svg>";
                                    }
                                    echo $_SESSION["username"]
                                    ?>
                                </div>
                                <div class="subtitle"></div>
                            </div>
                        </div>
                        <div class="playlist-button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#1ed760" class="icon playlist-button-svg" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814z" />
                            </svg>
                            <div class="playlist-edit">
                                <span id="btnDeletePlaylist">
                                    Delete Playlist
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                    </svg>
                                </span>
                                <span id="btnEditPlaylist">
                                    Edit Playlist
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="table-title">
                            <span>#</span>
                            <span class="long-span">Title</span>
                            <span class="long-span">Album</span>
                            <span>Data added</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                            </svg>
                        </div>
                        <div class="container-song"></div>
                    </div>
                </div>

                <!-- Show All -->
                <div id="div-showall" class="hidden">
                    <div class="home-section">
                        <div class="home-section-title">
                            <h2></h2>
                        </div>
                        <div class="home-section-list"></div>
                    </div>
                </div>

                <!-- Playlist Default Section -->
                <div id="div-list">
                    <!-- Last 8 -->
                    <?php
                    if (isset($_SESSION["username"])) {
                        echo "<div class='last8'> </div>";
                    }
                    ?>
                    <!-- Made For You -->
                    <div id="madeforyou" class="home-section">
                        <div class="home-section-title">
                            <?php
                            if (isset($_SESSION["username"])) {
                                echo "<h2><strong>Made For " . $row['name'] . "</strong></h2>";
                            } else {
                                echo "<h2>Recommended Playlists</h2>";
                            }
                            ?>
                            <span>Show all</span>
                        </div>
                        <div class="home-section-list"></div>
                    </div>

                    <!-- New Releases -->
                    <div id="newreleases" class="home-section">
                        <div class="home-section-title">
                            <h2>New releases for you</h2>
                            <span>Show all</span>
                        </div>
                        <div class="home-section-list"></div>
                    </div>

                    <!-- Popular -->
                    <div id="popular" class="home-section">
                        <div class="home-section-title">
                            <h2>Popular Playlists</h2>
                            <span>Show all</span>
                        </div>
                        <div class="home-section-list"></div>
                    </div>

                </div>

                <!-- Footer -->
                <footer>
                    <div class="footer-list">
                        <div class="footer-list-item">
                            <strong> Company </strong>
                            <span> About </span>
                            <span> Jobs </span>
                            <span> For the Record </span>
                        </div>
                        <div class="footer-list-item">
                            <strong> Communities </strong>
                            <span> Artists </span>
                            <span> Developers </span>
                            <span> Advertising </span>
                            <span> Investors</span>
                            <span> Vendors </span>
                        </div>
                        <div class="footer-list-item">
                            <strong> Useful links </strong>
                            <span> Support </span>
                            <span> Free Mobile App </span>
                            <span> Consumer rights </span>
                        </div>
                        <div class="footer-list-item">
                            <strong> Spotify Plans </strong>
                            <span> Premium Individual </span>
                            <span> Premium Duo </span>
                            <span> Premium Family </span>
                            <span> Premium Student </span>
                            <span> Spotify Free </span>
                        </div>
                        <div class="footer-list-item social">
                            <a href="https://www.instagram.com/spotify" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon bg-icon-footer" viewBox="0 0 16 16">
                                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                                </svg>
                            </a>
                            <a href="https://twitter.com/spotify" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon bg-icon-footer" viewBox="0 0 16 16">
                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518 3.3 3.3 0 0 0 1.447-1.817 6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429 3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218 3.2 3.2 0 0 1-.865.115 3 3 0 0 1-.614-.057 3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15" />
                                </svg>
                            </a>
                            <a href="https://www.facebook.com/SpotifyItalia/?brand_redir=6243987495" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon bg-icon-footer" viewBox="0 0 16 16">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="footer-bottom">
                        <div>
                            <span>Legal</span>
                            <span>Safety & Privacy Center</span>
                            <span>Privacy Policy</span>
                            <span>Cookie Settings</span>
                            <span>About Ads</span>
                            <span>Accessibility</span>
                        </div>
                        <span>© 2024 Spotify AB<span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Reproduction -->
    <div <?php
            if (!isset($_SESSION["username"])) {
                echo "class='hidden'";
            } else {
                echo "class='reprod'";
            }
            ?>>
        <div class="reprod-song">
            <img src="images/default.png">
            <div class="reprod-song-name">
                <strong>Click a track!</strong>
                <span></span>
            </div>
        </div>
        <div class="reprod-play">
            <div class="reprod-play-buttons">
                <svg fill="#1ed760" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M0 3.5A.5.5 0 0 1 .5 3H1c2.202 0 3.827 1.24 4.874 2.418.49.552.865 1.102 1.126 1.532.26-.43.636-.98 1.126-1.532C9.173 4.24 10.798 3 13 3v1c-1.798 0-3.173 1.01-4.126 2.082A9.6 9.6 0 0 0 7.556 8a9.6 9.6 0 0 0 1.317 1.918C9.828 10.99 11.204 12 13 12v1c-2.202 0-3.827-1.24-4.874-2.418A10.6 10.6 0 0 1 7 9.05c-.26.43-.636.98-1.126 1.532C4.827 11.76 3.202 13 1 13H.5a.5.5 0 0 1 0-1H1c1.798 0 3.173-1.01 4.126-2.082A9.6 9.6 0 0 0 6.444 8a9.6 9.6 0 0 0-1.317-1.918C4.172 5.01 2.796 4 1 4H.5a.5.5 0 0 1-.5-.5" />
                    <path d="M13 5.466V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192m0 9v-3.932a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                    <path d="M4 4a.5.5 0 0 1 1 0v3.248l6.267-3.636c.54-.313 1.232.066 1.232.696v7.384c0 .63-.692 1.01-1.232.697L5 8.753V12a.5.5 0 0 1-1 0z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                    <path d="M12.5 4a.5.5 0 0 0-1 0v3.248L5.233 3.612C4.693 3.3 4 3.678 4 4.308v7.384c0 .63.692 1.01 1.233.697L11.5 8.753V12a.5.5 0 0 0 1 0z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                    <path d="M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192m3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z" />
                </svg>
            </div>
            <div class="reprod-buttons">
                <span> 0:00 </span>
                <input type="range" class="reprod-bar volume-slider">
                <span id="reprod-ms-final"> 0:00 </span>
            </div>
        </div>
        <div class="reprod-buttons">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                <path d="M6 10.117V5.883a.5.5 0 0 1 .757-.429l3.528 2.117a.5.5 0 0 1 0 .858l-3.528 2.117a.5.5 0 0 1-.757-.43z" />
                <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                <path d="M13.426 2.574a2.831 2.831 0 0 0-4.797 1.55l3.247 3.247a2.831 2.831 0 0 0 1.55-4.797zM10.5 8.118l-2.619-2.62A63303.13 63303.13 0 0 0 4.74 9.075L2.065 12.12a1.287 1.287 0 0 0 1.816 1.816l3.06-2.688 3.56-3.129zM7.12 4.094a4.331 4.331 0 1 1 4.786 4.786l-3.974 3.493-3.06 2.689a2.787 2.787 0 0 1-3.933-3.933l2.676-3.045 3.505-3.99z">
                </path>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                <path d="M15 15H1v-1.5h14V15zm0-4.5H1V9h14v1.5zm-14-7A2.5 2.5 0 0 1 3.5 1h9a2.5 2.5 0 0 1 0 5h-9A2.5 2.5 0 0 1 1 3.5zm2.5-1a1 1 0 0 0 0 2h9a1 1 0 1 0 0-2h-9z">
                </path>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                <path d="M8 1a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1zm1 13.5a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0m2 0a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0M9.5 1a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM9 3.5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 0-1h-5a.5.5 0 0 0-.5.5M1.5 2A1.5 1.5 0 0 0 0 3.5v7A1.5 1.5 0 0 0 1.5 12H6v2h-.5a.5.5 0 0 0 0 1H7v-4H1.5a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5H7V2z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                <path d="M16 2.45c0-.8-.65-1.45-1.45-1.45H1.45C.65 1 0 1.65 0 2.45v11.1C0 14.35.65 15 1.45 15h5.557v-1.5H1.5v-11h13V7H16V2.45z">
                </path>
                <path d="M15.25 9.007a.75.75 0 0 1 .75.75v4.493a.75.75 0 0 1-.75.75H9.325a.75.75 0 0 1-.75-.75V9.757a.75.75 0 0 1 .75-.75h5.925z">
                </path>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                <path d="M11.536 14.01A8.47 8.47 0 0 0 14.026 8a8.47 8.47 0 0 0-2.49-6.01l-.708.707A7.48 7.48 0 0 1 13.025 8c0 2.071-.84 3.946-2.197 5.303z" />
                <path d="M10.121 12.596A6.48 6.48 0 0 0 12.025 8a6.48 6.48 0 0 0-1.904-4.596l-.707.707A5.48 5.48 0 0 1 11.025 8a5.48 5.48 0 0 1-1.61 3.89z" />
                <path d="M8.707 11.182A4.5 4.5 0 0 0 10.025 8a4.5 4.5 0 0 0-1.318-3.182L8 5.525A3.5 3.5 0 0 1 9.025 8 3.5 3.5 0 0 1 8 10.475zM6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06" />
            </svg>
            <input type="range" class="volume-slider">
            <svg xmlns="http://www.w3.org/2000/svg" id="full-screen" fill="currentColor" class="icon" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707m4.344-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707" />
            </svg>
        </div>
    </div>
    </div>

    <div <?php
            if (isset($_SESSION["username"])) {
                echo "class='hidden'";
            } else {
                echo "class='signup-div'";
            }
            ?>>
        <div class='myplaylist-desc'>
            <strong>Preview of Spotify</strong>
            <span>Sign up to get unlimited songs and podcasts with occasional ads. No credit card needed.</span>
        </div>
        <a href='signup.php' class='btn-login'> Sign up free</a>
    </div>
</body>

</html>