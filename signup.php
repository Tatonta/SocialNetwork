<?php

    // Avvia la sessione
    session_start();
    // Verifica l'accesso
    if(isset($_SESSION["username"]))
    {
        // Vai alla home
        header("Location: home.php");
        exit;
    }
    
    
    
    // Verifica l'esistenza di dati POST
    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        $target_dir = "img/user/";
        $_FILES["profile"] ["name"] = $_POST["username"].".".pathinfo($_FILES["profile"] ["name"], PATHINFO_EXTENSION); //salvo l'immagine dell'utente con l'username dell'utente
        $target_file = $target_dir.basename( $_FILES["profile"] ["name"]);
        $uploadOk =1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        //echo print_r($_FILES);
        
        $check = getimagesize($_FILES["profile"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $errore = 0;
        }

        if ($uploadOk == 1 && move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
            $l_user = strtolower($_POST["username"]);
            // Connetti al database utente
            $conn = mysqli_connect("151.97.9.184", "virgillito_fabio", "7289024802", "virgillito_fabio");
            // Cerca utenti con quelle credenziali

            $query = "INSERT INTO utente VALUES ('".$l_user."', '".$_POST['password']."', '".$_POST['email']."', '".$_POST['nome']."', '".$_POST['cognome']."', '".$target_file."')";
            
            $res = mysqli_query($conn, $query);

            if($res == TRUE)
            {
                echo "Inserito nel database";
                // Imposta la variabile di sessione
                $_SESSION["username"] = $l_user;
                // Vai alla pagina home_db.php
                header("Location: home.php?registered=1");
                exit; 
            }
            else
            {
                // Flag di errore
                $errore = true;
            }
        }


    }

?>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
        <link rel='stylesheet' href='login.css'>
        <script src='signup.js' defer></script>
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
                <div class='error'> 
                    <?php
                        // Verifica la presenza di errori
                        if(isset($errore))
                        {
                            echo "<p class='errore'>";
                            echo "Credenziali non valide.";
                            echo "</p>";
                        } 
                    ?>

                </div>
                <form name='registrazione' method='post' enctype="multipart/form-data">
                    <p>
                        <label>Username <input type='text' name='username'></label>
                    </p>
                    <p>
                        <label>Password <input type='password' name='password'></label>
                    </p>
                    <p>
                        <label>Conferma Password <input type='password' name='conferma'></label>
                    </p>
                    <p>
                        <label>Nome <input type='text' name='nome'></label>
                    </p>
                    <p>
                        <label>Cognome <input type='text' name='cognome'></label>
                    </p>
                    <p>
                        <label>E-mail <input type='text' name='email'></label>
                    </p>
                    <p>
                        <label>Immagine del profilo <input type='file' name='profile'></label>
                    </p>
                    <p>
                        <label>&nbsp;<input type='submit'></label>
                    </p>
                    <p> Hai già un account? <a href='login.php'> Accedi!</a></p>
                </form>
            </div>
        </section>
        <footer>Powered by Web Programming 2020</footer>

    </body>
</html>