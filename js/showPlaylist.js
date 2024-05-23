function onShowPlaylistJson(json){
    const playlist = json;
    if(playlist[0].idFavourite){
        document.querySelector("#form-imgplaylist input").disabled = true;
        document.querySelector(".overlay-img").classList.add('hidden');
        document.querySelector(".playlist-edit").classList.add('hidden');
    
        const img = document.querySelector(".playlist-title-img");
        img.src = "images/favourite.png";
    
        const container_title = document.querySelector(".subtitle");
        const title = document.createElement('h1');
        title.innerHTML = "Liked Songs";  
    
        const span = document.createElement('span');
        var num_song = playlist.length;
        if(playlist[0].idFavourite == 0){
            num_song = 0;
        }
        span.textContent = num_song + " songs";

        container_title.appendChild(title);
        container_title.appendChild(span);
    }
    else{
        document.querySelector(".playlist-edit").classList.remove('hidden');
        document.querySelector("#form-imgplaylist input").disabled = false;
        if(document.querySelector(".overlay-img").classList.contains('hidden')){
            document.querySelector(".overlay-img").classList.remove('hidden');
        }
        
        const img = document.querySelector(".playlist-title-img");
        if(playlist[0].img){
            img.src = "data:image/png;base64,"+ playlist[0].img;
        }
        else{
            img.src = "images/default.png";
        }
    
        const container_title = document.querySelector(".subtitle");
        
        const title = document.createElement('h1');
        title.innerHTML = playlist[0].title;  
        const span = document.createElement('span');
        span.textContent = playlist[0].countSong + " songs";
        num_song = playlist[0].countSong;
        container_title.appendChild(title);
        container_title.appendChild(span);
    }

    document.querySelector(".container-song").innerHTML = '';

    if(playlist[0].countSong > 0){
        songsList = '';
        for (let i = 0; i < playlist.length; i++) {
            songsList += playlist[i].codSong + ",";
        }    
        fetch("./server/showSongPlaylist.php?ids="+encodeURIComponent(songsList))
        .then(response => response.json())
            .then(json => {    
                const container_song = document.querySelector(".container-song");
                const results = json.tracks;
                for(let i=0; i<results.length; i++){
                    const song = results[i];
                    if(song!=null){    
                        const item = document.createElement('div');
                        item.classList.add('table-song');
                        item.addEventListener('click', () => {
                            updateReproduction(song);
                        });
                        
                        const span_number = document.createElement('span');
                        span_number.textContent = i+1;

                        const container_song_name = document.createElement('div');
                        container_song_name.classList.add('song-div');

                        const img = document.createElement('img');
                        img.src = song.album.images[0].url;

                        const song_desc = document.createElement('div');
                        song_desc.classList.add('song-desc');
                        song_desc.classList.add('long-span');
                
                        const song_name = document.createElement('p');
                        song_name.textContent = song.name;

                        const song_artist = document.createElement('span');
                        song_artist.classList.add('long-span');
                        song_artist.textContent = song.artists[0].name;
                        if(song.artists.length != 1){
                            for(let j=1; j<song.artists.length; j++){
                                song_artist.textContent += ', ' + song.artists[j].name;
                            }
                        }
                        
                        container_song_name.appendChild(img);
                        container_song_name.appendChild(song_desc);
                        song_desc.appendChild(song_name);
                        song_desc.appendChild(song_artist);

                        divSvg = document.querySelector('.heart-playlist');
                        const clonedFavourite = divSvg.cloneNode(true);
                        clonedFavourite.classList.remove('hidden');
                        
                        fetch("./server/checkFavourite.php?id="+encodeURIComponent(song.id))
                        .then(response => {
                            return response.json();
                        }).then(json => {
                            if (json.exists){
                                clonedFavourite.setAttribute('fill','#1ed760');
                            }
                            clonedFavourite.addEventListener('click', (event) => {
                                event.stopPropagation();
                                if(clonedFavourite.getAttribute('fill') == '#1ed760'){
                                    clonedFavourite.setAttribute('fill','lightgray');
                                    fetch("./server/deleteFavouriteSong.php?id="+encodeURIComponent(song.id))
                                    if(playlist[0].idFavourite){
                                        container_song.removeChild(item);  
                                        if(num_song){
                                            num_song -= 1;
                                            document.querySelector(".subtitle span").textContent = (num_song) + " songs";
                                        }  
                                    }
                                }
                                else{
                                    clonedFavourite.setAttribute('fill','#1ed760');
                                    fetch("./server/addFavouriteSong.php?id="+encodeURIComponent(song.id))
                                }
                            });
                        });

                        container_song_name.appendChild(clonedFavourite);
                        
                        if(!playlist[0].idFavourite){ // solo nelle playlist, non nei preferiti
                            divSvg = document.querySelector('#btnDeletePlaylist svg');
                            const clonedDelete = divSvg.cloneNode(true);
                            clonedDelete.addEventListener('click', (event) => {
                                event.stopPropagation();
                                container_song.removeChild(item);  

                                if(num_song){
                                    num_song -= 1;
                                    document.querySelector(".subtitle span").textContent = (num_song) + " songs";
                                }
                                fetch("./server/deleteSongPlaylist.php?id="+encodeURIComponent(song.id));
                            });
                            container_song_name.appendChild(clonedDelete);
                        }


                        const span_album = document.createElement('span');
                        span_album.classList.add('long-span');
                        span_album.textContent = song.album.name;

                        const span_data = document.createElement('span');
                        span_album.classList.add('long-span');
                        span_data.textContent = playlist[i].data;

                        const span_duration = document.createElement('span');
                        span_duration.textContent =  millisToMinutesAndSeconds(song.duration_ms);
                                    
                        container_song.appendChild(item);
                        item.appendChild(span_number);
                        item.appendChild(container_song_name);
                        item.appendChild(span_album);
                        item.appendChild(span_data);
                        item.appendChild(span_duration);           
                    }
                }        
            });
    }
}

