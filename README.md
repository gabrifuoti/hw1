# Homework Web Programming 2024 - Spotify
Written using HTML, CSS, JavaScript, PHP and API REST. I also used bootstrap for the buttons' icon

# Description
I tried to recreate Spotify's functionality (https://open.spotify.com/) like Signin, Login, Create and Delete Playlist, Liked a song, and Search an album or track.

# API
I used:
  1. Spotify's API for searching an album or a tracks by input text and playlist by Spotify to fill the home page 
  2. Ticketmaster's API to output a list of event in the following week.

# MAIN FOLDER
| File | Description |
|-|-|
| forgotPassword.php | code for the forgot password section |
| index.php | home page |
| login.php | code for the user login section |
| logout.php | session_destroy for the user logout |
| signup.php | code for the user signup section | 

# JS FOLDER
| File | Description |
|-|-|
| fillHomeSpotify.js | js functions for the filling of the home page with default playlist of Spotify and Ticketmaster |
| index.js | js functions for the home page, like showing playlist and search a song |
| showItem.js | js functions for the search of an album or a track function of spotify |
| showPassword.js | single js function for showing Password in signup and login pages, clicking the svg eye button |
| showPlaylist.js | js functions for the view of a single playlist and its songs |
| showReproduction.js | js functions for the dinamic view of the reproduction part when its clicked a track |
| signup.js | js functions for form fields' validation | 

# SERVER FOLDER
| File | Description |
|-|-|
| addFavouriteSong.php | query to insert a song on the favourite ones |
| addPlaylist.php | query to insert a new playlist |
| addSongPlaylist.php | query to insert a song in a selected playlist |
| autenticationSpotify.php | REST API with Spotify credentials and authenticate |
| autenticationTicketMaster.php | REST API with Ticketmaster credentials and authenticate |
| checkEmail.php | query to check if the insert email address already exist |
| checkFavourite.php | query to check if the song is on the favourite ones so I can edit the color of the like button |
| checkUsername.php | query to check if the insert username already exist |
| deleteFavouriteSong.php | query to delete a song from the favourite ones |
| deletePlaylist.php | query to delete a playlist |
| deleteSongPlaylist.php | query to insert a song in a selected playlist |
| fillHomeSpotify.php | REST API to show all default Spotify's playlist |
| searchItem.php | REST API to search a song or a track from an insert text |
| showPlaylist.php | query to show all the user's playlists |
| showSongPlaylist.php | REST API to get all the song of a playlist |
| updateImageAccount.php | query to update the profile image |
| updateImagePlaylist.php | query to update the playlist image |

# CSS FOLDER
| File | Description |
|-|-|
| forgot.css | style for forgot password page |
| index.css | style for the main home page |
| index_media.css | style for smartphone device view home page |
| leftpart.css | style for left part of home page |
| login.css | style for login page |
| playlistview.css | style for the view of a playlist |
| reproduction.css | style for the reproduction of a song part |
| rightpart.css | style for right part of home page |
| signup.css | style for the page about signup of a user|

# SQL FOLDER
| File | Description |
|-|-|
| config.php | setting connection at the database with default parameters |
| spotify.sql | spotify database extraction |
