<?php

$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit() == 1)
{	
	include('../cfg.php');
	
	
	
	echo '<h1>Liste des soutenances</h1>';
	
	
	echo '<table>
	<th class="border_cellule">Bin&ocirc;me</th>
	<th class="border_cellule">Date</th>
	<th class="border_cellule">Salle</th>
	<th class="border_cellule">Tuteur(s)</th>
	<th class="border_cellule">jur&eacute;</th>	
	<th class="border_cellule" colspan="2">Action</th>';
	
	$ret = mysql_query("SELECT s.id_bin,s.date,s.salle,p.tuteur1,p.tuteur2,s.tuteur_comp FROM binome b,soutenance s,projets p WHERE s.id_bin = b.num AND b.id_proj = p.id_proj");	
	while ($soutenance = mysql_fetch_array($ret))
	{
		$date = date("d/m/Y à G\hi",$soutenance['date']);
		echo '<tr>
		<td class="border_cellule">' . $soutenance['id_bin'] . '</td>
		<td class="border_cellule">' . $date . '</td>
		<td class="border_cellule">' . $soutenance['salle'] . '</td>
		<td class="border_cellule">' . ucfirst($soutenance['tuteur1']); 
		if ($soutenance['tuteur2'] != "") 
		{
			$cptprof++;
			echo ' & ' . ucfirst($soutenance['tuteur2']); 
		}	
		echo '</td>
		<td class="border_cellule">' . $soutenance['tuteur_comp'] . '</td>
		<td class="border_cellule"><a href="?page=ajouter_soutenance&bin=' . $soutenance['id_bin'] . '"><img src="../images/b_edit.png" alt="Modifier" title="Modifier" /></a></td>
		<td class="border_cellule"><a href="?page=gestion_soutenance&id=' . $soutenance['id_bin'] . '"><img src="../images/b_drop.png" alt="Supprimer" title="Supprimer" /></a></td>
		</tr>';
		if ($soutenance['tuteur_comp'] != "") $cptprof++;
		$cptprof++; // tuteur 1
		$cptsoutenance++;		
	}
	echo '<tr>
			<td class="border_cellule" colspan="7"> Nombre d\'enseignants : ' . $cptprof . '<br/>
							 Nombre de soutenances : ' . $cptsoutenance . '<br/>
<a href="?page=ajouter_soutenance">Ajouter une soutenance</a></td>
		</tr>		
		</table>';	
		
		//suppression d'un tuple
	if (isset($_GET['id']))
		del($_GET['id']);
}
else
{
echo 'Vous n\'avez pas accès à cette page	
<script type="text/javascript">redirection("login");</script>';
}

function del ($id)
{
	mysql_query("DELETE FROM soutenance WHERE id_bin = '" . $id . "'");
	echo 'Soutenance supprim&eacute;e';
}
