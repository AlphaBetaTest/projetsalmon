<?php

echo '<h1>Liste des affectations : '.$_GET['niveau'].'</h1>';
if ($_GET['niveau'] == "")
{
	echo '<a href="?page=liste_projets&niveau=A2">Ann&eacute;e 2</a><br/>
		<a href="?page=liste_projets&niveau=LP">Licence professionnelle</a><br/>
		<a href="?page=liste_projets&niveau=AS">Ann&eacute;e sp&eacute;ciale</a>';
}
else
{
	if (datecorrecte(time(), $_GET['niveau'])) // est-ce que la date de publication des affectations a �t� atteinte
	{
		$sql = mysql_query("SELECT DISTINCT p.id_proj, p.tuteur1, p.tuteur2, p.titre, p.binwish FROM projets p, binome b WHERE (p.id_proj = b.id_proj) AND b.niveau='" . $_GET['niveau'] . "' ORDER BY p.id_proj ASC"); // jointure permettant de r�cup�rer les sujets affect�s aux diff�rents binomes avec le nom des binomes		
		
		echo '<table>
		<tr>
		<th class="border_bottom">Tuteur(s)</th>
		<th class="border_bottom">Nb affec</th>
		<th class="border_bottom">Etudiants</th>
		<th class="border_bottom">Intitul� des sujets</th>
		<th class="border_bottom">Nb bin�mes souhait�</th>
		</tr>';
		if (mysql_num_rows($sql) == 0)	// s'il n'y a pas d'affectation	
			echo '<tr><td colspan="5">Aucune affectation n\'a &eacute;t&eacute; effectu&eacute; </td></tr>';
		else
		{			
			while ($donnees = mysql_fetch_array($sql)) // pour chaque affectation
			{
				
				$cpt = mysql_query("SELECT count(id_proj) FROM binome WHERE id_proj = '" . $donnees['id_proj'] . "'"); // on r�cupere le nombre d'affectation qu'il y a eu par projet
				$cpt = mysql_fetch_assoc($cpt); 
				
				$cpt = $cpt['count(id_proj)']; // le compteur d'affectation	
				$i = 0;
				$n = mysql_query("SELECT nom1,nom2 FROM binome WHERE id_proj = '" . $donnees['id_proj'] . "'"); // on r�cupere le nom des deux binomes

				while($noms = mysql_fetch_array($n))  // les noms
				{
					$chaine_noms .= $noms['nom1'] . '-' . $noms['nom2'] . ' & ';	
				}		
				$chaine_noms = substr($chaine_noms,0,-2); // supprime le dernier caractere pour �viter d'avoir un '& ' en fin de chaine.

					echo '<tr>';
					echo '<td>' . $donnees['tuteur1'];	
					if ($donnees['tuteur2'] != "")	{ echo ' - ' . $donnees['tuteur2']; }
					echo '</td>' ;
					echo '<td>' . $cpt . '</td>';
				    echo '<td>' . $chaine_noms . '</td>' ;
					echo '<td>' . $donnees['titre'] . '</td>';
					echo '<td>' . $donnees['binwish'] . '</td>';
					echo '</tr>';
					$chaine_noms = "";
			}
		}
		echo '</table>';
	}
	else
	{
	echo 'Il est trop t�t pour pouvoir consulter la liste. Vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("accueil");</script>';
	}
}

function datecorrecte($now, $niveau) // fonction qui permet de v�rifier si on peut afficher les affectations : la date de publication a t-elle �t� atteinte ?
{
	$date = mysql_query("SELECT affectation_sujet FROM date WHERE niveau = '".$niveau."'"); // on r�cupere la date d'affectation des sujets
	$date = mysql_fetch_assoc($date);
	$date = $date['affectation_sujet'];
	if ($now > $date) // a t-on d�pass� cette date ?
	return true;	
	else
	return false;
}
?>