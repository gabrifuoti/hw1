function updateReproduction(json){
    const song = json;
    document.querySelector(".reprod-song img").src = json.album.images[0].url;
    document.querySelector(".reprod-song-name strong").textContent = song.name;
    let song_artist = song.artists[0].name;
    if(song.artists.length != 1){
        for(let j=1; j<song.artists.length; j++){
            song_artist += ', ' + song.artists[j].name;
        }
    }
    document.querySelector(".reprod-song-name span").textContent = song_artist;
    document.querySelector("#reprod-ms-final").textContent =  millisToMinutesAndSeconds(song.duration_ms);
}