function validazione(event)
{
    right.innerHTML = '';
    // Verifica se tutti i campi sono riempiti
    if(form.username.value.length == 0 ||
       form.password.value.length == 0 ||
       form.conferma.value.length == 0 ||
       form.nome.value.length == 0 ||
       form.cognome.value.length == 0 ||
       form.email.value.length == 0 ||
       form.profile.value.length == 0)
       {
            const error = document.createElement('div');
            error.textContent = 'Compilare tutti i campi';
            right.appendChild(error);

            event.preventDefault();
            return;
    }
    
    if (form.password.value !== form.conferma.value){ //Verifica che le password coincidano
        const error = document.createElement('div');
        error.textContent = 'Le password non coincidono';
        right.appendChild(error);

        event.preventDefault();
    }
    const atpos = form.email.value.indexOf("@");
    const dotpos = form.email.value.indexOf(".");


    if(atpos < 1 || (dotpos - atpos) < 2 ){ //Verifica che il campo email sia corretto
        const error = document.createElement('div');
        error.textContent = 'Controlla il formato dell\'email';
        right.appendChild(error);

        event.preventDefault();
    }

        
}

function onText(text) { 
    if (text == 1 ) {
        alert("Username già inserito");
    }
}

function onResponse(response) {
    return response.text();
}

function chk_username(event) { //Verifica che l'username sia disponibile
    
    fetch('http://localhost/homework1/search_username.php?user=' + user.value).then(onResponse).then(onText);
    console.log("Fetch effettuata");
}

const right = document.querySelector('.error');

const form = document.forms['registrazione'];
form.addEventListener('submit', validazione);

const user = form.username;
user.addEventListener('blur', chk_username);