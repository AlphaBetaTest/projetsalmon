<?php 

$objet = unserialize($_SESSION['objet']);

echo '<h1>Formulation des voeux</h1>';
if ($_SESSION['objet'] != "" && $objet->type() == "eleves") // Page r�serv�e aux �leves
{		
	$numbinome = $objet->info_numbinome();	 // on r�cupere le num�ro du binome auquel appartient l'utilisateur
	
		if($numbinome != "") // Si l'utilisateur n'a pas encore de num�ro c'est qu'il n'est pas en binome
		{
			$retour = mysql_query('SELECT * FROM wish WHERE id_bin = "'.$numbinome.'"'); // On r�cupere les choix d�ja fait par le binome
			if(mysql_num_rows($retour) == 0) { // Si le binome n'a pas encore fait de choix
			
				if ($objet->datecorrecte("formulation_voeux")) // Si le binome peut encore formuler ses voeux
				{
					echo '<form action="#" method="post" name="formulaire">	
						  <p>Veuillez formuler 5 voeux en num�rotant de 1 � 5 les projets : </p>';	
			
					
					$req2 = mysql_query("SELECT * FROM projets WHERE niveau='" . $objet->info_niveau() . "'"); // On r�cupere les projets correspondant au niveau de l'utilisateur
					
					while ( $donnees = mysql_fetch_array($req2)) // affichage des projets
					{
						echo '<p class="info"><input type="text" size="1" name="proj' . $donnees['id_proj'] . '" value="" maxlength="1" onkeyup="checknum(this)"/> <a href = "#" OnClick = "affiche_overlay_window(\'images/load.gif\',\'proj_description.php?id=' . $donnees['id_proj'] . '\');">' . $donnees['titre'] . '</a> <span>' . $donnees['description'] . ' </span></p>';
					}
					
					echo '<p class="info"><input type="hidden" name="ok" value="1" /></p>
					<p class="info"><input style="border:2px outset white;text-align:center;" type="submit" value="Envoyer" /></p></form>';
	
				// traitement r�sultat formulaire
	
					if (isset($_POST['ok']))
					{
						echo $objet->traitement_voeux($numbinome);				
					}
					
				}
				else
				{
					echo 'Date d&eacute;pass&eacute;, vous ne pouvez plus formuler de voeux.<br/>
						En cas de probl&egrave;me, veuillez contacter l\'administrateur
							<script type="text/javascript">redirection("accueil");</script>';
				}
			}
			else {
				echo '<p>Votre binome a d�ja d�fini ses choix !</p>';
			}
			
		}		
		else
		{
			echo "Vous devez d'abord cr�er un bin�me avant de pouvoir formuler des voeux.";
		}
}
else
{
echo 'Vous n\'�tes pas connect�, vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("login");</script>';

}

?>