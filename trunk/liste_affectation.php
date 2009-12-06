<?php

echo '<h1>Liste des affectations</h1>';
if ($_GET['niveau'] == "")
{
	echo '<a href="?page=liste_projets&niveau=A2">Ann&eacute;e 2</a><br/>
		<a href="?page=liste_projets&niveau=LP">Licence professionnelle</a><br/>
		<a href="?page=liste_projets&niveau=AS">Ann&eacute;e sp&eacute;ciale</a>';
}
else
{
	if (datecorrecte(time()))
	{
		$sql = mysql_query("SELECT p.id_proj, p.tuteur1, p.tuteur2, p.titre, p.binwish FROM projets p, binome b WHERE (p.id_proj = b.id_proj) AND b.niveau='" . $_GET['niveau'] . "' ORDER BY p.id_proj  ASC");		
		
		echo '<table>
		<tr>
		<th class="border_bottom">Tuteur(s)</th>
		<th class="border_bottom">Nb affec</th>
		<th class="border_bottom">Etudiants</th>
		<th class="border_bottom">Intitulé des sujets</th>	
		<th class="border_bottom">Nb binômes souhaité</th>
		</tr>';
		if (mysql_num_rows($sql) == 0)		
			echo '<tr><td colspan="5">Aucune affectation n\'a &eacute;t&eacute; effectu&eacute; </td></tr>';
		else
		{			
			while ($donnees = mysql_fetch_array($sql))
			{
				
				$cpt = mysql_query("SELECT count(id_proj) FROM binome WHERE id_proj = '" . $donnees['id_proj'] . "'");
				$cpt = mysql_fetch_assoc($cpt);
				$cpt = $cpt['count(id_proj)']; // le compteur d'affectation	
				$i = 0;
				$n = mysql_query("SELECT nom1,nom2 FROM binome WHERE id_proj = '" . $donnees['id_proj'] . "'");
				while($noms = mysql_fetch_array($n))  // les noms
				{
					extract($noms);
					$chaine_noms .= $nom1 . '-' . $nom2 . ' & ';		
				}		
				$chaine_noms = substr($chaine_noms,0,-2); // supprime le dernier caractère pour éviter d'avoir un '& ' en fin de chaine.

					echo '<tr>';
					echo '<td>' . $donnees['tuteur1'];	
					if ($donnees['tuteur2'] != "")	{ echo ' - ' . $donnees['tuteur2']; }
					echo '</td>' ;
					echo '<td>' . $cpt . '</td>';
				    echo '<td>' . $chaine_noms . '</td>' ;
					echo '<td>' . $donnees['titre'] . '</td>';
					echo '<td>' . $donnees['binwish'] . '</td>';
					echo '</tr>';
			}
		}
		echo '</table>';
	}
	else
	{
	echo 'Il est trop tôt pour pouvoir consulter la liste. Vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("accueil");</script>';
	}
}

function datecorrecte($now)
{
	$date = mysql_query("SELECT affectation_sujet FROM date ORDER BY annee DESC");
	$date = mysql_fetch_assoc($date);
	$date = $date['affectation_sujet'];
	if ($date < $now)
	return true;	
	else
	return false;
}
?>