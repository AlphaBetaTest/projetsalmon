<?php	
		
		$mespages = array(
		'accueil' => 'accueil.php',
		'gestion_utilisateur' => 'gestion_users.php',
		'login'	=> 'login.php',
		'ajouter_utilisateur' => 'ajout_user.php',
		'ajout_multiple_utilisateur' => 'ajout_alluser.php',
		'gestion_binome'=> 'binomes.php',
		'modifier_binome' => 'modifier_binome.php',
		'enregistrer_date' => 'enr_date.php',
		'indisponibilites' => 'indisponibilites.php',
		'ajouter_soutenance' => 'insert_sout.php',
		'gestion_soutenance' => 'liste_soutenance.php',
		'compte_projet_enseignant' => 'compte_projet.php',
		'creer_fichier_voeux' => 'wish_bin.php', //admin
		'recuperer_affectation' => 'wish_affect.php' // admin
		);			
		@session_start();
		if (empty($_GET['page']))
		{
			header("Location: index.php?page=accueil");
		} else {
				if (array_key_exists($_GET['page'], $mespages) && is_file($mespages[$_GET['page']]))
				{
					$page = htmlentities($mespages[$_GET['page']]);				
				}
				else
					$page = "accueil.php";
 
		}
				
?>



	
	