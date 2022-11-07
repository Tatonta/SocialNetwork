<?php
    // Avvia la sessione
    session_start();
    // Verifica l'accesso
    if(!isset($_COOKIE["username"]) && !isset($_SESSION["username"]))
    {
        // Vai alla home
        header("Location: login.php");
        exit;
    } else if (!isset($_SESSION["username"])){ // E' settato solo il cookie
        $_SESSION["username"] = $_COOKIE["username"];
    }

?>

<html>
    <head>
        <link rel='stylesheet' href='home.css'>
        <script src='home.js' defer></script>
        <title> <?php echo "BENVENUTO ".$_SESSION['username']."!" ?> </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        
        <div class = "menu"> 
            <a href='./home.php'>Home</a>
            <a href='./create_post.php'>Nuovo Post</a>
            <a href='./search_people.php'>Ricerca</a>                    
            <a href='./logout.php'>Logout</a>
        
        </div>
        
        <div id="modal" class="hidden">
            <div class = "users">
        
            </div>
        </div>
        <section class = "container">
                <?php
                if (isset($_GET['login'])) {
                    echo "<div> <p> Benvenuto ".$_SESSION['username']."</p> </div>";
                }

                if (isset($_GET['registered'])) {
                    echo "<div> <p> Benvenuto su SocialCorner. Vai su Ricerca per iniziare a seguire utenti. Oppure crea il tuo primo post. ".$_SESSION['username']."</p> </div>";
                }

                if(isset($_GET['created'])){
                    echo "<div> <p> Post inserito correttamente</p> </div>";
                }
                ?>

        </section>
        
        <button id="goTop">↑</button>

    </body>
</html>
