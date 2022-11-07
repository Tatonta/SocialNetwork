<?php
    // Avvia la sessione
    session_start();
    // Vai alla home se esiste sessione
    if(isset($_SESSION["username"]))
    {
        // Vai alla home
        header("Location: home.php");
        exit;
    }

    // Se esiste il cookie ma non esiste sessione, setto la sessione
    if(isset($_COOKIE["username"]))
    {
        $_SESSION["username"] = $_COOKIE["username"];
        header("Location: home.php");
        exit;
    }


    // Verifica l'esistenza di dati POST
    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        $l_user = strtolower($_POST["username"]);
        // Connetti al database utente
        $conn = mysqli_connect("151.97.9.184", "virgillito_fabio", "7289024802", "virgillito_fabio");
        // Cerca utenti con quelle credenziali
        $query = "SELECT * FROM utente WHERE username = '".$l_user."' AND password = '".$_POST['password']."'";
        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res) > 0) // LOGIN EFFETTUATO!
        {
            // Imposta la variabile di sessione
            $_SESSION["username"] = $l_user;
            if($_POST["remember"] == "yes"){
                setcookie("username", $l_user);
            } 
            header("Location: home.php?login=1");
            exit;
        }
        else
        {
            // Flag di errore
            $errore = true;
        } 
    }

?>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
        <link rel='stylesheet' href='login.css'> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>


    <body>

        <section class="container">
            <div class="left-half">
                <div class="intro">
                    <p>Benvenuto in</p>
                    <p class="name">Social Corner</p>
                </div>
            </div>

            <div class ="right-half">
                <?php
                    if (isset($errore))
                        echo "<div class='error'> Errore nelle credenziali</div>";
                ?>
                    <form name='login' method='post'>
                        <p>
                            <label>Username <input type='text' name='username'></label>
                        </p>
                        <p>
                            <label>Password <input type='password' name='password'></label>
                        </p>
                        <p>
                            <label>&nbsp;<input type='submit'></label>
                        </p>
                        <label>Ricordami<input type='checkbox' name='remember' value = 'yes'></label>
                    </form>
                    <p> Non hai ancora un account? <a href='signup.php'> Registrati!</a></p>
            </div>
        </section>

        <footer>Powered by Web Programming 2020</footer>
    </body>
</html>