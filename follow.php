<?php

session_start();

if (isset($_GET["user"]) && isset($_GET["follow"])) {

    $conn = mysqli_connect("151.97.9.184", "virgillito_fabio", "7289024802", "virgillito_fabio");

    if ($_GET["follow"] == "1") //Devo fare insert
        $query = "INSERT INTO follow VALUES ('".$_GET['user']."', '".$_SESSION['username']."')";
    else
        $query = "DELETE FROM follow where followed = '".$_GET["user"]."' and follower = '".$_SESSION['username']."'";

    echo $query;
    $res = mysqli_query($conn, $query);
    mysqli_close($conn);

}

?>