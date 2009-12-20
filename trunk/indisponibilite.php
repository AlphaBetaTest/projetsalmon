<?php


$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->type() == "prof")
{
	
	echo '<h1>Indiquer ses indisponibilités</h1><br/>';
	echo '<p>- Pour sélectionner vos indisponibilités, il vous suffit de cliquer dans la/les case(s) désirée(s)<br/>
	- Pour en supprimer une, cliquez sur une case déjà sélectionnée ou pressez une touche.</p>';
	
	$indispos = $objet->recup_indisponibilites($objet->info_login()); // on vérifie si les indisponibilités existent ou non
	
	if (isset($_POST['exist']))
	{
		if($indispos == "")
			$objet->ajouter_indisponibilite();
		else
			$objet->modifier_indisponibilite();
	}
	
	echo '<p><form action="?page=ajouter_indisponibilite" method="post" name="formulaire">
		  <table>
		  <th>Horaire</th>
		  <th>Lundi</th>
		  <th>Mardi</th>
		  <th>Mercredi</th>
		  <th>Jeudi</th>
		  <th>Vendredi</th>';
	
	$indispos = $objet->recup_indisponibilites($objet->info_login()); // on récupere les indisponibilités de l'utilisateur si celui ci les a déja rentré
	
	$heures_memorisee_lundi = explode(";", $indispos['lundi']);
	$heures_memorisee_mardi = explode(";", $indispos['mardi']);
	$heures_memorisee_mercredi = explode(";", $indispos['mercredi']);
	$heures_memorisee_jeudi = explode(";", $indispos['jeudi']);
	$heures_memorisee_vendredi = explode(";", $indispos['vendredi']);

	for ($i = 1; $i <= 11 ; $i++)
	{
		$h = $i + 7;			
		
		echo '<tr>';
		echo '<th>' . $h . 'h-' . ($h + 1) . 'h</th>';
		if(in_array($i, $heures_memorisee_lundi)) $style = 'style="background-color:red" value="Indisponible"'; else $style = "";
		echo '<td><input type="text" class="indisponibilite" size="10" maxlength="0" onclick=active(this) name="LU' . $i . '" '.$style.'/></td>';
		 
		if(in_array($i, $heures_memorisee_mardi)) $style = 'style="background-color:red" value="Indisponible"'; else $style = "";
		echo '<td><input type="text" class="indisponibilite" size="10" maxlength="0" onclick=active(this) name="MA' . $i . '" '.$style.'/></td>';
		
		if(in_array($i, $heures_memorisee_mercredi)) $style = 'style="background-color:red" value="Indisponible"'; else $style = "";
		echo '<td><input type="text" class="indisponibilite"  size="10" maxlength="0" onclick=active(this) name="ME' . $i . '" '.$style.'/></td>';
		
		if(in_array($i, $heures_memorisee_jeudi)) $style = 'style="background-color:red" value="Indisponible"'; else $style = "";
		echo '<td><input type="text" class="indisponibilite"  size="10" maxlength="0" onclick=active(this) name="JE' . $i . '" '.$style.'/></td>';
		
		if(in_array($i, $heures_memorisee_vendredi)) $style = 'style="background-color:red" value="Indisponible"'; else $style = "";
		echo '<td><input type="text" class="indisponibilite"  size="10" maxlength="0" onclick=active(this) name="VE' . $i . '" '.$style.'/></td>';
		 echo ' </tr>';
	}	
	echo '<input type="hidden" value="1" name="exist"/>
	</table><br/>
	<input type="submit" value="Envoyer"/>
	</form>';
		  
}
else
{
	echo 'Vous n\'&ecirc;tes pas autorisé à accéder à cette page, vous allez &ecirc;tre redirig&eacute;...
<script type="text/javascript">redirection("login");</script>';

}
?>