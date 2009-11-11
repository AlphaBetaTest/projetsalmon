<?php

$objet = unserialize($_SESSION['objet']);	

if ($_SESSION['objet'] != "" && $objet->type() == "eleves")
{		
		$session = $objet->info_login();
		
		echo'<h1>Choix du bin&ocirc;me</h1>';
		
		if ($objet->get_boolbin(0) && $objet->datecorrecte("construction_binome"))
		{
			
			// traitement formulaire			
			if (isset($_POST['type']))
			{
				$espace = strrpos($_POST['binome'], " ");  // On r&eacute;cupère seulement le nom						
				$nom2 = strtolower(substr($_POST['binome'], 0, $espace)); 				
				$nom2pre = strtolower(substr($_POST['binome'], $espace + 1)); 				
				
				if (!$objet->test_modif_choix()) // Si on ne modifie pas un choix
				{ 	
					// Cr&eacute;ation du choix
					if ($_POST['type'] == 'binome') //cas bin&ocirc;me
					{
						$loginnom2 = $objet->renseigner_login($nom2,$nom2pre);	// On récupere le login de la personne choisie
						$objet->ajouter_binome($loginnom2);	// On ajoute temporairement binome utilisateur/personne choisie
					}
					else // cas du mon&ocirc;me
					{
						$objet->ajouter_monome();
					}					
				}
				else // Si on modifie notre choix
				{				
					if ($_POST['type'] == 'binome') //cas bin&ocirc;me					
					{
						$loginnom2 = $objet->renseigner_login($nom2,$nom2pre);					
						$objet->modifier_binome($loginnom2);
					}
					else // cas du mon&ocirc;me
						$objet->modifier_monome();				
				}
					//echo '<br/>Ton choix a &eacute;t&eacute; pris en compte';
					$_SESSION['objet'] = serialize($objet); // Pour sauvegarder la valeur modifiée ou non de boolbin
					echo '<p style="font-weight:bold;color:#26a200;">Choix pris en compte !</p>';
			}
			
			if($objet->get_boolbin(0)) 
			{
				$objet->partenaire(); // Y'a t-il quelqu'un qui nous a choisit ?
				
				echo 'Vous souhaitez créer un :<br /><br />';
				
				echo '<form action="?page=choisir_binome" method="post" name="formulaire">';
				echo '<input type="radio" name="type" value="monome" />Mon&ocirc;me<br />';
				echo '<input type="radio" name="type" selected="selected" value="binome" />Bin&ocirc;me <br/><br/>';
				echo 'Avec l\'éleve :<br /><br />';
				echo '<select name="binome" size="1"> <option> <-- S&eacute;lectionner un nom --> </option>';
				
				// Renvoi tous les éleves non affectés a un binome du meme groupe que l'éleve.
				$retour = mysql_query("SELECT nom, prenom,login, boolbin FROM eleves WHERE groupe = (SELECT groupe FROM eleves WHERE login ='" . $session . "') AND niveau='" . $objet->info_niveau() . "'"); 
				
				while ($donnees = mysql_fetch_array($retour)) // listing des éleves du meme groupe
				{			
					if ($donnees['boolbin'] == 0 && $donnees['login'] != $session)
					{
					echo '<option>' . $donnees['nom'] . ' ' . $donnees['prenom'] . '</option>';
					}
				} 
				echo '</select><br/><br/>';			
				echo '<input type="submit" value="Effectuer mon choix" />';
				echo '</form> ';
			}
						
		}	
		else
		{
			if ($objet->get_boolbin(0) && !$objet->datecorrecte("construction_binome"))			 
				echo '<p style="font-weight:bold;color:#FF0000;">Date d&eacute;pass&eacute;e, tu ne peux plus cr&eacute;er ou modifier ton bin&ocirc;me ! <br/>
									Contacte l\'administrateur pour plus d\'informations.</p>';
			
			else			
				echo '<p style="font-weight:bold;color:#FF0000;">Tu as d&eacute;j&agrave; fait ton choix et il a &eacute;t&eacute; valid&eacute; ! </p>';
		}
}
else
	echo 'Vous n\'êtes pas connect&eacute;, vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("login");</script>';

?>