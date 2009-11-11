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
	$date = mysql_fetch_assoc($date); // on r�cup�re la derni�re ann�e donc l'ann�e courante

	setlocale(LC_TIME, "fr_FR", "fr_FR@euro", "fr", "FR", "fra_fra", "fra"); // permet d'avoir la date en fran�ais a partir du timestamp

	echo '<table>';
	if (!empty($date['annee']))
	{	
		echo '
		<tr> 
			<td>Constitution des bin�mes</td> <td> dernier d�lai : ' . strftime("%A %d %B %Y � %Hh%M",$date['construction_binome']) . '</td>
		</tr>
		<tr>
			<td>Proposition des projets par les enseignants</td><td> ' . strftime("%A %d %B %Y � %Hh%M",$date['enregistrement_projet']) . '</td>
		</tr>
		<tr>
			<td>R�union de coordination des projets</td><td> ' . strftime("%A %d %B %Y de %Hh%M",$date['reunion_coor']) . strftime(" � %Hh%M",($date['reunion_coor'] + 3600)) . '</td>'; //la r�union durant 1h on rajoute une heure au timestamp
		echo '
		</tr>
		<tr>
			<td>Diffusion des sujets propos�s</td><td> ' . strftime("%A %d %B %Y � %Hh%M",$date['diffusion_sujet']) . '</td>
		</tr>
		<tr>
			<td>Choix <b>ordonn�e</b> des sujets par les �tudiants (<b>5 choix</b>)</td><td> ' . strftime("%A %d %B %Y � %Hh%M",$date['formulation_voeux']) . '</td>
		</tr>
		<tr>
			<td>Publication de l\'attribution des sujets</td><td> ' . strftime("%A %d %B %Y � %Hh%M",$date['affectation_sujet']) . '</td>
		</tr>
		<tr>
			<td>Remise du rapport pr�liminaire (au tuteur)</td><td> ' . strftime("%A %d %B %Y � %Hh%M",$date['rapport_pre']) . '</td>
		</tr>
		<tr>
			<td>Remise du rapport (au secr�tariat)</td><td> ' . strftime("%A %d %B %Y � %Hh%M",$date['remise_rapport']) . '</td>
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
	echo 'Chaque bin�me devra maintenir une page Web sur son site institutionnel personnel de l\'IUT : <br/>
				<b><u>Carnet de bord, �tat d\'avancement du projet et version courante du logiciel.</u></b>';
}
?>

