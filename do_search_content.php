<?php

    // Verifica dati POST
    if(isset($_POST["search"]) && isset($_POST["services"])) {

        if ($_POST["services"] == "library"){ //API Openlibrary

            $url = "http://openlibrary.org/search.json?author=".$_POST["search"];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($curl);
            curl_close($curl);

            echo $response;
        }

        if ($_POST["services"] == "movie") { //API TMdB
            
            $apikey = "0e64dfa1fd0b9c2a405980f5e909fe09";
            $search = rawurlencode($_POST["search"]);


            $url = "https://api.themoviedb.org/3/search/movie?api_key=".$apikey."&query=".$search;
            

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($curl);
            curl_close($curl);

            echo $response;


        }
        
        if ($_POST["services"] == "video") { //API Youtube
            
            $apikey = "AIzaSyB17MQ3R2g36-ykysCTfCc-sqqWLwuESJg";
            $search = rawurlencode($_POST["search"]);


            $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=25&q=".$search."&key=".$apikey;
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($curl);
            curl_close($curl);

            echo $response;


        }

        if ($_POST["services"] == "gif") { //API Youtube
            
            $apikey = "3UdtXqRk2NNRovLCMVLaugkgbRNflZz0";
            $search = rawurlencode($_POST["search"]);

            $url = "http://api.giphy.com/v1/gifs/search?api_key=".$apikey."&q=".$search;
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($curl);
            curl_close($curl);

            echo $response;


        }

        if ($_POST["services"] == "music") { //API Spotify
            
            // Get Access_Token
            $clientid = "ddac5ad4eeaf4b139bebbf65eb74527b";
            $secret = "93f9fab4db384a5e853bee2a670c1995";

            $body = "grant_type=client_credentials";

            $curl = curl_init("https://accounts.spotify.com/api/token");
            
            $encoded = base64_encode($clientid.':'.$secret);
            $header = array('Authorization: Basic '.$encoded);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl,CURLOPT_POST, 1);
            curl_setopt($curl,CURLOPT_POSTFIELDS, $body);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            
            $response = curl_exec($curl);
            $response = json_decode($response, true);
            $token = $response['access_token'];

            curl_close($curl);


            $search = rawurlencode($_POST["search"]);
            $url = ("https://api.spotify.com/v1/search?q=".$search."&type=track");
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$token));

            $response = curl_exec($curl);
            curl_close($curl);

            echo $response;
        }

    }
?>