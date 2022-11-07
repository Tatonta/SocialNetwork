<?php

    session_start();
    $conn = mysqli_connect("151.97.9.184", "virgillito_fabio", "7289024802", "virgillito_fabio");
    
    if (isset ($_GET['delete'])) {  //Dobbiamo inserire o rimuovere un like
        
        if ( $_GET['delete'] == "false"){
            $query = "INSERT INTO reaction VALUES ('".$_SESSION['username']."', '".$_GET['post']."')";

        }else if ( $_GET['delete'] == "true") {
            $query = "DELETE FROM reaction WHERE username = '".$_SESSION['username']."' AND id_post = ".$_GET['post']."";
        }

        $res = mysqli_query($conn, $query);

        if ($res === true) { // se l'operazione è andata a buon fine restituisco il numero di like aggiornato
            $query = "SELECT nlike FROM post WHERE id = '".$_GET["post"]."'";

            $res = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_row($res))
                echo $row[0];


            mysqli_close($conn);
        }
    } 


    else if (isset($_GET["post"])) { // Recupera i like di un post, viene effettuata anche dopo aver messo un like per restituire dati aggiornati
        
        $query = "SELECT username FROM reaction where id_post = '".$_GET["post"]."'";
        $res = mysqli_query($conn, $query);
        $row = array();

        while ($r = mysqli_fetch_assoc($res))
            $row[] = $r;

        echo json_encode($row);
        mysqli_close($conn);

    }

?>