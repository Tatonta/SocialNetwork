function following (event) {
    const utente = event.currentTarget.name;
    let toDo;
    if (event.currentTarget.classList.contains("follow")) //Utente da seguire
        toDo = 1;
    else //Utente da rimuovere
        toDo = 0;

    console.log(utente + " " + toDo);
    fetch('http://localhost/homework1/follow.php?user=' + utente + '&follow=' + toDo);    
    
    if (toDo == 1){
        event.currentTarget.classList.remove('follow');
        event.currentTarget.classList.add('unfollow');
        event.currentTarget.innerHTML = "Unfollow";
    } else {
        event.currentTarget.classList.remove('unfollow');
        event.currentTarget.classList.add('follow');
        event.currentTarget.innerHTML = "Follow";

    }
}

function onJSON(json)
{
    console.log('JSON ricevuto');

    const list = document.querySelector(".content");
    list.innerHTML = '';
    for(set of json)
    {
        console.log(set);
        const div = document.createElement("div")
        const utente = document.createElement("strong");
        utente.textContent = set.nome + " " + set.cognome;
        const image = document.createElement("img");
        if (set.folder != "" ) {
            image.src = set.folder;
        } else {
            image.src = "img/user/noprofile.png";
        }
        console.log(image.src);

        
        const follow = document.createElement("button");


        if(set.followed == 1){
            follow.innerHTML = "Unfollow";
            follow.classList.add("unfollow");
        } else {
            follow.innerHTML = "Follow";
            follow.classList.add("follow");
        }
        follow.name = set.username;
        follow.addEventListener('click', following);

        div.appendChild(image);
        div.appendChild(utente);
        div.appendChild(follow);
        list.appendChild(div);
    }
    
}


function onResponse(response) {
    //console.log(response.text());
    return response.json();
}

function showAll(event) {

    fetch('http://localhost/homework1/do_search_people.php').then(onResponse).then(onJSON);

}

function searchPeople(event) {
    
    event.preventDefault();
    const form_data = {method: 'post', body: new FormData(form)};
    fetch('http://localhost/homework1/do_search_people.php', form_data).then(onResponse).then(onJSON);

}


const form = document.forms['people'];
form.addEventListener('submit', searchPeople);

const button = document.querySelector('button');
button.addEventListener('click', showAll);