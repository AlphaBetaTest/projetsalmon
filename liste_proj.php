<?php

echo '<h1>Liste des projets</h1>';
if ($_GET['niveau'] == "")
{
	echo '<a href="?page=liste_projets&niveau=A2">Ann&eacute;e 2</a><br/>
		<a href="?page=liste_projets&niveau=LP">Licence professionnelle</a><br/>	
		<a href="?page=liste_projets&niveau=AS">Ann&eacute;e sp&eacute;ciale</a>';
}
else
{
	$retour = mysql_query('SELECT diffusion_sujet FROM date WHERE niveau = "'.$_GET['niveau'].'"'); // on récupere la date de publication des sujets
	$donnees = mysql_fetch_array($retour);
	
	if(time() > $donnees['diffusion_sujet']) { // a t-on atteint la date de diffusion des sujets ?
	
		$sql = mysql_query("SELECT id_proj,tuteur1,tuteur2,titre,binwish,remarques, groupe, description FROM projets WHERE niveau LIKE '" . $_GET['niveau'] . "%'") or die("Erreur"); // on récupere les informations de chaque projet
	
		echo '<table cellspacing="0">
		<th class="border_cellule">Tuteurs</th>
		<th class="border_cellule">Intitulé du sujet</th>
		<th class="border_cellule">Description</th>
		<th class="border_cellule">Binôme(s) souhaité(s)</th>
		<th class="border_cellule">Remarques</th>';
		
		if($_GET['niveau'] == "LP")
		 echo '<th class="border_cellule">Groupe</th>';
	
		if (mysql_num_rows($sql) == 0) // s'il n'y a pas de projets
			if($_GET['niveau'] == "LP") // sert uniquement pour que le message d'information soit correctement centré dans le tableau
				echo '<tr><td colspan="6">Aucun projet n\'a &eacute;t&eacute; ajout&eacute; dans cette cat&eacute;gorie</td></tr>';
			else
				echo '<tr><td colspan="5">Aucun projet n\'a &eacute;t&eacute; ajout&eacute; dans cette cat&eacute;gorie</td></tr>';
		else
		{
			while ($donnees = mysql_fetch_array($sql)) // pour chaque projet
			{
				echo '<tr>
				<td class="border_cellule">' . $donnees['tuteur1'];
				if ($donnees['tuteur2'] != "")	{ echo ' - ' . $donnees['tuteur2']; }
				echo '</td>
				<td class="border_cellule">' . $donnees['titre'] . '</td>
				<td class="border_cellule"><a href="?page=description&id='.$donnees['id_proj'].'" class="survol" title="Description détaillée">'. substr($donnees['description'], 0, 30) .'...<span>'.$donnees['description'].'</span></a></td>
				<td class="border_cellule">' . $donnees['binwish'] . '</td>
				<td class="border_cellule"><a href="?page=description&id='.$donnees['id_proj'].'" class="survol" title="Description détaillée">' . substr($donnees['remarques'], 0, 30) . '...<span>'.$donnees['remarques'].'</span></a></td>';
				if($_GET['niveau'] == "LP")
					echo '<td class="border_cellule">' . $donnees['groupe'] . '</td>';
				echo '</tr>';
			}
		}
		echo '</table>';
	}
	else {
		echo '<p class="warning">Vous ne pouvez pas encore consulter la liste des projets.</p>';	
	}
}

	
?>
	
	
		
