const UNLIKED_IMG = "img/unliked.png"
const LIKED_IMG = "img/liked.png"

function goTop() {
    list.scrollTop = 0;
}

function onScroll() {
    console.log(butt);
    if (list.scrollTop > 20) {
        butt.classList.add('hidden');
    } else {
        butt.classList.remove('hidden');
    }
    console.log(butt);
}

function onText (text){
    const div = document.querySelector('.toUpdate');
    const element = div.querySelector('u');
    element.textContent = text;
    div.classList.remove("toUpdate");

}

function responseSetLike(response) {
    return response.text();
}

function setLike(event) {
    const ref = event.currentTarget.parentElement;
    ref.classList.add("toUpdate");
    const id_post = ref.classList[1];
    const action = event.currentTarget.classList.contains("liked"); //se == 1 devo rimuovere
    fetch('http://localhost/homework1/get_like.php?post=' + id_post + '&delete=' + action).then(responseSetLike).then(onText);
    
    if (action == true){
        event.currentTarget.src = UNLIKED_IMG;
        event.currentTarget.classList.remove("liked");
        event.currentTarget.classList.add("unliked");
    } else {
        event.currentTarget.src = LIKED_IMG;
        event.currentTarget.classList.remove("unliked");
        event.currentTarget.classList.add("liked");
    }

}

function modalClose() {
    modalView.classList.add('hidden');
    document.body.classList.remove('no-scroll');
}

function onLikeJSON (json) {
    modalView.classList.remove("hidden");
    modalView.style.top = window.pageYOffset + 'px';
    
    
    document.body.classList.add('no-scroll');
    
    const element = modalView.querySelector(".users");
    element.innerHTML = '';
    
    const close = document.createElement('img');
    close.src = 'img/close.png';
    element.appendChild(close);
    close.addEventListener('click', modalClose );
    
    for(user of json) {
        console.log(user);
        const p = document.createElement('p');
        p.textContent = "Mi piace:"; 
        const name = document.createElement("p");
        name.textContent = user.username;
        element.appendChild(p);
        element.appendChild(name);
    }
}

function responseLike(response) {
    return response.json();
}

function showLike(event) {
    console.log("showLike");
    const id_post = event.currentTarget.classList;
    fetch('http://localhost/homework1/get_like.php?post=' + id_post).then(responseLike).then(onLikeJSON);
}


function onJSON(json) {

    const list = document.querySelector(".container");
    for(post of json)
    {
        const div = document.createElement("div");
        div.id = post.id;

        const own = document.createElement("div");
        own.classList.add("owner");


        const user = document.createElement("p");
        user.textContent = post.username;
        own.appendChild(user);

        const date = document. createElement("p");
        date.textContent = post.date;
        date.classList.add("date");

        own.appendChild(date);
        div.appendChild(own);


        const cont = document.createElement("div");
        cont.classList.add("content");

        const title = document.createElement("p");
        title.textContent = post.titolo;
        cont.appendChild(title);



        if (post.tipo == "img") {
            const content = document.createElement("img");
            content.src = post.contenuto;
            cont.appendChild(content);
        } else if (post.tipo == "audio") {
            const content = document.createElement("audio");
            content.src = post.contenuto;
            content.controls = true;
            cont.appendChild(content);
        } else {
            const content = document.createElement("iframe");
            content.src = post.contenuto;
            content.setAttribute("allowfullscreen", "");
            cont.appendChild(content);
        }
        div.appendChild(cont);

        const container = document.createElement("div");
        
        const like = document.createElement("img");
        if (post.liked == 1){
            like.src = LIKED_IMG;
            like.classList.add("liked");
        }
        else{
            like.src = UNLIKED_IMG;
            like.classList.add("unliked");
        }
        
        
        like.addEventListener('click', setLike);
        
        const num = document.createElement("u");
        num.textContent = post.nlike;
        num.classList.add(post.id);
        
        if(post.nlike !== "0")
        num.addEventListener('click', showLike);
        
        container.appendChild(like);
        container.appendChild(num);
        container.classList.add("reaction");
        container.classList.add(post.id);



        div.appendChild(container);
        list.appendChild(div);
        
    }


    
}

function responseUpdate(response) {
    return response.json();
}


function updatePost() {
    
    fetch('http://localhost/homework1/get_post.php').then(responseUpdate).then(onJSON);
    
}


updatePost();
const modalView = document.querySelector('#modal');
const butt = document.querySelector('#goTop');
butt.addEventListener('click',goTop);

const list = document.querySelector(".container");
list.addEventListener("scroll", onScroll);
