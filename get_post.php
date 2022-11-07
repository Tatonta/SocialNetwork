<?php

	session_start();

	$conn = mysqli_connect("151.97.9.184", "virgillito_fabio", "7289024802", "virgillito_fabio");
	
	//Lo inizializiamo come array perché il risultato che vogliamo ha una riga, ma più colonne
	$selezione = array();
	$row2 = array();
	$result_array = array();

	//Tutti i post dell'utente o degli utenti seguiti
	$res = mysqli_query($conn, "SELECT * FROM post WHERE username = '".$_SESSION["username"]."' OR username IN 
									(SELECT followed FROM follow where follower = '".$_SESSION["username"]."') ORDER BY id DESC");
					
	//Tutti i post a cui l'utente a messo like
	$res2 = mysqli_query($conn, "SELECT id_post FROM reaction WHERE username = '".$_SESSION["username"]."'");

	while($row = mysqli_fetch_array($res)) {
		$selezione[] = $row;
	}

	while($row1 = mysqli_fetch_array($res2)) {
		$row2[] = $row1;
		
	}

	// $selezione contiene i post       $row2 contiene i post piaciuti

	$k = 0;
	for ($i = 0; $i < count($selezione); $i++, $k++) {
		$result_array[$k]['id'] = $selezione[$i]['id'];
		$result_array[$k]['titolo'] = $selezione[$i]['titolo'];
		$result_array[$k]['contenuto'] = $selezione[$i]['contenuto'];
		$result_array[$k]['username'] = $selezione[$i]['username'];
		$result_array[$k]['tipo'] = $selezione[$i]['tipo'];
		$result_array[$k]['nlike'] = $selezione[$i]['nlike'];
		$result_array[$k]['date'] = $selezione[$i]['date'];

		
		$result_array[$k]['liked'] = 0;
		
		for($j = 0; $j < count($row2); $j++) {
			//Compara se id_post è tra id_post piaciuti
			if(strcmp($selezione[$i]['id'], $row2[$j]['id_post']) == 0) {	
				$result_array[$k]['liked'] = 1;
			}
		}
	}

	if (mysqli_num_rows($res) > 0) {
		echo json_encode($result_array);
	}

?>