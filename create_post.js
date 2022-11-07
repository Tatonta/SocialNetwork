function modalClose() {
    modalView.classList.add('hidden');
    document.body.classList.remove('no-scroll');
}


function onThumbClick(event) {
    
    modalView.classList.remove('hidden');
    modalView.style.top = window.pageYOffset + 'px';
    
    document.body.classList.add('no-scroll');
    
    const titolo = event.currentTarget.querySelector('span');
    let cont = event.currentTarget.querySelector('img');
    


    if (cont === null){//se non è immagine
        cont = event.currentTarget.querySelector('audio');
        if (cont === null) { // Video youtube
            cont = event.currentTarget.querySelector('iframe');
            module.choose.value = cont.src;
            module.type.value = "iframe";
        } else { 
            module.choose.value = cont.src;
            module.type.value = "audio";

        }
        
    } 
    else if (cont.naturalWidth < 10){ // Immagine non disponibile
        module.choose.value = "cont/default.png";
        module.type.value = "img";
    } 
    else{
        module.choose.value = cont.src;
        module.type.value = "img";
    }

}

function music(json) {
    console.log("JSON Spotify");
    const library = document.querySelector('#result');
    library.innerHTML = '';
    let num_results = json.tracks.limit;
    
    if(num_results > 12)
        num_results = 12;
        
    for(let i=0; i<num_results; i++) {
        const doc = json.tracks.items[i];
        const title = doc.name + " di " + doc.artists[0].name;
        const id = doc.id;
        const cont = document.createElement('iframe');
        cont.src = "https://open.spotify.com/embed/track/" + id;
        
		const book = document.createElement('div');
		book.appendChild(cont);


        const caption = document.createElement('span');
        caption.textContent = title;

        /*
        let preview = doc.preview_url;
        
        
        
        if (preview === null) {
            preview = doc.album.images[0].url;
            const cont = document.createElement('img');
            cont.src = preview;
            cont.id= id;
            book.appendChild(cont);
            console.log(preview);
            
        } else {
            const music = document.createElement('audio');
            music.controls = true;
            music.src = preview;
            book.appendChild(music);
            
        }
        */
        
        
        book.appendChild(caption);
        library.appendChild(book);
        
        book.addEventListener('click',onThumbClick);
    }
} 

function gif(json) {
    console.log(json);

    console.log('JSON Giphy');
    const library = document.querySelector('#result');
    library.innerHTML = '';
    let num_results = json.pagination.count;
    if(num_results > 12)
        num_results = 12;
        for(let i=0; i<num_results; i++) {
            const doc = json.data[i];
            const title = doc.title;
        const cover_url = doc.images.downsized_large.url;
        const id = doc.id;
        
        const book = document.createElement('div');
        const cont = document.createElement('img');
        
        cont.src = cover_url;
        cont.id= id; //  DA SISTEMARE
        
        const caption = document.createElement('span');
        caption.textContent = title;
        
        book.appendChild(cont);
        book.appendChild(caption);
        library.appendChild(book);
        
        book.addEventListener('click',onThumbClick);
    }
}

function video(json) {
    console.log(json);
    
    console.log('JSON Youtube');
    const library = document.querySelector('#result');
    library.innerHTML = '';
    let num_results = json.pageInfo.resultsPerPage;
    if(num_results > 12)
    num_results = 12;
    for(let i=0; i<num_results; i++) {
        const doc = json.items[i];
        const title = doc.snippet.title;
        const id = doc.id.videoId;
        const link = "http://www.youtube.com/embed/"+ id;
        const book = document.createElement('div');
        const cont = document.createElement('iframe');
        
        cont.src = link;
        cont.setAttribute("allowfullscreen", "");
        cont.id= id;
        
        console.log(unescape(title));
        const caption = document.createElement('span');
        caption.textContent = title;
        
        book.appendChild(cont);
        book.appendChild(caption);
        library.appendChild(book);
        
        book.addEventListener('click',onThumbClick);
    }
}

function movie(json) {
    console.log(json);
    
    console.log('JSON TmDB');
    const library = document.querySelector('#result');
    library.innerHTML = '';
    let num_results = json.total_results;
    if(num_results > 12)
        num_results = 12;
        console.log(num_results);
        for(let i=0; i<num_results; i++) {
        const doc = json.results[i];
        const title = doc.original_title;
        const poster = doc.poster_path;
        console.log(poster);
        if (poster != null)
            poster_url = 'https://image.tmdb.org/t/p/w500' + poster;
            else
            poster_url ="img/default.png";
        const book = document.createElement('div');
        const cont = document.createElement('img');
        
        cont.src = poster_url;
        cont.id= title;
        
        const caption = document.createElement('span');
        caption.textContent = title;
        
        book.appendChild(cont);
        book.appendChild(caption);
        library.appendChild(book);
        
        book.addEventListener('click',onThumbClick);
    }
}


function library(json) {

    console.log('JSON Libreria');
    const library = document.querySelector('#result');
    library.innerHTML = '';
    let num_results = json.num_found;
    if(num_results > 12)
    num_results = 12;
    for(let i=0; i<num_results; i++) {
        const doc = json.docs[i];
        const title = doc.title;
        const isbn = doc.isbn[0];
        const cover_url = 'http://covers.openlibrary.org/b/isbn/' + isbn + '-M.jpg';

        const book = document.createElement('div');
        const cont = document.createElement('img');

        cont.src = cover_url;
        cont.id= title;
        
        const caption = document.createElement('span');
        caption.textContent = title;
        
        book.appendChild(cont);
        book.appendChild(caption);
        library.appendChild(book);
        
        book.addEventListener('click',onThumbClick);
    }
}

function onJson(json){
    const div = document.querySelector('.select');
    div.textContent = "Scegli un contenuto:";
    div.classList.remove('hidden');

    if (form.services.value == "library")
    library(json);
    else if (form.services.value == "movie")
    movie(json);
    else if (form.services.value == "video")
    video(json);
    else if (form.services.value == "gif")
    gif(json);
    else if (form.services.value == "music")
    music(json);
} 

function onResponse(response) {
    //console.log(response.text());
    return response.json();
}

function createPost(event) {
    const form_data = {method: 'post', body: new FormData(form)};
    console.log(form_data);
    fetch('http://localhost/homework1/do_search_content.php', form_data).then(onResponse).then(onJson);
    event.preventDefault();
    console.log("fetch");
}


const form = document.forms['create'];
// Aggiungi listener
form.addEventListener('submit', createPost);

const module = document.forms['ultimate'];
const modalView = document.querySelector('#modal');

const butt = document.getElementById('cancel');
butt.addEventListener('click',modalClose);