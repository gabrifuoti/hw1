
function onSearchItemJson(json){
    let results;
    if(json.albums){
        results = json.albums.items;
    } else if(json.tracks){
        results = json.tracks.items;
    }

    if(json.albums && json.tracks){
        const albums = json.albums.items;
        const tracks = json.tracks.items;
        const searchResult = albums.concat(tracks);
        results = searchResult;
    }
    const container = document.querySelector('#div-search .home-section-list');
    container.innerHTML = '';

    for(let i=0; i<results.length; i++){
        const search = results[i];
        const item = document.createElement('div');
        item.classList.add('home-section-item');
        if(search.popularity){ 
            item.addEventListener('click', () => {
                updateReproduction(search);
            });
        }
        else{    
            item.addEventListener('click', () => {
                url = search.external_urls.spotify;
                window.open(url, '_blank');
            });
        }

        const img = document.createElement('img');
        img.classList.add('home-section-img');
        if(search.album){
            img.src = search.album.images[0].url;
        }else{        
            img.src = search.images[0].url;
        }

        const strong = document.createElement('strong');
        strong.textContent = search.name;

        const span = document.createElement('span');
        span.textContent = search.artists[0].name;
        if(search.artists.length != 1){
            for(let j=1; j<search.artists.length; j++){
                span.textContent += ', ' + search.artists[j].name;
            }
        }
        span.classList.add('home-section-desc');

        container.appendChild(item);
        item.appendChild(img);    
        item.appendChild(strong);
        item.appendChild(span);

        if(search.popularity){
            divSvg = document.querySelector('.flex-icon-search');
            const clonedFavourite = divSvg.cloneNode(true);
            clonedFavourite.classList.remove('hidden');

            fetch("./server/checkFavourite.php?id="+encodeURIComponent(search.id)).then(response => {
                return response.json();
            }).then(json => {
                const svgHeart = clonedFavourite.querySelector('.heart-song');
                if (json.exists){
                    svgHeart.setAttribute('fill','#1ed760');
                }
                svgHeart.addEventListener('click', (event) => {
                    event.stopPropagation();
                    if(svgHeart.getAttribute('fill') == '#1ed760'){
                        svgHeart.setAttribute('fill','lightgray');
                        fetch("./server/deleteFavouriteSong.php?id="+encodeURIComponent(search.id))
                    }
                    else{
                        svgHeart.setAttribute('fill','#1ed760');
                        fetch("./server/addFavouriteSong.php?id="+encodeURIComponent(search.id))
                    }
                });
            });

            clonedFavourite.querySelector('.addplaylist-select').addEventListener('change', (event) => {
                event.stopPropagation();
                const idPlaylist = clonedFavourite.querySelector('.addplaylist-select').value;
                fetch("./server/addSongPlaylist.php?idPlaylist="+encodeURIComponent(idPlaylist)+"&idSong="+encodeURIComponent(search.id))
            });;

            item.appendChild(clonedFavourite);
        }
    }
}

function onSearchItemResponse(response){
    return response.json();
}

function searchItem(){
    const item_input = document.querySelector('#search-item');
    const item_value = encodeURIComponent(item_input.value);
    const filter = document.querySelector('select[name="filter-search"]');

    document.querySelector(".right-part-page").scrollTop = 0;
    document.querySelector(".left-part-page a").style.color = "lightgray";
    document.querySelector(".filter-mynav").style.display = "none";
    document.querySelector("#btn-home").classList.add('hidden');
    document.querySelector("#btn-nothome").classList.remove('hidden');

    if(!document.querySelector("#div-playlist-user").classList.contains('hidden')){
        document.querySelector("#div-playlist-user").classList.add('hidden');
    }
    if(!document.querySelector("#div-showall").classList.contains('hidden')){
        document.querySelector("#div-showall").classList.add('hidden');
    }

    const left_arrow = document.querySelector("#left-arrow");
    left_arrow.style.cursor = "pointer";
    left_arrow.style.backgroundColor = 'black';
    left_arrow.addEventListener("click", leftArrow);

    const right_arrow = document.querySelector("#right-arrow");
    right_arrow.style.cursor = "not-allowed";
    right_arrow.style.backgroundColor = '#414141';
    right_arrow.removeEventListener("click", rightArrow);

    document.querySelector("#div-list").classList.add('hidden');
    document.querySelector("#div-search").classList.remove('hidden');
    
    if(item_input.value){
        let type = "";
        if(filter.value == "all" || filter.value == "none"){
            type = "album%2Ctrack";
        }
        else if(filter.value == "albums"){
            type = "album";
        }
        else if(filter.value == "tracks"){
            type = "track";
        }
        document.querySelector("#div-search .home-section-title h2").innerHTML = "Searching of "+item_input.value;
        document.querySelector("#div-search .home-section-list").innerHTML = '';
        fetch("./server/searchItem.php?q="+encodeURIComponent(item_value)+"&type="+encodeURIComponent(type)).then(onSearchItemResponse).then(onSearchItemJson);
    }
    else{
        document.querySelector("#div-list").classList.remove('hidden');
        document.querySelector("#div-search").classList.add('hidden');
    }
}

if(document.querySelector('#search-item').classList != 'none-input'){
    document.querySelector('#search-item').addEventListener('input', searchItem);
}
document.querySelector('select[name="filter-search"]').addEventListener('change', searchItem);