function millisToMinutesAndSeconds(millis) {
    var minutes = Math.floor(millis / 60000);
    var seconds = ((millis % 60000) / 1000).toFixed(0); //arrotondiamo al valore intero più vicino
    return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
}

function onShowPlaylistResponse(response){
    return response.json();
}

function showPlaylistView(event){
    document.querySelector(".right-part-page").scrollTop = 0;
    document.querySelector(".left-part-page a").style.color = "lightgray";
    document.querySelector(".filter-mynav").style.display = "none";
    document.querySelector("#btn-home").classList.add('hidden');
    document.querySelector("#btn-nothome").classList.remove('hidden');

    const left_arrow = document.querySelector("#left-arrow");
    left_arrow.style.cursor = "pointer";
    left_arrow.style.backgroundColor = 'black';
    left_arrow.addEventListener("click", leftArrow);

    const right_arrow = document.querySelector("#right-arrow");
    right_arrow.style.cursor = "not-allowed";
    right_arrow.style.backgroundColor = '#414141';
    right_arrow.removeEventListener("click", rightArrow);
    
    if(!document.querySelector("#div-list").classList.contains('hidden')){
        document.querySelector("#div-list").classList.add('hidden');
    }
    if(!document.querySelector("#div-showall").classList.contains('hidden')){
        document.querySelector("#div-showall").classList.add('hidden');
    }
    if(!document.querySelector("#div-search").classList.contains('hidden')){
        document.querySelector("#div-search").classList.add('hidden');
    }

    document.querySelector("#div-playlist-user").classList.remove('hidden');
    document.querySelector(".subtitle").innerHTML = '';
    
    const idPlaylist = event.target.closest('.myplaylist-item'); //problemi se cliccavo lo strong dentro al div
    fetch("./server/showPlaylist.php?id="+encodeURIComponent(idPlaylist.id)).then(onShowPlaylistResponse).then(onShowPlaylistJson);
}

document.querySelectorAll('.myplaylist-item').forEach( element => { element.addEventListener('click', showPlaylistView)});