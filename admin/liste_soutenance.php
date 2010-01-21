<?php
$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit(1)) // Page réservée a l'administrateur
{		
	echo '<h1>Liste des soutenances</h1>';
	
	if (isset($_GET['id'])) {
		mysql_query("DELETE FROM soutenance WHERE id_bin = '" . $_GET['id'] . "'");
		echo '<p>Soutenance supprim&eacute;e</p>';
	}
	
	echo '<table>
	<th class="border_cellule">Bin&ocirc;me</th>
	<th class="border_cellule">Date</th>
	<th class="border_cellule">Salle</th>
	<th class="border_cellule">Tuteur(s)</th>
	<th class="border_cellule">Jury</th>	
	<th class="border_cellule" colspan="2">Action</th>';
	
	$ret = mysql_query(
						"SELECT s.id_bin,s.date,s.salle,p.tuteur1,p.tuteur2,s.tuteur_comp, b.niveau
						FROM binome b,soutenance s,projets p 
						WHERE s.id_bin = b.num AND b.id_proj = p.id_proj");	// jointure permettant de récupérer les différentes soutenances avec le nom des tuteurs convoqués et le numéro de binome concerné
	while ($soutenance = mysql_fetch_array($ret)) // pour chaque soutenance
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
		<td class="border_cellule">' . ucfirst($soutenance['tuteur_comp']) . '</td>
		<td class="border_cellule"><a href="?page=edition_soutenance&bin=' . $soutenance['id_bin'] . '&niveau='.$soutenance['niveau'].'&jour='.date("d", $soutenance['date']).'&heure='.(date("G", $soutenance['date'])-7).'"><img src="../images/b_edit.png" alt="Modifier" title="Modifier" /></a></td>
		<td class="border_cellule"><a href="?page=gestion_soutenance&id=' . $soutenance['id_bin'] . '"><img src="../images/b_drop.png" alt="Supprimer" title="Supprimer" /></a></td>
		</tr>';
		if ($soutenance['tuteur_comp'] != "") $cptprof++;
		$cptprof++; // tuteur 1
		$cptsoutenance++;		
	}
	echo '<tr>
			<td class="border_cellule" colspan="7"> Nombre d\'enseignants : ' . $cptprof . '<br/>
							 Nombre de soutenances : ' . $cptsoutenance . '</td>
		</tr>		
		</table>';	
}
else
{
echo 'Vous n\'avez pas accès à cette page	
<script type="text/javascript">redirection("login");</script>';
}

function del ($id) // si on veut supprimer une soutenance
{
	mysql_query("DELETE FROM soutenance WHERE id_bin = '" . $id . "'");
	echo '<p class="granted">Soutenance supprim&eacute;e</p>';
}
