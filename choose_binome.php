<?php

$objet = unserialize($_SESSION['objet']);	

if ($_SESSION['objet'] != "" && $objet->type() == "eleves") // Page r�serv�e aux �leves
{		
		$session = $objet->info_login(); // ne pas supprimer cette variable !
		
		echo'<h1>Choix du bin&ocirc;me</h1>';
		
		/* On v�rifie si l'utilisateur est en binome avec est_en_binome() uniquement pour le cas ou l'utilisateur
		* aurait fait un souhait de binome qu'un autre utilisateur aurait valid� mais que ce premier ne ce soit pas d�connect�
		* entre temps (et ainsi modifier la valeur de boolbin dans l'objet)
		*/
		if($objet->get_boolbin(0) && $objet->est_en_binome()) { 
			$objet->modif_boolbin();
		}
		
		if ($objet->get_boolbin(0) && $objet->datecorrecte("construction_binome") && !$objet->est_en_binome())
		{
			
			// traitement formulaire			
			if (isset($_POST['type']))
			{
				$espace = strrpos($_POST['binome'], " ");  // On r&eacute;cup�re seulement le nom						
				$nom2 = strtolower(substr($_POST['binome'], 0, $espace)); 				
				$nom2pre = strtolower(substr($_POST['binome'], $espace + 1)); 				
				
				if (!$objet->test_modif_choix()) // Si on ne modifie pas un choix
				{ 	
					// Creation du choix
					if ($_POST['type'] == 'binome') //cas binome
					{
						$loginnom2 = $objet->renseigner_login($nom2,$nom2pre);	// On r�cupere le login de la personne choisie
						$objet->ajouter_binome($loginnom2);	// On ajoute temporairement binome utilisateur/personne choisie
					}
					else // cas du monome
					{
						$objet->ajouter_monome();
						$objet->modif_boolbin();
					}					
				}
				else // Si on modifie notre choix
				{				
					if ($_POST['type'] == 'binome') //cas binome					
					{
						$loginnom2 = $objet->renseigner_login($nom2,$nom2pre);					
						$objet->modifier_binome($loginnom2);
					}
					else // cas du monome
						$objet->modifier_monome();				
				}
					$_SESSION['objet'] = serialize($objet); // Pour sauvegarder la valeur modifi�e ou non de boolbin
					echo '<p class="granted">Choix pris en compte !</p>';
			}
			
			if($objet->get_boolbin(0)) 
			{
				$objet->partenaire(); // Y'a t-il quelqu'un qui nous a choisit ?
				
				echo '<p>Vous souhaitez cr�er un :<br /><br />';
				
				echo '<form action="?page=choisir_binome" method="post" name="formulaire">';
				echo '<input type="radio" name="type" value="monome" />Mon&ocirc;me<br />';
				echo '<input type="radio" name="type" selected="selected" value="binome" />Bin&ocirc;me <br/><br/>';
				echo 'Avec l\'�leve :<br /><br />';
				echo '<select name="binome" size="1"> <option> <-- S&eacute;lectionner un nom --> </option>';
				
				// Renvoi tous les �leves non affect�s a un binome du meme groupe que l'�leve.
				$retour = mysql_query("SELECT nom, prenom,login, boolbin FROM eleves WHERE groupe = (SELECT groupe FROM eleves WHERE login ='" . $session . "') AND niveau='" . $objet->info_niveau() . "'"); 
				
				while ($donnees = mysql_fetch_array($retour)) // listing des �leves du meme groupe
				{			
					if ($donnees['boolbin'] == 0 && $donnees['login'] != $session) // si l'�leve list� n'est pas en binome et si ce n'est pas l'utilisateur
					{
					echo '<option>' . $donnees['nom'] . ' ' . $donnees['prenom'] . '</option>';
					}
				} 
				echo '</select><br/><br/>';			
				echo '<input type="submit" value="Effectuer mon choix" />';
				echo '</form></p>';
			}
						
		}	
		else
		{
			if ($objet->get_boolbin(0) && !$objet->datecorrecte("construction_binome")) // n'est-il pas trop tard pour faire la s�lection de binome ?	 
				echo '<p class="warning">Date d&eacute;pass&eacute;e, tu ne peux plus cr&eacute;er ou modifier ton bin&ocirc;me ! <br/>
									Contacte l\'administrateur pour plus d\'informations.</p>';
			
			else			
				echo '<p class="warning">Tu as d&eacute;j&agrave; fait ton choix et il a &eacute;t&eacute; valid&eacute; ! </p>';
		}
}
else
	echo 'Vous n\'�tes pas connect&eacute;, vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("login");</script>';

?>