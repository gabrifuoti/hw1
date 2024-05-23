function fullScreen() {
    if (document.documentElement.requestFullscreen) {
        document.documentElement.requestFullscreen();
    } 
    if (document.fullscreenElement) {
        document.exitFullscreen();
    }
}

function showOptionAccount(){
    if(document.querySelector(".overlay-click-account").classList.contains('hidden')){
        document.querySelector(".overlay-click-account").classList.remove('hidden'); 
    }
    else{
        document.querySelector(".overlay-click-account").classList.add('hidden'); 
    }
}

function showAll(event){
    const container = event.target.closest('.home-section');;

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
    
    document.querySelector("#div-list").classList.add('hidden');
    
    const title = document.querySelector("#div-showall .home-section-title h2");
    
    if(container.id == "madeforyou"){
        made4you(11);
        title.textContent = "Made for You"
    }
    else if(container.id == "newreleases"){
        newreleases(14);
        title.textContent = "New releases for you";
    }
    else if(container.id == "popular"){
        featuredplaylist(16);
        title.textContent = "Popular Playlists";
    }

    document.querySelector("#div-showall").classList.remove('hidden');
}

var lastpage;

function leftArrow(event){
    event.target.style.cursor = "not-allowed";
    event.target.style.backgroundColor = '#414141';
    event.target.removeEventListener("click", leftArrow);

    document.querySelector(".right-part-page").scrollTop = 0;
    document.querySelector(".left-part-page a").style.color = "white";
    document.querySelector(".filter-mynav").style.display = "flex";
    document.querySelector("#btn-home").classList.remove('hidden');
    document.querySelector("#btn-nothome").classList.add('hidden');
    document.querySelector("#div-list").className = '';
    document.querySelector("#search-item").value = '';
    
    if(!document.querySelector("#div-showall").classList.contains("hidden")){    
        document.querySelector("#div-showall").classList.add('hidden');
        lastpage = "div-showall";
    }

    if(!document.querySelector("#div-search").classList.contains("hidden")){    
        document.querySelector("#div-search").classList.add('hidden');
        lastpage = "div-search";
    }

    if(!document.querySelector("#div-playlist-user").classList.contains("hidden")){    
        document.querySelector("#div-playlist-user").classList.add('hidden');
        lastpage = "div-playlist-user";
    }
    
    const right_arrow = document.querySelector("#right-arrow");
    right_arrow.style.cursor = "pointer";
    right_arrow.style.backgroundColor = 'black';
    right_arrow.addEventListener("click", rightArrow);

}

function rightArrow(event){
    event.target.style.cursor = "not-allowed";
    event.target.style.backgroundColor = '#414141';
    event.target.removeEventListener("click", leftArrow);
    
    document.querySelector(".right-part-page").scrollTop = 0;
    document.querySelector(".left-part-page a").style.color = "lightgray";
    document.querySelector(".filter-mynav").style.display = "none";
    document.querySelector("#btn-home").classList.add('hidden');
    document.querySelector("#btn-nothome").classList.remove('hidden');
    document.querySelector("#div-list").classList.add('hidden');

    document.querySelector("#"+lastpage).className = ''; 
        
    const left_arrow = document.querySelector("#left-arrow");
    left_arrow.style.cursor = "pointer";
    left_arrow.style.backgroundColor = 'black';
    left_arrow.addEventListener("click", leftArrow);
}

