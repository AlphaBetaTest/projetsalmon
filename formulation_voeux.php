<?php 

$objet = unserialize($_SESSION['objet']);

echo '<h1>Formulation des voeux</h1>';
if ($_SESSION['objet'] != "" && $objet->type() == "eleves")
{		
	$numbinome = $objet->info_numbinome();	
	
		if($numbinome != "")
		{
			if ($objet->datecorrecte("formulation_voeux"))
			{
				echo '<form action="#" method="post" name="formulaire">	
					  <p>Veuillez formuler 5 voeux en numérotant de 1 à 5 les projets : </p>';	
		
				
				$req2 = mysql_query("SELECT * FROM projets WHERE niveau='" . $objet->info_niveau() . "'");
				
				while ( $donnees = mysql_fetch_array($req2)) // affichage des projets
				{
					echo '<p class="info"><input type="text" size="1" name="proj' . $donnees['id_proj'] . '" value="" maxlength="1" onkeyup="checknum(this)"/> <a href = "#" OnClick = "affiche_overlay_window(\'images/load.gif\',\'proj_description.php?id=' . $donnees['id_proj'] . '\');">' . $donnees['titre'] . '</a> <span>' . $donnees['description'] . ' </span></p>';
				}
				
				echo '<p class="info"><input type="hidden" name="ok" value="1" /></p>
				<p class="info"><input style="border:2px outset white;text-align:center;" type="submit" value="Envoyer" /></p></form>';

			// traitement résultat formulaire

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
		else
		{
			echo "Vous devez d'abord créer un binôme avant de pouvoir formuler des voeux.";
		}
}
else
{
echo 'Vous n\'êtes pas connecté, vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("login");</script>';

}

?>