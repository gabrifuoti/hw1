//LAST 8
function onLast8Json(json){
    const last8 = document.querySelector('.last8');
    const results = json.playlists.items;
    for(let i=0; i<8; i++){
        const playlist = results[i];
        const item = document.createElement('div');
        item.classList.add('last8-item');
        item.addEventListener('click', () => {
            url = playlist.external_urls.spotify;
            window.open(url, '_blank');
        });
        
        const img = document.createElement('img');
        img.classList.add('last8-img');
        img.src = playlist.images[0].url;
        
        const strong = document.createElement('strong');
        strong.textContent = playlist.name;

        last8.appendChild(item);
        item.appendChild(img);    
        item.appendChild(strong);
    }
}

function onLast8Response(response){
    return response.json();
}

//MADE FOR YOU
function onMadeForYouJson(json){
    let madeforyou;
    if(json.playlists.limit == 6){
        madeforyou = document.querySelector('#madeforyou .home-section-list');
    }
    else if(json.playlists.limit == 11){
        madeforyou = document.querySelector('#div-showall .home-section-list');
        madeforyou.innerHTML = '';
    }

    const results = json.playlists.items;
    for(let i=0; i<json.playlists.limit; i++){
        const playlist = results[i];
        const item = document.createElement('div');
        item.classList.add('home-section-item');
        item.addEventListener('click', () => {
            url = playlist.external_urls.spotify;
            window.open(url, '_blank');
        });
        
        const img = document.createElement('img');
        img.classList.add('home-section-img');
        img.src = playlist.images[0].url;
        
        const strong = document.createElement('strong');
        strong.textContent = playlist.name;

        const span = document.createElement('span');
        span.textContent = playlist.description;
        span.classList.add('home-section-desc');

        madeforyou.appendChild(item);
        item.appendChild(img);    
        item.appendChild(strong);
        item.appendChild(span);
    }
}

function onMadeForYouResponse(response){
    return response.json();
}

//NEW RELEASES
function onNewReleasesJson(json){
    let newreleases;
    if(json.albums.limit == 6){
        newreleases = document.querySelector('#newreleases .home-section-list');
    }
    else if(json.albums.limit == 14){
        newreleases = document.querySelector('#div-showall .home-section-list');
        newreleases.innerHTML = '';
    }

    const results = json.albums.items;
    for(let i=0; i<json.albums.limit; i++){
        const album = results[i];
        const item = document.createElement('div');
        item.classList.add('home-section-item');
        item.addEventListener('click', () => {
            url = album.external_urls.spotify;
            window.open(url, '_blank');
        });
        
        const img = document.createElement('img');
        img.classList.add('home-section-img');
        img.src = album.images[0].url;
        
        const strong = document.createElement('strong');
        strong.textContent = album.name;

        const span = document.createElement('span');
        span.textContent = album.artists[0].name;
        if(album.artists.length != 1){
            for(let j=1; j<album.artists.length; j++){
                span.textContent += ', ' + album.artists[j].name;
            }
        }
        span.classList.add('home-section-desc');

        newreleases.appendChild(item);
        item.appendChild(img);    
        item.appendChild(strong);
        item.appendChild(span);
    }
}

function onNewReleasesResponse(response){
    return response.json();
}

//POPULAR PLAYLIST
function onPopularPlaylistJson(json){
    let popular;
    if(json.playlists.limit == 6){
        popular = document.querySelector('#popular .home-section-list');
    }
    else if(json.playlists.limit == 16){
        popular = document.querySelector('#div-showall .home-section-list');
        popular.innerHTML = '';
    }

    const results = json.playlists.items;
    for(let i=0; i<json.playlists.limit; i++){
        const playlist = results[i];
        const item = document.createElement('div');
        item.classList.add('home-section-item');
        item.addEventListener('click', () => {
            url = playlist.external_urls.spotify;
            window.open(url, '_blank');
        });
        
        const img = document.createElement('img');
        img.classList.add('home-section-img');
        img.src = playlist.images[0].url;
        
        const strong = document.createElement('strong');
        strong.textContent = playlist.name;

        const span = document.createElement('span');
        span.textContent = playlist.description;
        span.classList.add('home-section-desc');

        popular.appendChild(item);
        item.appendChild(img);    
        item.appendChild(strong);
        item.appendChild(span);
    }
}

function onPopularPlaylistResponse(response){
    return response.json();
}

function onTokenJson(json){
    if(document.querySelector('.last8')){
        last8(8);
    }
    made4you(6);
    newreleases(6);
    featuredplaylist(6);
}

function onTokenResponse(response){
    return response.json();
}

function onEventJson(json){
    const events = json._embedded.attractions;
    const container = document.querySelector('#event-list');

    for(let i=0; i<8; i++){
        const event = events[i];
        const item = document.createElement('div');
        item.classList.add('myevent-item');
        item.addEventListener('click', () => {
            url = event.url;
            window.open(url, '_blank');
        });

        const img = document.createElement('img');
        img.classList.add('myplaylist-img');
        img.src = event.images[0].url;

        const desc = document.createElement('div');
        desc.classList.add('myplaylist-desc');

        const strong = document.createElement('strong');
        strong.textContent = event.name;  
        
        const span = document.createElement('span');
        span.textContent = event.classifications[0].genre.name;

        container.appendChild(item);
        item.appendChild(img);    
        item.appendChild(desc);
        desc.appendChild(strong);
        desc.appendChild(span);
    }
}

function onEventResponse(response){
    return response.json();
}

fetch("./server/authenticationSpotify.php").then(onTokenResponse).then(onTokenJson);
fetch("./server/authenticationTicketMaster.php").then(onEventResponse).then(onEventJson);

function last8(limit){
    param = "last8";
    fetch("./server/fillHomeSpotify.php?p="+encodeURIComponent(param)+"&limit="+encodeURIComponent(limit)).then(onLast8Response).then(onLast8Json);
}

function made4you(limit){
    param = "m4y";
    fetch("./server/fillHomeSpotify.php?p="+encodeURIComponent(param)+"&limit="+encodeURIComponent(limit)).then(onMadeForYouResponse).then(onMadeForYouJson);
}

function newreleases(limit){
    param = "newreleases";
    fetch("./server/fillHomeSpotify.php?p="+encodeURIComponent(param)+"&limit="+encodeURIComponent(limit)).then(onNewReleasesResponse).then(onNewReleasesJson);
}

function featuredplaylist(limit){    
    param = "popular";
    fetch("./server/fillHomeSpotify.php?p="+encodeURIComponent(param)+"&limit="+encodeURIComponent(limit)).then(onPopularPlaylistResponse).then(onPopularPlaylistJson);
}

function showRelativeDiv(event) {
    const btn_clicked = event.target;
    
    btn_clicked.className = '';
    document.querySelector('#btn-events').className = '';
    document.querySelector('#btn-playlists').className = '';
    document.querySelector('#playlist-list').className = '';
    document.querySelector('#event-list').className = '';

    if(btn_clicked.id == "btn-playlists"){
        btn_clicked.classList.add('btn-current');
        document.querySelector('#btn-events').classList.add('btn-noncurrent');
        document.querySelector('#event-list').classList.add('hidden');
    }
    else if(btn_clicked.id == "btn-events"){
        btn_clicked.classList.add('btn-current');
        document.querySelector('#btn-playlists').classList.add('btn-noncurrent');
        document.querySelector('#playlist-list').classList.add('hidden');
    }
}

if(document.querySelector("#btn-playlists")){
    document.querySelector('#btn-playlists').addEventListener('click', showRelativeDiv);
}
document.querySelector('#btn-events').addEventListener('click', showRelativeDiv);