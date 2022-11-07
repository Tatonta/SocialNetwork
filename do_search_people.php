<?php

session_start();

$conn = mysqli_connect("151.97.9.184", "virgillito_fabio", "7289024802", "virgillito_fabio");

//Lo inizializiamo come array perché il risultato che vogliamo ha una riga, ma più colonne
$selezione = array();
$row2 = array();
$result_array = array();


if(isset($_POST["search"])) { // Ricerca utente

    $res = mysqli_query($conn, "SELECT username, nome, cognome, folder FROM utente WHERE username = '".$_POST["search"]."'");

} else { //Tutti gli utenti meno quello corrente

    $res = mysqli_query($conn, "SELECT username, nome, cognome, folder FROM utente WHERE username <> '".$_SESSION['username']."'");
    
}

// Abbiamo richiamato tutti gli utenti che l'utente della sessione segue
$res2 = mysqli_query($conn, "SELECT followed FROM follow WHERE follower = '".$_SESSION['username']."'");


while($row = mysqli_fetch_array($res)) {
    $selezione[] = $row;
}

while($row1 = mysqli_fetch_array($res2)) {
    $row2[] = $row1;
}

// $selezione contiene gli utenti       $row2 contiene gli utenti seguiti


$k = 0;
for ($i = 0; $i < count($selezione); $i++, $k++) {

    $result_array[$k]['username'] = $selezione[$i]['username'];
    $result_array[$k]['nome'] = $selezione[$i]['nome'];
    $result_array[$k]['cognome'] = $selezione[$i]['cognome'];
    $result_array[$k]['folder'] = $selezione[$i]['folder'];

    $result_array[$k]['followed'] = 0;

    for($j = 0; $j < count($row2); $j++) {
        // compariamo se l'username dell'utente seguito corrisponde a quello attuale del primo for
       if(strcmp($selezione[$i]['username'], $row2[$j]['followed']) == 0) {
           // aggiungiamo un campo followed per indicare che effettivamente è seguito. In JS ci permette di evitare una chiamata asincrona
           $result_array[$k]['followed'] = 1;
       }
    }
}

if (mysqli_num_rows($res) > 0) {
    echo json_encode($result_array);
}
?>