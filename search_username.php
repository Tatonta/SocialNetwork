<?php

    $conn = mysqli_connect("151.97.9.184", "virgillito_fabio", "7289024802", "virgillito_fabio");
 
    $query = "SELECT username FROM utente WHERE username = '".$_GET['user']."'" ;
    $res = mysqli_query($conn, $query);

    echo mysqli_num_rows($res);

?>