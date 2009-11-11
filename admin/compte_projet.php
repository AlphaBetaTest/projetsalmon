<?php

$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit() == 1)
{

	echo ' <table>
	<th>Nom</th>
	<th>Nombre de projet(s)</th>
	<th>Détail</th>
	<th>Nombre de soutenances';

	$sql = mysql_query("SELECT login,nom,prenom FROM prof");
	while ($donnees = mysql_fetch_array($sql))
	{

		$compteurtot = mysql_query("SELECT count(id_proj) FROM projets WHERE (tuteur1 ='" . $donnees['login'] . "' OR tuteur2 = '" . $donnees['login'] . "')"); // nombre de projet total où est le tuteur
		$compteurtot = mysql_fetch_assoc($compteurtot);	
		$compteurtot = $compteurtot['count(id_proj)'];

		$compteurprojet = mysql_query("SELECT count(id_proj) FROM projets WHERE (tuteur1 ='" . $donnees['login'] . "' AND tuteur2 = '')"); // nombre de projet (et non demi projet)
		$compteurprojet = mysql_fetch_assoc($compteurprojet);
		$compteurprojet = $compteurprojet['count(id_proj)'];	
		
		$compteurdemiprojet = $compteurtot - $compteurprojet; // la différence des projets totaux et les projets complet	
		$nbdemiprojet = $compteurdemiprojet; // nombre de demi projet
		$compteurdemiprojet =  $compteurdemiprojet * 0.5;
		$compteurtot = $compteurdemiprojet + $compteurprojet;
		
		$ret = mysql_query("SELECT count(s.id_bin) FROM binome b,soutenance s,projets p WHERE (s.id_bin = b.num AND b.id_proj = p.id_proj) AND (p.tuteur1 ='" . $donnees['login'] . "' OR p.tuteur2 ='" . $donnees['login'] . "' OR s.tuteur_comp='" . $donnees['login'] . "')");
		$nbsout = mysql_fetch_assoc($ret);
		echo '<tr>
		<td>' . $donnees['prenom'] . ' ' . $donnees['nom'] . '</td>
		<td>' . $compteurtot . '</td>
		<td>' . $compteurprojet . ' projet(s) et ' . $nbdemiprojet . ' demi-projet(s))</em></td>
		<td>' . $nbsout['count(s.id_bin)'] . '</td>
		</tr>';

	}
	echo '</table>';
}
else
	echo 'Vous n\'avez pas acc&egrave;s &agrave; cette page, vous allez &ecirc;tre redirig&eacute;...
	<script type="text/javascript">redirection("login");</script>';
?>


