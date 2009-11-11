<?php	
		
		$mespages = array(
		'accueil' => 'accueil.php', 
		'enregistrer_projet' => 'enr_proj.php', //prof
		'login'	=> 'login.php',
		'choisir_binome'=> 'choose_binome.php', //eleves
		'formulation_voeux' => 'formulation_voeux.php', // eleves
		'liste_projet_affecte' => 'liste_affectation.php',//all
		'liste_projets' => 'liste_proj.php',		  //all		
		'ajouter_indisponibilite' => 'indisponibilite.php', //prof
		'affiche_date' => 'affiche_date.php',		//all
		'affiche_soutenance' => 'planning_soutenance.php'
		);		
		
		session_start();
		
		if (empty($_GET['page']))
		{
			header("Location: index.php?page=accueil");
		} 
		else {
			if (array_key_exists($_GET['page'], $mespages) && is_file($mespages[$_GET['page']]))
			{
				$page = htmlentities($mespages[$_GET['page']]);				
			} 
			else
			{
				header("Location: index.php?page=accueil");
			}
		}
				
?>



	
	