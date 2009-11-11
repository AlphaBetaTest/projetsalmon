<?php

echo '<h1>Organisation des projets</h1>';

if ($_GET['niveau'] == "")
{
	echo '<a href="?page=affiche_date&niveau=A2">Ann&eacute;e 2</a><br/>
		<a href="?page=affiche_date&niveau=LP">Licence professionnelle</a><br/>
		<a href="?page=affiche_date&niveau=AS">Ann&eacute;e sp&eacute;ciale</a>';
}
else
{
	$date = mysql_query("SELECT * FROM date WHERE niveau='" . $_GET['niveau'] . "' ORDER BY annee DESC");
	$date = mysql_fetch_assoc($date); // on récupère la dernière année donc l'année courante

	setlocale(LC_TIME, "fr_FR", "fr_FR@euro", "fr", "FR", "fra_fra", "fra"); // permet d'avoir la date en français a partir du timestamp

	echo '<table>';
	if (!empty($date['annee']))
	{	
		echo '
		<tr> 
			<td>Constitution des binômes</td> <td> dernier délai : ' . strftime("%A %d %B %Y à %Hh%M",$date['construction_binome']) . '</td>
		</tr>
		<tr>
			<td>Proposition des projets par les enseignants</td><td> ' . strftime("%A %d %B %Y à %Hh%M",$date['enregistrement_projet']) . '</td>
		</tr>
		<tr>
			<td>Réunion de coordination des projets</td><td> ' . strftime("%A %d %B %Y de %Hh%M",$date['reunion_coor']) . strftime(" à %Hh%M",($date['reunion_coor'] + 3600)) . '</td>'; //la réunion durant 1h on rajoute une heure au timestamp
		echo '
		</tr>
		<tr>
			<td>Diffusion des sujets proposés</td><td> ' . strftime("%A %d %B %Y à %Hh%M",$date['diffusion_sujet']) . '</td>
		</tr>
		<tr>
			<td>Choix <b>ordonnée</b> des sujets par les étudiants (<b>5 choix</b>)</td><td> ' . strftime("%A %d %B %Y à %Hh%M",$date['formulation_voeux']) . '</td>
		</tr>
		<tr>
			<td>Publication de l\'attribution des sujets</td><td> ' . strftime("%A %d %B %Y à %Hh%M",$date['affectation_sujet']) . '</td>
		</tr>
		<tr>
			<td>Remise du rapport préliminaire (au tuteur)</td><td> ' . strftime("%A %d %B %Y à %Hh%M",$date['rapport_pre']) . '</td>
		</tr>
		<tr>
			<td>Remise du rapport (au secrétariat)</td><td> ' . strftime("%A %d %B %Y à %Hh%M",$date['remise_rapport']) . '</td>
		</tr>
		<tr>
			<td>Soutenances de projets</td><td> du ' . strftime("%A %d %B",$date['deb_soutenance']) . strftime(" au %A %d %B %Y",$date['fin_soutenance']) . '</td>
		</tr>';
	}
	else
	{
		echo '<tr><td>Les dates n\'ont pas encore &eacute;t&eacute; saisies</td></tr>';
	}
	
	echo '</table><br/><br/><br/>';
	echo 'Chaque binôme devra maintenir une page Web sur son site institutionnel personnel de l\'IUT : <br/>
				<b><u>Carnet de bord, état d\'avancement du projet et version courante du logiciel.</u></b>';
}
?>