function showModal(event){
    document.querySelector(".modal").classList.remove('hidden');
    
    if(!document.querySelector(".modal-createplaylist").classList.contains('hidden')){
        document.querySelector(".modal-createplaylist").classList.add('hidden');
    }
    if(!document.querySelector(".modal-editplaylist").classList.contains('hidden')){
        document.querySelector(".modal-editplaylist").classList.add('hidden');
    }
    if(!document.querySelector(".modal-deleteplaylist").classList.contains('hidden')){
        document.querySelector(".modal-deleteplaylist").classList.add('hidden');
    }

    if(event.target.id == "btnCreatePlaylist" ){
        if(document.querySelector(".modal-createplaylist").classList.contains('hidden')){
            document.querySelector(".modal-createplaylist").classList.remove('hidden');
        }
    }
    else if(event.target.id == "btnEditPlaylist" ){
        if(document.querySelector(".modal-editplaylist").classList.contains('hidden')){
            document.querySelector(".modal-editplaylist").classList.remove('hidden');
        }
        document.querySelector(".modal-editplaylist input[name='newnameplaylist']").value = document.querySelector(".subtitle h1").textContent; 
    }
    else if(event.target.id == "btnDeletePlaylist"){
        if(document.querySelector(".modal-deleteplaylist").classList.contains('hidden')){
            document.querySelector(".modal-deleteplaylist").classList.remove('hidden');
        }
    }
}

function closeModal(){
    document.querySelector(".modal").classList.add('hidden');
    
    if(!document.querySelector(".modal-createplaylist").classList.contains('hidden')){
        document.querySelector(".modal-createplaylist").classList.add('hidden');
    }
    
    if(!document.querySelector(".modal-deleteplaylist").classList.contains('hidden')){
        document.querySelector(".modal-deleteplaylist").classList.add('hidden');
    }

    if(!document.querySelector(".modal-editplaylist").classList.contains('hidden')){
        document.querySelector(".modal-editplaylist").classList.add('hidden');
    }
}

function loadImageAccount(){
    document.querySelector("#form-imgaccount").submit()
}

function loadImagePlaylist(){
    document.querySelector("#form-imgplaylist").submit()
}

function createPlaylist(event){
    event.preventDefault();
    document.querySelector('#form-playlist').submit();
}

function deletePlaylist(){
    document.querySelector(".modal-deleteplaylist").classList.add('hidden');
    document.querySelector('#form-deletePlaylist').submit();
}

function editPlaylist(){
    document.querySelector("#form-editplaylist").submit()
}

if(document.querySelector("#btn-account")){
    document.querySelector("#btn-account").addEventListener("click", showOptionAccount);
}

const showAll_MadeForYou = document.querySelectorAll("#madeforyou h2, #madeforyou span");
const showAll_NewReleases = document.querySelectorAll("#newreleases h2, #newreleases span");
const showAll_Popular = document.querySelectorAll("#popular h2, #popular span");

showAll_MadeForYou.forEach( element => { element.addEventListener('click', showAll) });
showAll_NewReleases.forEach( element => { element.addEventListener('click', showAll) });
showAll_Popular.forEach( element => { element.addEventListener('click', showAll) });


if(document.querySelector("#btnCreatePlaylist")){
    document.querySelector("#btnCreatePlaylist").addEventListener('click', showModal);
}

document.querySelector(".closemodal").addEventListener('click', closeModal);
document.querySelector("#close-modal-edit").addEventListener('click', closeModal);

document.querySelector("#btnDeletePlaylist").addEventListener('click', showModal);
document.querySelector("#btnEditPlaylist").addEventListener('click', showModal);
document.querySelector("#btn-delete-no").addEventListener('click', closeModal);
document.querySelector("#btn-delete-yes").addEventListener('click', deletePlaylist);


document.querySelector(".image").addEventListener('click', function() {
    document.querySelector('input[name="imgaccount"]').click();
});

document.querySelector('input[name="imgaccount"]').addEventListener('change', loadImageAccount);
document.querySelector('#form-playlist').addEventListener('submit', createPlaylist);

document.querySelector('#form-editplaylist').addEventListener('submit', editPlaylist);

document.querySelector(".playlist-title-img").addEventListener('click', function() {
    document.querySelector('input[name="imgplaylist"]').click();
});

document.querySelector('input[name="imgplaylist"]').addEventListener('change', loadImagePlaylist);

document.querySelector('#full-screen').addEventListener("click", fullScreen);