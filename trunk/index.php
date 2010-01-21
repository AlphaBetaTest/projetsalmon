<?php	
		include('entete.php'); // en-tete des pages : correspondance nom des pages avec nom des fichiers
		include('head.html');
			
		require_once('class/prof.php'); // inclusion de la classe professeur
		require_once('class/eleves.php'); // inclusion de la classe eleves
		include_once('cfg.php'); // fichier de configuration de la BD

		
		include('hautpage.html');
		include('menu.php');
	
		

			
		include($page);	// inclusion de la page determinee par entete.php
			
		include('footer.html'); 
?>