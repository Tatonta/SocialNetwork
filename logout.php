<?php

    // Avvia la sessione
    session_start();
    // Elimina la sessione
    session_destroy();
    setcookie("username", "");
    // Vai alla login
    header("Location: login.php");
    exit;

?>
