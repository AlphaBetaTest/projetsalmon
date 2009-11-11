<?php

$objet = unserialize($_SESSION['objet']);

if ($_SESSION['objet'] != "" && $objet->get_droit() == 1)
{		
	//suppression d'un tuple
	if (isset($_GET['id']) && $_GET['action'] == "supprimer")
	{
		$objet->supprimer_binome($_GET['id']);	
		echo 'Tuple supprimé';
	}
	
	//Modification d'un tuple
	if (isset($_POST['modif']) && $_POST['modif'] != "")
	{
		$objet->modifier_binome();
	}
	
	echo '<h1> Les binômes</h1>';
	
	
	echo '<table>
	<th class="border_cellule">Numéro</th>
	<th class="border_cellule">Nom 1</th>
	<th class="border_cellule">Nom 2</th>
	<th class="border_cellule">Niveau</th>
	<th class="border_cellule">Valide</th>
	<th class="border_cellule" colspan="2">Action</th>';
	
	$ret = mysql_query("SELECT * FROM binome");	
	while ($binome = mysql_fetch_array($ret))
	{
		
		echo '<tr>
		<td class="border_cellule">' . $binome['num'] . '</td>
		<td class="border_cellule">' . $binome['nom1'] . '</td>
		<td class="border_cellule">' . $binome['nom2'] . '</td>
		<td class="border_cellule">' . $binome['niveau'] . '</td>
		<td class="border_cellule">' . $binome['valide'] . '</td>
		<td class="border_cellule"><a href="?page=modifier_binome&id=' . $binome['num'] . '"><img src="../images/b_edit.png" alt="Modifier" title="Modifier" /></a></td>
		<td class="border_cellule"><a href="javascript:confirmation(\'gestion_binome\',\'id\',\''. $binome['num'] . '\',\'action\',\'supprimer\',3);"><img src="../images/b_drop.png" alt="Supprimer" title="Supprimer" /></a></td>
		</tr>';
		
		//?page=gestion_binome&id=' . $binome['num'] . '&action=supprimer"><img src="../images/b_drop.png" alt="Supprimer" title="Supprimer" /></a></td>
		//</tr>';
	}
	echo '</table>';

	
	
}
else
{
echo 'Vous n\'avez pas accès à cette page	
<script type="text/javascript">redirection("login");</script>';
}
?>

