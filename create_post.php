<?php
    // Avvia la sessione
    session_start();
    // Verifica l'accesso
    if(!isset($_SESSION["username"]))
    {
        // Vai alla home
        header("Location: login.php");
        exit;
    }

    if(isset($_POST["title"]) && isset($_POST["choose"])) {
        $conn = mysqli_connect("151.97.9.184", "virgillito_fabio", "7289024802", "virgillito_fabio");
        $query = "INSERT INTO post (username, titolo, contenuto, tipo) VALUES ('".$_SESSION["username"]."', '".$_POST["title"]."', '".$_POST["choose"]."','".$_POST["type"]."')";
        

        $res = mysqli_query($conn, $query);
        if($res == TRUE)
        {
            header("Location: home.php?created=" .$res);
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
        <link rel='stylesheet' href='create_post.css'>
        <script src='create_post.js' defer></script>
        <title> <?php echo "BENVENUTO ".$_SESSION['username']."!" ?> </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        
        <div class="menu"> 
            <a href='./home.php'>Home</a>
            <a href='./create_post.php'>Nuovo Post</a>
            <a href='./search_people.php'>Ricerca</a>                    
            <a href='./logout.php'>Logout</a>
            
        </div>
        
        <div id="modal" class="hidden">
            <div>
                
                <form name='ultimate' method='post'>
                    <input type='hidden' name='type' value=''>
                    <input type='hidden' name='choose' value=''>
                    <p>
                        <label>Titolo <textarea name='title' rows= '3' cols='100'> </textarea></label>
                    </p>
                    <p>
                        <label>&nbsp;<input type='submit'></label>
                        <input type='button' value='Chiudi' id='cancel'>
                    </p>
                </form>
                
            </div>
        </div>
        <section class = "container">
            <div>
                <form name='create' method='post'>
                    <p>
                        <label>Ricerca <input type='text' name='search'></label>

                        <label>Servizi 
                            <select name='services'>
                                <option value='library'>Libreria</option>
                                <option value='movie'>TMdB</option>
                                <option value='video'>Youtube</option>
                                <option value='gif'>GIPHY</option>
                                <option value='music'>Spotify</option>
                            </select>
                        </label>

                        <label>&nbsp;<input type='submit'></label>
                    </p>
                </form>
            </div>
            <div class="select hidden" >

            </div>

            <section id="result">
            </section>
            
        
    </section>
    </body>
</html>
