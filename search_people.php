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
?>

<html>
    <head>
        <link rel='stylesheet' href='search_people.css'>
        <script src='search_people.js' defer></script>
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

        <section class = "container">
            <div>
                <form name='people' method='post'>
                    <p>
                        <label>Ricerca <input type='text' name='search'></label>
                        <label>&nbsp;<input type='submit'></label>
                    </p>
                </form>
                    <button type='button' name='all'> Mostra tutti gli iscritti </button>
            </div>
            
            
            <section class = "content">
            </section>
            
        
        </section>
    </body>
</html>